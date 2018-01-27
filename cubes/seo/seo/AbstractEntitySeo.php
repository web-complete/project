<?php

namespace cubes\seo\seo;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

abstract class AbstractEntitySeo implements SeoMetaInterface
{
    /**
     * @var SeoManager
     */
    protected $seoManager;
    /**
     * @var AbstractEntityService
     */
    protected $entityService;

    /**
     * @param SeoManager $seoManager
     * @param AbstractEntityService $entityService
     */
    public function __construct(SeoManager $seoManager, AbstractEntityService $entityService)
    {
        $this->seoManager = $seoManager;
        $this->entityService = $entityService;
    }

    /**
     * @param string $slug
     *
     * @return null|AbstractEntity
     */
    public function findCurrentItem(string $slug)
    {
        $condition = $this->entityService->createCondition(['slug' => $slug]);
        if ($this->entityService->create()->has('is_active')) {
            $condition->addEqualsCondition('is_active', 1);
        }

        return $this->entityService->findOne($condition);
    }
}
