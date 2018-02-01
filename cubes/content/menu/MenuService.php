<?php

namespace cubes\content\menu;

use WebComplete\core\entity\AbstractEntityService;

class MenuService extends AbstractEntityService implements MenuItemRepositoryInterface
{

    /**
     * @var MenuItemRepositoryInterface
     */
    protected $repository;

    /**
     * @param MenuItemRepositoryInterface $repository
     */
    public function __construct(MenuItemRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        $result = [
            'items' => [],
            'root' => [],
        ];
        /** @var MenuItem[] $items */
        $items = $this->findAll();

        \uasort($items, function (MenuItem $item1, MenuItem $item2) {
            return $item1->sort <=> $item2->sort;
        });

        foreach ($items as $item) {
            if (!$item->parent_id) {
                $result['root'][] = $item->getId();
            } elseif (isset($items[$item->parent_id])) {
                $items[$item->parent_id]->addChild($item);
            }
            $result['items'][$item->getId()] = $item;
        }

        return $result;
    }
}
