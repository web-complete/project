<?php

namespace cubes\system\user;

use cubes\system\auth\IdentityInterface;
use cubes\system\auth\IdentityServiceInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\helpers\SecurityHelper;

/**
 * @method User create()
 * @method User|null findById($id)
 * @method User|null findOne(Condition $condition)
 * @method User[] findAll(Condition $condition = null)
 */
class UserService extends AbstractEntityService implements UserRepositoryInterface, IdentityServiceInterface
{

    /**
     * @var UserRepositoryInterface
     */
    protected $repository;
    /**
     * @var User|null
     */
    protected $currentUser;
    /**
     * @var SecurityHelper
     */
    protected $securityHelper;

    /**
     * @param UserRepositoryInterface $repository
     * @param SecurityHelper $securityHelper
     */
    public function __construct(
        UserRepositoryInterface $repository,
        SecurityHelper $securityHelper
    ) {
        parent::__construct($repository);
        $this->securityHelper = $securityHelper;
    }

    /**
     * @return User|null
     */
    public function current()
    {
        return $this->currentUser;
    }

    /**
     * @param User|IdentityInterface $user
     */
    public function login(IdentityInterface $user)
    {
        $this->currentUser = $user;
    }

    /**
     * @param SessionInterface|null $session
     */
    public function logout($session)
    {
        if ($this->currentUser) {
            $this->currentUser->token = null;
            $this->save($this->currentUser);
        }

        if ($session) {
            $session->clear();
        }

        $this->currentUser = null;
    }

    /**
     * @param string $login
     *
     * @return User|AbstractEntity|IdentityInterface|null
     */
    public function findByLogin(string $login)
    {
        $condition = $this->repository->createCondition(['login' => $login]);
        return $this->repository->findOne($condition);
    }

    /**
     * @param string $token
     *
     * @return User|AbstractEntity|IdentityInterface|null
     */
    public function findByToken(string $token)
    {
        $condition = $this->repository->createCondition(['token' => $token]);
        return $this->repository->findOne($condition);
    }

    /**
     * @param $login
     * @param $password
     * @param SessionInterface|null $session
     *
     * @return User|null
     * @throws \RuntimeException
     */
    public function authByLoginPassword($login, $password, SessionInterface $session = null)
    {
        if (!$login || !$password) {
            return null;
        }

        /** @var User $user */
        if (!$user = $this->findOne(new Condition(['login' => $login]))) {
            return null;
        }

        if (!$user->is_active || !$user->checkPassword($password)) {
            return null;
        }

        if (!$token = $user->token) {
            $token = $this->securityHelper->generateRandomString(50);
            $user->token = $token;
            $this->save($user);
        }

        $this->login($user);
        if ($session) {
            $session->set('userId', $user->getId());
        }

        return $user;
    }
}
