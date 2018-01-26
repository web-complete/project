<?php

namespace cubes\notification\template;

use WebComplete\core\entity\AbstractEntityService;

class TemplateService extends AbstractEntityService implements TemplateRepositoryInterface
{

    /**
     * @var TemplateRepositoryInterface
     */
    protected $repository;

    /**
     * @param TemplateRepositoryInterface $repository
     */
    public function __construct(TemplateRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
