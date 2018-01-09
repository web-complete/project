<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>;

use WebComplete\core\entity\AbstractEntityService;

class <?=$config->nameCamel ?>Service extends AbstractEntityService implements <?=$config->nameCamel ?>RepositoryInterface
{

    /**
     * @var <?=$config->nameCamel ?>RepositoryInterface
     */
    protected $repository;

    /**
     * @param <?=$config->nameCamel ?>RepositoryInterface $repository
     */
    public function __construct(<?=$config->nameCamel ?>RepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
