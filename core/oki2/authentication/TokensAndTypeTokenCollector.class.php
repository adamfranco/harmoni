<?php
/**
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BasicFormNamePassTokenCollector.class.php,v 1.4 2007/09/04 20:25:37 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/TokenCollector.abstract.php");

/**
 * This Token collector will return the 
 * 
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BasicFormNamePassTokenCollector.class.php,v 1.4 2007/09/04 20:25:37 adamfranco Exp $
 */
class TokensAndTypeTokenCollector
	extends TokenCollector
{

	/**
	 * Constructor
	 * 
	 * @param string $jqueryUrl
	 * @param string $jqueryAutocompleteUrl
	 * @return void
	 * @access public
	 * @since 10/8/09
	 */
	public function __construct ($jqueryUrl, $jqueryAutocompleteUrl, $jqueryAutocompleteCss) {
		if (!strlen($jqueryUrl))
			throw new ConfigurationErrorException('$jqueryUrl is not specified');
		if (!strlen($jqueryAutocompleteUrl))
			throw new ConfigurationErrorException('$jqueryAutocompleteUrl is not specified');
		if (!strlen($jqueryAutocompleteCss))
			throw new ConfigurationErrorException('$jqueryAutocompleteCss is not specified');
		
		$this->jqueryUrl = $jqueryUrl;
		$this->jqueryAutocompleteUrl = $jqueryAutocompleteUrl;
		$this->jqueryAutocompleteCss = $jqueryAutocompleteCss;
	}
	
	/**
	 * Prompt the user to supply their tokens
	 * 
	 * @return void
	 * @access public
	 * @since 3/16/05
	 */
	function prompt () {
		$harmoni = Harmoni::instance();
		$harmoni->request->startNamespace("harmoni-authentication");
		
		$action = str_replace('&', '&amp;', $_SERVER['REQUEST_URI']);
		$userField = $harmoni->request->getName("user");
		$idField = $harmoni->request->getName("identifier");
		$typeField = $harmoni->request->getName("type");
		$userText = _("User");
		$loginText = _("Login");
		
		$seachAction = MYURL;
		
		print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<title>Choose User</title>
	<script type='text/javascript' src='".$this->jqueryUrl."'></script>
	<script type='text/javascript' src='".$this->jqueryAutocompleteUrl."'></script>
	<link rel='stylesheet' type='text/css' href='".$this->jqueryAutocompleteCss."'/>
	
	<script type='text/javascript'>
	// <![CDATA[
	
	$(document).ready(function() {
		
		$('#user_search').autocomplete('$seachAction', {
			extraParams: {
				'$userField': function() { return $('#user_search').val(); },
				'module': 'auth',
				'action': 'search_users'
			},
			delay: 600,
			max: 100,
			minChars: 3,
			mustMatch: true
		}).result(function(event, data, formatted) {
			if (data) {
				var regex = /type=\"([^\"]+)\"/;
				var matches = regex.exec(data);
				$('#auth_type').val(matches[1]);
				
				var regex = /id=\"([^\"]+)\"/;
				var matches = regex.exec(data);
				$('#user_id').val(matches[1]);
				
				$('#choose_user').submit();
			}
		});
		
	});
	
	//]]>
	</script>
</head>
<body>

	<form id='choose_user' action='$action' method='post'>
		$userText: <input type='text' size='60' id='user_search' name='$userField' /><br />
		<input type='hidden' id='user_id' name='$idField' />
		<input type='hidden' id='auth_type' name='$typeField' />
		<input type='submit' value='$loginText'/>
	</form>

</body>
</html>

";
		$harmoni->request->endNamespace();
		exit;
	}
	
	/**
	 * Collect any tokens that the user may have supplied. Reply NULL if none
	 * are found.
	 * 
	 * @return mixed
	 * @access public
	 * @since 3/16/05
	 */
	function collect () {
		$harmoni = Harmoni::instance();
		$harmoni->request->startNamespace("harmoni-authentication");
		$typeString = $harmoni->request->get("type");
		$identifier = $harmoni->request->get("identifier");
		$harmoni->request->endNamespace();
		
		if (!strlen($typeString) || !strlen($identifier))
			return null;
		
		$authNMethodManager = Services::getService("AuthNMethods");
		$this->type = HarmoniType::fromString($typeString);
		$authNMethod = $authNMethodManager->getAuthNMethodForType($this->type);
		return $authNMethod->createTokensForIdentifier($identifier);
	}
	
	/**
	 * Collect the authentication type associated with the tokens or null if not found
	 * 
	 * @return Type
	 * @access public
	 * @since 10/8/09
	 */
	public function getAuthNType () {
		if (!isset($this->type)) {
			$tokens = $this->collect();
			if (is_null($tokens))
				return null;
		}
		return $this->type;
	}
}

?>