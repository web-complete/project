<?php

use modules\admin\classes\mongo\Mongo;
use MongoDB\Client;

return [
    'mongo_db' => 'project',
    Client::class => \DI\autowire(Client::class),
    Mongo::class => \DI\autowire(Mongo::class)
        ->constructorParameter('database', \DI\get('mongo_db')),
];