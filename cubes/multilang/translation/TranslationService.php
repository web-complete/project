<?php

namespace cubes\multilang\translation;

use WebComplete\core\entity\AbstractEntityService;

class TranslationService extends AbstractEntityService implements TranslationRepositoryInterface
{

    /**
     * @var TranslationRepositoryInterface
     */
    protected $repository;

    /**
     * @param TranslationRepositoryInterface $repository
     */
    public function __construct(TranslationRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
