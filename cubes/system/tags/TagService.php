<?php

namespace cubes\system\tags;

use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\event\EventService;
use WebComplete\core\utils\helpers\StringHelper;

class TagService extends AbstractEntityService implements TagRepositoryInterface
{

    /**
     * @var TagRepositoryInterface
     */
    protected $repository;
    /**
     * @var StringHelper
     */
    protected $stringHelper;

    /**
     * @param TagRepositoryInterface $repository
     * @param EventService $eventService
     * @param StringHelper $stringHelper
     */
    public function __construct(
        TagRepositoryInterface $repository,
        EventService $eventService,
        StringHelper $stringHelper
    ) {
        parent::__construct($repository, $eventService);
        $this->stringHelper = $stringHelper;
    }

    /**
     * @param string $name
     * @param string $namespace
     * @param string|int $entityId
     *
     * @return Tag
     */
    public function attachTag(string $name, string $namespace, $entityId): Tag
    {
        /** @var Tag $tag */
        if (!$tag = $this->findOne($this->createCondition(['name' => $name, 'namespace' => $namespace]))) {
            $tag = $this->create();
            $tag->name = $name;
            $tag->slug = $this->stringHelper->str2url($name);
            $tag->namespace = $namespace;
        }
        $ids = (array)$tag->ids;
        $ids[$entityId] = $entityId;
        $tag->ids = $ids;
        $this->save($tag);
        return $tag;
    }

    /**
     * @param string $name
     * @param string $namespace
     * @param $entityId
     */
    public function detachTag(string $name, string $namespace, $entityId)
    {
        /** @var Tag $tag */
        if ($tag = $this->findOne($this->createCondition(['name' => $name, 'namespace' => $namespace]))) {
            $ids = (array)$tag->ids;
            unset($ids[$entityId]);
            if ($ids) {
                $tag->ids = $ids;
                $this->save($tag);
            } else {
                $this->delete($tag->getId());
            }
        }
    }

    /**
     * @param string $slug
     * @param string $namespace
     *
     * @return array|\WebComplete\core\entity\AbstractEntity[]|Tag[]
     */
    public function findBySlug(string $slug, string $namespace)
    {
        return $this->findAll($this->createCondition(['slug' => $slug, 'namespace' => $namespace]));
    }
}
