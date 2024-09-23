<?php

/*
*
* FrontendApplication.php
* @Auteur : Christophe Dufour
*
* Application orientée utilisateur.
*
*/

namespace AccTools\App\Frontend;

use \Mamba\Application;

class FrontendApplication extends Application
{
	
	/*
		Constructeur
		------------
	*/
	public function __construct(string $rootDir, string $appDir, string $appName)
	{
		$this->name = "Frontend";
		parent::__construct($rootDir, $appDir, $appName);
	}
	
	/*
		Les méthodes
		------------
	*/
	
	// Lance l'application
	public function run(): void
	{
		$controller = $this->getController();
		$controller->execute();

		$this->httpResponse->setView($controller->view());
		$this->httpResponse->render();
	}
}