<?php

namespace cubes\system\tags\tests;

use cubes\system\tags\Tag;
use cubes\system\tags\TagService;
use WebComplete\core\condition\Condition;

class TagsTest extends \AppTestCase
{

    public function testEntity()
    {
        $tagService = $this->container->get(TagService::class);
        /** @var Tag $tag1 */
        $tag1 = $tagService->create();
        $tag1->name = 'tag1';
        $tag1->slug = 'tag-1';
        $tag1->namespace = 'news';
        $tag1->ids = [1,2,3];
        $tagService->save($tag1);

        /** @var Tag $tag2 */
        $tag2 = $tagService->create();
        $tag2->name = 'tag2';
        $tag2->slug = 'tag-2';
        $tag2->namespace = 'news';
        $tag2->ids = [2,3,4];
        $tagService->save($tag2);

        /** @var Tag $tag3 */
        $tag3 = $tagService->create();
        $tag3->name = 'tag1';
        $tag3->slug = 'tag-1';
        $tag3->namespace = 'article';
        $tag3->ids = [5,6,7];
        $tagService->save($tag3);

        $tags1 = $tagService->findAll(new Condition(['namespace' => 'news']));
        $this->assertCount(2, $tags1);
        $tags2 = $tagService->findAll(new Condition(['namespace' => 'article']));
        $this->assertCount(1, $tags2);
        $this->assertEquals([
            'id' => $tag3->getId(),
            'name' => 'tag1',
            'slug' => 'tag-1',
            'namespace' => 'article',
            'ids' => [5,6,7],
        ], $tags2[$tag3->getId()]->mapToArray());
    }

    public function testSlug()
    {
        $tagService = $this->container->get(TagService::class);
        $tag = $tagService->attachTag('проверка чпу', 'news', 1);
        $this->assertEquals('proverka-chpu', $tag->slug);
    }

    public function testAttachDetach()
    {
        $tagService = $this->container->get(TagService::class);
        $tag1 = $tagService->attachTag('tag 1', 'news', 1);
        $tag2 = $tagService->attachTag('tag 1', 'news', 2);
        $tag3 = $tagService->attachTag('tag 1', 'article', 3);
        $this->assertEquals($tag1->getId(), $tag2->getId());
        $this->assertEquals([1,2], \array_keys($tag2->ids));
        $this->assertNotEquals($tag1->getId(), $tag3->getId());
        $this->assertEquals([3], \array_keys($tag3->ids));

        $tagService->detachTag('tag 1', 'article', 3);
        $this->assertNull($tagService->findById($tag3->getId()));
    }

    public function testFindBySlug()
    {
        $tagService = $this->container->get(TagService::class);
        $tagService->attachTag('tag 1', 'news', 1);
        $tag2 = $tagService->attachTag('проверка чпу', 'news', 1);
        $tagService->attachTag('tag 3', 'news', 2);
        $tagService->attachTag('проверка чпу', 'article', 2);

        $tags = $tagService->findBySlug('proverka-chpu', 'news');
        $this->assertCount(1, $tags);
        $this->assertTrue(isset($tags[$tag2->getId()]));
    }
}
