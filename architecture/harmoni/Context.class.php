<?php

	################################
	# file: Context.inc			   #
	# This object keeps track of   #
	# the agent's current context. #
	################################

	class Context {
	
		var $vars;
	
		function Context () {
			$vars = $_REQUEST;
		}
		
		function getURL ($params) {
			$url = "index.php?";
					
			if (empty ($params['module'])) {
				$url .= "module=".$this->vars['module']."&";
			}
			
			if (empty ($params['action'])) {
				$url .= "action=".$this->varas['action']."&";
			}
					
			foreach ($params as $key => $val) {
				$url .= "$key=$val&";
			}
			return substr($url, 0, strlen($url) - 1);
		}
		
		function getValue ($param) {
			return $this->vars[$param];
		}
	
	}

?>