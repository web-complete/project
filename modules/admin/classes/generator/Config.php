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
    public $type;
    public $path;
    public $namespace;
    public $force;

    /**
     * @param AliasService $aliasService
     * @param InflectorHelper $inflectorHelper
     * @param string $section
     * @param string $name
     * @param string $type
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
        bool $force = false
    ) {
        $this->section = $section;
        $this->name = $name;
        $this->type = $type;
        $this->force = $force;
        $this->nameVar = $inflectorHelper->variablize($this->name);
        $this->nameCamel = $inflectorHelper->camelize($this->name);
        $this->path = $aliasService->get('@app/cubes/' . $this->section . '/' . $this->nameVar);
        $this->namespace = 'cubes\\' . $this->section;
    }
}
