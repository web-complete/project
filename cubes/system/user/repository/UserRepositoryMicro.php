<?php

namespace cubes\system\user\repository;

use cubes\system\user\UserFactory;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\microDb\MicroDb;

class UserRepositoryMicro extends AbstractEntityRepositoryMicro implements UserRepositoryInterface
{

    protected $collectionName = 'user';

    public function __construct(
        UserFactory $factory,
        MicroDb $microDb,
        ConditionMicroDbParser $conditionParser
    ) {
        parent::__construct($factory, $microDb, $conditionParser);
    }
}
