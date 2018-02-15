<?php

namespace cubes\system\search\search\adapters;

use cubes\system\search\search\elastic\ElasticSearchDocIndex;
use cubes\system\search\search\SearchDoc;
use cubes\system\search\search\SearchDocFactory;
use WebComplete\core\utils\paginator\Paginator;

class ElasticSearchAdapter extends AbstractAdapter
{
    /**
     * @var float
     */
    public $searchTime;
    /**
     * @var ElasticSearchDocIndex
     */
    protected $index;
    /**
     * @var bool
     */
    protected $highlight = false;

    /**
     * @param SearchDocFactory $factory
     * @param ElasticSearchDocIndex $index
     * @param bool $useHighlight
     */
    public function __construct(SearchDocFactory $factory, ElasticSearchDocIndex $index, bool $useHighlight = true)
    {
        parent::__construct($factory);
        $this->index = $index;
        $this->highlight = $useHighlight;
    }

    /**
     * @param SearchDoc $doc
     *
     * @throws \Exception
     */
    public function indexDoc(SearchDoc $doc)
    {
        $this->index->indexDoc(null, [
            'item_id'   => $doc->item_id,
            'type'      => $doc->type,
            'title'     => $doc->title,
            'auto'      => $doc->title,
            'content'   => $doc->content,
            'extra'     => $doc->extra,
            'image'     => $doc->image,
            'url'       => $doc->url,
            'weight'    => $doc->weight,
            'lang_code' => $doc->lang_code,
        ]);
    }

    /**
     * @param string $type
     * @param string|int $itemId
     * @param string|null $langCode
     *
     * @throws \Exception
     */
    public function deleteDoc(string $type, $itemId, string $langCode = null)
    {
        $paginator = new Paginator();
        $docs = $this->searchInternal($paginator, '*', $type, $langCode, $itemId);
        foreach ($docs as $doc) {
            $this->index->deleteDoc($doc->getId());
        }
    }

    /**
     * @param Paginator $paginator
     * @param string $query
     * @param string|null $type
     * @param string|null $langCode
     *
     * @return SearchDoc[]
     * @throws \Exception
     */
    public function search(Paginator $paginator, string $query, string $type = null, string $langCode = null): array
    {
        return $this->searchInternal($paginator, $query, $type, $langCode);
    }

    /**
     * @param string|null $type
     *
     * @return int
     * @throws \Exception
     */
    public function count(string $type = null): int
    {
        if ($type) {
            $paginator = new Paginator();
            $this->searchInternal($paginator, '*', $type);
            return $paginator->getTotal();
        }
        return $this->index->countIndex();
    }

    /**
     * @param string|null $type
     *
     * @throws \Exception
     */
    public function clear(string $type = null)
    {
        if ($type) {
            $paginator = new Paginator();
            $docs = $this->searchInternal($paginator, '*', $type);
            foreach ($docs as $doc) {
                $this->index->deleteDoc($doc->getId());
            }
        } else {
            $this->index->createIndex();
        }
    }

    /**
     * @param Paginator $paginator
     * @param string $query
     * @param string|null $type
     * @param string|null $langCode
     * @param string|int|null $itemId
     *
     * @return SearchDoc[]
     * @throws \Exception
     */
    protected function searchInternal(
        Paginator $paginator,
        string $query,
        string $type = null,
        string $langCode = null,
        $itemId = null
    ): array {
        $params = [];
        if ($limit = $paginator->getLimit()) {
            $params['from'] = $paginator->getOffset();
            $params['size'] = $limit;
        }
        $params['body'] = [
            'query' => [
                'function_score' => [
                    'query' => $this->getSearchQueryStatement($query, $type, $langCode, $itemId),
                    'boost' => 1,
                    'boost_mode' => 'multiply',
                    'field_value_factor' => [
                        'field' => 'weight',
                        'factor' => 1.2,
                        'modifier' => 'sqrt',
                        'missing' => 1,
                    ]

                ],
            ],
        ];

        if ($this->highlight) {
            $params['body']['highlight'] = [
                'fields' => [
                    'title' => ['number_of_fragments' => 0],
                    'content' => ['fragment_size' => 150, 'number_of_fragments' => 3],
                ],
            ];
        }

        $result = $this->index->searchDoc($params);
        $this->searchTime = $result['took'] ?? null;
        $paginator->setTotal($result['hits']['total'] ?? 0);
        $rows = (array)($result['hits']['hits'] ?? []);
        $docs = [];
        foreach ($rows as $row) {
            $doc = new SearchDoc();
            $doc->setId($row['_id'] ?? null);
            $doc->type = $row['_source']['type'] ?? null;
            $doc->item_id = $row['_source']['item_id'] ?? null;
            $doc->title = $row['_source']['title'] ?? null;
            $doc->content = $row['_source']['content'] ?? null;
            $doc->extra = $row['_source']['extra'] ?? null;
            $doc->image = $row['_source']['image'] ?? null;
            $doc->url = $row['_source']['url'] ?? null;
            $doc->lang_code = $row['_source']['lang_code'] ?? null;
            $doc->weight = $row['_score'] ?? null;

            if ($this->highlight) {
                if ($titleHighlight = $row['highlight']['title'] ?? null) {
                    $doc->title = \implode(' ... ', $titleHighlight);
                }
                if ($contentHighlight = $row['highlight']['content'] ?? null) {
                    $doc->content = \implode(' ... ', $contentHighlight);
                }
            }

            $docs[] = $doc;
        }
        return $docs;
    }

    /**
     * @param string $query
     * @param string|null $type
     * @param string|null $langCode
     * @param null $itemId
     *
     * @return array
     */
    protected function getSearchQueryStatement(
        string $query,
        string $type = null,
        string $langCode = null,
        $itemId = null
    ): array {
        $queryStatement = (($query && $query !== '*') || $type || $langCode || $itemId)
            ? ['bool' => []]
            : ['match_all' => new \stdClass()];

        if ($type) {
            if (!isset($queryStatement['bool']['filter'])) {
                $queryStatement['bool']['filter'] = [];
            }
            $queryStatement['bool']['filter'][] = ['term' => ['type' => $type]];
        }
        if ($langCode) {
            if (!isset($queryStatement['bool']['filter'])) {
                $queryStatement['bool']['filter'] = [];
            }
            $queryStatement['bool']['filter'][] = ['term' => ['lang_code' => $langCode]];
        }
        if ($itemId) {
            if (!isset($queryStatement['bool']['filter'])) {
                $queryStatement['bool']['filter'] = [];
            }
            $queryStatement['bool']['filter'][] = ['term' => ['item_id' => $itemId]];
        }

        if ($query && $query !== '*') {
            $queryStatement['bool']['minimum_should_match'] = 1;
            $queryStatement['bool']['should'] = [
                [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['auto^4'],
                        'minimum_should_match' => '100%',
                        'operator' => 'and',
                        'boost' => 10,
                    ],
                ],
                [
                    'multi_match' => [
                        'query' => $query,
                        'type' => 'cross_fields',
                        'fields' => ['title^3', 'content^2', 'extra^1'],
                        'operator' => 'and',
                        'boost' => 30,
                    ],
                ],
                [
                    'fuzzy' => [
                        'title' => [
                            'value' => $query,
                            'fuzziness' => 2,
                            'prefix_length' => 0,
                            'max_expansions' => 100,
                            'boost' => 3,
                        ],
                    ]
                ],
                [
                    'fuzzy' => [
                        'content' => [
                            'value' => $query,
                            'fuzziness' => 2,
                            'prefix_length' => 0,
                            'max_expansions' => 100,
                            'boost' => 1,
                        ],
                    ]
                ],
            ];
        }

        return $queryStatement;
    }
}
