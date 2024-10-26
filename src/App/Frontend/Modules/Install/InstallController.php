<?php

/**
 * InstallController.php
 * @Auteur : Christophe Dufour
 * 
 */

namespace Blackfox\AccTools\App\Frontend\Modules\Install;

use Blackfox\Mamba\BackController;
use Blackfox\Mamba\HTTPRequest;
use Blackfox\Mamba\PDOFactory;

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
                $this->writeDbConf($datas);

                $adminPass = password_hash($adminPass, PASSWORD_DEFAULT);
                $this->app->backConfig()->create(['password' => $adminPass]);

                $man = $this->managers->getManagerOf('CreateDB');
                $man->createDB();

                $this->app->appConfig()->set('installed', true);
                $this->app->appConfig()->write();

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
        if(empty($this->app->appConfig()->get())) {
            return $this->app->appConfig()->create(['installed' => false]);
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
            PDOFactory::mysqlConnexion($dbConf);
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

    /**
     * Ecrit le fichier de configguration de la base de données
     * Retourne le nombre d'octets écrits, ou false si une erreur survient.
     * 
     * @param array $dbConf, tableau de configuration de la base de données
     * 
     * @return int|false
     */
    protected function writeDbConf(array $dbConf): int|false
    {
        foreach($dbConf as $key => $value) {
            $this->app->dbConfig()->set($key, $value);
        }

        return $this->app->dbConfig()->write();
    }

}
