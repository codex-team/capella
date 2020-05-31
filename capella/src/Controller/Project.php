<?php

namespace App\Controller;

use App\API;
use App\DB\DbNames;
use App\DB\Mongo;
use App\Http;
use App\Methods;

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
            $token = Methods::generateId();

            /** Compose project's data */
            $projectData = [
                'name' => (string) $_POST['name'],
                'description' => (string) $_POST['description'],
                'email' => (string) $_POST['email'],
                'token' => (string) $token,
            ];

            /** Save project's data to database */
            Mongo::connect()->{DbNames::PROJECTS}->insertOne($projectData);

            HTTP\Response::OK();

            API\Response::json([
                'token' => $token
            ]);
        } else {
            /** Render page */
            require_once DOCROOT . "src/View/projectForm.php";
        }
    }
}
