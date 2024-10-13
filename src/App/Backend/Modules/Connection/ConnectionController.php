<?php

/**
 * ConnectionController.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Blackfox\AccTools\App\Backend\Modules\Connection;

use Blackfox\Mamba\BackController;
use Blackfox\Mamba\Config;
use Blackfox\Mamba\HTTPRequest;
use Blackfox\Mamba\Link;

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

            if(password_verify($password, Config::get('password')))
            {
                $this->app->user()->setAuthenticated(true);
                $this->app->httpResponse()->redirect(Link::get('url_admin'));
            }
            else
            {
                $this->view->setData(["badPassword" => true]);
            }
        }
    }

}
