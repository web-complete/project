<?php

namespace cubes\system\user\tests;

use cubes\system\user\User;
use Mvkasatkin\mocker\Mocker;
use WebComplete\core\utils\helpers\SecurityHelper;
use WebComplete\mvc\ApplicationConfig;
use WebComplete\rbac\Rbac;

class UserTest extends \AppTestCase
{

    public function testUserPassword()
    {
        $helper = new SecurityHelper();
        $config = $this->container->get(ApplicationConfig::class);
        $user = $this->container->make(User::class);
        $user->setNewPassword('123password');
        $passwordHash = $helper->cryptPassword('123password', $config['salt']);
        $this->assertEquals($passwordHash, $user->password);
    }

    public function testCheckPassword()
    {
        $user = $this->container->make(User::class);
        $user->setNewPassword('123password');
        $this->assertFalse($user->checkPassword('123456'));
        $this->assertTrue($user->checkPassword('123password'));
    }
}
