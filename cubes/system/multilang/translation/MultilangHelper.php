<?php

namespace cubes\system\multilang\translation;

use cubes\system\multilang\lang\LangService;
use WebComplete\core\utils\container\ContainerInterface;

class MultilangHelper
{
    /**
     * @var ContainerInterface
     */
    protected static $container;
    /**
     * @var LangService
     */
    protected static $langService;
    /**
     * @var TranslationService
     */
    protected static $translationService;

    /**
     * @param $text
     * @param string $namespace
     * @param string|null $langCode
     *
     * @return string
     * @throws \Exception
     */
    public static function getText(string $text, string $namespace = '', string $langCode = null): string
    {
        $namespace = $namespace ?: '_';
        $langCode = $langCode ?? self::getLangService()->getCurrentLangCode();
        return $langCode
            ? self::getTranslationService()->getTranslationFor($text, $namespace, $langCode)
            : '%' . $text . '%';
    }

    /**
     * @param string|null $langCode
     *
     * @return array
     */
    public static function getTextMap(string $langCode = null): array
    {
        $result = [];
        $langService = self::getLangService();
        $translationService = self::getTranslationService();

        if ($langCode = $langCode ?? $langService->getCurrentLangCode()) {
            foreach ($translationService->getTranslations() as $namespace => $nsTranslations) {
                $result[$namespace] = [];
                foreach ((array)$nsTranslations as $text => $translationData) {
                    $result[$namespace][$text] = $translationData->translations[$langCode] ?? '%' . $text . '%';
                }
            }
        }

        return $result;
    }

    /**
     * @return LangService
     */
    public static function getLangService(): LangService
    {
        if (!self::$langService) {
            self::$langService = self::getContainer()->get(LangService::class);
        }
        return self::$langService;
    }

    /**
     * @param ContainerInterface $container
     */
    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }

    /**
     * @return ContainerInterface
     */
    protected static function getContainer(): ContainerInterface
    {
        if (!self::$container) {
            global $application;
            self::setContainer($application->getContainer());
        }
        return self::$container;
    }

    /**
     * @return TranslationService
     */
    protected static function getTranslationService(): TranslationService
    {
        if (!self::$translationService) {
            self::$translationService = self::getContainer()->get(TranslationService::class);
        }
        return self::$translationService;
    }
}
