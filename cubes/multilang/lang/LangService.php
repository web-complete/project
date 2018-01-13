<?php

namespace cubes\multilang\lang;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

class LangService extends AbstractEntityService implements LangRepositoryInterface
{
    const DEFAULT_CODE = 'ru';

    /**
     * @var LangRepositoryInterface
     */
    protected $repository;

    /** @var Lang|null */
    protected $current;

    /**
     * @param LangRepositoryInterface $repository
     */
    public function __construct(LangRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Lang $lang
     */
    public function setCurrentLang(Lang $lang)
    {
        $this->current = $lang;
    }

    /**
     * @return null|Lang
     */
    public function getCurrentLang()
    {
        return $this->current;
    }

    /**
     * @param string $code
     */
    public function setCurrentLangByCode(string $code)
    {
        /** @var Lang $lang */
        if ($lang = $this->getLang($code)) {
            $this->setCurrentLang($lang);
        }
    }

    /**
     * @return null|string
     */
    public function getCurrentLangCode()
    {
        return $this->current ? $this->current->code : null;
    }

    /**
     * @return AbstractEntity|Lang
     */
    public function getMainLang(): Lang
    {
        /** @var Lang $lang */
        if (!$lang = $this->findOne($this->createCondition(['is_main' => 1]))) {
            if (!$lang = $this->findOne($this->createCondition())) {
                $lang = $this->createFromData([
                    'code' => self::DEFAULT_CODE
                ]);
            }
        }

        return $lang;
    }

    /**
     * @return null
     */
    public function getMainLangCode()
    {
        return $this->getMainLang()->code;
    }

    /**
     * @return Lang[]
     */
    public function getLangs(): array
    {
        return $this->findAll();
    }

    /**
     * @param $langCode
     *
     * @return Lang|AbstractEntity|null
     */
    public function getLang($langCode)
    {
        return $this->findOne($this->createCondition(['code' => $langCode]));
    }

    /**
     * @return array
     */
    public function getState(): array
    {
        $result = [
            'langs' => []
        ];
        foreach ($this->getLangs() as $lang) {
            $result['langs'][] = $lang->mapToArray();
        }
        return $result;
    }

    /**
     * Check that main language is only one
     * @param Lang|AbstractEntity $item
     * @param array $oldData
     */
    public function save(AbstractEntity $item, array $oldData = [])
    {
        /** @var Lang[] $items */
        $items = $this->findAll();
        $hasMain = false;
        foreach ($items as $listItem) {
            if ($listItem->is_main) {
                $hasMain = true;
                if ($item->is_main) {
                    $listItem->is_main = false;
                    $this->save($listItem);
                }
            }
        }

        if (!$item->is_main && !$hasMain) {
            $item->is_main = true;
        }

        parent::save($item, $oldData);
    }
}