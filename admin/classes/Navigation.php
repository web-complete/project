<?php

namespace admin\classes;

class Navigation
{

    public function get()
    {
        return [
            [
                'name' => 'Todo stick',
                'open' => 1,
                'items' => [
                    [
                        'name' => 'Раздел 1.1',
                        'url' => '/',
                    ],
                    [
                        'name' => 'Раздел 1.2',
                        'url' => '/404'
                    ],
                    [
                        'name' => 'Раздел 1.3',
                        'url' => '/settings'
                    ],
                ]
            ],
            [
                'name' => 'Раздел 2',
                'open' => 0,
                'items' => [
                    [
                        'name' => 'Раздел 2.1',
                        'url' => '#'
                    ],
                    [
                        'name' => 'Раздел 2.2',
                        'url' => '#'
                    ],
                    [
                        'name' => 'Раздел 2.3',
                        'url' => '#'
                    ],
                ]
            ],
        ];
    }
}