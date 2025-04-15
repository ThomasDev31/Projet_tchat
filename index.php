<?php
session_start();

require './services/loader/loader.php';
use Models\Data;
$datas = new Data();
$datas->createTable();


$route = new \services\rooter\Routing;
$route->router();


$dbb = new \services\database\Bdd;
$dbb->getConnection();
