<?php

namespace cubes\content\staticBlock;

class StaticBlockHelper
{
    const TYPE_STRING = StaticBlockService::TYPE_STRING;
    const TYPE_TEXT = StaticBlockService::TYPE_TEXT;
    const TYPE_IMAGE = StaticBlockService::TYPE_IMAGE;
    const TYPE_HTML = StaticBlockService::TYPE_HTML;
    const TYPE_IMAGES = StaticBlockService::TYPE_IMAGES;

    protected static $currentNamespace;
    protected static $currentName;
    protected static $currentType;
    protected static $currentLangCode;

    /**
     * @var StaticBlockService
     */
    protected static $staticBlockService;

    /**
     * @param string $namespace
     * @param string $name
     * @param int $type
     *
     * @param string|null $langCode
     *
     * @return mixed|null
     */
    public static function get(string $namespace, string $name, int $type, string $langCode = null)
    {
        $result = null;
        /** @var StaticBlock $item */
        if ($item = self::findStaticBlockItem($namespace, $name)) {
            $result = $item->setLang($langCode)->content;
        } else {
            $service = self::getStaticBlockService();
            $item = $service->create();
            $item->namespace = $namespace;
            $item->name = $name;
            $item->type = $type;
            $service->save($item);
        }
        return $result;
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param int $type
     * @param string|null $langCode
     *
     * @throws \RuntimeException
     */
    public static function begin(string $namespace, string $name, int $type, string $langCode = null)
    {
        if (!\in_array($type, [self::TYPE_STRING, self::TYPE_TEXT, self::TYPE_HTML], true)) {
            throw new \RuntimeException('begin/end available only for text static content');
        }
        self::$currentNamespace = $namespace;
        self::$currentName = $name;
        self::$currentType = $type;
        self::$currentLangCode = $langCode;
        \ob_start();
    }

    /**
     */
    public static function end()
    {
        if ($item = self::findStaticBlockItem(self::$currentNamespace, self::$currentName)) {
            $content = $item->setLang(self::$currentLangCode)->content;
        } else {
            $content = \ob_get_contents();
            $service = self::getStaticBlockService();
            /** @var StaticBlock $item */
            $item = $service->create();
            $item->namespace = self::$currentNamespace;
            $item->name = self::$currentName;
            $item->type = self::$currentType;
            $item->content = $content;
            $service->save($item);
        }

        \ob_end_clean();
        echo $content;
    }

    /**
     * @return StaticBlockService
     */
    public static function getStaticBlockService(): StaticBlockService
    {
        if (!self::$staticBlockService) {
            global $application;
            self::setStaticBlockService($application->getContainer()->get(StaticBlockService::class));
        }
        return self::$staticBlockService;
    }

    /**
     * @param StaticBlockService $staticBlockService
     */
    public static function setStaticBlockService(StaticBlockService $staticBlockService)
    {
        self::$staticBlockService = $staticBlockService;
    }

    /**
     * @param string $namespace
     * @param string $name
     *
     * @return null|\WebComplete\core\entity\AbstractEntity|StaticBlock
     */
    protected static function findStaticBlockItem(string $namespace, string $name)
    {
        $service = self::getStaticBlockService();
        $condition = $service->createCondition(['namespace' => $namespace, 'name' => $name]);
        return $service->findOne($condition);
    }
}
