<?php

namespace modules\admin\classes;

abstract class EntityConfig
{

    abstract public static function fieldTypes(): array;
    abstract public function listFields(): array;
    abstract public function detailFields(): array;
    abstract public function form();
}