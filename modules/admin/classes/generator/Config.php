<?php

namespace modules\admin\classes\generator;

use WebComplete\core\utils\alias\AliasService;
use WebComplete\core\utils\helpers\InflectorHelper;

class Config
{
    public $section;
    public $name; // example: product-property
    public $nameVar; // example: productProperty
    public $nameCamel; // example: ProductProperty
    public $nameUnderscore; // example: product_property
    public $type;
    public $path;
    public $namespace;
    public $customize;
    public $force;

    /**
     * @param AliasService $aliasService
     * @param InflectorHelper $inflectorHelper
     * @param string $section
     * @param string $name
     * @param string $type
     * @param bool $customize
     * @param bool $force
     *
     * @throws \WebComplete\core\utils\alias\AliasException
     */
    public function __construct(
        AliasService $aliasService,
        InflectorHelper $inflectorHelper,
        string $section,
        string $name,
        string $type,
        bool $customize,
        bool $force = false
    ) {
        $this->section = $section;
        $this->name = $name;
        $this->type = $type;
        $this->customize = $customize;
        $this->force = $force;
        $this->nameVar = $inflectorHelper->variablize($this->name);
        $this->nameCamel = $inflectorHelper->camelize($this->name);
        $this->nameUnderscore = $inflectorHelper->underscore($this->nameCamel);
        $this->path = $aliasService->get('@app/cubes/' . $this->section . '/' . $this->nameVar);
        $this->namespace = 'cubes\\' . $this->section . '\\' . $this->nameVar;
    }
}
