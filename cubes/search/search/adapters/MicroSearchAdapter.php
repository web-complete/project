<?php

namespace cubes\search\search\adapters;

use cubes\search\search\SearchDoc;
use cubes\search\search\SearchDocFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\utils\paginator\Paginator;
use WebComplete\microDb\MicroDb;

class MicroSearchAdapter extends AbstractAdapter
{
    protected $collectionName = 'search';
    /**
     * @var MicroDb
     */
    protected $microDb;
    /**
     * @var ConditionMicroDbParser
     */
    protected $conditionParser;

    /**
     * @param SearchDocFactory $factory
     * @param MicroDb $microDb
     * @param ConditionMicroDbParser $conditionParser
     */
    public function __construct(SearchDocFactory $factory, MicroDb $microDb, ConditionMicroDbParser $conditionParser)
    {
        parent::__construct($factory);
        $this->microDb = $microDb;
        $this->conditionParser = $conditionParser;
    }

    /**
     * @param SearchDoc $doc
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function indexDoc(SearchDoc $doc)
    {
        if ($id = $doc->getId()) {
            $collection = $this->microDb->getCollection($this->collectionName);
            $this->deleteDoc($id);
            $collection->insert($doc->mapToArray(), $id);
        }
    }

    /**
     * @param $id
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function deleteDoc($id)
    {
        if ($id) {
            $collection = $this->microDb->getCollection($this->collectionName);
            $collection->delete(function (array $row) use ($id) {
                return (string)$row['id'] === (string)$id;
            });
        }
    }

    /**
     * @param Paginator $paginator
     * @param string $query
     * @param string|null $type
     * @param string|null $langCode
     *
     * @return SearchDoc[]
     * @throws \WebComplete\microDb\Exception
     */
    public function search(Paginator $paginator, string $query, string $type = null, string $langCode = null): array
    {
        $found = [];
        $collection = $this->microDb->getCollection($this->collectionName);
        $collection->fetchAll(
            function (array $row) use ($query, $type, $langCode, &$found) {
                $weight = 0;
                if ($type && $row['type'] !== $type) {
                    return false;
                }
                if ($langCode) {
                    // TODO
                    throw new \Exception('TODO IMPLEMENT');
                }
                if (\strpos($row['title'], $query) !== false) {
                    $weight = 3;
                } elseif (\strpos($row['content'], $query) !== false) {
                    $weight = 2;
                } elseif (\strpos($row['extra'], $query) !== false) {
                    $weight = 1;
                }

                if ($weight) {
                    $item = $this->factory->createFromData($row);
                    $item->weight *= $weight;
                    $found[$row['id']] = $item;
                    return true;
                }

                return false;
            }
        );

        $paginator->setTotal(\count($found));
        if ($limit = $paginator->getLimit()) {
            $offset = $paginator->getOffset();
            $found = \array_slice($found, $offset, $limit);
        }

        return $found;
    }

    /**
     * @param string|null $type
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function clear(string $type = null)
    {
        $collection = $this->microDb->getCollection($this->collectionName);
        if ($type) {
            $collection->delete(function (array $row) use ($type) {
                return $row['type'] === $type;
            });
        } else {
            $collection->drop();
        }
    }
}
