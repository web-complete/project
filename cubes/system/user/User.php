<?php

namespace cubes\system\user;

use cubes\system\auth\IdentityInterface;
use cubes\system\logger\Log;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\helpers\SecurityHelper;
use WebComplete\mvc\ApplicationConfig;
use WebComplete\rbac\entity\RoleInterface;
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
 * @property $roles
 * @property $is_active
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
        return UserConfig::getFieldTypes();
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
     * @param array $ruleParams
     * @param bool $checkActive
     *
     * @return bool
     */
    public function can(string $permissionName, $ruleParams = [], bool $checkActive = true): bool
    {
        try {
            if ($checkActive && !$this->is_active) {
                return false;
            }

            $ruleParams['userId'] = $this->getId();
            $roles = $this->getRoles();
            foreach ($roles as $role) {
                if ($role->checkAccess($permissionName, $ruleParams)) {
                    return true;
                }
            }
        } catch (RbacException $e) {
            Log::exception($e);
        }
        return false;
    }

    /**
     * @return RoleInterface[]
     */
    public function getRoles(): array
    {
        $result = [];
        foreach ((array)$this->roles as $roleName) {
            if ($role = $this->rbac->getRole($roleName)) {
                $result[$roleName] = $role;
            }
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return \trim($this->first_name . ' ' . $this->last_name);
    }
}
