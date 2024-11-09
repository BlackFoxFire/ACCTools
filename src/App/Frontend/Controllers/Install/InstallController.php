<?php

/**
 * InstallController.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace App\Frontend\Controllers\Install;

use Blackfox\BackController;
use Blackfox\HTTPRequest;
use Blackfox\Config\Enums\ConfigEnum;
use Blackfox\Database\PDOFactory;

class InstallController extends BackController
{

    /**
     * Lance le processus d'installation
     * 
     * @param HTTPRequest $request
     * 
     * @return void
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
                $this->app->config()->set('dbname', $dbConf['db'], ConfigEnum::Database);
                $this->app->config()->set('username', $dbConf['login'], ConfigEnum::Database);
                $this->app->config()->set('password', $dbConf['password'], ConfigEnum::Database);

                $adminPass = password_hash($adminPass, PASSWORD_DEFAULT);
                $this->app->config()->set('password', $adminPass, ConfigEnum::Backend);

                $man = $this->managers->getManagerOf('CreateDB');
                $man->createDB();

                $this->app->config()->set('installed', true, ConfigEnum::Global);
                $this->app->config()->write();

                $this->app->httpResponse()->redirect("/");
            }

            $this->view->setData($datas);
        }
    }

    /**
     * Ecrit le fichier de configuration général de l'application
     * Retourne le nombre d'octets écrits, ou false si une erreur survient.
     * 
     * @return int|false
     */
    protected function setAppConfig(): int|false
    {
        if(empty($this->app->config['global'])) {
            $this->app->config()->set('installed', false, ConfigEnum::Global);
            return $this->app->config()->write();
        }

        return false;
    }

    /**
     * Test si la connexion avec la base de données est possible
     * Retourne true en cas de succès, sinon false
     * 
     * @param array $dbConf, tableau de configuration de la base de données
     * 
     * @return bool
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
     * Retourne true en cas de succès, sinon false
     * 
     * @param string $adminPass, le mot de passe à tester
     * 
     * @return bool
     */
    protected function adminPassTest(string $adminPass): bool
    {
        if(is_string($adminPass) && strlen($adminPass) >= 8) {
            return true;
        }

        return false;
    }

}
