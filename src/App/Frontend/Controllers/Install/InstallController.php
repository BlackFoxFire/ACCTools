<?php

/**
 * InstallController.php
 * @Auteur : Christophe Dufour
 * 
 * Gère l'installation de l'application
 */

namespace App\Frontend\Controllers\Install;

use Blackfox\BackController;
use Blackfox\HTTPRequest;
use Blackfox\Config\Enums\AreaConfig;
use Blackfox\Database\PDOFactory;

class InstallController extends BackController
{

    /**
     * Lance le processus d'installation
     * 
     * @param HTTPRequest $request
     * Une requête http
     * @return void
     * Ne retourne aucune valeur
     */
    protected function executeIndex(HTTPRequest $request): void
    {
        $this->setAppConfig();

        if($request->formIsSubmit()) {
            $db = $request->getFromPost("db");
            $login = $request->getFromPost("login");
            $password = $request->getFromPost("password");
            $adminPass = $request->getFromPost("adminPass");

            $datas = array(
                'db' => $db,
                'login' => $login,
                'password' => $password,
            );

            $dbConf = $datas;

            $datas['adminPass'] = $adminPass;

            if(!$this->connectionTest($dbConf)) {
                $this->view->setData('dbError', true);
            }

            if(!$this->adminPassTest($adminPass)) {
                $this->view->setData('adminPassError', true);
            }

            if($this->connectionTest($dbConf) && $this->adminPassTest($adminPass)) {
                $this->app->config()->set('dbname', $dbConf['db'], AreaConfig::Database);
                $this->app->config()->set('username', $dbConf['login'], AreaConfig::Database);
                $this->app->config()->set('password', $dbConf['password'], AreaConfig::Database);

                $adminPass = password_hash($adminPass, PASSWORD_DEFAULT);
                $this->app->config()->set('password', $adminPass, AreaConfig::Backend);

                $man = $this->modelFactory->create('CreateDB');
                $man->createDB();

                $this->app->config()->set('installed', true, AreaConfig::Global);
                $this->app->config()->write();

                $this->app->httpResponse()->redirect("/");
            }

            $this->view->setData($datas);
        }
    }

    /**
     * Ecrit le fichier de configuration général de l'application
     * 
     * @return int|false
     * Retourne le nombre d'octets écrits, ou false si une erreur survient
     */
    protected function setAppConfig(): int|false
    {
        if(empty($this->app->config['global'])) {
            $this->app->config()->set('installed', false, AreaConfig::Global);
            return $this->app->config()->write();
        }

        return false;
    }

    /**
     * Test si la connexion avec la base de données est possible
     * 
     * @param array $dbConf
     * Tableau de configuration de la base de données
     * @return bool
     * Retourne true en cas de succès, sinon false
     */
    protected function connectionTest(array $dbConf): bool
    {
        try {
            PDOFactory::getInstance($dbConf['db'], $dbConf['login'], $dbConf['password']);
            return true;
        }
        catch (\PDOException) {
            return false;
        }

    }

    /**
     * Test si le mot de passe de la zone d'administration est correct
     * 
     * @param string $adminPass
     * Le mot de passe à tester
     * @return bool
     * Retourne true en cas de succès, sinon false
     */
    protected function adminPassTest(string $adminPass): bool
    {
        if(is_string($adminPass) && strlen($adminPass) >= 8) {
            return true;
        }

        return false;
    }

}
