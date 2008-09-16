<?php
/**
 * @since 9/16/08
 * @package harmoni.user_prefs
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

/**
 * User-preferences are persisted key-value pairs attached to the current user. They 
 * can be used for persisting options settings or last-looked-at states.
 *
 * Data persistance:
 *		- If the user is unauthenticated (anonymous):
 *				All preferences are stored for the session.
 *
 *		- If user is authenticated:
 *				Preferences will be stored persistantly.
 *
 *		- If user is authenticated in admin-acting-as-mode:
 *				Preferences will be stored for the session.
 *
 *		- If the user is unauthenticated (anonymous), sets a preference, then logs in:
 *				?
 * 
 * @since 9/16/08
 * @package harmoni.user_prefs
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class UserPreferences {
		
	/**
 	 * @var object  $instance;  
 	 * @access private
 	 * @since 10/10/07
 	 * @static
 	 */
 	private static $instance;

	/**
	 * This class implements the Singleton pattern. There is only ever
	 * one instance of the this class and it is accessed only via the 
	 * ClassName::instance() method.
	 * 
	 * @return object 
	 * @access public
	 * @since 5/26/05
	 * @static
	 */
	public static function instance () {
		if (!isset(self::$instance))
			self::$instance = new UserPreferences;
		
		return self::$instance;
	}
	
	/**
	 * Constructor
	 * 
	 * @return void
	 * @access private
	 * @since 9/16/08
	 */
	private function __construct () {
		if (!isset($_SESSION['harmoni_user_prefs']))
			$_SESSION['harmoni_user_prefs'] = array();
	}
	
	/**
	 * Set a user preference.
	 * 
	 * @param string $key
	 * @param string $val
	 * @return void
	 * @access public
	 * @since 9/16/08
	 */
	public function setPreference ($key, $val) {
		ArgumentValidator::validate($key, NonzeroLengthStringValidatorRule::getRule());
		$val = strval($val);
		
		if ($this->_storePersistently()) {
			// Unset any setting in the session
			if (isset($_SESSION['harmoni_user_prefs'][$key]))
				unset($_SESSION['harmoni_user_prefs'][$key]);
			
			$this->_storePref($key, $val);
		} else
			$_SESSION['harmoni_user_prefs'][$key] = $val;
	}
	
	/**
	 * Get a user preference.
	 * 
	 * @param string $key
	 * @return string
	 * @access public
	 * @since 9/16/08
	 */
	public function getPreference ($key) {
		ArgumentValidator::validate($key, NonzeroLengthStringValidatorRule::getRule());
		
		// First check the session for any overridden values
		if (isset($_SESSION['harmoni_user_prefs'][$key]))
			return $_SESSION['harmoni_user_prefs'][$key];
		else
			return $this->_fetchPref($key);
	}
	
	/**
	 * Answer all of the preference keys.
	 * 
	 * @return array
	 * @access public
	 * @since 9/16/08
	 */
	public function getPreferenceKeys () {
		$this->_loadUserPrefs();
		$keys = array();
		if (isset($_SESSION['harmoni_user_prefs_persistant']))
			$keys = array_keys($_SESSION['harmoni_user_prefs_persistant']);
		$keys = array_unique(array_merge($keys, array_keys($_SESSION['harmoni_user_prefs'])));
		sort($keys);
		return $keys;
	}
	
	/**
	 * Clear the value of a preference.
	 * 
	 * @param string $key
	 * @return void
	 * @access public
	 * @since 9/16/08
	 */
	public function clearPreference ($key) {
		ArgumentValidator::validate($key, NonzeroLengthStringValidatorRule::getRule());
		
		// Unset any setting in the session
		if (isset($_SESSION['harmoni_user_prefs'][$key]))
			unset($_SESSION['harmoni_user_prefs'][$key]);
		
		$this->_deletePref($key);
	}
	
	/**
	 * Clear out any session-stored preferences
	 * 
	 * @return void
	 * @access public
	 * @since 9/16/08
	 */
	public function clearSessionPreferences () {
		$_SESSION['harmoni_user_prefs'] = array();
	}
	
	/**
	 * Clear all preferences for the current user
	 * 
	 * @return void
	 * @access public
	 * @since 9/16/08
	 */
	public function clearAllPreferences () {
		$this->clearSessionPreferences();
		
		// Do not persist preferences for anonymous.
		if ($this->_getCurrentAgentId() == 'edu.middlebury.agents.anonymous')
			return;
				
		$query = new DeleteQuery();
		$query->setTable('user_prefs');
		$query->addWhereEqual('agent_id', $this->_getCurrentAgentId());
		$dbc = Services::getService('DatabaseManager');
		$dbc->query($query);
	}
	
	/**
	 * Answer the session-value of a preference
	 * 
	 * @param string $key
	 * @return string
	 * @access public
	 * @since 9/16/08
	 */
	public function getPreferenceSessionValue ($key) {
		if (isset($_SESSION['harmoni_user_prefs'][$key]))
			return $_SESSION['harmoni_user_prefs'][$key];
		else
			return null;
	}
	
	/**
	 * Answer the persistant-value of a preference.
	 * 
	 * @param string $key
	 * @return string
	 * @access public
	 * @since 9/16/08
	 */
	public function getPreferencePersistantValue ($key) {
		return $this->_fetchPref($key);
	}
	
	
	/*********************************************************
	 * Private methods
	 *********************************************************/
	
	
	/**
	 * Load all user preferences for the current user
	 * 
	 * @return void
	 * @access protected
	 * @since 9/16/08
	 */
	protected function _loadUserPrefs () {
		if (!isset($_SESSION['harmoni_user_prefs_persistant']) 
			|| $_SESSION['harmoni_user_prefs_user'] != $this->_getCurrentAgentId()) 
		{
			unset($_SESSION['harmoni_user_prefs_user']);
			unset($_SESSION['harmoni_user_prefs_persistant']);
			// Do not load preferences for anonymous.
			if ($this->_getCurrentAgentId() == 'edu.middlebury.agents.anonymous')
				return;
			
			
			$query = new SelectQuery();
			$query->addTable('user_prefs');
			$query->addColumn('pref_key');
			$query->addColumn('pref_val');
			$query->addWhereEqual('agent_id', $this->_getCurrentAgentId());
			
			$dbc = Services::getService('DatabaseManager');
			$result = $dbc->query($query);
			
			$_SESSION['harmoni_user_prefs_user'] = $this->_getCurrentAgentId();
			$_SESSION['harmoni_user_prefs_persistant'] = array();
			while ($result->hasNext()) {
				$row = $result->next();
				$_SESSION['harmoni_user_prefs_persistant'][$row['pref_key']] = $row['pref_val'];
			}
		}
	}
	
	/**
	 * Fetch a persisted user preference
	 * 
	 * @param string $key
	 * @return string
	 * @access protected
	 * @since 9/16/08
	 */
	protected function _fetchPref ($key) {
		$this->_loadUserPrefs();
		if (isset($_SESSION['harmoni_user_prefs_persistant'][$key]))
			return $_SESSION['harmoni_user_prefs_persistant'][$key];
		else
			return null;
	}
	
	/**
	 * Persistantly store a user preference
	 * 
	 * @param string $key
	 * @param string $val
	 * @return void
	 * @access protected
	 * @since 9/16/08
	 */
	protected function _storePref ($key, $val) {
		// Do not persist preferences for anonymous.
		if ($this->_getCurrentAgentId() == 'edu.middlebury.agents.anonymous')
			return;
		
		if ($this->_fetchPref($key) == $val)
			return;
		
		if (is_null($this->_fetchPref($key))) {
			$query = new InsertQuery();
			$query->addValue('agent_id', $this->_getCurrentAgentId());
			$query->addValue('pref_key', $key);
		} else {
			$query = new UpdateQuery();
			$query->addWhereEqual('agent_id', $this->_getCurrentAgentId());
			$query->addWhereEqual('pref_key', $key);
		}
		
		$query->setTable('user_prefs');
		
		$query->addValue('pref_val', $val);
		
		$dbc = Services::getService('DatabaseManager');
		$dbc->query($query);
		
		$_SESSION['harmoni_user_prefs_persistant'][$key] = $val;
	}
	
	/**
	 * Delete a preference
	 * 
	 * @param string $key
	 * @return void
	 * @access protected
	 * @since 9/16/08
	 */
	protected function _deletePref ($key) {
		// Do not persist preferences for anonymous.
		if ($this->_getCurrentAgentId() == 'edu.middlebury.agents.anonymous')
			return;
				
		$query = new DeleteQuery();
		$query->setTable('user_prefs');
		$query->addWhereEqual('agent_id', $this->_getCurrentAgentId());
		$query->addWhereEqual('pref_key', $key);
		$dbc = Services::getService('DatabaseManager');
		$dbc->query($query);
	}
	
	/**
	 * Answer the current agentId
	 * 
	 * @return string
	 * @access protected
	 * @since 9/16/08
	 */
	protected function _getCurrentAgentId () {
		if (!isset($this->_currentAgentId)) {
			$authN = Services::getService('AuthN');
			$this->_currentAgentId = $authN->getFirstUserId()->getIdString();
		}
		
		return $this->_currentAgentId;
	}
	
	/**
	 * Answer true if preferences should be stored persistantly.
	 * 
	 * @return boolean
	 * @access protected
	 * @since 9/16/08
	 */
	protected function _storePersistently () {
		// Anonymous will never be persisted.
		if ($this->_getCurrentAgentId() == 'edu.middlebury.agents.anonymous')
			return false;
		
		// Check to see if we are an admin acting as another user
		if (isset($_SESSION['__ADMIN_IDS_ACTING_AS_OTHER']) && count($_SESSION['__ADMIN_IDS_ACTING_AS_OTHER']))
			return false;
		
		// For normal logged in users.
		return true;
	}
}

?>