<?php

namespace cubes\system\search\search\adapters;

use cubes\system\mongo\Mongo;
use cubes\system\search\search\SearchDoc;
use cubes\system\search\search\SearchDocFactory;
use MongoDB\Model\BSONDocument;
use WebComplete\core\utils\paginator\Paginator;

class MongoSearchAdapter extends AbstractAdapter
{
    protected $collectionName = 'search';

    protected $collection;

    /**
     * @param SearchDocFactory $factory
     * @param Mongo $client
     * @throws \Exception
     */
    public function __construct(SearchDocFactory $factory, Mongo $client)
    {
        parent::__construct($factory);
        $this->collection = $client->selectCollection($this->collectionName);
    }


    public function indexDoc(SearchDoc $doc)
    {
        if (($itemId = $doc->item_id) && $doc->type) {
            $this->deleteDoc($doc->type, $itemId, $doc->lang_code);

            $doc->title = \mb_strtolower($doc->title);
            $doc->content = \mb_strtolower($doc->content);
            if ($doc->extra) {
                $doc->extra = \mb_strtolower($doc->extra);
            }

            $this->collection->insertOne($doc->mapToArray());
        }
    }

    public function deleteDoc(string $type, $itemId, string $langCode = null)
    {
        if ($itemId) {
            $filter = [
                'type' => $type,
                'item_id' => $itemId,
                'lang_code' => $langCode ?? 'ru'
            ];
            $this->collection->deleteOne($filter);
        }

    }

    public function search(Paginator $paginator, string $query, string $type = null, string $langCode = null): array
    {
        $found = [];

        $filter = [
            'type' => $type,
            '$text' => ['$search' => $query],
        ];

        $options['projection'] = ['score' => ['$meta' => 'textScore']];
        $options['sort'] = ['score' => ['$meta' => 'textScore']];

        $cursor = $this->collection->find($filter, $options);
        $rows  = $cursor->toArray();
        /** @var BSONDocument $row */
        foreach ($rows as $row) {
            $data = $row->getArrayCopy();
            unset($data['_id']);
            $found[] = $this->factory->createFromData($data);
        }

        return $found;
    }

    public function count(string $type = null): int
    {
        if ($type) {
            $filter = ['type' => $type];
        } else {
            $filter = [];
        }

        return $this->collection->count($filter);
    }

    public function clear(string $type = null)
    {
        if ($type) {
            $filter = ['type' => $type];
        } else {
            $filter = [];
        }

        $this->collection->deleteMany($filter);
    }
}
