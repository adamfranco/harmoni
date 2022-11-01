<?php
/**
 * @since 10/5/09
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 *
 * @copyright Copyright &copy; 2009, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 */

// Temporarily disable warnings while checking for the existance of phpCAS in
// case autoload is being used and phpCAS hasn't been loaded yet.
$tmp = error_reporting();
error_reporting($tmp ^ E_WARNING);
if (!class_exists('phpCAS')) {
	include_once('CAS.php');
}
error_reporting($tmp);
unset($tmp);

require_once(dirname(__FILE__).'/CASGroup.class.php');

/**
 * The CASAuthNMethod is used to authenticate against CAS
 *
 * @since 10/5/09
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 *
 * @copyright Copyright &copy; 2009, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 */
class CASAuthNMethod
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
	function assignConfiguration ( Properties $configuration ) {
		parent::assignConfiguration($configuration);

		$format = $configuration->getProperty('DISPLAY_NAME_FORMAT');
		ArgumentValidator::validate($format, RegexValidatorRule::getRule('/\[\[([^]]+)\]\]/'));
		$this->displayNameFormat = $format;

		if ($debug = $configuration->getProperty('CAS_DEBUG_PATH')) {
			ArgumentValidator::validate($debug, StringValidatorRule::getRule());
			phpCAS::setDebug($debug);
		}
		if ($logger = $configuration->getProperty('CAS_LOGGER')) {
			ArgumentValidator::validate($logger, ExtendsValidatorRule::getRule('Psr\Log\LoggerInterface'));
			phpCAS::setLogger($logger);
		}

		$host = $configuration->getProperty('CAS_HOST');
		ArgumentValidator::validate($host, RegexValidatorRule::getRule('/^[a-z0-9]+\.[a-z0-9]+.[a-z]+$/'));
		$port = $configuration->getProperty('CAS_PORT');
		ArgumentValidator::validate($port, RegexValidatorRule::getRule('/^[0-9]+$/'));
		$path = $configuration->getProperty('CAS_PATH');
		ArgumentValidator::validate($path, RegexValidatorRule::getRule('/^\/.*$/'));
		$service_base_url = $configuration->getProperty('CAS_SERVICE_BASE_URL');
		phpCAS::client(CAS_VERSION_2_0, $host, intval($port), $path, $service_base_url, false);

		if ($cert = $configuration->getProperty('CAS_CERT')) {
			phpCAS::setCasServerCACert($cert);
		} else {
			phpCAS::setNoCasServerValidation();
		}


		// Allow group lookup via a CASDirectory:
		// https://mediawiki.middlebury.edu/wiki/LIS/CAS_Directory
		$dirUrl = $configuration->getProperty('CASDIRECTORY_BASE_URL');
		ArgumentValidator::validate($dirUrl, StringValidatorRule::getRule());
		$this->directoryUrl = $dirUrl;

		// set the callback URL for the PGT to be sent to. This must be an https url
		// whose certificate is trusted by CAS.
// 		$callbackUrl = $configuration->getProperty('CALLBACK_URL');
// 		ArgumentValidator::validate($callbackUrl, RegexValidatorRule::getRule('/^https:\/\/.*$/'));
// 		phpCAS::setFixedCallbackURL($callbackUrl);

		$adminAccess = $configuration->getProperty('CASDIRECTORY_ADMIN_ACCESS');
		ArgumentValidator::validate($adminAccess, StringValidatorRule::getRule());
		$this->adminAccess = $adminAccess;

		$classRoot = $configuration->getProperty('CASDIRECTORY_CLASS_ROOT');
		if ($classRoot) {
			ArgumentValidator::validate($classRoot, StringValidatorRule::getRule());
			$this->classRoot = $classRoot;
		} else {
			$this->classRoot = null;
		}

		$groupIdRegex = $configuration->getProperty('CASDIRECTORY_GROUP_ID_REGEX');
		if ($groupIdRegex) {
			ArgumentValidator::validate($groupIdRegex, StringValidatorRule::getRule());
			$this->groupIdRegex = $groupIdRegex;
		} else {
			$this->groupIdRegex = null;
		}

		// Root Groups to expose
		ArgumentValidator::validate (
			$configuration->getProperty('ROOT_GROUPS'),
			ArrayValidatorRuleWithRule::getRule(StringValidatorRule::getRule()));
		$this->rootGroups = array_unique($configuration->getProperty('ROOT_GROUPS'));
	}

	/**
	 * Create a Tokens Object
	 *
	 * @return object Tokens
	 * @access public
	 * @since 3/1/05
	 */
	function createTokensObject () {
		return new CASAuthNTokens($this, $this->_configuration, $this->directoryUrl);
	}

	/**
	 * Authenticate a Tokens object
	 *
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function authenticateTokens ( $authNTokens ) {
		phpCAS::forceAuthentication();
		return ($authNTokens->getIdentifier() == phpCAS::getUser());
	}

	/**
	 * Return true if the AuthNTokens can be matched in the system.
	 *
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function tokensExist ( $authNTokens ) {
		try {
			$result = $this->_queryDirectory('get_user', array('id' => $authNTokens->getIdentifier()));
			return (is_object($result));
		} catch (OperationFailedException $e) {
			return false;
		}
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
	function getTokensBySearch ( $searchString ) {
		$doc = $this->_queryDirectory('search_users', array('query' => $searchString));
		$foundTokens = new HarmoniObjectIterator(array());
		if ($doc) {
			foreach ($doc->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'entry') as $element) {
				$id = $this->_getIdFromCASEntry($element);
				$tokens = $this->createTokensForIdentifier($id);
				$tokens->properties = $this->_getPropertiesFromCASEntry($element);
				$foundTokens->add($tokens);
			}
		}
		return $foundTokens;
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
	function getGroupTokensBySearch ( $searchString ) {
		return $this->_getGroupTokensBySearch($searchString);
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
	 * @param optional string $searchBase
	 * @return object ObjectIterator
	 * @access public
	 * @since 3/3/05
	 */
	function _getGroupTokensBySearch ( $searchString, $searchBase = null ) {
		ArgumentValidator::validate ($searchString, StringValidatorRule::getRule());

		$args = array('query' => $searchString);
		if (is_string($searchBase))
			$args['base'] = $searchBase;
		$doc = $this->_queryDirectory('search_groups', $args);
		$foundTokens = new HarmoniObjectIterator(array());
		if ($doc) {
			foreach ($doc->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'entry') as $element) {
				$id = $this->_getIdFromCASEntry($element);
				$tokens = $this->createTokensForIdentifier($id);
				$tokens->properties = $this->_getPropertiesFromCASEntry($element);
				$foundTokens->add($tokens);
			}
		}
		return $foundTokens;
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
	function getClassTokensBySearch ( $searchString ) {
		ArgumentValidator::validate ($searchString, StringValidatorRule::getRule());

		if (!$this->classRoot)
			throw new ConfigurationErrorException("Cannot getClassTokensBySearch($searchString) CASDIRECTORY_CLASS_ROOT is not set.");

		return $this->_getGroupTokensBySearch($searchString, $this->classRoot);
	}

	/**
	 * Return Properties associated with the Tokens. The properties will have
	 * the AuthNMethod Type as their Type. One Property that should always be
	 * included is 'identifier' which corresponds to the identifier for the tokens
	 *
	 * @param object AuthNTokens $authNTokens
	 * @return object Properties
	 * @access public
	 * @since 3/1/05
	 */
	function getPropertiesForTokens ( $authNTokens ) {
		ArgumentValidator::validate($authNTokens, ExtendsValidatorRule::getRule("AuthNTokens"));
		if (!isset($authNTokens->properties)) {
			$result = $this->_queryDirectory('get_user', array('id' => $authNTokens->getIdentifier()));
			$elements = $result->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'entry');
			if (!$elements->length)
				throw new OperationFailedException("Could not getPropertiesForTokens ".$authNTokens->getIdentifier()." from \n\n".$result->saveXML());
			$authNTokens->properties = $this->_getPropertiesFromCASEntry($elements->item(0));
		}

		return $authNTokens->properties;
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
		if (!isset($authNTokens->displayName)) {
			$this->getPropertiesForTokens($authNTokens);

			if (preg_match_all('/([^\[\]]*)\[\[([^\]]+)\]\]([^\[\]]*)/i', $this->displayNameFormat, $matches,  PREG_SET_ORDER )) {
				$authNTokens->displayName = '';
				foreach ($matches as $set) {
					$authNTokens->displayName .= $set[1];
					if ($set[2])
						$authNTokens->displayName .= $authNTokens->properties->getProperty($set[2]);
					$authNTokens->displayName .= $set[3];
				}
			} else {
				$authNTokens->displayName = $authNTokens->getIdentifier();
			}
		}
		return $authNTokens->displayName;
	}

	/**
	 * forces CAS logout and sends user back to index.php
	 */
	function destroyAuthentication() {
		phpCAS::logout();
	}

/*********************************************************
 * 	Directory methods
 *********************************************************/

	/**
	 * Answer TRUE if this AuthN method supports directory functionality
	 *
	 * @return boolean
	 * @access public
	 * @since 2/23/06
	 */
	function supportsDirectory () {
		// Override if implementing
		return true;
	}

	/**
	 * Answer an iterator of all groups
	 *
	 * @return object AgentIterator
	 * @access public
	 * @since 2/23/06
	 */
	function getAllGroups () {
		throw new UnimplementedException();
	}

	/**
	 * Answer an iterator of the top-level groups, may be equivalent to
	 * getAllGroups() if this directory is not hierarchically organized.
	 *
	 * @return object AgentIterator
	 * @access public
	 * @since 2/23/06
	 */
	function getRootGroups () {
		$iterator = new HarmoniIterator(array());
		foreach ($this->rootGroups as $dn) {
			$iterator->add($this->getGroup(new HarmoniId($dn)));
		}
		return $iterator;
	}

	/**
	 * Answer a group by Id
	 *
	 * @param object Id $id
	 * @return object AgentIterator
	 * @access public
	 * @since 2/23/06
	 */
	function getGroup ( $id ) {
		return new CASGroup($id, $this);
	}

	/**
	 * Answer a true if the Id corresponds to a valid group
	 *
	 * @param object Id $id
	 * @return boolean
	 * @access public
	 * @since 2/23/06
	 */
	function isGroup ( $id ) {
		if ($this->groupIdRegex && !preg_match($this->groupIdRegex, $id))
			return false;

		try {
			$result = $this->_queryDirectory('get_group', array('id' => $id->getIdString()));
			return (is_object($result));
		} catch (OperationFailedException $e) {
			return false;
		}
	}

	/**
	 * Answer an iterator of groups that contain the tokens. If $includeSubgroups
	 * is true then groups will be returned if any descendent group contains
	 * the tokens.
	 *
	 * @param object AuthNTokens $authNTokens
	 * @return object AgentIterator
	 * @access public
	 * @since 2/23/06
	 */
	function getGroupsContainingTokens ( $authNTokens, $includeSubgroups ) {
		$result = $this->_queryDirectory('get_user', array('id' => $authNTokens->getIdentifier(), 'include_membership' => 'true'));
		$groups = new HarmoniIterator(array());
		foreach ($result->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'attribute') as $element) {
			if ($element->getAttribute('name') == 'MemberOf')
				$groups->add(new CASGroup(new HarmoniId($element->getAttribute('value')), $this));
		}
		return $groups;
	}

	/**
	 * Answer an iterator of groups that contain the Id. If $includeSubgroups
	 * is true then groups will be returned if any descendent group contains
	 * the Id.
	 *
	 * @param object Id $id
	 * @return object AgentIterator
	 * @access public
	 * @since 2/23/06
	 */
	function getGroupsContainingGroup ( $id, $includeSubgroups ) {
		$result = $this->_queryDirectory('get_group', array('id' => $id->getIdString(), 'include_membership' => 'true'));
		$groups = new HarmoniIterator(array());
		foreach ($result->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'attribute') as $element) {
			if ($element->getAttribute('name') == 'MemberOf')
				$groups->add(new CASGroup(new HarmoniId($element->getAttribute('value')), $this));
		}
		return $groups;
	}

/*********************************************************
 * Package methods
 *********************************************************/

	/**
	 * Run a query on our directory service
	 *
	 * @param string $action
	 * @param array $params
	 * @return DOMDocument on success or throw an OperationFailedException.
	 * @access public
	 * @since 10/6/09
	 */
	public function _queryDirectory ($action, $params = array()) {
		$doc = new DOMDocument;
		$params['action'] = $action;

		$url = $this->directoryUrl.'?'.http_build_query($params, '', '&');

		if ($this->adminAccess) {
			$opts = array(
				'http' => array(
					'header' =>
						"ADMIN_ACCESS: ".$this->adminAccess."\r\n".
						"User-Agent: Drupal CAS-MM-Sync\r\n",
				)
			);
			$context = stream_context_create($opts);
		} else {
			$context = null;
		}

		$xml_string = file_get_contents($url, false, $context);

		if(@$doc->loadXML($xml_string))
			return $doc;
		else {
			$paramstring = '';
			foreach ($params as $key => $val)
				$paramstring .= $key.' => \''.$val."'";
			throw new OperationFailedException("Could not access directory with action '$action' and parameters [".$paramstring."].");
		}
	}

	/**
	 * Answer a Properties object from an entry XML element.
	 *
	 * @param DOMElement $element
	 * @return Properties
	 * @access public
	 * @since 10/6/09
	 */
	public function _getPropertiesFromCASEntry (DOMElement $element) {
		$properties = new HarmoniProperties(new Type('GroupProperties', 'edu.middlebury', 'CAS Properties'));
		foreach ($element->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'attribute') as $attra) {
			if ($attra->getAttribute('name') != 'MemberOf')
				$properties->addProperty($attra->getAttribute('name'), $attra->getAttribute('value'));
		}
		return $properties;
	}

	/**
	 * Answer an identifier from a CAS entry XML element
	 *
	 * @param DOMElement $element
	 * @return string
	 * @access public
	 * @since 10/6/09
	 */
	public function _getIdFromCASEntry (DOMElement $element) {
		// Check for a user id.
		$ids = $element->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'user');
		if ($ids->length)
			return $ids->item(0)->nodeValue;

		// Check for a group id.
		$ids = $element->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'group');
		if ($ids->length)
			return $ids->item(0)->nodeValue;

		throw new OperationFailedException("No cas:user or cas:group available in \n\n".$element->ownerDocument->saveXML($element));
	}

}
