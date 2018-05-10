<?php

namespace cubes\system\seo\meta;

use cubes\system\seo\meta\repository\MetaRepositoryInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

class MetaService extends AbstractEntityService implements MetaRepositoryInterface
{

    /**
     * @var MetaRepositoryInterface
     */
    protected $repository;

    /**
     * @param MetaRepositoryInterface $repository
     */
    public function __construct(MetaRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Meta|AbstractEntity $item
     * @param array $oldData
     */
    public function save(AbstractEntity $item, array $oldData = [])
    {
        $this->preventDuplicates($item);
        parent::save($item, $oldData);
    }

    /**
     * @param Meta $item
     */
    protected function preventDuplicates(Meta $item)
    {
        /** @var Meta $otherItem */
        $otherItem = $this->findOne($this->createCondition(['url' => $item->url]));
        if ($otherItem !== null && $otherItem->getId() !== $item->getId()) {
            $this->delete($otherItem->getId());
        }
    }
}
