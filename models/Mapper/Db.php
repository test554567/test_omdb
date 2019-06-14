<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Db
{
    protected $dbEntity;

    //TODO config
    public static function getDbEntity()
    {
        $db = [
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => '',
            'host' => '127.0.0.1',
            'port' => '3306',
            'dbname' => 'omdb',
        ];
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../"), $isDevMode);
        return EntityManager::create($db, $config);
    }


}