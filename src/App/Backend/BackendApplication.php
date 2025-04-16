<?php

/*
*
* BackendApplication.php
* @Auteur : Christophe Dufour
*
* Application orientée administrateur.
*/

namespace App\Backend;

use Blackfox\Application;

class BackendApplication extends Application
{

	/**
	 * Constructeur
	 * 
	 * @param string $rootDir
	 * Dossier racine de l'application
	 */
	public function __construct(string $rootDir)
	{
		$this->name = "Backend";
		parent::__construct($rootDir, __DIR__, __NAMESPACE__);
	}
	
	/**
	 * Lance l'application
	 * 
	 * @return void
	 * Ne retourne aucune valeur
	 */
	public function run(): void
	{
		if($this->user->isAuthenticated()) {
			$controller = $this->getController();
		}
		else {
			$controller = new \App\Backend\Controllers\Connection\ConnectionController($this,'Connection', 'index');
		}

		$controller->execute();

		$this->httpResponse->setView($controller->view());
		$this->httpResponse->render();
	}
}
