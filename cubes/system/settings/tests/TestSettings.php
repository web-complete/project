<?php

namespace cubes\system\settings\tests;

use cubes\system\settings\Settings;
use WebComplete\core\utils\alias\AliasService;
use WebComplete\mvc\ApplicationConfig;

class TestSettings extends \AppTestCase
{

    public function setUp()
    {
        parent::setUp();
        @unlink(__DIR__ . '/settings.json');
    }

    public function tearDown()
    {
        @unlink(__DIR__ . '/settings.json');
        parent::tearDown();
    }

    public function testGetSet()
    {
        $settings = $this->getSettings();
        $this->assertEquals(null, $settings->get('aaa'));
        $this->assertEquals('', $settings->get('site_name'));

        $settings->set('aaa', 1);
        $settings->set('site_name', 2);
        $this->assertEquals(null, $settings->get('aaa'));
        $this->assertEquals(2, $settings->get('site_name'));

        $this->assertEquals([
            'sections' => [
                'common' => 'Основное',
                'system' => 'Система',
            ],
            'data' => [
                'common' => [
                    'site_name' => [
                        'title' => '',
                        'type' => '',
                        'value' => 2,
                    ],
                    'site_description' => [
                        'title' => '',
                        'type' => '',
                        'value' => '',
                    ],
                ],
                'system' => [
                ],
            ],
        ], $settings->getStructure());
    }

    /**
     * @return Settings
     */
    protected function getSettings(): Settings
    {
        $config = new ApplicationConfig(['settings' => [
            'sections' => [
                'common' => 'Основное',
                'system' => 'Система',
            ],
            'data' => [
                'common' => [
                    'site_name' => [
                        'title' => '',
                        'type' => '',
                        'value' => '',
                    ],
                    'site_description' => [
                        'title' => '',
                        'type' => '',
                        'value' => '',
                    ],
                ],
                'system' => [
                ],
            ],
        ]]);
        $aliasService = $this->container->get(AliasService::class);
        $settings = new Settings($config, $aliasService);
        $settings->setStoragePath(__DIR__ . '/settings.json');
        return $settings;
    }
}
