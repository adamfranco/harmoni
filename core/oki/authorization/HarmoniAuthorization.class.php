<?php

require_once(OKI."/authorization.interface.php");
require_once(HARMONI."utilities/DateTime.class.php");

/**
 * Authorization indicates what an Agent can do a Function in a Qualifier context. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package harmoni.osid.authorization
 */
class HarmoniAuthorization extends Authorization {

	/**
	 * The date when this Authorization starts being effective.
	 * @attribute private object _effectiveDate
	 */
	var $_effectiveDate;
	
	
	/**
	 * The Id of this Authorization.
	 * @attribute protected object _id
	 */
	var $_id;
	
	
	/**
	 * The Id of the agent.
	 * @attribute private object _agentId
	 */
	var $_agentId;
	
	
	/**
	 * The Id of the function.
	 * @attribute private object _functionId
	 */
	var $_functionId;
	
	
	/**
	 * The Id of the qualifier.
	 * @attribute private object _qualifierId
	 */
	var $_qualifierId;
	
	
	/**
	 * The date when the authorization becomes effective.
	 * @attribute private object _effectiveDate
	 */
	var $_effectiveDate;
	
	
	/**
	 * The date when the authorization expires.
	 * @attribute private object _expirationDate
	 */
	var $_expirationDate;
	
	
	/**
	 * Specifies whether this Authorization is explicit or not.
	 * @attribute private boolean _explicit
	 */
	var $_explicit;

	
	/**
	 * The AuthorizationCache object.
	 * @attribute private object _cache
	 */
	var $_cache;
	
	
	/**
	 * The constructor.
	 * @param ref object id The id of this Authorization
	 * @param ref object agentId The Id of the agent.
	 * @param ref object functionId The Id of the function.
	 * @param ref object qualifierId The Id of the qualifier.
	 * @param ref object effectiveDate The date when the authorization becomes effective.
	 * @param ref object expirationDate The date when the authorization expires.
	 * @param boolean explicit Specifies whether this Authorization is explicit or not.
	 * @access public
	 */
	function HarmoniAuthorization(& $id, & $agentId, & $functionId, & $qualifierId, 
							      $explicit, $cache, & $effectiveDate, & $expirationDate) {

		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
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

		$this->_id =& $id;
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
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getEffectiveDate() {
		return $this->_effectiveDate;
	}



	/* :: full java declaration :: java.util.Calendar getEffectiveDate()
	/**
	 * Get the date when this Authorization stops being effective.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getExpirationDate() {
		return $this->_expirationDate;
	}



	/* :: full java declaration :: java.util.Calendar getExpirationDate()
	/**
	 * Get the Id of the Agent that modified this Authorization.
	 * @return object osid.shared.Agent
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getModifiedBy() { /* :: interface :: */ }



	/* :: full java declaration :: osid.shared.Agent getModifiedBy()
	/**
	 * Get the date when this Authorization was modified.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getModifiedDate() { /* :: interface :: */ }



	/* :: full java declaration :: java.util.Calendar getModifiedDate()
	/**
	 * It may or may not exist.
	 * @return Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getFunction() {
		$idValue = $this->_functionId->getIdString();
		$result =& $this->_cache->getFunction($idValue);
		
		return $result;
	}



	/* :: full java declaration :: Function getFunction()
	/**
	 * The instance may or may not exist.
	 * @return Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getQualifier() {
		$result =& $this->_cache->getQualifier($this->_qualifierId);
		
		return $result;
	}



	/* :: full java declaration :: Qualifier getQualifier()
	/**
	 * Get the Agent Id associated with this Authorization.
	 * @return object osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getAgentId() {
		return $this->_agentId;
	}



	/* :: full java declaration :: osid.shared.Agent getAgent()
	/**
	 * Return true if this Authorization is effective; false otherise;
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function isActiveNow() {
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



	/* :: full java declaration :: boolean isActiveNow()
	/**
	 * Some Authorizations are explicitly stored and others are implied, so use this method to determine if the Authorization is explicit and can be modified or deleted.
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function isExplicit() {
		return $this->_explicit;
	}


	/* :: full java declaration :: boolean isExplicit()
	/**
	 * Modify the date when this Authorization starts being effective.
	 * @param expirationDate the date when this Authorization stops being effective
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package harmoni.osid.authorization
	 */
	function updateExpirationDate(& $expirationDate) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("DateTime");
		ArgumentValidator::validate($expirationDate, $extendsRule, true);
		// ** end of parameter validation

		// make sure effective date is before expiration date
		if (DateTime::compare($this->_effectiveDate, $expirationDate) < 0) {
			$str = "The effective date must be before the expiration date.";
			throwError(new Error($str, "Authorization", true));
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
		$idValue = $this->_id->getIdString();
		$where = "{$dbPrefix}.authorization_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$dbPrefix}.authorization_expiration_date"));
		$timestamp = $dbHandler->toDBDate($expirationDate, $this->_cache->_dbIndex);
		$query->setValues(array("'$timestamp'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The authorization with Id: ".$idValue." does not exist in the database.","Authorization",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple authorizations with Id: ".$idValue." exist in the database. Note: their descriptions have been updated." ,"Authorization",true));
	}
					
					
	/* :: full java declaration :: void updateExpirationDate(java.util.Calendar expirationDate)
	/**
	 * the date when this Authorization stops being effective.
	 * @param effectiveDate the date when this Authorization becomes effective
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package harmoni.osid.authorization
	 */
	function updateEffectiveDate(& $effectiveDate) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("DateTime");
		ArgumentValidator::validate($effectiveDate, $extendsRule, true);
		// ** end of parameter validation

		// make sure effective date is before expiration date
		if (DateTime::compare($effectiveDate, $this->_expirationDate) < 0) {
			$str = "The effective date must be before the expiration date.";
			throwError(new Error($str, "Authorization", true));
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
		$idValue = $this->_id->getIdString();
		$where = "{$dbPrefix}.authorization_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$dbPrefix}.authorization_effective_date"));
		$timestamp = $dbHandler->toDBDate($effectiveDate, $this->_cache->_dbIndex);
		$query->setValues(array("'$timestamp'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The authorization with Id: ".$idValue." does not exist in the database.","Authorization",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple authorizations with Id: ".$idValue." exist in the database. Note: their descriptions have been updated." ,"Authorization",true));
	}


}

?>