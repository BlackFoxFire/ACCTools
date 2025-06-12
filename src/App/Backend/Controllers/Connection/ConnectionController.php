<?php

/**
 * ConnectionController.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace App\Backend\Controllers\Connection;

use Blackfox\BackController;
use Blackfox\HTTPRequest;
use Blackfox\Config\Config;
use Blackfox\Config\Link;

class ConnectionController extends BackController
{
    /**
     * Permet de se connecter à la zone d'administration
     * 
     * @param HTTPRequest $request
     * 
     * @return void
     */
    public function executeIndex(HTTPRequest $request): void
    {
        if($request->formIsSubmit())
        {
            $username = $request->getFromPost('username');
            $password = $request->getFromPost('password');

            $datas = array(
                'username' => $username,
                'password' => $password
            );
            
            if($username == Config::backend('admin') && 
               password_verify($password, Config::backend('password'))) {
            //if($username == $this->app->config()['backend']['admin'] && 
               //password_verify($password, $this->app->config()['backend']['password'])) {
                $this->app->user()->setAuthenticated(true);
                $this->app->user()->set('security', bin2hex(random_bytes(32)));
                $this->app->httpResponse()->redirect(Link::get('url_admin'));

                if($request->postKeyExists('rememberMe')) {
                    /*
                    $day = 120;
                    $cookieLife = time() + $day;

                    $cookieDatas = array(
                        'expires' => $cookieLife,
						'path' => "/",
						'domain' => "",
						'secure' => true,
						'httponly' => true,
						'samesite' => "Strict"
                    );

                    $this->app->httpResponse()->setCookie("rememberMe", "", $cookieDatas);
                    */
                }
            }
            else
            {
                $datas['badPassword'] = true;
            }

            $this->view->setData($datas);
        }
    }

}
