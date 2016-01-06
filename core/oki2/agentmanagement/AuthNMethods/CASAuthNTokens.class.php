<?php
/**
 * @since 10/5/09
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 *
 * @copyright Copyright &copy; 2009, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 */

/**
 * <##>
 *
 * @since 10/5/09
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 *
 * @copyright Copyright &copy; 2009, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 */
class CASAuthNTokens
	extends AuthNTokens
{

	/**
	 * Constructor
	 *
	 * @param object CASAuthNMethod $authNMethod
	 * @param object Properties $configuration
	 * @param optional string $directoryUrl
	 * @return void
	 * @access public
	 * @since 10/5/09
	 */
	public function __construct (CASAuthNMethod $authNMethod, Properties $configuration, $directoryUrl = null) {
		$this->_authNMethod = $authNMethod;
		$this->_directoryUrl = $directoryUrl;
		parent::AuthNTokens($configuration);
	}

	/**
	 * Initialize this object for a set of authentication tokens.
	 *
	 * @param mixed $tokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function initializeForTokens ( $tokens ) {
		// If we are passed a username, do a search to try to map that to an id.
		if (is_array($tokens) && isset($tokens['username'])) {
			// Look up the user by username
			$doc = $this->_authNMethod->_queryDirectory('search_users_by_attributes', array('Login' => $tokens['username']));
			if ($doc) {
				$elements = $doc->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'user');
				if ($elements->length > 1) {
					throw new UnknownIdException("Username '".$tokens['username']."' matches multiple CAS ids could not determine a single CAS Id.");
				} else if ($elements->length == 1) {
					$this->_identifier = $elements->item(0)->nodeValue;
					return;
				}
			}
			// If we didn't find an Id based on the username, just stuff the username
			// into the identifier field to see if it happens to be a valid id and not a username.
			$this->_identifier = $tokens['username'];
		}
		// Normal Case
		else {
			ArgumentValidator::validate($tokens, NonzeroLengthStringValidatorRule::getRule());
			$this->_identifier = $tokens;
		}
	}

	/**
	 * Initialize this object for an identifier. The identifier is often a
	 * username, but can be any string as long as it is unique within a given
	 * AuthNMethod.
	 *
	 * @param string $identifier
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function initializeForIdentifier ( $identifier ) {
		ArgumentValidator::validate($identifier, NonzeroLengthStringValidatorRule::getRule());
		$this->_identifier = $identifier;
	}

	/**
	 * Return properly formatted tokens for this instance.
	 *
	 * @return mixed
	 * @access public
	 * @since 3/1/05
	 */
	function getTokens () {
		return $this->getIdentifier();
	}

}
