<?php

namespace cubes\seo\seo;

use WebComplete\core\entity\AbstractEntity;

trait SeoEntityTrait
{
    /**
     * @var AbstractEntitySeo
     */
    private static $entitySeo;
    private $url;

    /**
     * @param AbstractEntitySeo $entitySeo
     */
    public static function setEntitySeo(AbstractEntitySeo $entitySeo)
    {
        self::$entitySeo = $entitySeo;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->url === null) {
            $this->url = '#';
            if ($entitySeo = self::$entitySeo) {
                /** @var AbstractEntity $item */
                $item = $this;
                $entitySeo->setCurrentItem($item);
                $this->url = $entitySeo->getUrl();
            }
        }
        return $this->url;
    }
}
