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
	 * Confirm an email address
	 * 
	 * @param object AuthNTokens $email
	 * @param string $confirmationCode
	 * @return boolean True on success
	 * @access public
	 * @since 6/4/08
	 */
	public function confirmEmail (AuthNTokens $authNTokens, $confirmationCode) {
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