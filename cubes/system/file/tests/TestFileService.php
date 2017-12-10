<?php

namespace cubes\system\file\tests;

use cubes\system\file\FileService;
use Symfony\Component\Filesystem\Filesystem;

class TestFileService extends \AppTestCase
{

    public function setUp()
    {
        parent::setUp();
        $fileService = $this->container->get(FileService::class);
        $fileService->setBaseDir(__DIR__);
    }

    public function tearDown()
    {
        $fileService = $this->container->get(FileService::class);
        $fileService->setBaseDir('@web');
        $fs = new Filesystem();
        $fs->remove(__DIR__ . '/usr');
        parent::tearDown();
    }

    public function testCreateFileFromLocalPath()
    {
        $fileService = $this->container->get(FileService::class);
        $file = $fileService->createFileFromPath(
            __DIR__ . '/test.file',
            null,
            null,
            'code1',
            110,
            ['some' => 'data']
        );
        $this->assertNotNull($file->getId());
        $this->assertEquals('code1', $file->code);
        $this->assertEquals('test.file', \substr($file->file_name, 11));
        $this->assertTrue((bool)\preg_match('~^\/usr\/..\/..\/.........._test.file$~', $file->url));
        $this->assertEquals(110, $file->sort);
        $this->assertEquals(['some' => 'data'], $file->data);
    }

    public function testCreateFileFromRemotePath()
    {
        $url = 'https://raw.githubusercontent.com/web-complete/core/master/readme.md';
        $fileService = $this->container->get(FileService::class);
        $file = $fileService->createFileFromPath(
            $url,
            null,
            null,
            'code1',
            110,
            ['some' => 'data']
        );
        $this->assertNotNull($file->getId());
        $this->assertEquals('code1', $file->code);
        $this->assertEquals('readme.md', \substr($file->file_name, 11));
        $this->assertTrue((bool)\preg_match('~^\/usr\/..\/..\/.........._readme.md$~', $file->url));
        $this->assertEquals(110, $file->sort);
        $this->assertEquals(['some' => 'data'], $file->data);
    }

    public function testCreateFileFromBase64Content()
    {
        $content = 'data:image/gif;base64,R0lGODdhMAAwAPAAAAAAAP///ywAAAAAMAAw
AAAC8IyPqcvt3wCcDkiLc7C0qwyGHhSWpjQu5yqmCYsapyuvUUlvONmOZtfzgFz
ByTB10QgxOR0TqBQejhRNzOfkVJ+5YiUqrXF5Y5lKh/DeuNcP5yLWGsEbtLiOSp
a/TPg7JpJHxyendzWTBfX0cxOnKPjgBzi4diinWGdkF8kjdfnycQZXZeYGejmJl
ZeGl9i2icVqaNVailT6F5iJ90m6mvuTS4OK05M0vDk0Q4XUtwvKOzrcd3iq9uis
F81M1OIcR7lEewwcLp7tuNNkM3uNna3F2JQFo97Vriy/Xl4/f1cf5VWzXyym7PH
hhx4dbgYKAAA7';
        $fileService = $this->container->get(FileService::class);
        $file = $fileService->createFileFromContent(
            $content,
            'larry.gif',
            null,
            'code1',
            110,
            ['some' => 'data']
        );
        $this->assertNotNull($file->getId());
        $this->assertEquals('code1', $file->code);
        $this->assertEquals('larry.gif', \substr($file->file_name, 11));
        $this->assertTrue((bool)\preg_match('~^\/usr\/..\/..\/.........._larry.gif$~', $file->url));
        $this->assertEquals(110, $file->sort);
        $this->assertEquals(['some' => 'data'], $file->data);
    }

    public function testDeleteOneFile()
    {
        $fileService = $this->container->get(FileService::class);
        $file = $fileService->createFileFromPath(__DIR__ . '/test.file', 'file1.txt', null, 'code1');
        $this->assertTrue(\file_exists(__DIR__ . $file->url));
        $fileService->delete($file->getId());
        $this->assertFalse(\file_exists(__DIR__ . $file->url));
    }

    public function testDeleteManyFiles()
    {
        $fileService = $this->container->get(FileService::class);
        $file1 = $fileService->createFileFromPath(__DIR__ . '/test.file', 'file1.txt', null, 'code1');
        $this->assertTrue(\file_exists(__DIR__ . $file1->url));
        $file2 = $fileService->createFileFromPath(__DIR__ . '/test.file', 'file2.txt', null, 'code1');
        $this->assertTrue(\file_exists(__DIR__ . $file2->url));
        $fileService->deleteAll();
        $this->assertFalse(\file_exists(__DIR__ . $file1->url));
        $this->assertFalse(\file_exists(__DIR__ . $file2->url));
    }
}
