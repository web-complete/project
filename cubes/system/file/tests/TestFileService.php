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
            'code1',
            null,
            null,
            110,
            ['some' => 'data']
        );
        $this->assertNotNull($file->getId());
        $this->assertEquals('code1', $file->code);
        $this->assertEquals('test.file', $file->file_name);
        $this->assertEquals('/usr/4b/81/test.file', $file->url);
        $this->assertEquals(110, $file->sort);
        $this->assertEquals(['some' => 'data'], $file->data);
    }

    public function testCreateFileFromRemotePath()
    {
        $url = 'https://raw.githubusercontent.com/web-complete/core/master/readme.md';
        $fileService = $this->container->get(FileService::class);
        $file = $fileService->createFileFromPath(
            $url,
            'code1',
            null,
            null,
            110,
            ['some' => 'data']
        );
        $this->assertNotNull($file->getId());
        $this->assertEquals('code1', $file->code);
        $this->assertEquals('readme.md', $file->file_name);
        $this->assertEquals('/usr/1b/19/readme.md', $file->url);
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
            'code1',
            'larry.gif',
            null,
            110,
            ['some' => 'data']
        );
        $this->assertNotNull($file->getId());
        $this->assertEquals('code1', $file->code);
        $this->assertEquals('larry.gif', $file->file_name);
        $this->assertEquals('/usr/9c/3d/larry.gif', $file->url);
        $this->assertEquals(110, $file->sort);
        $this->assertEquals(['some' => 'data'], $file->data);
    }

    public function testDeleteOneFile()
    {
        $fileService = $this->container->get(FileService::class);
        $file = $fileService->createFileFromPath(__DIR__ . '/test.file', 'code1', 'file1.txt');
        $this->assertTrue(\file_exists(__DIR__ . '/usr/63/3e/file1.txt'));
        $fileService->delete($file->getId());
        $this->assertFalse(\file_exists(__DIR__ . '/usr/63/3e/file1.txt'));
    }

    public function testDeleteManyFiles()
    {
        $fileService = $this->container->get(FileService::class);
        $fileService->createFileFromPath(__DIR__ . '/test.file', 'code1', 'file1.txt');
        $this->assertTrue(\file_exists(__DIR__ . '/usr/63/3e/file1.txt'));
        $fileService->createFileFromPath(__DIR__ . '/test.file', 'code1', 'file2.txt');
        $this->assertTrue(\file_exists(__DIR__ . '/usr/cc/b7/file2.txt'));
        $fileService->deleteAll();
        $this->assertFalse(\file_exists(__DIR__ . '/usr/63/3e/file1.txt'));
        $this->assertFalse(\file_exists(__DIR__ . '/usr/cc/b7/file2.txt'));
    }
}
