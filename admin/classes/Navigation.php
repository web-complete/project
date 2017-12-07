<?php

namespace admin\classes;

class Navigation
{

    protected $data = [
        [
            'name' => 'Todo stick',
            'sort' => 100,
            'open' => 1,
            'items' => [
                [
                    'name' => 'Раздел 1.1',
                    'sort' => 300,
                    'url' => '/',
                ],
                [
                    'name' => 'Раздел 1.2',
                    'sort' => 200,
                    'url' => '/404'
                ],
                [
                    'name' => 'Раздел 1.3',
                    'sort' => 100,
                    'url' => '/settings'
                ],
            ]
        ],
        [
            'name' => 'Раздел 2',
            'sort' => 2,
            'open' => 0,
            'items' => [
                [
                    'name' => 'Раздел 2.1',
                    'sort' => 100,
                    'url' => '#'
                ],
                [
                    'name' => 'Раздел 2.2',
                    'sort' => 200,
                    'url' => '#'
                ],
                [
                    'name' => 'Раздел 2.3',
                    'sort' => 300,
                    'url' => '#'
                ],
            ]
        ],
    ];

    /**
     * @return array
     */
    public function get(): array
    {
        $result = $this->data;
        \usort($result, function ($a, $b) {
            return (int)$a['sort'] <=> (int)$b['sort'];
        });
        foreach ($result as &$section) {
            \usort($section['items'], function ($a, $b) {
                return (int)$a['sort'] <=> (int)$b['sort'];
            });
        }
        return $result;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasSection(string $name): bool
    {
        foreach ($this->data as $section) {
            if ($section['name'] === $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $name
     * @param int $sort
     * @param bool $openedByDefault
     */
    public function addSection(string $name, int $sort = 100, bool $openedByDefault = false)
    {
        if (!$this->hasSection($name)) {
            $this->data[] = [
                'name' => $name,
                'sort' => $sort,
                'open' => (int)$openedByDefault,
                'items' => [],
            ];
        }
    }

    /**
     * @param string $sectionName
     * @param string $name
     * @param string $frontUrl
     * @param int $sort
     */
    public function addItem(string $sectionName, string $name, string $frontUrl, int $sort = 100)
    {
        foreach ($this->data as &$section) {
            if ($section['name'] === $sectionName) {
                $section['items'][] = [
                    'name' => $name,
                    'sort' => $sort,
                    'url' => $frontUrl,
                ];
                return;
            }
        }
    }
}
