<?php

namespace cubes\system\storage\tests;

use cubes\system\storage\Storage;

class StorageTest extends \AppTestCase
{

    public function testGetSet()
    {
        $data = ['a' => 1, 'b' => 2];
        $storage = $this->container->get(Storage::class);
        $this->assertNull($storage->get('test1'));
        $this->assertEquals('empty', $storage->get('test1', 'empty'));
        $storage->set('test1', $data);
        $this->assertEquals($data, $storage->get('test1'));
        $storage->set('test2', 'string2');
        $this->assertEquals('string2', $storage->get('test2'));
        $this->assertEquals($data, $storage->get('test1'));
        $storage->set('test1', 'string1');
        $this->assertEquals('string1', $storage->get('test1'));
    }
}
