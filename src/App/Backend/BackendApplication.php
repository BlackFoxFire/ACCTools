<?php

/*
*
* BackendApplication.php
* @Auteur : Christophe Dufour
*
* Application orientée administrateur.
*
*/

namespace App\Backend;

use Blackfox\Application;

class BackendApplication extends Application
{
	
	/*
		Constructeur
		------------
	*/
	public function __construct(string $rootDir)
	{
		$this->name = "Backend";
		parent::__construct($rootDir, __DIR__, __NAMESPACE__);
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
			$controller = new \App\Backend\Controllers\Connection\ConnectionController($this,'Connection', 'index');
		}

		$controller->execute();

		$this->httpResponse->setView($controller->view());
		$this->httpResponse->render();
	}
}
