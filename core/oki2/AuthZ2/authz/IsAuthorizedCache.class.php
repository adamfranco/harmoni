<?php
/**
 * @since 12/20/05
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: IsAuthorizedCache.class.php,v 1.1 2008/04/24 20:51:43 adamfranco Exp $
 */ 

/**
 * The IsAuthorizedCache maintains a per-session cache of the boolean
 * responces to the methods isAuthorized($agent, $function, $qualifier) and 
 * isUserAuthorized($function, $qualifier). As these are
 * the most common Authorization functions called, expediacy is of the 
 * utmost importance, in which this cache plays an integral part.
 * 
 * The IsAuthorizedCache is a singleton and should be accessed ONLY via:
 * 	IsAuthorizedCache::instance();
 *
 * Usage
 * -----
 * The usage of this cache falls into 2 parts:
 *	- Queuing nodes for all-at-once AZ loading.
 *	- Querying as to isUserAuthorized()?
 *
 * Queuing Methodology
 * ------------------
 * Ideally, all of the nodes at which AZs will be checked during a page-load will
 * be added to the checking queue so that only one AZ query is needed to fetch them
 * all. In practice the nodes needed may be queued in several chunks. The initial 
 * implementation of this caching system will have the NodeIterator adding its
 * member Ids to the queue on its first member access.
 * 
 * Querying Methodology
 * --------------------
 * When a call to isUserAuthorized() is made the cache is checked.
 * Cache Hit:
 * 	On a cache it, the result is returned.
 * Cache Miss:
 * 	On a cache miss the queue is checked. If the Id is in the queue, it is added to 
 *	the queue. The entire queue is then loaded and the [now cached] result is returned.
 * 
 * Cache Synchronization Methodology
 * ---------------------------------
 * A table, az_node_changed, is maintained containing a timestamped list of all
 * nodes at which AZs may have changed. When node parentage is changed or an
 * Authorization is added or removed from a node, that nodeId and its descendent's
 * Ids are added to that table with the current timestamp.
 * 
 * On page-loading, a SELECT query is made of the node_changed field where the 
 * timestamp is greater than the cache-update time. Any nodes found have their
 * caches cleared and the cache-update time is set to now.
 * 
 * Cache Structure
 * ---------------
 * The cache is a two-dimensional array with the outer elements being keyed by
 * nodeId and the inner elements being keyed by FunctionId.
 * 
 * A cache hit is is made when a nodeId exists in the cache.
 * Only TRUE booleans should be considered positive authorization. NULL, FALSE, 
 * and non-existant function values in a node array should be considered 
 * unauthorized.
 * 
 * @since 12/20/05
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: IsAuthorizedCache.class.php,v 1.1 2008/04/24 20:51:43 adamfranco Exp $
 */
class AuthZ2_IsAuthorizedCache {
		
/*********************************************************
 * Class Methods - Instance-Creation/Singlton
 *********************************************************/

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
			self::$instance = new AuthZ2_IsAuthorizedCache;
		
		return self::$instance;
	}
	
	/**
	 * Set up the cache instance to use a particular AuthorizationManager
	 * 
	 * @param object AuthorizationManager $manager
	 * @return object
	 * @access public
	 * @since 4/22/08
	 * @static
	 */
	public static function initializeForManager (AuthorizationManager $manager) {
		if (!isset(self::$instance))
			self::$instance = new AuthZ2_IsAuthorizedCache($manager);
		else
			self::$instance->initialize($manager);
		
		return self::$instance;
	}
	
/*********************************************************
 * Instance Variables
 *********************************************************/
	
	/**
	 * @var array $_agentIdStrings;  
	 * @access private
	 * @since 12/20/05
	 */
	var $_agentIdStrings;
	
	/**
	 * An array of string Ids of nodes which should next have AZs loaded
	 * 
	 * @var array $_queue; 
	 * @access private
	 * @since 12/20/05
	 */
	var $_queue;
	
	/**
	 * The configuration, taken from the AuthorizationManager
	 *
	 * @var object ConfigurationProperties $_configuration;
	 * @access private
	 * @since 12/20/05
	 */
	var $_configuration;
	
	/**
	 * This is the AuthorizationCache used by the AuthorizationManager
	 * that holds the Authorization objects. It is needed as a parameter
	 * for the explicit Authorization constructor.
	 *
	 * @var object AuthorizationCache $_authorizationManagerObjectCache; 
	 * @access private
	 * @since 12/20/05
	 */
	var $_authorizationManagerObjectCache;


/*********************************************************
 * Instance Methods - Instance Creation
 *********************************************************/	

	/**
	 * The constructor, use IsAuthorizedCache::instance() to access the object.
	 * @access public
	 * @return void
	 **/
	private function __construct(AuthorizationManager $manager = null) {
		if (is_null($manager))
			$manager = Services::getService("AuthZ");
		
		$this->initialize($manager);
	}
	
	/**
	 * Initialize this cache for an authorization manager
	 * 
	 * @param object AuthorizationManager $manager
	 * @return void
	 * @access private
	 * @since 4/22/08
	 */
	private function initialize (AuthorizationManager $manager) {
		// Initialize our paremeters
		$this->_queue = array();
		$this->_agentIdStrings = array();
		
		// get our configuration
		$this->authorizationManager = $manager;
		$this->_configuration = $manager->_configuration;
		$this->_authorizationManagerObjectCache = $manager->_cache;
		
		
		
		// [Re]set up our cache if it doesn't exist or if we have a new user.
		if(!isset($_SESSION['__isAuthorizedCache']))
			$_SESSION['__isAuthorizedCache'] = array();
		
		if(!isset($_SESSION['__isAuthorizedCacheUnknownIds']))
			$_SESSION['__isAuthorizedCacheUnknownIds'] = array();
		
		
		if (!isset($_SESSION['__isAuthorizedCache']['USER'])
			|| !isset($_SESSION['__isAuthorizedCacheAgents']['USER'])
			|| !isset($_SESSION['__isAuthorizedCacheTime']['USER'])
			|| $_SESSION['__isAuthorizedCacheAgents']['USER'] != implode(", ", $this->getAgentIdStringArray('USER')))
		{
			$_SESSION['__isAuthorizedCacheAgents']['USER'] = implode(", ", $this->getAgentIdStringArray('USER'));
			$_SESSION['__isAuthorizedCache']['USER'] = array();
			$_SESSION['__isAuthorizedCacheTime']['USER'] = DateAndTime::now();
		}
		
		// Unload any expired Node AZs
		$this->_synchronizeCache();
	}
	
/*********************************************************
 * Instance Methods - Public
 *********************************************************/

	/**
	 * Given a functionId and qualifierId returns true if the user is
	 * authorized now to perform the Function with the Qualifier.
	 * 
	 * @param object Id $functionId
	 * @param object Id $qualifierId
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function isUserAuthorized ( $functionId, $qualifierId ) {
		// Cache Misses will be determined in the queing methods
		$this->queueId($qualifierId);
		$this->_loadQueue('USER');
		
		if (in_array($qualifierId->getIdString(), $_SESSION['__isAuthorizedCacheUnknownIds']))
			throw new UnknownIdException("The id, '".$qualifierId->getIdString()."', passed to the Authorization cache is unknown.");
		
		// Cache hit or newly loaded cache
		if (isset($_SESSION['__isAuthorizedCache']
					['USER']
					[$qualifierId->getIdString()]
					[$functionId->getIdString()])
			&& true === $_SESSION['__isAuthorizedCache']
							['USER']
							[$qualifierId->getIdString()]
							[$functionId->getIdString()])
		{
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Given an agentId, functionId, and qualifierId returns true if the agent is
	 * authorized now to perform the Function with the Qualifier.
	 * 
	 * @param object Id $agentId
	 * @param object Id $functionId
	 * @param object Id $qualifierId
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function isAuthorized ($agentId, $functionId, $qualifierId ) {
		if (!isset($_SESSION['__isAuthorizedCache'][$agentId->getIdString()]))
			$_SESSION['__isAuthorizedCache'][$agentId->getIdString()] = array();
			
		// Cache Misses will be determined in the queing methods
		$this->queueId($qualifierId);
		$this->_loadQueue($agentId->getIdString());
		
		if (in_array($qualifierId->getIdString(), $_SESSION['__isAuthorizedCacheUnknownIds']))
			throw new UnknownIdException("The id, '".$qualifierId->getIdString()."', passed to the Authorization cache is unknown.");
		
		// Cache hit or newly loaded cache
		if (isset($_SESSION['__isAuthorizedCache']
					[$agentId->getIdString()]
					[$qualifierId->getIdString()]
					[$functionId->getIdString()])
			&& true === $_SESSION['__isAuthorizedCache']
							[$agentId->getIdString()]
							[$qualifierId->getIdString()]
							[$functionId->getIdString()])
		{
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Add an Id to the Queue
	 * 
	 * @param object Id $id
	 * @return void
	 * @access public
	 * @since 12/20/05
	 */
	function queueId ( $id ) {
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"));
		$this->queueIdString($id->getIdString());
	}
	
	/**
	 * Add an id string to the Queue
	 * 
	 * @param string $idString
	 * @return void
	 * @access public
	 * @since 12/20/05
	 */
	function queueIdString ( $idString ) {
		foreach (array_keys($_SESSION['__isAuthorizedCache']) as $agentKey) {
			if (!isset($this->_queue[$agentKey]))
				$this->_queue[$agentKey] = array();
			
			if ((!isset($_SESSION['__isAuthorizedCache'][$agentKey][$idString])
					|| !isset($_SESSION['__isAuthorizedCache']
									[$agentKey]
									[$idString]
									['__IMPLICIT_CACHED']))
				&& !in_array($idString, $this->_queue[$agentKey])
				&& !in_array($idString, $_SESSION['__isAuthorizedCacheUnknownIds']))
			{
				$this->_queue[$agentKey][] = $idString;
			}
		}
	}
	
	/**
	 * Add an array of Ids to the Queue
	 * 
	 * @param array $idArray An array of Id objects
	 * @return void
	 * @access public
	 * @since 12/20/05
	 */
	function queueIdArray ( $idArray ) {
		foreach (array_keys($idArray) as $key) {
			$this->queueId($idArray[$key]);
		}
	}
	
	/**
	 * Add an array of id strings to the Queue
	 * 
	 * @param array $idStringArray An array of string ids
	 * @return void
	 * @access public
	 * @since 12/20/05
	 */
	function queueIdStringArray ( $idStringArray ) {
		foreach ($idStringArray as $idString) {
			$this->queueIdString($idString);
		}
	}
	
	/**
	 * Add an array of Assets to the Queue
	 * 
	 * @param array $assetArray An array of Asset or Node objects
	 * @return void
	 * @access public
	 * @since 12/20/05
	 */
	function queueAssetArray ( $assetArray ) {
		foreach (array_keys($assetArray) as $key) {
			$this->queueId($assetArray[$key]->getId());
		}
	}

/*********************************************************
 * Instance Methods - Private
 *********************************************************/
 	/**
 	 * Answer an array of the Agent id strings that correspond to the 
 	 * AgentKey passed. the agent key can be an agent id string or USER.
 	 * 
 	 * @param string $agentKey
 	 * @return array
 	 * @access public
 	 * @since 5/25/06
 	 */
 	function getAgentIdStringArray ($agentKey) {
 		
 		if (!isset($this->_agentIdStrings[$agentKey])) {
 			
 			$azManager = $this->authorizationManager;
 			$idManager = Services::getService("Id");
 			
			$this->_agentIdStrings[$agentKey] = array();
			
 			if ($agentKey == 'USER') {
 				// Store our current users
				$userIds =$azManager->_getUserIds();
				foreach ($userIds as $userId) {
					$this->_agentIdStrings['USER'][] =	$userId->getIdString();
					
					$this->_agentIdStrings['USER'] = array_merge(
						$this->_agentIdStrings['USER'],	
						$azManager->_getContainingGroupIdStrings($userId));
				}
 			} else {
				$agentId =$idManager->getId($agentKey);
				$this->_agentIdStrings[$agentKey][] = $agentKey;
				$this->_agentIdStrings[$agentKey] = array_merge(
					$this->_agentIdStrings[$agentKey],	
					$azManager->_getContainingGroupIdStrings($agentId));
 			}
 		}
 		return $this->_agentIdStrings[$agentKey];
 	}
	
	/**
	 * Load all of the Authorizations for the user and cache them
	 * 
	 * @return void
	 * @access public
	 * @since 11/10/05
	 */
	function _loadQueue ($agentIdString) {
		if (!count($this->_queue[$agentIdString]))
			return;
		
		$dbHandler = Services::getService("DatabaseManager");
		$dbIndex = $this->_configuration->getProperty('database_index');
		
// 		$timer = new Timer;
// 		$timer->start();
// 		$startingQueries = $dbHandler->getTotalNumberOfQueries();
		
	/*********************************************************
	 * Explicit AZs
	 *********************************************************/
		// Select and create all of the explicit AZs
		$query = new SelectQuery();
		$query->addColumn("*");
		$query->addTable("az2_explicit_az");
		$agentIdStrings = $this->getAgentIdStringArray($agentIdString);
		foreach($agentIdStrings as $key => $val)
			$agentIdStrings[$key] = "'".addslashes($val)."'";
		$query->addWhere("fk_agent IN(".implode(", ", $agentIdStrings).")");
		$query->addWhere("(effective_date IS NULL OR effective_date < NOW())");
		$query->addWhere("(expiration_date IS NULL OR expiration_date > NOW())");
		$query->addWhereIn("fk_qualifier", $this->_queue[$agentIdString]);
		
// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		$result =$dbHandler->query(
						$query, 
						$dbIndex);
		
		// Create the explicit AZs
		while ($result->hasMoreRows()) {
			// Set a boolean for the AZ.
			if(!isset($_SESSION['__isAuthorizedCache'][$agentIdString][$result->field("fk_qualifier")]))
				$_SESSION['__isAuthorizedCache'][$agentIdString][$result->field("fk_qualifier")] = array();
			
			$_SESSION['__isAuthorizedCache']
				[$agentIdString]
				[$result->field("fk_qualifier")]
				[$result->field("fk_function")] = true;
			
			
			$result->advanceRow();
		}
		$result->free();
		
		
	/*********************************************************
	 * Implicit AZs	
	 *********************************************************/	
	 
	 	// Before we do the big work to find the implicit AZs, first check that the
		// node Ids we are looking for exist. If not, make note of this and do not search
		// for them.
		$query = new SelectQuery();
		$query->addColumn("DISTINCT id");
		$query->addTable("az2_node");
		$query->addWhereIn("id", $this->_queue[$agentIdString]);
		$result = $dbHandler->query(
						$query, 
						$this->_configuration->getProperty('database_index'));
		$foundNodes = array();
		while ($result->hasMoreRows()) {
			$foundNodes[] = $result->field('id');
			$result->advanceRow();
		}
		$result->free();
		
		// Get a list of missing nodes
		$missing = array_diff($this->_queue[$agentIdString], $foundNodes);
		foreach ($missing as $nodeId) {
			$_SESSION['__isAuthorizedCacheUnknownIds'][] = $nodeId;
		}
		
		// Select and create all of the explicit AZs
		$query = new SelectQuery();
		$query->addColumn("*");
		$query->addTable("az2_implicit_az");
		$agentIdStrings = $this->getAgentIdStringArray($agentIdString);
		foreach($agentIdStrings as $key => $val)
			$agentIdStrings[$key] = "'".addslashes($val)."'";
		$query->addWhere("fk_agent IN(".implode(", ", $agentIdStrings).")");
		$query->addWhere("(effective_date IS NULL OR effective_date < NOW())");
		$query->addWhere("(expiration_date IS NULL OR expiration_date > NOW())");
		$query->addWhereIn("fk_qualifier", $this->_queue[$agentIdString]);
		
// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		$result =$dbHandler->query(
						$query, 
						$dbIndex);
		
		// Create the explicit AZs
		while ($result->hasMoreRows()) {
			// Set a boolean for the AZ.
			if(!isset($_SESSION['__isAuthorizedCache'][$agentIdString][$result->field("fk_qualifier")]))
				$_SESSION['__isAuthorizedCache'][$agentIdString][$result->field("fk_qualifier")] = array();
			
			$_SESSION['__isAuthorizedCache']
				[$agentIdString]
				[$result->field("fk_qualifier")]
				[$result->field("fk_function")] = true;
			
			
			$result->advanceRow();
		}
		$result->free();
		
		/*********************************************************
		 * Clear the Queue
		 *********************************************************/
		 
// 		$timer->end();
// 		printf("<br/>CacheAZTime: %1.6f", $timer->printTime());
// 		print "<br/>Num Queries: ".($dbHandler->getTotalNumberOfQueries() - $startingQueries);
		
		$this->_queue[$agentIdString] = array();
		
// 		@$this->ticker++;
// 		if ($this->ticker > 100) {
// 			printpre($_SESSION['__isAuthorizedCache'][$agentIdString]);
// 			exit;
// 		}
	}
	
	
	/**
	 * Sychronize the cache. Remove any nodes from the cache whose AZs may have 
	 * changed.
	 * 
	 * @return void
	 * @access public
	 * @since 12/20/05
	 */
	function _synchronizeCache () {
		$dbHandler = Services::getService("DBHandler");
		
		foreach (array_keys($_SESSION['__isAuthorizedCacheAgents']) as $agentIdString) {
			// Select the nodeIds who's authorization situation may have changed
			// since the cache was last synchronized. Clear these Ids from the cache.
			$query = new SelectQuery();
			$query->addTable("az2_node");
			$query->setColumns(array("id"));
			$dbDate = $dbHandler->toDBDate(
						$_SESSION['__isAuthorizedCacheTime'][$agentIdString],
						$this->_configuration->getProperty('database_index'));
			$query->addWhere("last_changed > ".$dbDate);
			
	// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
			
			$result =$dbHandler->query($query, $this->_configuration->getProperty('database_index'));
			
			while ($result->hasMoreRows()) {			
				unset($_SESSION['__isAuthorizedCache'][$agentIdString][$result->field("id")]);
				$result->advanceRow();
			}
			$result->free();
			
			$_SESSION['__isAuthorizedCacheTime'][$agentIdString] = DateAndTime::now();
		}
	}
	
	/**
	 * Update the last-changed timestamp for the node to be now so that the authorization
	 * system can sychronize with the new value.
	 * 
	 * @param object Id $nodeId
	 * @return void
	 * @access public
	 * @since 12/20/05
	 */
	function dirtyNode ( Id $nodeId ) {
		// Need to test more to determin if the Harmoni_Db version is fast enough to use.
// 		if (isset($this->authorizationManager->harmoni_db))
// 			return $this->dirtyNode_Harmoni_Db($nodeId);
    	
		$hierarchyManager = $this->authorizationManager->getHierarchyManager();
		$node =$hierarchyManager->getNode($nodeId);
		$hierarchy =$hierarchyManager->getHierarchyForNode($node);
		
		$dbHandler = Services::getService("DBHandler");
			
		if (isset($this->_configuration))
			$dbIndex = $this->_configuration->getProperty('database_index');
		else
			$dbIndex = $hierarchyManager->_configuration->getProperty('database_index');
		
		$traversalInfo =$hierarchy->traverse(
    		$nodeId,
    		Hierarchy::TRAVERSE_MODE_DEPTH_FIRST,
    		Hierarchy::TRAVERSE_DIRECTION_DOWN,
    		Hierarchy::TRAVERSE_LEVELS_ALL);
    		
    	$nodesToDirty = array();	
    		
		while ($traversalInfo->hasNext()) {
			$info =$traversalInfo->next();
			$nodeId =$info->getNodeId();
			
			$idString = $nodeId->getIdString();
			if (isset($_SESSION['__isAuthorizedCache'])) {
				foreach (array_keys($_SESSION['__isAuthorizedCache']) as $agentIdString) {
					if (isset($_SESSION['__isAuthorizedCache'][$agentIdString][$idString]))				
						unset($_SESSION['__isAuthorizedCache'][$agentIdString][$idString]);
				}
			}
			
			$nodesToDirty[] = "'".addslashes($idString)."'";
			
		}
		// Update the node's az_changed time
		// so that it can be removed from the caches of other users during
		// their synchronization.
		$query = new UpdateQuery();
		$query->setTable("az2_node");
		$query->setColumns(array("last_changed"));
		$query->setValues(array("NOW()"));
		$query->addWhere("id IN (".implode(", ", $nodesToDirty).")");
		
// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
					
		$queryResult =$dbHandler->query($query, $dbIndex);
	}
	
	/**
	 * Update the last-changed timestamp for the node to be now so that the authorization
	 * system can sychronize with the new value.
	 * 
	 * @param object Id $nodeId
	 * @return void
	 * @access public
	 * @since 4/24/08
	 */
	public function dirtyNode_Harmoni_Db (Id $nodeId) {
		$hierarchyManager = $this->authorizationManager->getHierarchyManager();
		$node = $hierarchyManager->getNode($nodeId);
		$hierarchy = $hierarchyManager->getHierarchyForNode($node);
		$harmoni_db = $this->authorizationManager->harmoni_db;
		
		$traversalInfo = $hierarchy->traverse(
    		$nodeId,
    		Hierarchy::TRAVERSE_MODE_DEPTH_FIRST,
    		Hierarchy::TRAVERSE_DIRECTION_DOWN,
    		Hierarchy::TRAVERSE_LEVELS_ALL);
    	
    	if (!isset($this->dirtyNode_stmt)) {
    		$this->dirtyNode_stmt = $harmoni_db->prepare(
    			'UPDATE '.$harmoni_db->quoteIdentifier('az2_node')
    			.' SET '.$harmoni_db->quoteIdentifier('last_changed').' = NOW()'
    			.' WHERE '.$harmoni_db->quoteIdentifier('id').' = ?');
    		
    	}
    	
		while ($traversalInfo->hasNext()) {
			$info =$traversalInfo->next();
			$nodeId =$info->getNodeId();
			
			$idString = $nodeId->getIdString();
			if (isset($_SESSION['__isAuthorizedCache'])) {
				foreach (array_keys($_SESSION['__isAuthorizedCache']) as $agentIdString) {
					if (isset($_SESSION['__isAuthorizedCache'][$agentIdString][$idString]))				
						unset($_SESSION['__isAuthorizedCache'][$agentIdString][$idString]);
				}
			}
			
			$this->dirtyNode_stmt->bindValue(1, $idString);
			$this->dirtyNode_stmt->execute();
		}
	}
	
	/**
	 * Unset the cache for the the user as the user has just changed.
	 * 
	 * @return void
	 * @access public
	 * @since 8/7/06
	 */
	function dirtyUser () {
		unset($this->_agentIdStrings['USER']);
		unset($_SESSION['__isAuthorizedCache']['USER']);
		$_SESSION['__isAuthorizedCache']['USER'] = array();
	}
}

?>