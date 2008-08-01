<?php

require_once(OKI2."/osid/authorization/Authorization.php");
require_once(HARMONI."Primitives/Chronology/include.php");

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
 * @version $Id: Authorization.class.php,v 1.1 2008/04/24 20:51:42 adamfranco Exp $
 */
class AuthZ2_Authorization 
	implements Authorization 
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
	 * @param integer effectiveDate The date when the authorization becomes effective.
	 * @param integer expirationDate The date when the authorization expires.
	 * @param boolean explicit Specifies whether this Authorization is explicit or not.
	 * @access public
	 */
	function __construct($id, Id $agentId, Id $functionId, Id $qualifierId, $explicit, AuthZ2_AuthorizationCache $cache, $effectiveDate = NULL, $expirationDate = NULL) {

		// ** parameter validation
		ArgumentValidator::validate($id, OptionalRule::getRule(StringValidatorRule::getRule()), true);
		ArgumentValidator::validate($effectiveDate, OptionalRule::getRule(HasMethodsValidatorRule::getRule('asDateAndTime')), true);
		ArgumentValidator::validate($expirationDate, OptionalRule::getRule(HasMethodsValidatorRule::getRule('asDateAndTime')), true);
		ArgumentValidator::validate($explicit, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		// make sure effective date is before expiration date
		if (isset($effectiveDate) && isset($expirationDate))
			if ($effectiveDate > $expirationDate) {
				$str = "The effective date must be before the expiration date.";
				throwError(new Error($str, "Authorization", true));
			}

		$this->_id = $id;
		$this->_agentId =$agentId;
		$this->_functionId =$functionId;
		$this->_qualifierId =$qualifierId;
		if (isset($effectiveDate))
			$this->_effectiveDate =$effectiveDate;
		if (isset($expirationDate))
			$this->_expirationDate =$expirationDate;
		$this->_explicit = $explicit;
		$this->_cache =$cache;
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
	function getModifiedBy () { 
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
	function getFunction () { 
		$idValue = $this->_functionId->getIdString();
		$result =$this->_cache->getFunction($idValue);
		
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
	function getQualifier () { 
		$result =$this->_cache->getQualifier($this->_qualifierId);
		
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
	function getAgentId () { 
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
		if (!is_object($this->_effectiveDate) || !is_object($this->_expirationDate))
			// a non-dated Authorization is always active
			return true;
		
		// if current time is after the effective date and before the expiration
		// date, then the Authorization is active.
		if ($this->_effectiveDate->isLessThanOrEqualTo(DateAndTime::now()) 
			&& $this->_expirationDate->isGreaterThan(DateAndTime::now()))
		{
			return true;
		} else
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
	 * @param object DateAndTime $expirationDate
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
			throwError(new Error(AuthorizationException::OPERATION_FAILED(), 
				"Authorization", true));
		}
		
		// ** parameter validation
		ArgumentValidator::validate($expirationDate, 
			HasMethodsValidatorRule::getRule("asDateAndTime"), true);
		// ** end of parameter validation

		// make sure effective date is before expiration date
		if ($this->_effectiveDate->isGreaterThan($expirationDate)) {
			throwError(new Error(AuthorizationException::EFFECTIVE_PRECEDE_EXPIRATION(), 
				"Authorization", true));
		}

		if ($this->_expirationDate->isEqualTo($expirationDate))
			return; // nothing to update

		// update the object
		$this->_expirationDate = $expirationDate;

		// update the database
		$dbHandler = Services::getService("DatabaseManager");
		
		$query = new UpdateQuery();
		$query->setTable("az2_explicit_az");
		$query->addWhereEqual("id", $this->_id);
		$timestamp = $dbHandler->toDBDate($expirationDate, $this->_cache->_dbIndex);
		$query->addValue("expiration_date", $timestamp);
		
		$queryResult =$dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(AuthorizationException::OPERATION_FAILED(),"Authorization",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(AuthorizationException::OPERATION_FAILED() ,"Authorization",true));
	}
					
	/**
	 * the date when this Authorization stops being effective.
	 * 
	 * @param object DateAndTime $effectiveDate
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
			throwError(new Error(AuthorizationException::OPERATION_FAILED(), 
				"Authorization", true));
		}
		
		// ** parameter validation
		ArgumentValidator::validate($effectiveDate, 
			HasMethodsValidatorRule::getRule("asDateAndTime"), true);
		// ** end of parameter validation

		// make sure effective date is before expiration date
		if ($effectiveDate->isGreaterThan($this->_expirationDate)) {
			throwError(new Error(AuthorizationException::EFFECTIVE_PRECEDE_EXPIRATION(), 
				"Authorization", true));
		}

		if ($this->_effectiveDate->isEqualTo($effectiveDate))
			return; // nothing to update

		// update the object
		$this->_effectiveDate =$effectiveDate;

		// update the database
		$dbHandler = Services::getService("DatabaseManager");
		
		$query = new UpdateQuery();
		$query->setTable("az2_explicit_az");
		$query->addWhereEqual("id", $this->_id);
		$timestamp = $dbHandler->toDBDate($effectiveDate, $this->_cache->_dbIndex);
		$query->addValue("effective_date", $timestamp);
		
		$queryResult =$dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(AuthorizationException::OPERATION_FAILED(),"Authorization",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(AuthorizationException::OPERATION_FAILED() ,"Authorization",true));
	}

	/**
	 * Answer the internal Id of this authorization. Should not be used outside of this
	 * implementation.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @return string
	 * @access public
	 * @since 4/22/08
	 */
	public function getIdString () {
		if (!$this->_id)
			throw new Exception("No Id set.");
		return $this->_id;
	}
	
	/**
	 * Answer the explicit authorization for this implicit authorization
	 * 
	 * @return object Authorization
	 * @access public
	 * @since 4/22/08
	 */
	public function getExplicitAZ () {
		if ($this->isExplicit())
			throw new OperationFailedException("Can not get explicit AZs for an explicit AZ");
		
		if (isset($this->explicitAZId))
			return $this->_cache->getExplicitAZById($this->explicitAZId);
		
		if (isset($this->_cache->harmoni_db)) {
			if (!isset($this->_cache->_getExplicitAZ_stmt)) {
				$query = $this->_cache->harmoni_db->select();
				$query->addColumn("fk_explicit_az");
				$query->addTable("az2_implicit_az");
				$query->addWhereEqual("id", '?');
				$this->_cache->_getExplicitAZ_stmt = $query->prepare();
			}
			$this->_cache->_getExplicitAZ_stmt->bindValue(1, $this->getIdString());
			$this->_cache->_getExplicitAZ_stmt->execute();
			$result = $this->_cache->_getExplicitAZ_stmt->getResult();
		} else {
			$dbHandler = Services::getService("DatabaseManager");
			$query = new SelectQuery();
			$query->addColumn("fk_explicit_az");
			$query->addTable("az2_implicit_az");
			$query->addWhereEqual("id", $this->getIdString());
	// 		printpre($query->asString());
			$result = $dbHandler->query($query, $this->_cache->_dbIndex);
		}
		
		$this->explicitAZId = $result->field("fk_explicit_az");
		$result->free();
		return $this->_cache->getExplicitAZById($this->explicitAZId);
	}
	
	/**
	 * Set an explicit authorization as that which is causing this implicit Authorization.
	 * This is to be used when dynamically creating implicit Authorizations that
	 * do not have database rows with their information.
	 * 
	 * @param string $explicitAZId
	 * @return void
	 * @access public
	 * @since 4/23/08
	 */
	public function setExplicitAZId ($explicitAZId) {
		if ($this->isExplicit())
			throw new OperationFailedException("Can not set explicit AZs for an explicit AZ");
		
		$this->explicitAZId = $explicitAZId;
	}

}

?>