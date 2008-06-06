<?php
/**
 * @since 6/4/08
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

/**
 * The VisitorRegistration Method is similar to the SQL Database AuthNMethod, but
 * includes an email confirmation step.
 * 
 * @since 6/4/08
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class VisitorSQLDatabaseAuthNMethod
	extends SQLDatabaseAuthNMethod
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
	function assignConfiguration ( Properties $configuration ) {
		// Set the configuration values to our custom values.
		$configuration->addProperty('authentication_table', 'auth_visitor');
		$configuration->addProperty('username_field', 'email');
		$configuration->addProperty('password_field', 'password');
		$propertiesFields = array(
				'name' => 'display_name',
				'email' => 'email'
		);
		$configuration->addProperty('properties_fields', $propertiesFields);
		
		try {
			ArgumentValidator::validate(
				$configuration->getProperty('email_from_name'),
				NonzeroLengthStringValidatorRule::getRule());
		} catch (InvalidArgumentException $e) {
			throw new ConfigurationErrorException("'email_from_name' must be a string. ".$e->getMessage());
		}
		try {
			ArgumentValidator::validate(
				$configuration->getProperty('email_from_address'),
				RegexValidatorRule::getRule('^.+@.+$'));
		} catch (InvalidArgumentException $e) {
			throw new ConfigurationErrorException("'email_from_address' must be an email address. ".$e->getMessage());
		}
			
		try {
				ArgumentValidator::validate(
				$configuration->getProperty('domain_blacklist'),
				OptionalRule::getRule(
					ArrayValidatorRuleWithRule::getRule(
						NonzeroLengthStringValidatorRule::getRule())));
			ArgumentValidator::validate(
				$configuration->getProperty('domain_whitelist'),
				OptionalRule::getRule(
					ArrayValidatorRuleWithRule::getRule(
						NonzeroLengthStringValidatorRule::getRule())));
		} catch (InvalidArgumentException $e) {
			throw new ConfigurationErrorException("'domain_blacklist' and 'domain_whitelist' if specified must be arrays of domain name strings. ".$e->getMessage());
		}
		
		parent::assignConfiguration($configuration);
		
	}
	
	/**
	 * Should return the 'display_name_property' value for tokens
	 * 
	 * @param object AuthNTokens
	 * @return string
	 * @access public
	 * @since 10/25/05
	 */
	function getDisplayNameForTokens ($authNTokens) {
		$properties =$this->getPropertiesForTokens($authNTokens);

		if (!preg_match('/^.+@([^@]+)$/', $properties->getProperty('email'), $matches))
			throw new OperationFailedException("No email specified.");
		return $properties->getProperty('name')." (".$matches[1].")";
	}
	
	/**
	 * Authenticate an AuthNTokens object
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function authenticateTokens ( $authNTokens ) {
		ArgumentValidator::validate($authNTokens, ExtendsValidatorRule::getRule("AuthNTokens"));
		
		$dbc = Services::getService("DatabaseManager");
		$dbId = $this->_configuration->getProperty('database_id');
		$authenticationTable = $this->_configuration->getProperty('authentication_table');
		$usernameField = $this->_configuration->getProperty('username_field');
		$passwordField = $this->_configuration->getProperty('password_field');
		
		$query =  new SelectQuery;
		$query->addTable($authenticationTable);
		$query->addColumn("COUNT(*)", "count");
		$query->addWhereEqual($usernameField, $authNTokens->getUsername());
		$query->addWhereEqual($passwordField, $authNTokens->getPassword());
		$query->addWhereEqual('email_confirmed', '1');
		
		$result =  $dbc->query($query, $dbId);
		
		if ($result->field("count") == 1) {
			$result->free();
			return TRUE;
		}
		else if ($result->field("count") == 0) {
			$result->free();
			return FALSE;
		}
		else
			throwError( new Error("Authorization Error: "
							.$result->field("count")
							." results were returned when authenticating '"
							.$authNTokens->getUsername()."'; should be 0 or 1.",
									 "SQLDatabaseAuthNMethod", true));
	}
	
	/**
	 * Add tokens to the system.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function addTokens ( $authNTokens ) {
		/*********************************************************
		 * Check validity
		 *********************************************************/
		
		ArgumentValidator::validate($authNTokens, ExtendsValidatorRule::getRule("AuthNTokens"));
		
		if ($this->tokensExist($authNTokens)) {
			throw new OperationFailedException("Cannot create tokens: '".$authNTokens->getUsername()."' already exists.");
		} 
		
		$email = $authNTokens->getUsername();
		
		// Check that the email is in a whitelisted domain if a whitelist is set.
		if (is_array($this->_configuration->getProperty('domain_whitelist'))) {
			$allowed = false;
			foreach ($this->_configuration->getProperty('domain_whitelist') as $domain) {
				if (preg_match('/'.str_replace('.', '\.', $domain).'$/i', $email)) {
					$allowed = true;
					break;
				}
			}
			if (!$allowed) {
				preg_match('/@([^@]+)$/', $email, $matches);
				throw new OperationFailedException("Cannot create visitor registrations from ".$matches[1].". Not in list of allowed domains.");
			}
		}
		
		// Check that the email is not in a blacklisted domain if a blacklist is set.
		if (is_array($this->_configuration->getProperty('domain_blacklist'))) {
			
			foreach ($this->_configuration->getProperty('domain_blacklist') as $domain) {
				if (preg_match('/'.str_replace('.', '\.', $domain).'$/i', $email))
					throw new OperationFailedException("Cannot create visitor registration from $domain. Domain is black-listed.");
			}
		}
		
		// Check that the email is not for someone with an account already in the 
		// system through another authentication method.
		$methodMgr = Services::getService("AuthNMethodManager");
		$types = $methodMgr->getAuthNTypes();
		while($types->hasNext()) {
			$method = $methodMgr->getAuthNMethodForType($types->next());
			$matching = $method->getTokensBySearch($email);
			while ($matching->hasNext()) {
				$properties = $method->getPropertiesForTokens($matching->next());
				if ($properties->getProperty('email')
					&& strtolower($email) == strtolower($properties->getProperty('email')))
				{
					$message = dgettext("polyphony", "Cannot create visitor registration for %1. An account already exists in the %2 system. Please log in with your %2 username and password.");
					$message = str_replace("%1", $email, $message);
					$message = str_replace("%2", $method->getType()->getKeyword(), $message);
					throw new OperationFailedException($message);
				}
			}
		}		
		
		
		/*********************************************************
		 * Add the tokens
		 *********************************************************/

		$dbc = Services::getService("DatabaseManager");
		$dbId = $this->_configuration->getProperty('database_id');
		$authenticationTable = $this->_configuration->getProperty('authentication_table');
		$usernameField = $this->_configuration->getProperty('username_field');
		$passwordField = $this->_configuration->getProperty('password_field');
		
		$query =  new InsertQuery;
		$query->setTable($authenticationTable);
		$query->addValue($usernameField, $authNTokens->getUsername());
		$query->addValue($passwordField, $authNTokens->getPassword());
		$query->addValue('display_name', $authNTokens->getUsername());
		$query->addValue('email_confirmed', '0');
		$query->addValue('confirmation_code', md5(rand()));
		$result =  $dbc->query($query, $dbId);
	}
	
	/**
	 * Send out a confirmation email
	 * 
	 * @param object AuthNTokens $email
	 * @param object URLWriter $url
	 * @return void
	 * @access public
	 * @since 6/4/08
	 */
	public function sendConfirmationEmail (AuthNTokens $authNTokens, URLWriter $url) {
		$dbc = Services::getService("DatabaseManager");
		$dbId = $this->_configuration->getProperty('database_id');
		$authenticationTable = $this->_configuration->getProperty('authentication_table');
		$usernameField = $this->_configuration->getProperty('username_field');
		$passwordField = $this->_configuration->getProperty('password_field');
		
		$query =  new SelectQuery;
		$query->addTable($authenticationTable);
		$query->addColumn("email_confirmed");
		$query->addColumn("confirmation_code");
		$query->addWhereEqual($usernameField, $authNTokens->getUsername());
		
		$result =  $dbc->query($query, $dbId);
		
		if ($result->hasNext()) {
			$row = $result->next();
			$result->free();
			if ($row['email_confirmed'] == '1') {
				throw new OperationFailedException("Email already confirmed.");
			}
			
			$subject = _("Segue Visitor Registration Confirmation.");
			$instructions =  _("Please click on the link below to confirm your Segue Visitor Registration:");
			$url->setValue('email', $authNTokens->getUsername());
			$url->setValue('confirmation_code', $row['confirmation_code']);
			$urlString = $url->write();
			ob_start();
			print "
<html>
<head>
	<title>$subject</title>
</head>
<body>
	<p>$instructions
		<br/>&nbsp; &nbsp; &nbsp; <a href='$urlString'>$urlString</a>
	</p>
</body>
</html>";
			
			
			$message = ob_get_clean();
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Additional headers
			$headers .= 'From: '.$this->_configuration->getProperty('email_from_name').' <'.$this->_configuration->getProperty('email_from_address').'>' . "\r\n";
			
			mail($authNTokens->getUsername(), $subject, $message, $headers);
			
		} else {
			$result->free();
			throw new UnknownIdException("Unknown login, '".$authNTokens->getUsername()."'.");
		}
		
	}
	
	/**
	 * Answer true if an email address is confirmed
	 * 
	 * @param object AuthNTokens $email
	 * @return boolean
	 * @access public
	 * @since 6/4/08
	 */
	public function isEmailConfirmed (AuthNTokens $authNTokens) {
		$dbc = Services::getService("DatabaseManager");
		$dbId = $this->_configuration->getProperty('database_id');
		$authenticationTable = $this->_configuration->getProperty('authentication_table');
		$usernameField = $this->_configuration->getProperty('username_field');
		$passwordField = $this->_configuration->getProperty('password_field');
		
		$query =  new SelectQuery;
		$query->addTable($authenticationTable);
		$query->addColumn("email_confirmed");
		$query->addWhereEqual($usernameField, $authNTokens->getUsername());
		
		$result =  $dbc->query($query, $dbId);
		
		if ($result->hasNext()) {
			$row = $result->next();
			$result->free();
			
			if ($row['email_confirmed'] == '1')
				return true;
			else
				return false;
		} else {
			$result->free();
			throw new UnknownIdException("Unknown login, '".$authNTokens->getUsername()."'.");
		}
	}
	
	/**
	 * Confirm an email address
	 * 
	 * @param object AuthNTokens $email
	 * @param string $confirmationCode
	 * @return boolean True on success
	 * @access public
	 * @since 6/4/08
	 */
	public function confirmEmail (AuthNTokens $authNTokens, $confirmationCode) {
		$dbc = Services::getService("DatabaseManager");
		$dbId = $this->_configuration->getProperty('database_id');
		$authenticationTable = $this->_configuration->getProperty('authentication_table');
		$usernameField = $this->_configuration->getProperty('username_field');
		$passwordField = $this->_configuration->getProperty('password_field');
		
		$query =  new UpdateQuery;
		$query->setTable($authenticationTable);
		$query->addValue("email_confirmed", "1");
		$query->addWhereEqual($usernameField, $authNTokens->getUsername());
		$query->addWhereEqual('confirmation_code', $confirmationCode);
		
		$result =  $dbc->query($query, $dbId);
		
		if ($result->getNumberOfRows())
			return TRUE;
		else
			return FALSE;
	}
	
}

?>