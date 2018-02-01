<?php

namespace cubes\content\menu;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\tree\Tree;

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
     * @return Tree
     * @throws \InvalidArgumentException
     */
    public function getTree(): Tree
    {
        $items = $this->findAll();
        return new Tree($items);
    }

    /**
     * @param int $parentId
     * @param array $childrenIds
     *
     * @throws \InvalidArgumentException
     */
    public function move(int $parentId, array $childrenIds)
    {
        $tree = $this->getTree();
        if (!$tree->getItem($parentId)) {
            return;
        }
        foreach ($childrenIds as $sort => $itemId) {
            /** @var MenuItem $item */
            if ($item = $tree->getItem($itemId)) {
                $item->parent_id = $parentId;
                $item->sort = $sort;
                $this->save($item);
            }
        }
    }

    /**
     * @param MenuItem|AbstractEntity $item
     * @param array $oldData
     *
     * @throws \InvalidArgumentException
     */
    public function save(AbstractEntity $item, array $oldData = [])
    {
        if (!$item->getId()) {
            $tree = $this->getTree();
            foreach ($tree->getChildren($item->parent_id) as $sibling) {
                /** @var MenuItem $sibling */
                $item->sort = ($sibling->sort >= $item->sort) ? $sibling->sort+1 : $item->sort;
            }
        }
        parent::save($item, $oldData);
    }

    /**
     * @param $id
     * @param MenuItem|AbstractEntity|null $item
     *
     * @throws \InvalidArgumentException
     */
    public function delete($id, AbstractEntity $item = null)
    {
        $tree = $this->getTree();
        foreach ($tree->getChildren($id) as $childItem) {
            $this->delete($childItem->getId(), $childItem);
        }
        parent::delete($id, $item);
    }
}
