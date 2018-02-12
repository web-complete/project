<?php

namespace modules\admin\classes;

use cubes\system\user\User;

class Navigation
{
    /**
     * @var array
     * example structure
     * ```
     * [
     *     [
     *          'name' => 'System',
     *          'sort' => 100,
     *          'open' => 1,
     *          'items' => [
     *              [
     *                  'name' => 'Settings',
     *                  'sort' => 300,
     *                  'url' => '/',
     *              ],
     *          ]
     *     ],
     * ]
     * ```
     */
    protected $data = [];

    /**
     * @param User|null $user
     *
     * @return array
     */
    public function get(User $user = null): array
    {
        $result = $this->data;
        \usort($result, function ($a, $b) {
            return (int)$a['sort'] <=> (int)$b['sort'];
        });
        foreach ($result as $k => &$section) {
            if ($user) {
                $this->filterAccess($user, $section);
            }
            if (!$section['items']) {
                unset($result[$k]);
            } else {
                \usort($section['items'], function ($a, $b) {
                    return (int)$a['sort'] <=> (int)$b['sort'];
                });
            }
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
     * @param string|null $permission
     */
    public function addItem(
        string $sectionName,
        string $name,
        string $frontUrl,
        int $sort = 100,
        string $permission = null
    ) {
        foreach ($this->data as &$section) {
            if ($section['name'] === $sectionName) {
                $section['items'][] = [
                    'name' => $name,
                    'sort' => $sort,
                    'url' => $frontUrl,
                    'permission' => $permission,
                ];
                return;
            }
        }
    }

    /**
     * @param User $user
     * @param array[] $section
     */
    protected function filterAccess(User $user, array &$section)
    {
        foreach ($section['items'] as $k => $item) {
            if ($item['permission'] && !$user->can($item['permission'])) {
                unset($section['items'][$k]);
            }
        }
    }
}
