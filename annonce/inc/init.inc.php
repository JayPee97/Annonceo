<?php
//session_start() : se positionne toujours en haut ET en premier avant ls traitements php

session_start();

//connextion a la bdd :
$pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));

//var_dump($pdo);

//Definition d'une constante :
define('URL', "http://localhost/PHP_jp/annonce/");

//Déclaration d'une variable :

$content = '';

require_once('fonction.inc.php');







?>








