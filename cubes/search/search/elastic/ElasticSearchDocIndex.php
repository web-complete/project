<?php

namespace cubes\search\search\elastic;

use cubes\system\elastic\AbstractElasticIndex;

class ElasticSearchDocIndex extends AbstractElasticIndex
{

    /**
     * Warning! Use getRealIndexName() instead
     * @return string
     */
    public function getIndexName(): string
    {
        return 'search';
    }

    /**
     * @return array
     */
    public function createIndexParams(): array
    {
        return [
            'index' => $this->getRealIndexName(),
            'body' => [
                'settings' => [
                    'number_of_shards' => 1, // https://www.elastic.co/guide/en/elasticsearch/guide/current/relevance-is-broken.html
                    'max_result_window' => 1000000,
                    'analysis' => [
                        'filter' => [
                            'ru_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_',
                            ],
                            'ru_stemmer' => [
                                'type' => 'snowball',
                                'language' => 'russian',
                            ],
                            'autocomplete_filter' => [
                                'type' => 'edge_ngram',
                                'min_gram' => 3,
                                'max_gram' => 20,
                            ],
                            'ngram_3_10_filter' => [
                                'type' => 'ngram',
                                'min_gram' => 3,
                                'max_gram' => 10,
                            ],
                            'synonym' => [
                                'type' => 'synonym',
                                // TODO INJECT
                                'synonyms' => ServiceManager::getInstance()->searchSynonymService->getRepository()->getSynonyms(),
                            ],
                        ],
                        'analyzer' => [
                            'index_text' => [
                                'char_filter' => ['html_strip', 'ru_chars'],
                                'tokenizer' => 'standard',
                                // установить морфологию https://github.com/imotov/elasticsearch-analysis-morphology
//                                'filter' => ['lowercase', 'synonym', 'ru_stop', 'ru_stemmer'], // простой вариант без плагина
                                'filter' => ['lowercase', 'synonym', 'russian_morphology', 'english_morphology'],
                            ],
                            'index_autocomplete' => [
                                'type' => 'custom',
                                'char_filter' => ['ru_chars'],
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase', 'autocomplete_filter',]
                            ],
                            'index_partial' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase', 'ngram_3_10_filter',]
                            ],
                            'search_partial' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase',]
                            ]
                        ],
                        'char_filter' => [
                            'ru_chars' => [
                                'type' => 'mapping',
                                'mappings' => [
                                    'ё => е',
                                    'й => и',
                                ],
                            ],
                        ],
                    ],
                ],
                'mappings' => [
                    '_default_' => [
                        'properties' => [
                            'title'   => ['type' => 'text', 'analyzer' => 'index_text', 'term_vector' => 'with_positions_offsets'],
                            'auto'    => ['type' => 'text', 'analyzer' => 'index_autocomplete'],
                            'partial' => ['type' => 'text', 'analyzer' => 'index_partial', 'search_analyzer' => 'search_partial'],
                            'content' => ['type' => 'text', 'analyzer' => 'index_text', 'term_vector' => 'with_positions_offsets'],
                            'extra'   => ['type' => 'text', 'analyzer' => 'index_text'],
                            'tags'    => ['type' => 'keyword', 'index' => 'not_analyzed'],
                        ]
                    ],
                ],
            ]
        ];
    }
}
