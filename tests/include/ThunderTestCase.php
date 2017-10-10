<?php

namespace tests;

use Mvkasatkin\mocker\Mocker;
use PHPUnit\Framework\TestCase;

class ThunderTestCase extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Mocker::init($this);
    }
}