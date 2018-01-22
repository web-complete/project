<?php

namespace cubes\multilang\translation;

use WebComplete\core\entity\AbstractEntityService;

class TranslationService extends AbstractEntityService implements TranslationRepositoryInterface
{
    /**
     * @var TranslationRepositoryInterface
     */
    protected $repository;

    /** @var Translation[][] */
    protected $translations;

    /**
     * @param TranslationRepositoryInterface $repository
     */
    public function __construct(TranslationRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @return Translation[][]
     */
    public function getTranslations(): array
    {
        $this->loadTranslations();
        return $this->translations;
    }

    /**
     * @param $text
     * @param string $namespace
     * @param string|null $langCode
     *
     * @return string
     * @throws \Exception
     */
    public function getTranslationFor(string $text, string $namespace, string $langCode): string
    {
        $this->loadTranslations();
        $nsTranslations = (array)($this->translations[$namespace] ?? []);

        if (isset($nsTranslations[$text])) {
            /** @var Translation $translation */
            $translation = $nsTranslations[$text];
            $translationData = $translation->translations;
            if (\array_key_exists($langCode, $translationData)) {
                return $translationData[$langCode];
            }
        } else {
            /** @var Translation $translation */
            $translation = $this->create();
            $translation->original = $text;
            $translation->namespace = $namespace;
            $this->save($translation);
        }

        return '%' . $text . '%';
    }

    /**
     *
     */
    public function clearCache()
    {
        $this->translations = null;
        $this->loadTranslations();
    }

    /**
     */
    protected function loadTranslations()
    {
        if ($this->translations === null) {
            $this->translations = [];
            /** @var Translation[] $translations */
            $translations = $this->findAll();
            foreach ($translations as $translation) {
                $namespace = $translation->namespace ?: '_';
                if (!isset($this->translations[$namespace])) {
                    $this->translations[$namespace] = [];
                }
                $this->translations[$namespace][$translation->original] = $translation;
            }
        }
    }
}
