<?php
/**
 * Created by PhpStorm.
 * User: erikmagnusson
 * Date: 17/09/14
 * Time: 19:25
 */
require_once("./view/view.php");
require_once("./model/model.php");

class ControllerClass {

    public function __construct() {
        $this->view = new ViewClass();
        $this->model = new ModelClass();
    }

    public function formControll() {
        return $this->view->loginForm();

    }

}