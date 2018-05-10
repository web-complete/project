<?php

namespace cubes\content\menu;

use cubes\content\menu\repository\MenuItemRepositoryInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\cache\Cache;
use WebComplete\core\utils\tree\Tree;

class MenuService extends AbstractEntityService implements MenuItemRepositoryInterface
{
    const CACHE_KEY = 'menu_tree';
    const TYPE_URL = 1;
    const TYPE_PAGE = 2;

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
     * @throws \RuntimeException
     * @throws \Symfony\Component\Cache\Exception\InvalidArgumentException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function getTree(): Tree
    {
        return Cache::getOrSet(self::CACHE_KEY, function () {
            $items = $this->findAll();
            return new Tree($items);
        });
    }

    /**
     * @param int $parentId
     * @param array $childrenIds
     *
     * @throws \InvalidArgumentException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \RuntimeException
     * @throws \Symfony\Component\Cache\Exception\InvalidArgumentException
     */
    public function move(int $parentId, array $childrenIds)
    {
        $tree = $this->getTree();
        foreach ($childrenIds as $sort => $itemId) {
            /** @var MenuItem $item */
            if ($item = $tree->getItem($itemId)) {
                $item->parent_id = $parentId;
                $item->sort = $sort;
                $this->save($item);
            }
        }
        Cache::invalidate(self::CACHE_KEY);
    }

    /**
     * @param MenuItem|AbstractEntity $item
     * @param array $oldData
     *
     * @throws \InvalidArgumentException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \RuntimeException
     * @throws \Symfony\Component\Cache\Exception\InvalidArgumentException
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
        Cache::invalidate(self::CACHE_KEY);
    }

    /**
     * @param $id
     * @param MenuItem|AbstractEntity|null $item
     *
     * @throws \InvalidArgumentException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \RuntimeException
     * @throws \Symfony\Component\Cache\Exception\InvalidArgumentException
     */
    public function delete($id, AbstractEntity $item = null)
    {
        $tree = $this->getTree();
        foreach ($tree->getChildren($id) as $childItem) {
            $this->delete($childItem->getId(), $childItem);
        }
        parent::delete($id, $item);
        Cache::invalidate(self::CACHE_KEY);
    }
}
