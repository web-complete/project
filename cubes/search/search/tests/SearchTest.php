<?php

namespace cubes\search\search\tests;

use cubes\search\search\adapters\MicroSearchAdapter;
use cubes\search\search\SearchDoc;
use cubes\search\search\SearchDocFactory;
use cubes\search\search\SearchService;
use WebComplete\core\utils\paginator\Paginator;
use WebComplete\microDb\MicroDb;

class SearchTest extends \AppTestCase
{

    public function setUp()
    {
        parent::setUp();
        @\unlink(__DIR__ . '/test_search.fdb');
        @\unlink(__DIR__ . '/test_multilang.fdb');
    }

    public function tearDown()
    {
        @\unlink(__DIR__ . '/test_search.fdb');
        @\unlink(__DIR__ . '/test_multilang.fdb');
        parent::tearDown();
    }

    public function testSearch()
    {
        $data = [
            [
                'type' => 'test_search',
                'item_id' => 5,
                'title' => 'Some news title',
                'content' => 'Some news content',
                'url' => '/url1',
                'image' => '/img1.jpg',
                'extra' => 'tag1',
                'weight' => 1
            ],
            [
                'type' => 'test_search',
                'item_id' => 7,
                'title' => 'Some article title',
                'content' => 'Some article content prod',
                'url' => '/url2',
                'image' => '/img2.jpg',
                'extra' => 'tag2',
                'weight' => 1
            ],
            [
                'type' => 'test_search',
                'item_id' => 9,
                'title' => 'Some product article',
                'content' => 'Some product content',
                'url' => '/url3',
                'image' => '/img3.jpg',
                'extra' => 'tag3',
                'weight' => 1
            ],
            [
                'type' => 'test_other',
                'item_id' => 9,
                'title' => 'other item',
                'content' => 'other item content',
                'url' => '/url3',
                'image' => '/img3.jpg',
                'extra' => 'tag4',
                'weight' => 1
            ],
        ];

        $microDb = new MicroDb(__DIR__, 'test');
        $searchAdapter = new MicroSearchAdapter(new SearchDocFactory(), $microDb);
        $searchService = new SearchService($searchAdapter, new SearchDocFactory());
        foreach ($data as $row) {
            $doc = new SearchDoc();
            $doc->mapFromArray($row);
            $searchService->indexDoc($doc);
        }
        $this->assertEquals(3, $searchService->count('test_search'));
        $this->assertEquals(0, $searchService->count('test_search2'));

        $paginator = new Paginator();
        $this->assertCount(3, $searchService->search($paginator, 'some'));
        $this->assertCount(0, $searchService->search($paginator, 'somer'));
        $this->assertCount(3, $searchService->search($paginator, 'some', 'test_search'));
        $this->assertCount(0, $searchService->search($paginator, 'some', 'test_search2'));
        $this->assertCount(2, $searchService->search($paginator, 'article'));
        $this->assertCount(1, $searchService->search($paginator, 'product'));
        $this->assertCount(1, $searchService->search($paginator, 'tag3'));
        $docs = $searchService->search($paginator, 'prod');
        $this->assertEquals(9, $docs[0]->item_id);
        $this->assertEquals(7, $docs[1]->item_id);
        $this->assertEquals(5, $docs[0]->weight);
        $this->assertEquals(2, $docs[1]->weight);

        $this->assertEquals(4, $searchService->count());
        $this->assertEquals(3, $searchService->count('test_search'));
        $searchService->clear('test_other');
        $this->assertEquals(3, $searchService->count());
        $searchService->clear();
        $this->assertEquals(0, $searchService->count());
    }

    public function testSearchMultilang()
    {
        $data = [
            [
                'type' => 'test_multilang',
                'item_id' => 5,
                'title' => 'Some news title lang1',
                'content' => 'Some news content lang1',
                'url' => '/url1',
                'image' => '/img1.jpg',
                'extra' => 'tag1',
                'weight' => 1,
                'lang_code' => 'ru',
            ],
            [
                'type' => 'test_multilang',
                'item_id' => 5,
                'title' => 'Some news title lang2',
                'content' => 'Some news content lang2',
                'url' => '/url2',
                'image' => '/img2.jpg',
                'extra' => 'tag2',
                'weight' => 1,
                'lang_code' => 'en',
            ],
            [
                'type' => 'test_multilang',
                'item_id' => 9,
                'title' => 'Some product article',
                'content' => 'Some product content',
                'url' => '/url3',
                'image' => '/img3.jpg',
                'extra' => 'tag3',
                'weight' => 1,
                'lang_code' => 'en',
            ],
        ];

        $microDb = new MicroDb(__DIR__, 'test');
        $searchAdapter = new MicroSearchAdapter(new SearchDocFactory(), $microDb);
        $searchService = new SearchService($searchAdapter, new SearchDocFactory());
        foreach ($data as $row) {
            $doc = new SearchDoc();
            $doc->mapFromArray($row);
            $searchService->indexDoc($doc);
        }

        $this->assertEquals(3, $searchService->count('test_multilang'));

        $paginator = new Paginator();
        $this->assertCount(2, $searchService->search($paginator, 'news'));
        $this->assertCount(1, $searchService->search($paginator, 'news', null, 'ru'));
        $this->assertCount(1, $searchService->search($paginator, 'news', null, 'en'));
        $searchService->deleteDoc('test_multilang', 5);
        $this->assertCount(0, $searchService->search($paginator, 'news'));
        $this->assertEquals(1, $searchService->count('test_multilang'));
        $searchService->clear();
        $this->assertEquals(0, $searchService->count('test_multilang'));
    }
}
