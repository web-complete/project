<?php

namespace cubes\system\user;

use cubes\system\auth\IdentityInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\helpers\SecurityHelper;
use WebComplete\mvc\ApplicationConfig;
use WebComplete\rbac\exception\RbacException;
use WebComplete\rbac\Rbac;

/**
 *
 * @property $login
 * @property $email
 * @property $password
 * @property $token
 * @property $first_name
 * @property $last_name
 * @property $sex
 * @property $last_visit
 * @property $is_active
 * @property $roles
 * @property $created_on
 * @property $updated_on
 */
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
     * @param mixed $password
     */
    public function setNewPassword($password)
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
        return $this->password === $this->securityHelper->cryptPassword($password, $this->config['salt']);
    }

    /**
     * @return null|string
     * @throws \RuntimeException
     */
    public function getMaskedToken()
    {
        if ($token = $this->token) {
            return $this->securityHelper->maskToken($token);
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool)$this->get('is_active');
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
            return (!$checkActive || $this->is_active)
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
        return \trim($this->first_name . ' ' . $this->last_name);
    }
}
