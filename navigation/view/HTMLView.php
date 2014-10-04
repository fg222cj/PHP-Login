<?php
/**
 * Created by PhpStorm.
 * User: erikmagnusson
 * Date: 17/09/14
 * Time: 19:26
 */
class HTMLView {

    public function echoHTML($body) {
        echo "
				<!DOCTYPE html>
				<html>
                    <body>
                        $body
                    </body>
				</html>
            ";
    }
}