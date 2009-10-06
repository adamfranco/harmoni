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
	 * @param object Properties $configuration
	 * @param optional string $directoryUrl
	 * @return void
	 * @access public
	 * @since 10/5/09
	 */
	public function __construct (Properties $configuration, $directoryUrl = null) {
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
		ArgumentValidator::validate($tokens, NonzeroLengthStringValidatorRule::getRule());
		$this->_identifier = $tokens;
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

?>