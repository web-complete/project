<?php

namespace cubes\system\search\search\adapters;

use cubes\system\search\search\SearchDoc;
use cubes\system\search\search\SearchDocFactory;
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
     * @param SearchDocFactory $factory
     * @param MicroDb $microDb
     */
    public function __construct(SearchDocFactory $factory, MicroDb $microDb)
    {
        parent::__construct($factory);
        $this->microDb = $microDb;
    }

    /**
     * @param SearchDoc $doc
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function indexDoc(SearchDoc $doc)
    {
        if (($itemId = $doc->item_id) && $doc->type) {
            $collection = $this->microDb->getCollection($this->collectionName);
            $this->deleteDoc($doc->type, $itemId, $doc->lang_code);

            $doc->title = \strtolower($doc->title);
            $doc->content = \strtolower($doc->content);
            $doc->extra = \strtolower($doc->extra);
            $collection->insert($doc->mapToArray());
        }
    }

    /**
     * @param string $type
     * @param string|int $itemId
     * @param string $langCode
     *
     * @throws \WebComplete\microDb\Exception
     */
    public function deleteDoc(string $type, $itemId, string $langCode = null)
    {
        if ($itemId) {
            $collection = $this->microDb->getCollection($this->collectionName);
            $collection->delete(function (array $row) use ($type, $itemId, $langCode) {
                if ((string)$row['item_id'] === (string)$itemId && $row['type'] === $type) {
                    return $langCode ? $row['lang_code'] === $langCode : true;
                }
                return false;
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
                if (($type && $row['type'] !== $type) || ($langCode && $row['lang_code'] !== $langCode)) {
                    return false;
                }
                $weight = 0;
                $weight += \strpos($row['title'], $query) !== false ? 3 : 0;
                $weight += \strpos($row['content'], $query) !== false ? 2 : 0;
                $weight += \strpos($row['extra'], $query) !== false ? 1 : 0;

                if ($weight) {
                    $item = $this->factory->createFromData($row);
                    $item->weight *= $weight;
                    $found[$row['id']] = $item;
                    return true;
                }

                return false;
            }
        );

        \usort($found, function (SearchDoc $doc1, SearchDoc $doc2) {
            return $doc2->weight <=> $doc1->weight;
        });

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
     * @return int
     * @throws \WebComplete\microDb\Exception
     */
    public function count(string $type = null): int
    {
        $collection = $this->microDb->getCollection($this->collectionName);
        $rows = $collection->fetchAll(function (array $row) use ($type) {
            return $type ? $row['type'] === $type : true;
        });
        return \count($rows);
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
