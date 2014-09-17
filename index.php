 <?php
 /**
  * Created by PhpStorm.
  * User: erikmagnusson
  * Date: 17/09/14
  * Time: 19:25
  */
session_start();
error_reporting(E_ALL); ini_set('display_errors', 'on');
ini_set( 'default_charset', 'UTF-8' );

require_once("controller/controller.php");
require_once("view/HTMLView.php");


$view = new HTMLView();
$LC = new ControllerClass();

$LVC = $LC->formControll();

$view->echoHTML($LVC);
