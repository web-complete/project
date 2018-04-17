<?php

namespace modules\admin\tests;

use modules\admin\classes\mongo\Mongo;

class MongoSequenceTest extends \AppTestCase
{
    public function testSequence()
    {
        $mongo = $this->container->get(Mongo::class);
        $sequence = $mongo->getSequence();
        $nextId = $sequence->next();
        $nextId2 = $sequence->next();
        $nextId3 = $sequence->next(2);
        $this->assertEquals($nextId2, $nextId+1);
        $this->assertEquals($nextId3, $nextId+3);
    }
}
