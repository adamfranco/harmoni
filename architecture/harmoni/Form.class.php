<?php

class Form {

	var $http_vars;         // http variables held by this form object
	var $errors;            // errors reported from failed validations
	var $validations;       // validation tests

	// Constructor
	// $HTTP_VARS   Should be sent by reference to avoid copying
	function Form() {
		//$this->http_vars = $HTTP_VARS;
		$this->http_vars = $_REQUEST;
	}


	// Returns a submitted form value, or returns a
	// default value.
	function getValue($name,$default) {
		if ($this->http_vars[$name] != "") {
			return trim($this->http_vars[$name]);
		} else {
			return $default;
		}
	}

	// Validates a submitted form value against a regular
	// expression, and stores the error if the match fails.
	//      name    the name of the HTTP variable
	//      regex   the regex to execute: can be a predefined one
	//      errmsg  the error message if the regex fails
	function validate($name,$regex,$errmsg) {
		$val = $this->http_vars[$name];
		
		// if validations are not yet defined, create them
		if ($this->validations == null) {
			$this->getAllValidations();
		}
		
		// see if regex is a predefined regex or an
		// actual regex
		if ($this->validations[$regex] != null) {
			$re = $this->validations[$regex];
		} else {
			$re = $regex;
		}
		
		
		// execute the validation
		if (ereg($re,$val)) {
			return $val;
		} else {
			$this->errors[$name] = $errmsg;
			return "";
		}
			
	}
        
	// Tests if any errors were encountered.
	function hasErrors() {
        if (count($this->errors) > 0) {
			return true;
        } else {
			return false;
        }
	}
        
	// Allows errors to be registered manually
	function registerError($name,$errmsg) {
		$this->errors[$name] = $errmsg;
	}
        
	// Gets an error for a submitted from value, and optionally
	// helps format it.
	//      name            the name of the form element
	//      tag             the tag to embed the error in
	//      cssclass        the css class to assign to this tag
	function getError($name,$tag,$cssclass) {
		// if no error index to that name exists, skip
		if ($this->errors[$name] == "") {
		    return;
		}
		
		if ($tag != "") {
			if ($cssclass != "") {
				return "<$tag class=\"$cssclass\">" . $this->errors[$name] . "</$tag>";
			} else {
				return "<$tag>" . $this->errors[$name] . "</$tag>";
			}
		} else {
			return $this->errors[$name];
		}
	}
        
	// returns a string containing the objects properties
	function toString() {
		$s = "Form<br>";
		
		$s .= "&nbsp;&nbsp;[errors]<br>";
		foreach ($this->errors as $key => $val) {
			$s .= "&nbsp;&nbsp;&nbsp;&nbsp;" .$key . "=" . $val . "<br>";
		}
		
		return $s;
	}
        
	// Gets an array of all predefined validations
	function getAllValidations() {
		$this->validations = array (
		        "REGEX_REQUIRED"        =>      "[^[:blank:]]+",
		        "REGEX_ALPHABETIC"      =>      "[[:alpha:]]+",
		        "REGEX_NUMERIC"         =>      "[[:digit:]]+"
		);
	}
}
                
?>