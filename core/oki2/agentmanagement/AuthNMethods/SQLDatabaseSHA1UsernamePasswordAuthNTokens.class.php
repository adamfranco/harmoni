<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLDatabaseSHA1UsernamePasswordAuthNTokens.class.php,v 1.1 2005/03/03 01:03:51 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/UsernamePasswordAuthNTokens.class.php");

/**
 * This UserNamePasswordAuthNTokens class encrypts the password passed to it using
 * the database's SHA1 function.
 * 
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLDatabaseSHA1UsernamePasswordAuthNTokens.class.php,v 1.1 2005/03/03 01:03:51 adamfranco Exp $
 */
class SQLDatabaseSHA1UsernamePasswordAuthNTokens
	extends UsernamePasswordAuthNTokens
{

	/**
	 * Initialize this object for a set of authentication tokens. Set the 
	 * password to the encrypted version.
	 * 
	 * @param mixed $tokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function initializeForTokens ( $tokens ) {
		ArgumentValidator::validate($tokens, new ArrayValidatorRule);
		ArgumentValidator::validate($tokens['username'], new StringValidatorRule);
		ArgumentValidator::validate($tokens['password'], new StringValidatorRule);
		
		$this->_tokens = $tokens;
		$this->_identifier = $tokens['username'];
		
		// set the password to the encrypted version.
		$dbc =& Services::getService("DBHandler");
		$dbId = $this->_configuration->getProperty('database_id');
		
		$passwordQuery = & new SelectQuery;
		$passwordQuery->addColumn(	"SHA1('".addslashes($tokens['password'])."')",
									"encryptedPassword");
		$passwordResult = & $dbc->query($passwordQuery, $dbId);
		$this->_tokens['password'] = $passwordResult->field("encryptedPassword");
	}
	
}

?>