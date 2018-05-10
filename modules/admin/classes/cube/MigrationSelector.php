<?php

namespace modules\admin\classes\cube;

class MigrationSelector
{
    /**
     *
     * @param array $migrations
     * @return mixed
     */
    public static function get(array $migrations)
    {
        switch (\DB_TYPE) {
            case 'micro':
                return $migrations['micro'] ?? [];
                break;
            case 'mysql':
                return $migrations['mysql'] ?? [];
                break;
            case 'mongo':
            default:
                return $migrations['mongo'] ?? [];
                break;
        }
    }
}
