<?php

namespace modules;

use cubes\system\auth\RbacLoader;
use cubes\system\logger\Log;
use Monolog\Logger;
use WebComplete\rbac\Rbac;
use WebComplete\rbac\resource\RuntimeResource;

class Application extends \WebComplete\mvc\Application
{
    /**
     * @return array
     * @throws \WebComplete\core\utils\alias\AliasException
     */
    protected function getApplicationDefinitions(): array
    {
        return \array_merge(parent::getApplicationDefinitions(), [
            Rbac::class => function () {
                return new Rbac(new RuntimeResource());
            }
        ]);
    }

    /**
     */
    protected function initErrorHandler()
    {
        register_shutdown_function(function () {
            if ($error = error_get_last()) {
                Log::log(Logger::EMERGENCY, \json_encode($error));
            }
        });
        parent::initErrorHandler();
    }

    /**
     * @throws \WebComplete\rbac\exception\RbacException
     */
    protected function bootstrapCubes()
    {
        $rbacLoader = $this->getContainer()->get(RbacLoader::class);
        $rbacLoader->initRbacPermissions();
        parent::bootstrapCubes();
        $rbacLoader->initRbacRoles();
    }
}
