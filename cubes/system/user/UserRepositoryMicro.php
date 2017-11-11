<?php

namespace cubes\system\user;

use WebComplete\core\condition\Condition;
use WebComplete\core\condition\ConditionMicroDbParser;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityRepository;
use WebComplete\core\entity\AbstractEntityRepositoryMicro;
use WebComplete\core\factory\EntityFactory;
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

    /**
     * @param string $token
     *
     * @return User|AbstractEntity|null
     * @throws \WebComplete\microDb\Exception
     */
    public function findByToken(string $token)
    {
        return $this->findOne($this->createCondition(['token' => $token]));
    }
}
