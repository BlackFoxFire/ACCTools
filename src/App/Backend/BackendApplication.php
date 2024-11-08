<?php

/*
*
* BackendApplication.php
* @Auteur : Christophe Dufour
*
* Application orientée administrateur.
*
*/

namespace Blackfox\AccTools\App\Backend;

use Blackfox\Application;

class BackendApplication extends Application
{
	
	/*
		Constructeur
		------------
	*/
	public function __construct(string $rootDir, string $appDir, string $appName)
	{
		$this->name = "Backend";
		parent::__construct($rootDir, $appDir, $appName);
	}
	
	/*
		Les méthodes
		------------
	*/
	
	// Lance l'application
	public function run(): void
	{
		if($this->user->isAuthenticated())
		{
			$controller = $this->getController();
		}
		else
		{
			$controller = new \Blackfox\AccTools\App\Backend\Modules\Connection\ConnectionController($this,'Connection', 'index');
		}

		$controller->execute();

		$this->httpResponse->setView($controller->view());
		$this->httpResponse->render();
	}
}
