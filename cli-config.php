<?php
require_once "bootstrap.php";

require_once "models/Mapper/MapperAbstract.php";
$entityManager = (new MapperAbstract())->getEntityManager();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
