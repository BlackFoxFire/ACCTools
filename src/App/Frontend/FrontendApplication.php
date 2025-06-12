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
use Blackfox\Config\Config;

class FrontendApplication extends Application
{
	/**
	 * Lance l'application
	 * 
	 * @return void
	 * Ne retourne aucune valeur
	 */
	public function run(): void
	{
		if(Config::global('installed')) {
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
