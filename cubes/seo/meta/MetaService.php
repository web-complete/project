<?php

namespace cubes\seo\meta;

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
        if (!$item->getId()) {
            /** @var Meta $otherItem */
            if ($otherItem = $this->findOne($this->createCondition(['url' => $item->url]))) {
                $item->title = $item->title ?: $otherItem->title;
                $item->description = $item->description ?: $otherItem->description;
                $item->keywords = $item->keywords ?: $otherItem->keywords;
                $this->delete($otherItem->getId());
            }
        }
    }
}
