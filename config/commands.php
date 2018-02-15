<?php

return [
    \modules\admin\commands\AdminInitCommand::class,
    \modules\admin\commands\MinifyJsCommand::class,
    \modules\admin\commands\GenerateCommand::class,
    \WebComplete\core\utils\cache\CacheCommand::class,
    \WebComplete\core\utils\migration\commands\MigrationUpCommand::class,
    \WebComplete\core\utils\migration\commands\MigrationDownCommand::class,
    \cubes\system\seo\sitemap\commands\SitemapCommand::class,
    \cubes\system\search\search\commands\SearchClearCommand::class,
    \cubes\system\search\search\commands\SearchCountCommand::class,
    \cubes\system\search\search\commands\SearchReindexCommand::class,
];
