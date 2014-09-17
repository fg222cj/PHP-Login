 <?php
 /**
  * Created by PhpStorm.
  * User: erikmagnusson
  * Date: 17/09/14
  * Time: 19:25
  */
error_reporting(E_ALL); ini_set('display_errors', 'on');
ini_set( 'default_charset', 'UTF-8' );

require_once("controller/controller.php");
require_once("view/HTMLView.php");
//session_start();

$view = new HTMLView();
$LC = new ControllerClass();

$LVC = $LC->formControll();

$view->echoHTML($LVC);
