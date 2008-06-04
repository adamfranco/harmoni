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
		ArgumentValidator::validate($authNTokens, ExtendsValidatorRule::getRule("AuthNTokens"));
		
		if ($this->tokensExist($authNTokens)) {
			throwError( new Error("Token Addition Error: ".
							"'".$authNTokens->getUsername()."' already exists.",
									 "SQLDatabaseAuthNMethod", true));
		} else {
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
	}
	
	/**
	 * Send out a confirmation email
	 * 
	 * @param object AuthNTokens $email
	 * @return void
	 * @access public
	 * @since 6/4/08
	 */
	public function sendConfirmationEmail (AuthNTokens $authNTokens) {
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
			
			$harmoni = Harmoni::instance();
			$subject = _("Segue Visitor Registration Confirmation.");
			$instructions =  _("Please click on the link below to confirm your Segue Visitor Registration:");
			$url = $harmoni->request->quickURL('user', 'confirm_email', 
						array('email' => $authNTokens->getUsername(),
							'confirmation_code' => $row['confirmation_code']));
			ob_start();
			print "
<html>
<head>
	<title>$subject</title>
</head>
<body>
	<p>$instructions
		<br/>&nbsp; &nbsp; &nbsp; <a href='$url'>$url</a>
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