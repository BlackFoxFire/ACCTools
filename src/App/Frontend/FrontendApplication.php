<?php

/*
*
* FrontendApplication.php
* @Auteur : Christophe Dufour
*
* Application orientée utilisateur
*/

namespace App\Frontend;

use Blackfox\Application;
use Blackfox\Config\Enums\AreaConfig;

class FrontendApplication extends Application
{

	/**
	 * Constructeur
	 * 
	 * @param string $rootDir
	 * Dossier racine de l'application
	 */
	public function __construct(string $rootDir)
	{
		$this->name = "Frontend";
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
		if($this->config->get('installed', AreaConfig::Global)) {
			$controller = $this->getController();
		}
		else {
			$controller = new \App\Frontend\Controllers\Install\InstallController($this,'Install', 'index');
		}

		$controller->execute();

		$this->httpResponse->setView($controller->view());
		$this->httpResponse->render();
	}

}
