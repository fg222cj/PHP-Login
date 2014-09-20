<?php

session_start();
error_reporting(E_ALL); ini_set('display_errors','on');
ini_set('default_charset', 'UTF-8');
date_default_timezone_set('Europe/Stockholm');

require_once("controller/controller.php");
require_once("view/HTMLView.php");

$view = new HTMLView();
$Controller = new ControllerClass();

$ControllerFormControll = $Controller->formControll();

$view->echoHTML($ControllerFormControll);
