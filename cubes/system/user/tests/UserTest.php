<?php

namespace cubes\system\user\tests;

use cubes\system\user\User;
use Mvkasatkin\mocker\Mocker;
use WebComplete\core\utils\helpers\SecurityHelper;
use WebComplete\core\utils\helpers\StringHelper;
use WebComplete\mvc\ApplicationConfig;
use WebComplete\rbac\Rbac;

class UserTest extends \AppTestCase
{

    public function testUserPassword()
    {
        $helper = new SecurityHelper(new StringHelper());
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

    public function testCan()
    {
        /** @var Rbac $rbac */
        $rbac = Mocker::create(Rbac::class, [
            Mocker::method('checkAccess', 1)->with([11, 'update', ['id' => 22]])->returns(true)
        ]);
        $user = new User(new SecurityHelper(new StringHelper()), $this->config, $rbac);
        $user->setId(11);
        $this->assertFalse($user->can('update', ['id' => 22]));
        $user->is_active = true;
        $this->assertTrue($user->can('update', ['id' => 22]));
    }

    public function testCanNot()
    {
        /** @var Rbac $rbac */
        $rbac = Mocker::create(Rbac::class, [
            Mocker::method('checkAccess', 1)->returns(false)
        ]);
        $user = new User(new SecurityHelper(new StringHelper()), $this->config, $rbac);
        $user->is_active = true;
        $user->setId(11);
        $this->assertFalse($user->can('update', ['id' => 22]));
    }
}
