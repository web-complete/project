<?php

namespace cubes\system\user;

use cubes\system\auth\IdentityInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\helpers\SecurityHelper;
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
        return UserConfig::fieldTypes();
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
        return $this->get('login');
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->set('login', $login);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->get('email');
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->set('email', $email);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->get('password');
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $hash = $this->securityHelper->cryptPassword($password, $this->config['salt']);
        $this->set('password', $hash);
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
     * @return null|string
     * @throws \RuntimeException
     */
    public function getMaskedToken()
    {
        if ($token = $this->getToken()) {
            return $this->securityHelper->maskToken($token);
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->get('token');
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->set('token', $token);
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->get('first_name');
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->set('first_name', $firstName);
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->get('last_name');
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->set('last_name', $lastName);
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->get('sex');
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->set('sex', $sex);
    }

    /**
     * @return mixed
     */
    public function getLastVisit()
    {
        return $this->get('last_visit');
    }

    /**
     * @param mixed $lastVisit
     */
    public function setLastVisit($lastVisit)
    {
        $this->set('last_visit', $lastVisit);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->get('is_active');
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->set('is_active', $isActive);
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->get('roles');
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->set('roles', $roles);
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->get('created_on');
    }

    /**
     * @return mixed
     */
    public function getUpdatedOn()
    {
        return $this->get('updated_on');
    }

    /**
     * @param mixed $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->set('updated_on', $updatedOn);
    }

    /**
     * Check access rights by rbac permission
     *
     * @param string $permissionName
     * @param null $ruleParams
     *
     * @param bool $checkActive
     *
     * @return bool
     */
    public function can(string $permissionName, $ruleParams = null, bool $checkActive = true): bool
    {
        try {
            return (!$checkActive || $this->isActive())
                ? $this->rbac->checkAccess($this->getId(), $permissionName, $ruleParams)
                : false;
        } catch (RbacException $e) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return \trim($this->getFirstName() . ' ' . $this->getLastName());
    }
}
