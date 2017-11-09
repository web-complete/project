<?php

namespace cubes\system\user;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\helpers\SecurityHelper;
use WebComplete\mvc\ApplicationConfig;

class User extends AbstractEntity
{

    protected $login;
    protected $email;
    protected $password;
    protected $token;
    protected $first_name;
    protected $last_name;
    protected $sex;
    protected $last_visit;
    protected $f_active;
    protected $roles = [];
    protected $created_on;
    protected $updated_on;
    /**
     * @var SecurityHelper
     */
    private $securityHelper;
    /**
     * @var ApplicationConfig
     */
    private $config;

    /**
     * @param SecurityHelper $securityHelper
     * @param ApplicationConfig $config
     */
    public function __construct(SecurityHelper $securityHelper, ApplicationConfig $config)
    {
        $this->securityHelper = $securityHelper;
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $this->securityHelper->cryptPassword($password, $this->config['salt']);
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
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getLastVisit()
    {
        return $this->last_visit;
    }

    /**
     * @param mixed $lastVisit
     */
    public function setLastVisit($lastVisit)
    {
        $this->last_visit = $lastVisit;
    }

    /**
     * @return bool
     */
    public function getFActive(): bool
    {
        return (bool)$this->f_active;
    }

    /**
     * @param mixed $fActive
     */
    public function setFActive($fActive)
    {
        $this->f_active = (int)$fActive;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return \is_array($this->roles) ? $this->roles : [];
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->created_on;
    }

    /**
     * @return mixed
     */
    public function getUpdatedOn()
    {
        return $this->updated_on;
    }

    /**
     * @param mixed $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updated_on = $updatedOn;
    }
}
