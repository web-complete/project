<?php

namespace cubes\system\search\search\tests;

use cubes\system\search\search\adapters\ElasticSearchAdapter;
use cubes\system\search\search\SearchDoc;
use cubes\system\search\search\SearchDocFactory;
use cubes\system\search\search\SearchService;
use cubes\system\elastic\ElasticSearchDriver;
use WebComplete\core\utils\paginator\Paginator;

class ElasticSearchTest extends \AppTestCase
{
    /**
     * @var ElasticSearchDriver
     */
    protected $driver;
    /**
     * @var SearchService
     */
    protected $searchService;

    public function setUp()
    {
        parent::setUp();
        $this->driver = new ElasticSearchDriver('wcp_test', ['localhost:9200'], true);
        $index = new ElasticTestingDocIndex($this->driver);
        $adapter = new ElasticSearchAdapter(new SearchDocFactory(), $index);
        $this->searchService = new SearchService($adapter, new SearchDocFactory());
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
                'weight' => 2
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

        $this->searchService->clear();
        foreach ($data as $row) {
            $doc = new SearchDoc();
            $doc->mapFromArray($row);
            $this->searchService->indexDoc($doc);
        }
        $this->searchService->count('test_search');
        $this->assertEquals(3, $this->searchService->count('test_search'), $this->driver->getLastSearchQuery());
        $this->assertEquals(0, $this->searchService->count('test_search2'), $this->driver->getLastSearchQuery());

        $paginator = new Paginator();
        $this->assertCount(3, $this->searchService->search($paginator, 'some'), $this->driver->getLastSearchQuery());
        $this->assertCount(0, $this->searchService->search($paginator, 'aamerororo'), $this->driver->getLastSearchQuery());
        $this->assertCount(3, $this->searchService->search($paginator, 'some', 'test_search'), $this->driver->getLastSearchQuery());
        $this->assertCount(0, $this->searchService->search($paginator, 'some', 'test_search2'), $this->driver->getLastSearchQuery());
        $this->assertCount(2, $this->searchService->search($paginator, 'article'), $this->driver->getLastSearchQuery());
        $this->assertCount(1, $this->searchService->search($paginator, 'product'), $this->driver->getLastSearchQuery());
        $this->assertCount(1, $this->searchService->search($paginator, 'tag3'), $this->driver->getLastSearchQuery());

        // test highlight
        $paginator = new Paginator();
        $doc = $this->searchService->search($paginator, 'product')[0];
        $this->assertEquals('Some <em>product</em> article', $doc->title);
        $this->assertEquals('Some <em>product</em> content', $doc->content);

        $docs = $this->searchService->search($paginator, 'prod');
        $this->assertEquals(7, $docs[0]->item_id, $this->driver->getLastSearchQuery());
        $this->assertEquals(9, $docs[1]->item_id, $this->driver->getLastSearchQuery());
        $this->assertEquals(103, (int)$docs[0]->weight, $this->driver->getLastSearchQuery());
        $this->assertEquals(88, (int)$docs[1]->weight, $this->driver->getLastSearchQuery());

        $this->assertEquals(4, $this->searchService->count(), $this->driver->getLastSearchQuery());
        $this->assertEquals(3, $this->searchService->count('test_search'), $this->driver->getLastSearchQuery());
        $this->searchService->clear('test_other');
        \sleep(1);
        $this->assertEquals(3, $this->searchService->count(), $this->driver->getLastSearchQuery());
        $this->searchService->clear();
        $this->assertEquals(0, $this->searchService->count(), $this->driver->getLastSearchQuery());
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

        $this->searchService->clear();
        foreach ($data as $row) {
            $doc = new SearchDoc();
            $doc->mapFromArray($row);
            $this->searchService->indexDoc($doc);
        }

        $this->assertEquals(3, $this->searchService->count('test_multilang'));

        $paginator = new Paginator();
        $this->assertCount(2, $this->searchService->search($paginator, 'news'));
        $this->assertCount(1, $this->searchService->search($paginator, 'news', null, 'ru'));
        $this->assertCount(1, $this->searchService->search($paginator, 'news', null, 'en'));
        $this->searchService->deleteDoc('test_multilang', 5);
        \sleep(5);
        $this->assertCount(0, $this->searchService->search($paginator, 'news'));
        $this->assertEquals(1, $this->searchService->count('test_multilang'));
        $this->searchService->clear();
        $this->assertEquals(0, $this->searchService->count('test_multilang'));
    }
}
