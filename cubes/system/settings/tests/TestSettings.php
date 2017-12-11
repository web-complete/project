<?php

namespace cubes\system\settings\tests;

use cubes\system\settings\Settings;
use modules\admin\classes\fields\Field;
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
                [
                    'title' => 'Основное',
                    'name' => 'common',
                ],
                [
                    'title' => 'Система',
                    'name' => 'system',
                ],
            ],
            'fields' => [
                'common' => [
                    [
                        'component' => 'VueFieldString',
                        'name' => 'site_name',
                        'title' => '',
                        'value' => 2,
                        'fieldParams' => [
                            'type' => 'text',
                            'disabled' => false,
                            'maxlength' => '',
                            'placeholder' => '',
                            'filter' => '',
                            'mask' => '',
                        ],
                    ],
                    [
                        'component' => 'VueFieldString',
                        'name' => 'site_description',
                        'title' => '',
                        'value' => '',
                        'fieldParams' => [
                            'type' => 'text',
                            'disabled' => false,
                            'maxlength' => '',
                            'placeholder' => '',
                            'filter' => '',
                            'mask' => '',
                        ],
                    ],
                ],
                'system' => [
                ],
            ],
        ], $settings->getStructure(true));
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
            'fields' => [
                'common' => [
                    'site_name' => Field::string('', 'site_name'),
                    'site_description' => Field::string('', 'site_description'),
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
