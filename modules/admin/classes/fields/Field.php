<?php

namespace modules\admin\classes\fields;

class Field
{

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldString
     */
    public static function string(string $title, string $name): FieldString
    {
        return new FieldString($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldCheckbox
     */
    public static function checkbox(string $title, string $name): FieldCheckbox
    {
        return new FieldCheckbox($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldSelect
     */
    public static function select(string $title, string $name): FieldSelect
    {
        return new FieldSelect($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldTextarea
     */
    public static function textarea(string $title, string $name): FieldTextarea
    {
        return new FieldTextarea($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldRedactor
     */
    public static function redactor(string $title, string $name): FieldRedactor
    {
        return new FieldRedactor($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldFile
     */
    public static function file(string $title, string $name): FieldFile
    {
        return new FieldFile($title, $name);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FieldImage
     */
    public static function image(string $title, string $name): FieldImage
    {
        return new FieldImage($title, $name);
    }
}