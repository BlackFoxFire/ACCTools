<?php

/**
 * ConnectionController.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace App\Backend\Controllers\Connection;

use Blackfox\BackController;
use Blackfox\HTTPRequest;

class ConnectionController extends BackController
{

    /**
     * Affiche la page de connexion et connecte un utilisateur
     */
    public function executeIndex(HTTPRequest $request): void
    {
        if($request->formIsSubmit())
        {
            $password = $request->getFromPost('password');
            
            if(password_verify($password, $this->app->config()['backend']['password'])) {
                $this->app->user()->setAuthenticated(true);
                $this->app->httpResponse()->redirect($this->app->link()->get('url_admin'));
            }
            else
            {
                $this->view->setData(["badPassword" => true]);
            }
        }
    }

}