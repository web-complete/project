<?php

namespace modules\admin\classes\fields;

use cubes\system\tags\TagService;
use WebComplete\core\utils\container\ContainerInterface;

class FieldFactory
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * factory method
     *
     * @param ContainerInterface|null $container
     *
     * @return FieldFactory
     */
    public static function build(ContainerInterface $container = null): FieldFactory
    {
        if (!$container) {
            global $application;
            $container = $application->getContainer();
        }
        return $container->get(__CLASS__);
    }

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldString
     */
    public function string(string $title, string $name): FieldString
    {
        return new FieldString($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldString
     */
    public function number(string $title, string $name): FieldString
    {
        return $this->string($title, $name)->filter('^[0-9]*$');
    }

    /**
     * @param string $title
     * @param string $name
     * @param string $mask
     * @param string $placeholder
     *
     * @return FieldDate
     */
    public function date(
        string $title,
        string $name,
        string $mask = '00.00.0000',
        string $placeholder = 'дд.мм.гггг'
    ): FieldDate {
        return (new FieldDate($title, $name))->mask($mask)->placeholder($placeholder);
    }

    /**
     * @param string $title
     * @param string $name
     * @param string $mask
     * @param string $placeholder
     *
     * @return FieldDateTime
     */
    public function dateTime(
        string $title,
        string $name,
        string $mask = '00.00.0000 00:00:00',
        string $placeholder = 'дд.мм.гггг чч:мм:сс'
    ): FieldDateTime {
        return (new FieldDateTime($title, $name))->mask($mask)->placeholder($placeholder);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldCheckbox
     */
    public function checkbox(string $title, string $name): FieldCheckbox
    {
        return new FieldCheckbox($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldSelect
     */
    public function select(string $title, string $name): FieldSelect
    {
        return new FieldSelect($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldTextarea
     */
    public function textarea(string $title, string $name): FieldTextarea
    {
        return new FieldTextarea($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldRedactor
     */
    public function redactor(string $title, string $name): FieldRedactor
    {
        return new FieldRedactor($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldFile
     */
    public function file(string $title, string $name): FieldFile
    {
        return new FieldFile($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldImage
     */
    public function image(string $title, string $name): FieldImage
    {
        return new FieldImage($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     * @param string $namespace
     *
     * @return FieldTags
     */
    public function tags(string $title, string $name, string $namespace): FieldTags
    {
        $tagService = $this->container->get(TagService::class);
        return new FieldTags($title, $name, $namespace, $tagService);
    }
}
