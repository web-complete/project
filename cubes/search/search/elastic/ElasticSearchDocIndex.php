<?php

namespace cubes\search\search\elastic;

use cubes\system\elastic\AbstractElasticIndex;

class ElasticSearchDocIndex extends AbstractElasticIndex
{

    /**
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
                    // https://www.elastic.co/guide/en/elasticsearch/guide/current/relevance-is-broken.html
                    'number_of_shards' => 1,
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
                        ],
                        'analyzer' => [
                            'index_text' => [
                                'char_filter' => ['html_strip', 'ru_chars'],
                                'tokenizer' => 'standard',
                                // установить морфологию https://github.com/imotov/elasticsearch-analysis-morphology
//                                'filter' => ['lowercase', 'russian_morphology', 'english_morphology'],
                                'filter' => ['lowercase', 'ru_stop', 'ru_stemmer'], // простой вариант без плагина
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
                            'type'      => ['type' => 'keyword', 'index' => 'not_analyzed'],
                            'auto'      => ['type' => 'text', 'analyzer' => 'index_autocomplete'],
                            'title'     => ['type' => 'text', 'analyzer' => 'index_text',
                                            'term_vector' => 'with_positions_offsets'],
                            'content'   => ['type' => 'text', 'analyzer' => 'index_text',
                                            'term_vector' => 'with_positions_offsets'],
                            'extra'     => ['type' => 'keyword', 'index' => 'not_analyzed'],
                            'image'     => ['type' => 'keyword', 'index' => 'not_analyzed'],
                            'url'       => ['type' => 'keyword', 'index' => 'not_analyzed'],
                            'lang_code' => ['type' => 'keyword', 'index' => 'not_analyzed'],
                            'weight'    => ['type' => 'integer'],
                        ]
                    ],
                ],
            ]
        ];
    }
}
