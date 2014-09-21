<?php

session_start();
error_reporting(E_ALL); ini_set('display_errors','on');
ini_set('default_charset', 'UTF-8');
date_default_timezone_set('Europe/Stockholm');

require_once("view/HTMLview.php");
require_once("controller/controller.php");


$view = new HTMLView();
$Controller = new ControllerClass();

$ControllerFormControll = $Controller->formControll();

$view->echoHTML($ControllerFormControll);
