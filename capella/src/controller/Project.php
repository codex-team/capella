<?php

namespace Controller;

use API;
use DB\DbNames;
use HTTP;
use DB\Mongo;

/**
 * Class for showing and processing project form
 */
class Project
{
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /* @todo validate data */

            /** Generate project's token */
            $token = \Methods::generateId();

            /** Compose project's data */
            $projectData = array(
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'email' => $_POST['email'],
                'token' => $token,
            );

            /** Save project's data to database */
            Mongo::connect()->{DbNames::PROJECTS}->insertOne($projectData);

            HTTP\Response::OK();

            API\Response::json(array(
                'token' => $token
            ));
        } else {
            /** Render page */
            require_once DOCROOT . "src/view/projectForm.php";
        }
    }
}
