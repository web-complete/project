<?php

namespace cubes\system\user;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityRepositoryDb;

class UserRepositoryDb extends AbstractEntityRepositoryDb implements UserRepositoryInterface
{

    protected $table = 'user';
    protected $serializeFields = ['roles'];

    /**
     * @param UserFactory $factory
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        UserFactory $factory,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $conditionParser, $db);
    }

    /**
     * @param string $token
     *
     * @return User|AbstractEntity|null
     */
    public function findByToken(string $token)
    {
        return $this->findOne($this->createCondition(['t1.token' => $token]));
    }
}
