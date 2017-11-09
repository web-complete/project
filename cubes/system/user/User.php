<?php

namespace cubes\system\user;

use cubes\system\auth\IdentityInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\helpers\SecurityHelper;
use WebComplete\core\utils\typecast\Cast;
use WebComplete\mvc\ApplicationConfig;
use WebComplete\rbac\exception\RbacException;
use WebComplete\rbac\Rbac;

class User extends AbstractEntity implements IdentityInterface
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'login' => Cast::STRING,
            'email' => Cast::STRING,
            'password' => Cast::STRING,
            'token' => Cast::STRING,
            'first_name' => Cast::STRING,
            'last_name' => Cast::STRING,
            'sex' => Cast::STRING,
            'last_visit' => Cast::STRING,
            'f_active' => Cast::BOOL,
            'roles' => [Cast::STRING],
            'created_on' => Cast::STRING,
            'updated_on' => Cast::STRING,
        ];
    }

    /**
     * @var SecurityHelper
     */
    protected $securityHelper;
    /**
     * @var ApplicationConfig
     */
    protected $config;
    /**
     * @var Rbac
     */
    protected $rbac;

    /**
     * @param SecurityHelper $securityHelper
     * @param ApplicationConfig $config
     * @param Rbac $rbac
     */
    public function __construct(
        SecurityHelper $securityHelper,
        ApplicationConfig $config,
        Rbac $rbac
    ) {
        $this->securityHelper = $securityHelper;
        $this->config = $config;
        $this->rbac = $rbac;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->getField('login');
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->setField('login', $login);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->getField('email');
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->setField('email', $email);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->getField('password');
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $hash = $this->securityHelper->cryptPassword($password, $this->config['salt']);
        $this->setField('password', $hash);
    }

    /**
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        return $this->getPassword() === $this->securityHelper->cryptPassword($password, $this->config['salt']);
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->getField('token');
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->setField('token', $token);
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->getField('first_name');
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->setField('first_name', $firstName);
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->getField('last_name');
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->setField('last_name', $lastName);
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->getField('sex');
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->setField('sex', $sex);
    }

    /**
     * @return mixed
     */
    public function getLastVisit()
    {
        return $this->getField('last_visit');
    }

    /**
     * @param mixed $lastVisit
     */
    public function setLastVisit($lastVisit)
    {
        $this->setField('last_visit', $lastVisit);
    }

    /**
     * @return bool
     */
    public function getFActive(): bool
    {
        return $this->getField('f_active');
    }

    /**
     * @param mixed $fActive
     */
    public function setFActive($fActive)
    {
        $this->setField('f_active', $fActive);
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->getField('roles');
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->setField('roles', $roles);
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->getField('created_on');
    }

    /**
     * @return mixed
     */
    public function getUpdatedOn()
    {
        return $this->getField('updated_on');
    }

    /**
     * @param mixed $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->setField('updated_on', $updatedOn);
    }

    /**
     * Check access rights by rbac permission
     *
     * @param string $permissionName
     * @param null $ruleParams
     *
     * @return bool
     */
    public function can(string $permissionName, $ruleParams = null): bool
    {
        try {
            return $this->rbac->checkAccess($this->getId(), $permissionName, $ruleParams);
        } catch (RbacException $e) {
            return false;
        }
    }
}
