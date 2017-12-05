<?php

namespace admin\classes;

class Navigation
{

    public function get()
    {
        return [
            [
                'name' => 'Раздел 1',
                'items' => [
                    [
                        'name' => 'Раздел 1.1',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Раздел 1.2',
                        'url' => '#'
                    ],
                    [
                        'name' => 'Раздел 1.3',
                        'url' => '#'
                    ],
                ]
            ],
            [
                'name' => 'Раздел 2',
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