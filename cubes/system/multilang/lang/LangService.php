<?php

namespace cubes\system\multilang\lang;

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
     * @return Lang
     */
    public function getCurrentLang(): Lang
    {
        return $this->current ?: $this->getMainLang();
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
     * @return string
     */
    public function getCurrentLangCode(): string
    {
        return $this->getCurrentLang()->code;
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
     * @return string
     */
    public function getMainLangCode(): string
    {
        return $this->getMainLang()->code;
    }

    /**
     * @return Lang[]
     */
    public function getLangs(): array
    {
        $condition = $this->createCondition();
        $condition->addSort('sort', \SORT_ASC);
        return $this->findAll($condition);
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
            if ($listItem->is_main && $listItem->getId() !== $item->getId()) {
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

    /**
     * @param $id
     * @param AbstractEntity|null $item
     */
    public function delete($id, AbstractEntity $item = null)
    {
        if ($this->count($this->createCondition()) <= 1) {
            return; // cannot delete last lang
        }
        /** @var Lang $loadedItem */
        if (!$item && $loadedItem = $this->findById($id)) {
            $item = $loadedItem;
        }
        parent::delete($id, $item);
        if ($item->is_main) {
            /** @var Lang $someItem */
            if ($someItem = $this->findOne($this->createCondition())) {
                $someItem->is_main = true;
                $this->save($someItem);
            }
        }
    }
}
