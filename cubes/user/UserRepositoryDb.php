<?php

namespace cubes\user;

use Doctrine\DBAL\Connection;
use WebComplete\core\condition\ConditionDbParser;
use WebComplete\core\entity\AbstractEntityRepositoryDb;
use WebComplete\core\factory\ObjectFactory;
use WebComplete\core\utils\hydrator\HydratorInterface;

class UserRepositoryDb extends AbstractEntityRepositoryDb implements UserRepositoryInterface
{

    protected $table = 'user';

    protected $serializeFields = ['roles'];

    /**
     * @param UserFactory $factory
     * @param HydratorInterface $hydrator
     * @param ConditionDbParser $conditionParser
     * @param Connection $db
     */
    public function __construct(
        UserFactory $factory,
        HydratorInterface $hydrator,
        ConditionDbParser $conditionParser,
        Connection $db
    ) {
        parent::__construct($factory, $hydrator, $conditionParser, $db);
    }
}
