<?php

/*
*
* FrontendApplication.php
* @Auteur : Christophe Dufour
*
* Application orientée utilisateur.
*
*/

namespace Blackfox\AccTools\App\Frontend;

use Blackfox\Mamba\Application;

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
		if($this->appConfig->get('installed')) {
			$controller = $this->getController();
		}
		else {
			$controller = new \Blackfox\AccTools\App\Frontend\Modules\Install\InstallController($this,'Install', 'index');
		}

		$controller->execute();

		$this->httpResponse->setView($controller->view());
		$this->httpResponse->render();
	}

}
