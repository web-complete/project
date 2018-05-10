<?php

namespace cubes\system\mongo;

use MongoDB\Collection;
use MongoDB\Model\BSONDocument;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityRepository;
use WebComplete\core\factory\EntityFactory;

class AbstractEntityRepositoryMongo extends AbstractEntityRepository
{
    protected $collectionName;

    /**
     * @var Mongo
     */
    protected $mongo;
    /**
     * @var Collection
     */
    protected $collection;
    /**
     * @var ConditionMongoDbParser
     */
    protected $conditionParser;

    /**
     * @param EntityFactory $factory
     * @param Mongo $mongo
     * @param ConditionMongoDbParser $conditionParser
     */
    public function __construct(EntityFactory $factory, Mongo $mongo, ConditionMongoDbParser $conditionParser)
    {
        parent::__construct($factory);
        $this->mongo = $mongo;
        $this->collection = $this->mongo->getDatabase()->selectCollection($this->collectionName);
        $this->conditionParser = $conditionParser;
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
     */
    public function findById($id)
    {
        return $this->findOne($this->createCondition(['id' => $id]));
    }

    /**
     * @param Condition $condition
     *
     * @return AbstractEntity|null
     */
    public function findOne(Condition $condition)
    {
        $result = null;
        /** @var BSONDocument $row */
        if ($row = $this->collection->findOne(
            $this->conditionParser->filter($condition),
            $this->conditionParser->options($condition)
        )) {
            /** @var AbstractEntity $result */
            $result = $this->factory->create();
            $data = $row->getArrayCopy();
            unset($data['_id']);
            $result->mapFromArray($data);
        }
        return $result;
    }

    /**
     * @param Condition $condition
     *
     * @return AbstractEntity[]
     */
    public function findAll(Condition $condition = null): array
    {
        $result = [];
        if ($cursor = $this->collection->find(
            $this->conditionParser->filter($condition),
            $this->conditionParser->options($condition)
        )) {
            /** @var BSONDocument $row */
            foreach ($cursor as $row) {
                /** @var AbstractEntity $entity */
                $entity = $this->factory->create();
                $data = $row->getArrayCopy();
                unset($data['_id']);
                $entity->mapFromArray($data);
                $result[$entity->getId()] = $entity;
            }
        }
        return $result;
    }

    /**
     * @param Condition|null $condition
     *
     * @return int
     */
    public function count(Condition $condition = null): int
    {
        return $this->collection->count(
            $this->conditionParser->filter($condition),
            $this->conditionParser->options($condition)
        );
    }

    /**
     * @param AbstractEntity $item
     */
    public function save(AbstractEntity $item)
    {
        if ($id = $item->getId()) {
            $this->collection->updateOne(['id' => $id], ['$set' => $item->mapToArray()]);
        } else {
            $id = $this->mongo->getSequence()->next();
            $item->setId($id);
            $this->collection->insertOne($item->mapToArray());
        }
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->collection->deleteOne(['id' => $id]);
    }

    /**
     * @param Condition|null $condition
     */
    public function deleteAll(Condition $condition = null)
    {
        $this->collection->deleteMany(
            $this->conditionParser->filter($condition),
            $this->conditionParser->options($condition)
        );
    }

    /**
     * @param string $field
     * @param string $key
     * @param Condition|null $condition
     *
     * @return array
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
}
