<?php

require_once(OKI2."/osid/authorization/Authorization.php");
require_once(HARMONI."utilities/DateTime.class.php");

/**
 * Authorization indicates what an agentId can do a Function in a Qualifier
 * context.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniAuthorization.class.php,v 1.7 2005/02/07 21:38:24 adamfranco Exp $
 */
class HarmoniAuthorization 
	extends Authorization 
{

	/**
	 * The date when this Authorization starts being effective.
	 * @var object _effectiveDate 
	 * @access private
	 */
	var $_effectiveDate;
	
	
	/**
	 * The Id of this Authorization (string).
	 * @var string _id 
	 * @access protected
	 */
	var $_id;
	
	
	/**
	 * The Id of the agent.
	 * @var object _agentId 
	 * @access private
	 */
	var $_agentId;
	
	
	/**
	 * The Id of the function.
	 * @var object _functionId 
	 * @access private
	 */
	var $_functionId;
	
	
	/**
	 * The Id of the qualifier.
	 * @var object _qualifierId 
	 * @access private
	 */
	var $_qualifierId;
	
	
	/**
	 * The date when the authorization becomes effective.
	 * @var object _effectiveDate 
	 * @access private
	 */
	var $_effectiveDate;
	
	
	/**
	 * The date when the authorization expires.
	 * @var object _expirationDate 
	 * @access private
	 */
	var $_expirationDate;
	
	
	/**
	 * Specifies whether this Authorization is explicit or not.
	 * @var boolean _explicit 
	 * @access private
	 */
	var $_explicit;

	
	/**
	 * The AuthorizationCache object.
	 * @var object _cache 
	 * @access private
	 */
	var $_cache;
	
	
	/**
	 * The constructor.
	 * @param object id The id of this Authorization
	 * @param ref object agentId The Id of the agent.
	 * @param ref object functionId The Id of the function.
	 * @param ref object qualifierId The Id of the qualifier.
	 * @param ref object effectiveDate The date when the authorization becomes effective.
	 * @param ref object expirationDate The date when the authorization expires.
	 * @param boolean explicit Specifies whether this Authorization is explicit or not.
	 * @access public
	 */
	function HarmoniAuthorization($id, & $agentId, & $functionId, & $qualifierId, 
								  $explicit, & $cache, & $effectiveDate, & $expirationDate) {

		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, new OptionalRule(new StringValidatorRule()), true);
		ArgumentValidator::validate($agentId, $extendsRule, true);
		ArgumentValidator::validate($functionId, $extendsRule, true);
		ArgumentValidator::validate($qualifierId, $extendsRule, true);
		$extendsRule =& new ExtendsValidatorRule("DateTime");
		ArgumentValidator::validate($effectiveDate, new OptionalRule($extendsRule), true);
		ArgumentValidator::validate($expirationDate, new OptionalRule($extendsRule), true);
		ArgumentValidator::validate($explicit, new BooleanValidatorRule(), true);
		ArgumentValidator::validate($cache, new ExtendsValidatorRule("AuthorizationCache"), true);
		// ** end of parameter validation
		
		// make sure effective date is before expiration date
		if (isset($effectiveDate) && isset($expirationDate))
			if (DateTime::compare($effectiveDate, $expirationDate) < 0) {
				$str = "The effective date must be before the expiration date.";
				throwError(new Error($str, "Authorization", true));
			}

		$this->_id = $id;
		$this->_agentId =& $agentId;
		$this->_functionId =& $functionId;
		$this->_qualifierId =& $qualifierId;
		if (isset($effectiveDate))
			$this->_effectiveDate =& $effectiveDate;
		if (isset($expirationDate))
			$this->_expirationDate =& $expirationDate;
		$this->_explicit = $explicit;
		$this->_cache =& $cache;
	}
	
	/**
	 * Get the date when this Authorization starts being effective.
	 *	
	 * @return int
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getEffectiveDate () { 
		return $this->_effectiveDate;
	}

	/**
	 * Get the date when this Authorization stops being effective.
	 *	
	 * @return int
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getExpirationDate () { 
		return $this->_expirationDate;
	}

	/**
	 * Get the Id of the agent that modified this Authorization.
	 *	
	 * @return object Id
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getModifiedBy () { 
		throwError(new Error(AuthorizationExeption::UNIMPLEMENTED(), "Authorization", true));
	} 

	/**
	 * Get the date when this Authorization was modified.
	 *	
	 * @return int
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getModifiedDate () { 
		throwError(new Error(AuthorizationExeption::UNIMPLEMENTED(), "Authorization", true));
	} 

	/**
	 * 
	 *	
	 * @return object Function
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getFunction () { 
		$idValue = $this->_functionId->getIdString();
		$result =& $this->_cache->getFunction($idValue);
		
		return $result;
	}

	/**
	 * 
	 *	
	 * @return object Qualifier
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getQualifier () { 
		$result =& $this->_cache->getQualifier($this->_qualifierId);
		
		return $result;
	}

	/**
	 * Get the agentid associated with this Authorization.
	 *	
	 * @return object Id
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getAgentId () { 
		return $this->_agentId;
	}

	/**
	 * Return true if this Authorization is effective; false otherise;
	 *	
	 * @return boolean
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function isActiveNow () { 
		if (!isset($this->_effectiveDate) || !isset($this->_expirationDate))
			// a non-dated Authorization is always active
			return true;
	
		// create a DateTime with the current time
		$now =& DateTime::now();
		$afterEffectiveDate = DateTime::compare($this->_effectiveDate, $now);
		$beforeExpirationDate = DateTime::compare($this->_expirationDate, $now);
		
		// if current time is after the effective date and before the expiration
		// date, then the Authorization is active.
		if ($afterEffectiveDate >= 0 && $beforeExpirationDate < 0)
			return true;
		else
			return false;
	}

	/**
	 * Some Authorizations are explicitly stored and others are implied, so use
	 * this method to determine if the Authorization is explicit and can be
	 * modified or deleted.
	 *	
	 * @return boolean
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function isExplicit () { 
		return $this->_explicit;
	}

	/**
	 * Modify the date when this Authorization starts being effective.
	 * 
	 * @param int $expirationDate
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * 
	 * @access public
	 */
	function updateExpirationDate ( $expirationDate ) { 
		if (!$this->isExplicit()) {
			$str = "Cannot modify an implicit Authorization.";
			throwError(new Error(AuthorizationException::OPERATION_FAILED(), "Authorization", true));
		}
		
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("DateTime");
		ArgumentValidator::validate($expirationDate, $extendsRule, true);
		// ** end of parameter validation

		// make sure effective date is before expiration date
		if (DateTime::compare($this->_effectiveDate, $expirationDate) < 0) {
			throwError(new Error(AuthorizationException::EFFECTIVE_PRECEDE_EXPIRATION(), "Authorization", true));
		}

		if (DateTime::compare($this->_expirationDate, $expirationDate) == 0)
			return; // nothing to update

		// update the object
		$this->_expirationDate =& $expirationDate;

		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$dbPrefix = $this->_cache->_authzDB.".az_authorization";
		
		$query =& new UpdateQuery();
		$query->setTable($dbPrefix);
		$idValue = $this->_id;
		$where = "{$dbPrefix}.authorization_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$dbPrefix}.authorization_expiration_date"));
		$timestamp = $dbHandler->toDBDate($expirationDate, $this->_cache->_dbIndex);
		$query->setValues(array("'$timestamp'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(AuthorizationException::OPERATION_FAILED(),"Authorization",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(AuthorizationException::OPERATION_FAILED() ,"Authorization",true));
	}
					
	/**
	 * the date when this Authorization stops being effective.
	 * 
	 * @param int $effectiveDate
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * 
	 * @access public
	 */
	function updateEffectiveDate ( $effectiveDate ) { 
		if (!$this->isExplicit()) {
			// "Cannot modify an implicit Authorization."
			throwError(new Error(AuthorizationException::OPERATION_FAILED(), "Authorization", true));
		}
		
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("DateTime");
		ArgumentValidator::validate($effectiveDate, $extendsRule, true);
		// ** end of parameter validation

		// make sure effective date is before expiration date
		if (DateTime::compare($effectiveDate, $this->_expirationDate) < 0) {
			throwError(new Error(AuthorizationException::EFFECTIVE_PRECEDE_EXPIRATION(), "Authorization", true));
		}

		if (DateTime::compare($this->_effectiveDate, $effectiveDate) == 0)
			return; // nothing to update

		// update the object
		$this->_effectiveDate =& $effectiveDate;

		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$dbPrefix = $this->_cache->_authzDB.".az_authorization";
		
		$query =& new UpdateQuery();
		$query->setTable($dbPrefix);
		$idValue = $this->_id;
		$where = "{$dbPrefix}.authorization_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$dbPrefix}.authorization_effective_date"));
		$timestamp = $dbHandler->toDBDate($effectiveDate, $this->_cache->_dbIndex);
		$query->setValues(array("'$timestamp'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(AuthorizationException::OPERATION_FAILED(),"Authorization",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(AuthorizationException::OPERATION_FAILED() ,"Authorization",true));
	}


}

?>