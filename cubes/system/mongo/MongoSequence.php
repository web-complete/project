<?php

namespace cubes\system\mongo;

use MongoDB\Collection;
use MongoDB\Operation\FindOneAndUpdate;

class MongoSequence
{
    const COLLECTION_NAME = 'counters';
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @param Mongo $mongo
     */
    public function __construct(Mongo $mongo)
    {
        $this->collection = $mongo->getDatabase()->selectCollection(self::COLLECTION_NAME);
    }

    /**
     * @param int $count
     *
     * @return int
     * @throws \RuntimeException
     */
    public function next(int $count = 1): int
    {
        $response = $this->collection->findOneAndUpdate(
            ['name' => 'sequence'],
            ['$inc' => ['value' => $count]],
            ['upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );
        if (!isset($response['value']) || !(int)$response['value']) {
            throw new \RuntimeException('Cannot fetch sequence value');
        }
        return (int)$response['value'];
    }
}
