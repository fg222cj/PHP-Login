<?php

session_start();
error_reporting(E_ALL); ini_set('display_errors','on');
ini_set('default_charset', 'UTF-8');
date_default_timezone_set('Europe/Stockholm');

require_once("navigation/view/HTMLView.php");
require_once("navigation/controller/NavigationController.php");


$view = new HTMLView();
$controller = new NavigationController();

$htmlBody = $controller->doNavigation();

$view->echoHTML($htmlBody);
