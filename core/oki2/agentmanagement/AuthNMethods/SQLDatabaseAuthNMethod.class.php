<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLDatabaseAuthNMethod.class.php,v 1.5 2005/03/24 15:43:21 adamfranco Exp $
 */ 
 
require_once(dirname(__FILE__)."/AuthNMethod.abstract.php");

/**
 * The SQLDatabaseAuthNMethod is used to authenticate against a SQL database.
 * 
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLDatabaseAuthNMethod.class.php,v 1.5 2005/03/24 15:43:21 adamfranco Exp $
 */
class SQLDatabaseAuthNMethod
	extends AuthNMethod
{
	/**
	 * Stores the configuration. Calls the parent configuration first,
	 * then does additional operations.
	 * 
	 * @param object Properties $configuration
	 * @return object
	 * @access public
	 * @since 3/24/05
	 */
	function assignConfiguration ( &$configuration ) {
	
		parent::assignConfiguration($configuration);
		
		// Validate the configuration options we use:
		ArgumentValidator::validate (
			$this->_configuration->getProperty('properties_fields'), 
			new ArrayValidatorRuleWithRule(new StringValidatorRule));
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('database_id'), 
			new IntegerValidatorRule);
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('authentication_table'), 
			new StringValidatorRule);
		
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('username_field'), 
			new StringValidatorRule);
		
		ArgumentValidator::validate (
			$this->_configuration->getProperty('password_field'), 
			new StringValidatorRule);
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('allow_token_addition'), 
			new OptionalRule(new BooleanValidatorRule));
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('allow_token_deletion'), 
			new OptionalRule(new BooleanValidatorRule));
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('allow_token_updates'), 
			new OptionalRule(new BooleanValidatorRule));
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('allow_property_updates'), 
			new OptionalRule(new BooleanValidatorRule));
			
	}
		
	/**
	 * Create a Tokens Object
	 * 
	 * @return object Tokens
	 * @access public
	 * @since 3/1/05
	 */
	function createTokensObject () {
		$tokensClass = $this->_configuration->getProperty('tokens_class');
		$newTokens =& new $tokensClass($this->_configuration);
		
		$validatorRule = new ExtendsValidatorRule('UsernamePasswordAuthNTokens');
		if ($validatorRule->check($newTokens))
			return $newTokens;
		else
			throwError( new Error("Configuration Error: tokens_class, '".$tokensClass."' does not extend UsernamePasswordAuthNTokens.",
									 "SQLDatabaseAuthNMethod", true));
		
	}
	
	/**
	 * Authenticate an AuthNTokens object
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function authenticateTokens ( &$authNTokens ) {
		ArgumentValidator::validate($authNTokens, new ExtendsValidatorRule("AuthNTokens"));
		
		$dbc =& Services::getService("DBHandler");
		$dbId = $this->_configuration->getProperty('database_id');
		$authenticationTable = $this->_configuration->getProperty('authentication_table');
		$usernameField = $this->_configuration->getProperty('username_field');
		$passwordField = $this->_configuration->getProperty('password_field');
		
		$query = & new SelectQuery;
		$query->addTable($authenticationTable);
		$query->addColumn("COUNT(*)", "count");
		$query->addWhere(
			$usernameField."='".addslashes($authNTokens->getUsername())."'");
		$query->addWhere(
			$passwordField."='".addslashes($authNTokens->getPassword())."'", _AND);
		$result = & $dbc->query($query, $dbId);
		
		if ($result->field("count") == 1)
			return TRUE;
		else if ($result->field("count") == 0)
			return FALSE;
		else
			throwError( new Error("Authorization Error: "
							.$result->field("count")
							." results were returned when authenticating '"
							.$authNTokens->getUsername()."'; should be 0 or 1.",
									 "SQLDatabaseAuthNMethod", true));
	}
	
	/**
	 * Return true if the tokens can be matched in the system.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function tokensExist ( &$authNTokens ) {
		ArgumentValidator::validate($authNTokens, new ExtendsValidatorRule("AuthNTokens"));
		
		$dbc =& Services::getService("DBHandler");
		$dbId = $this->_configuration->getProperty('database_id');
		$authenticationTable = $this->_configuration->getProperty('authentication_table');
		$usernameField = $this->_configuration->getProperty('username_field');
		
		$query = & new SelectQuery;
		$query->addTable($authenticationTable);
		$query->addColumn("COUNT(*)", "count");
		$query->addWhere(
			$usernameField."='".addslashes($authNTokens->getUsername())."'");
		$result = & $dbc->query($query, $dbId);
		
		if ($result->field("count") == 1)
			return TRUE;
		else if ($result->field("count") == 0)
			return FALSE;
		else
			throwError( new Error("Authorization Error: "
							.$result->field("count")
							." results were returned when checking the existance of '"
							.$authNTokens->getUsername()."'; should be 0 or 1.",
									 "SQLDatabaseAuthNMethod", true));
	}
	
	/**
	 * A private method used to populate the Properties that correspond to the
	 * given AuthNTokens
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @param object Properties $properties
	 * @return void
	 * @access private
	 * @since 3/1/05
	 */
	function _populateProperties ( &$authNTokens, &$properties ) {
		ArgumentValidator::validate($authNTokens, new ExtendsValidatorRule("AuthNTokens"));
		ArgumentValidator::validate($properties, new ExtendsValidatorRule("Properties"));
		
		$dbc =& Services::getService("DBHandler");
		$dbId = $this->_configuration->getProperty('database_id');
		$authenticationTable = $this->_configuration->getProperty('authentication_table');
		$usernameField = $this->_configuration->getProperty('username_field');
		$propertiesFields =& $this->_configuration->getProperty('properties_fields');
		
		// if we aren't looking for any properties from the database, don't 
		// bother running a query.
		if (!is_array($propertiesFields) || !count($propertiesFields))
			return;
		
		$query = & new SelectQuery;
		$query->addTable($authenticationTable);
		
		foreach ($propertiesFields as $propertyKey => $fieldName) {
			$query->addColumn($fieldName);
		}
		
		$query->addWhere(
			$usernameField."='".addslashes($authNTokens->getUsername())."'");
		$result =& $dbc->query($query, $dbId);
		
		if ($result->getNumberOfRows() == 1) {
			foreach ($propertiesFields as $propertyKey => $fieldName) {
				
				// Properties take values by reference, so we have to work around
				// that by creating/unsetting variables.
				$value = $result->field($fieldName);
				$properties->addProperty($propertyKey, $value);
				unset($value);
			}	
		} else if ($result->getNumberOfRows() == 0)
			return;
		else
			throwError( new Error("Authorization Error: "
							.$result->getNumberOfRows()
							." results were returned when trying to populate the properties for '"
							.$authNTokens->getUsername()."'; should be 0 or 1.",
									 "SQLDatabaseAuthNMethod", true));
	}
	
	/**
	 * Get an iterator of the AuthNTokens that match the search string passed.
	 * The '*' wildcard character can be present in the string and will be
	 * converted to the system wildcard for the AuthNMethod if wildcards are
	 * supported or removed (and the exact string searched for) if they are not
	 * supported.
	 *
	 * When multiple fields are searched on an OR search is performed, i.e.
	 * '*ach*' would match username/fullname 'achapin'/'Chapin, Alex' as well as
	 *  'zsmith'/'Smith, Zach'.
	 * 
	 * @param string $searchString
	 * @return object ObjectIterator
	 * @access public
	 * @since 3/3/05
	 */
	function &getTokensBySearch ( $searchString ) {
		$dbc =& Services::getService("DBHandler");
		$dbId = $this->_configuration->getProperty('database_id');
		$authenticationTable = $this->_configuration->getProperty('authentication_table');
		$usernameField = $this->_configuration->getProperty('username_field');
		$propertiesFields =& $this->_configuration->getProperty('properties_fields');
		
		$searchString = str_replace('*', '%', $searchString);
		
		$query = & new SelectQuery;
		$query->addTable($authenticationTable);
		$query->addColumn($usernameField);
		$query->addWhere(
			$usernameField." LIKE ('".addslashes($searchString)."')", _OR);
		
		if (is_array($propertiesFields) && count($propertiesFields)) {
			foreach ($propertiesFields as $propertyKey => $fieldName) {
				$query->addWhere(
					$fieldName." LIKE ('".addslashes($searchString)."')", _OR);
			}
		}
		
		$result =& $dbc->query($query, $dbId);
		
		$tokens = array();
		while ($result->hasMoreRows()) {
			$tokens[] =& $this->createTokensForIdentifier($result->field($usernameField));
			$result->advanceRow();
		}
		
		return new HarmoniObjectIterator($tokens);
	}
	
	/**
	 * Return TRUE if this method supports token addition.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function supportsTokenAddition () {
		if ($this->_configuration->getProperty('allow_token_addition') !== NULL)
			return $this->_configuration->getProperty('allow_token_addition');
		else
			return TRUE;
	}
	
	/**
	 * Add tokens to the system.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function addTokens ( &$authNTokens ) {
		ArgumentValidator::validate($authNTokens, new ExtendsValidatorRule("AuthNTokens"));
		
		if ($this->tokensExist($authNTokens)) {
			throwError( new Error("Token Addition Error: ".
							"'".$authNTokens->getUsername()."' already exists.",
									 "SQLDatabaseAuthNMethod", true));
		} else {
			$dbc =& Services::getService("DBHandler");
			$dbId = $this->_configuration->getProperty('database_id');
			$authenticationTable = $this->_configuration->getProperty('authentication_table');
			$usernameField = $this->_configuration->getProperty('username_field');
			$passwordField = $this->_configuration->getProperty('password_field');
			
			$query = & new InsertQuery;
			$query->setTable($authenticationTable);
			$query->setColumns(array(
				$usernameField,
				$passwordField
			));
			$query->addRowOfValues(array(
				"'".addslashes($authNTokens->getUsername())."'",
				"'".addslashes($authNTokens->getPassword())."'"
			));
			$result = & $dbc->query($query, $dbId);
		}
	}
	
	/**
	 * Return TRUE if this method supports token deletion.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function supportsTokenDeletion () {
		if ($this->_configuration->getProperty('allow_token_deletion') !== NULL)
			return $this->_configuration->getProperty('allow_token_deletion');
		else
			return TRUE;
	}
	
	/**
	 * Add tokens and associated Properties to the system.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function deleteTokens ( &$authNTokens ) {
		ArgumentValidator::validate($authNTokens, new ExtendsValidatorRule("AuthNTokens"));
		
		if (!$this->tokensExist($authNTokens)) {
			throwError( new Error("Token Deletion Error: "
							."'".$authNTokens->getUsername()."' does not exist.",
									 "SQLDatabaseAuthNMethod", true));
		} else {
			$dbc =& Services::getService("DBHandler");
			$dbId = $this->_configuration->getProperty('database_id');
			$authenticationTable = $this->_configuration->getProperty('authentication_table');
			$usernameField = $this->_configuration->getProperty('username_field');
			$passwordField = $this->_configuration->getProperty('password_field');
			
			$query = & new DeleteQuery;
			$query->setTable($authenticationTable);
			$query->addWhere(
				$usernameField."='".addslashes($authNTokens->getUsername())."'");
			$result = & $dbc->query($query, $dbId);
		}
	}
	
	/**
	 * Return TRUE if this method supports token updates.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function supportsTokenUpdates () {
		if ($this->_configuration->getProperty('allow_token_updates') !== NULL)
			return $this->_configuration->getProperty('allow_token_updates');
		else
			return TRUE;
	}
	
	/**
	 * Update old tokens to new tokens in the system.
	 * 
	 * @param object AuthNTokens $oldAuthNTokens
	 * @param object AuthNTokens $newAuthNTokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function updateTokens ( &$oldAuthNTokens, &$newAuthNTokens ) {
		ArgumentValidator::validate($oldAuthNTokens, new ExtendsValidatorRule("AuthNTokens"));
		ArgumentValidator::validate($newAuthNTokens, new ExtendsValidatorRule("AuthNTokens"));
		
		if (!$this->tokensExist($oldAuthNTokens)) {
			throwError( new Error("Token Update Error: "
							."'".$oldAuthNTokens->getUsername()."' does not exist.",
									 "SQLDatabaseAuthNMethod", true));
		} else {
			$dbc =& Services::getService("DBHandler");
			$dbId = $this->_configuration->getProperty('database_id');
			$authenticationTable = $this->_configuration->getProperty('authentication_table');
			$usernameField = $this->_configuration->getProperty('username_field');
			$passwordField = $this->_configuration->getProperty('password_field');
			
			$query = & new UpdateQuery;
			$query->setTable($authenticationTable);
			$query->setColumns(array(
				$usernameField,
				$passwordField
			));
			$query->setValues(array(
				"'".addslashes($newAuthNTokens->getUsername())."'",
				"'".addslashes($newAuthNTokens->getPassword())."'"
			));
			$query->addWhere(
				$usernameField."='".addslashes($oldAuthNTokens->getUsername())."'");
			$result = & $dbc->query($query, $dbId);
		}
	}
	
	/**
	 * Return TRUE if this method supports property updates.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function supportsPropertyUpdates () {
		if ($this->_configuration->getProperty('allow_property_updates') !== NULL)
			return $this->_configuration->getProperty('allow_property_updates');
		else
			return TRUE;
	}
	
	/**
	 * Update the properties for the given tokens
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @param object Properties $newProperties
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function updatePropertiesForTokens ( &$authNTokens, &$newProperties ) {
		ArgumentValidator::validate($authNTokens, new ExtendsValidatorRule("AuthNTokens"));
		ArgumentValidator::validate($newProperties, new ExtendsValidatorRule("Properties"));
		
		if (!$this->tokensExist($authNTokens)) {
			throwError( new Error("Properties Update Error: "
							."'".$authNTokens->getUsername()."' does not exist.",
									 "SQLDatabaseAuthNMethod", true));
		} else {
			$dbc =& Services::getService("DBHandler");
			$dbId = $this->_configuration->getProperty('database_id');
			$authenticationTable = $this->_configuration->getProperty('authentication_table');
			$usernameField = $this->_configuration->getProperty('username_field');
			$passwordField = $this->_configuration->getProperty('password_field');
			$propertiesFields =& $this->_configuration->getProperty('properties_fields');
			
			if (!is_array($propertiesFields) || !count($propertiesFields))
				return;
			
			$query = & new UpdateQuery;
			$query->setTable($authenticationTable);
			$columns = array();
			$values = array();
			
			foreach ($propertiesFields as $propertyKey => $fieldName) {
				
				// Don't allow overwriting of tokens even if they are listed in the
				// properties array.
				if ($fieldName != $usernameField 
					&& $fieldName != $passwordField)
				{
					$columns[] = $fieldName;
					$values[] = "'"
						.addslashes($newProperties->getProperty($propertyKey))."'";
				}
			}
			$query->setColumns($columns);
			$query->setValues($values);
			
			$query->addWhere(
				$usernameField."='".addslashes($authNTokens->getUsername())."'");
			$result = & $dbc->query($query, $dbId);
		}
	}
}

?>