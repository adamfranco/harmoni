<?php

/**
 * The Service Interface defines what methods are required for a Harmoni Service. 
 * 
 * Harmoni services can be set up with the Services interface to give scripts easy
 * access to any services they need.
 * Services should extend this class somewhere in their inheritance tree. (probably the top)
 * 
 * @see {@link ServicesInterface}
 * @version $Id: Service.interface.php,v 1.3 2003/06/27 13:51:38 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.services
 **/
class ServiceInterface {
	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>