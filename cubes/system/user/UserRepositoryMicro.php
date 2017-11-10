<?php

namespace cubes\system\user;

use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityRepository;
use WebComplete\microDb\MicroDb;

class UserRepositoryMicro extends AbstractEntityRepository implements UserRepositoryInterface
{

    protected $table = 'user';

    /**
     * @var MicroDb
     */
    protected $microDb;

    /**
     * @var ConditionMicroDbParser
     */
    protected $conditionParser;

    /**
     * @param UserFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(UserFactory $factory, MicroDb $microDb, ConditionMicroDbParser $conditionParser)
    {
        parent::__construct($factory);
        $this->microDb = $microDb;
        $this->conditionParser = $conditionParser;
    }

    /**
     * Adjust data before save
     *
     * @param $data
     */
    protected function beforeDataSave(&$data)
    {
    }

    /**
     * @param \Closure $closure
     *
     * @throws \Exception
     */
    public function transaction(\Closure $closure)
    {
        $closure();
    }

    /**
     * @param $id
     *
     * @return AbstractEntity|null
     * @throws \WebComplete\microDb\Exception
     */
    public function findById($id)
    {
        return $this->findOne($this->createCondition(['id' => $id]));
    }

    /**
     * @param Condition $condition
     *
     * @return AbstractEntity|null
     * @throws \WebComplete\microDb\Exception
     */
    public function findOne(Condition $condition)
    {
        $result = null;
        $row = $this->microDb->getCollection($this->table)->fetchOne(
            $this->conditionParser->filter($condition),
            $this->conditionParser->sort($condition)
        );
        if ($row) {
            /** @var AbstractEntity $result */
            $result = $this->factory->createFromData($row);
        }

        return $result;
    }

    /**
     * @param Condition $condition
     *
     * @return AbstractEntity[]
     * @throws \WebComplete\microDb\Exception
     */
    public function findAll(Condition $condition = null): array
    {
        $result = [];
        $filter = $this->conditionParser->filter($condition, $limit, $offset);
        $rows = $this->microDb->getCollection($this->table)->fetchAll(
            $filter,
            $this->conditionParser->sort($condition),
            $limit,
            $offset
        );
        foreach ($rows as $row) {
            /** @var AbstractEntity $entity */
            $entity = $this->factory->createFromData($row);
            $result[$entity->getId()] = $entity;
        }

        return $result;
    }

    /**
     * @param Condition|null $condition
     *
     * @return int
     * @throws \WebComplete\microDb\Exception
     */
    public function count(Condition $condition = null): int
    {
        return \count($this->findAll($condition));
    }

    /**
     * @param AbstractEntity $item
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function save(AbstractEntity $item)
    {
        $collection = $this->microDb->getCollection($this->table);
        if ($id = (string)$item->getId()) {
            $collection->update(function ($row) use ($id) {
                return isset($row['id']) && (string)$row['id'] === $id;
            }, $item->mapToArray());
        } else {
            $id = $collection->insert($item->mapToArray());
            $item->setId($id);
        }
    }

    /**
     * @param $id
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function delete($id)
    {
        $id = (string)$id;
        $this->microDb->getCollection($this->table)->delete(function ($row) use ($id) {
            return isset($row['id']) && (string)$row['id'] === $id;
        });
    }

    /**
     * @param Condition|null $condition
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function deleteAll(Condition $condition = null)
    {
        $this->microDb->getCollection($this->table)->delete($this->conditionParser->filter($condition));
    }

    /**
     * @param string $field
     * @param string $key
     * @param Condition|null $condition
     *
     * @return array
     * @throws \WebComplete\microDb\Exception
     * @throws \TypeError
     */
    public function getMap(string $field, string $key = 'id', Condition $condition = null): array
    {
        $result = [];
        $items = $this->findAll($condition);
        foreach ($items as $item) {
            $data = $item->mapToArray();
            if (isset($data[$key])) {
                $result[$data[$key]] = $data[$field] ?? null;
            }
        }
        return $result;
    }

    /**
     * @param string $token
     *
     * @return User|AbstractEntity|null
     * @throws \WebComplete\microDb\Exception
     */
    public function findByToken(string $token)
    {
        return $this->findOne($this->createCondition(['token' => $token]));
    }
}
