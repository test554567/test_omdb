<?php

require_once 'Db.php';

class MapperAbstract
{
    protected $entityManager;

    public function __construct()
    {
        $this->entityManager = Db::getDbEntity();
    }

    public function getEntityManager() {
        return $this->entityManager;
    }
}
?>