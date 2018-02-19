<?php

namespace cubes\system\seo\seo;

use cubes\system\seo\slug\Slug;
use cubes\system\seo\slug\SlugService;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\core\utils\helpers\StringHelper;

abstract class AbstractEntitySeo implements SeoMetaInterface
{
    protected $entityServiceClass;
    protected $titleField;
    protected $urlPrefix;

    /**
     * @var SeoManager
     */
    protected $seoManager;
    /**
     * @var SlugService
     */
    protected $slugService;
    /**
     * @var AbstractEntityService
     */
    protected $entityService;
    /**
     * @var AbstractEntity
     */
    protected $item;

    /**
     * @param ContainerInterface $container
     *
     * @throws \RuntimeException
     */
    public function __construct(ContainerInterface $container)
    {
        if (!$this->entityServiceClass) {
            throw new \RuntimeException('Property "entityServiceClass" is not defined');
        }
        if (!$this->titleField) {
            throw new \RuntimeException('Property "titleField" is not defined');
        }
        if (!$this->urlPrefix) {
            throw new \RuntimeException('Property "urlPrefix" is not defined');
        }
        $this->seoManager = $container->get(SeoManager::class);
        $this->slugService = $container->get(SlugService::class);
        $this->entityService = $container->get($this->entityServiceClass);
    }

    /**
     * @param string $slug
     *
     * @return null|AbstractEntity
     */
    public function findCurrentPageItem(string $slug)
    {
        if (!$itemId = $this->findCurrentPageItemId($slug)) {
            return null;
        }

        if ($item = $this->entityService->findById($itemId)) {
            if ($item->has('is_active') && !$item->get('is_active')) {
                return null;
            }
            $this->setCurrentItem($item);
            $this->seoManager->registerSeoMeta($this);
        }

        return $item;
    }

    /**
     * @param string $slug
     *
     * @return null|string|int
     */
    public function findCurrentPageItemId(string $slug)
    {
        if (!$slug) {
            return null;
        }

        $condition = $this->slugService->createCondition([
            'name' => $slug,
            'item_class' => \get_class($this)
        ]);

        /** @var Slug $slugItem */
        if (!($slugItem = $this->slugService->findOne($condition)) || !$slugItem->item_id) {
            return null;
        }

        return $slugItem->item_id;
    }

    /**
     * @return AbstractEntity|null
     */
    public function getCurrentItem()
    {
        return $this->item;
    }

    /**
     * @param AbstractEntity $item
     */
    public function setCurrentItem(AbstractEntity $item)
    {
        $this->item = $item;
    }

    /**
     * @param bool $generateFromTitle
     *
     * @return string
     */
    public function getSlug(bool $generateFromTitle = false): string
    {
        if ($item = $this->getCurrentItem()) {
            if (!$generateFromTitle && $item->getId()) {
                $condition = $this->slugService->createCondition([
                    'item_class' => \get_class($this),
                    'item_id' => $item->getId(),
                ]);
                /** @var Slug $slugItem */
                if ($slugItem = $this->slugService->findOne($condition)) {
                    return $slugItem->name;
                }
            }

            $title = $item->get($this->titleField);
            return StringHelper::str2url($title);
        }
        return '';
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->getCurrentItem()) {
            return \rtrim($this->urlPrefix, '/') . '/' . $this->getSlug();
        }
        return '#';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        if ($item = $this->getCurrentItem()) {
            return $item->get($this->titleField);
        }
        return '';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getCanonical(): string
    {
        return '';
    }

    /**
     * @return bool
     */
    public function getNoindex(): bool
    {
        return false;
    }

    /**
     * @return SeoMetaOG
     */
    public function getMetaOG(): SeoMetaOG
    {
        return new SeoMetaOG();
    }
}
