<?php

class Harmoni {

	var $user;		// who
	var $context;	// where + what
	var $form;		// input variables
	var $config;	// application configuration	
	var $oki;		// oki services
	
	
	function Harmoni () {
	
		require_once ("User.class.php");
		require_once ("Context.class.php");
		require_once ("Form.class.php");
		require_once ("Config.class.php");
		//require_once ("OKI.class.php");
	
		$this->user = new User ();
		$this->context = new Context ($_REQUEST);
		$this->form = new Form ($_REQUEST);
		$this->config = new Config ();
		//$this->oki = new OKI ();
		
		################
		# OKI SERVICES #
		################
		
		#$this->oki['authentication'];
		#$this->oki['authorization'];
		#$this->oki['dbc'];
		#$this->oki['dictionary'];
		#$this->oki['filing'];
		#$this->oki['heirarchy'];
		#$this->oki['logging'];
		#$this->oki['shared'];
		#$this->oki['sql'];
	}
	
	function getUser () {
		return $this->user;
	}

	function getContext () {
		return $this->context;
	}
	
	function getConfig () {
		return $this->config;
	}
	
	function getOKI () {
		//return $this->oki;
	}
	
	function execute () {
		$module = $this->context->getValue('module');
		$action = $this->context->getValue('action');
		if (empty ($module)) {
			$module = $this->config->get('DefaultModule');
		}
		require_once ("modules/$module.mod.php");
		if (empty ($action)) {
			eval ("\$action = $module::getDefaultAction();");
		}
		eval ("\$layout = $module::$action(& \$this);");
		print $layout->render();
	}
}

?>