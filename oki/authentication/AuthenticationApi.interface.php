<?php

class AuthenticationManager
	extends OsidManager
{ // begin AuthenticationManager
	// public osid.shared.TypeIterator & getAuthenticationTypes();
	function & getAuthenticationTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Agent & authenticate(osid.shared.Type & $authenticationType);
	function & authenticate(& $authenticationType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean isAuthenticated(osid.shared.Type & $authenticationType);
	function isAuthenticated(& $authenticationType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void destroyAuthentication();
	function destroyAuthentication() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void destroyAuthentication(osid.shared.Type & $authenticationType);
	function destroyAuthentication(& $authenticationType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end AuthenticationManager


// public static final String AUTHENTICATION_TYPE_INVALID = "Authentication type is invalid";
define("AUTHENTICATION_TYPE_INVALID","Authentication type is invalid";);

class AuthenticationException
	extends OsidException
{ // begin AuthenticationException
} // end AuthenticationException


?>
