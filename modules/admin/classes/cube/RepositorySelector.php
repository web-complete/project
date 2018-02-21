<?php

namespace modules\admin\classes\cube;

class RepositorySelector
{
    /**
     * @param string|null string $microClass
     * @param string|null $mysqlClass
     * @param string|null $mongoClass
     *
     * @return mixed
     */
    public static function get(string $microClass = null, string $mysqlClass = null, string  $mongoClass = null)
    {
        switch (\DB_TYPE) {
            case 'mongo':
                return \DI\autowire($mongoClass);
                break;
            case 'mysql':
                return \DI\autowire($mysqlClass);
                break;
            case 'micro':
            default:
                return \DI\autowire($microClass);
                break;
        }
    }
}
