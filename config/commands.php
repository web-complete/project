<?php

return [
    \modules\admin\commands\AdminInitCommand::class,
    \modules\admin\commands\MinifyJsCommand::class,
    \WebComplete\core\utils\migration\commands\MigrationUpCommand::class,
    \WebComplete\core\utils\migration\commands\MigrationDownCommand::class,
];
