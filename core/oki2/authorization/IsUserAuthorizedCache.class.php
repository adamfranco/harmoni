<?php
/**
 * @since 12/20/05
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: IsUserAuthorizedCache.class.php,v 1.7 2006/02/15 14:27:20 adamfranco Exp $
 */ 

/**
 * The IsUserAuthorizedCache maintains a per-session cache of the boolean
 * responces to the method isUserAuthorized($function, $qualifier). As this is
 * the most common Authorization function to be called, expediacy is of the 
 * utmost importance, in which this cache plays an integral part.
 * 
 * The IsUserAuthorizedCache is a singleton and should be accessed ONLY via:
 * 	IsUserAuthorizedCache::instance();
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
 * @version $Id: IsUserAuthorizedCache.class.php,v 1.7 2006/02/15 14:27:20 adamfranco Exp $
 */
class IsUserAuthorizedCache {
		
/*********************************************************
 * Class Methods - Instance-Creation/Singlton
 *********************************************************/

	/**
	 * Get the instance of the IsUserAuthorizedCache.
	 * The IsUserAuthorizedCache class implements the Singleton pattern. There 
	 * is only ever one instance of the IsUserAuthorizedCache object and it is 
	 * accessed only via the IsUserAuthorizedCache::instance() method.
	 * 
	 * @return object Harmoni
	 * @access public
	 * @since 5/26/05
	 * @static
	 */
	function &instance () {
		if (!defined("IsUserAuthorizedCache_INSTANTIATED")) {
			$GLOBALS['__IsUserAuthorizedCacheInstance'] =& new IsUserAuthorizedCache();
			define("IsUserAuthorizedCache_INSTANTIATED", true);
		}
		
		return $GLOBALS['__IsUserAuthorizedCacheInstance'];
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
	 * The constructor, use IsUserAuthorizedCache::instance() to access the object.
	 * @access public
	 * @return void
	 **/
	function IsUserAuthorizedCache() {
		// Verify that there is only one instance of Harmoni.
		$backtrace = debug_backtrace();
		if (false && $GLOBALS['__IsUserAuthorizedCache'] 
			|| !(
				$backtrace[1]['class'] == 'isuserauthorizedcache'
				&& $backtrace[1]['function'] == 'instance'
				&& $backtrace[1]['type'] == '::'
			))
		{
			die("<br/><strong>Invalid IsUserAuthorizedCache instantiation at...</strong>"
			."<br/> File: ".$backtrace[0]['file']
			."<br/> Line: ".$backtrace[0]['line']
			."<br/><strong>Access IsUserAuthorizedCache with <em>IsUserAuthorizedCache::instance()</em></strong>");
		}
		
		// Initialize our paremeters
		$this->_queue = array();
		
		// get our configuration
		$azManager =& Services::getService("AuthZ");
		$this->_configuration =& $azManager->_configuration;
		$this->_authorizationManagerObjectCache =& $azManager->_cache;
		
		// Store our current users
		$userIds =& $azManager->_getUserIds();
		$this->_agentIdStrings = array();
		foreach (array_keys($userIds) as $key) {
			$userId =& $userIds[$key];
			$this->_agentIdStrings[] =	$userId->getIdString();
			$this->_agentIdStrings = array_merge(
				$this->_agentIdStrings,	
				$azManager->_getContainingGroupIdStrings($userId));
		}
		
		// [Re]set up our cache if it doesn't exist or if we have a new user.
		if(!isset($_SESSION['__isUserAuthorizedCache'])
			|| !isset($_SESSION['__isUserAuthorizedCachedUser'])
			|| $_SESSION['__isUserAuthorizedCachedUser'] != implode(", ", $this->_agentIdStrings))
		{
			$_SESSION['__isUserAuthorizedCache'] = array();
			$_SESSION['__isUserAuthorizedCachedUser'] = implode(", ", $this->_agentIdStrings);
			$_SESSION['__isUserAuthorizedCacheTime'] =& DateAndTime::now();
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
	function isUserAuthorized ( &$functionId, &$qualifierId ) {
		// Cache Misses will be determined in the queing methods
		$this->queueId($qualifierId);
		$this->_loadQueue();
		
		// Cache hit or newly loaded cache
		if (isset($_SESSION['__isUserAuthorizedCache']
					[$qualifierId->getIdString()]
					[$functionId->getIdString()])
			&& true === $_SESSION['__isUserAuthorizedCache']
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
	function queueId ( &$id ) {
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
		if ((!isset($_SESSION['__isUserAuthorizedCache'][$idString])
				|| !isset($_SESSION['__isUserAuthorizedCache']
								[$idString]
								['__IMPLICIT_CACHED']))
			&& !in_array($idString, $this->_queue))
		{
			$this->_queue[] = $idString;
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
	function queueIdArray ( &$idArray ) {
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
	function queueAssetArray ( &$assetArray ) {
		foreach (array_keys($assetArray) as $key) {
			$this->queueId($assetArray[$key]->getId());
		}
	}

/*********************************************************
 * Instance Methods - Private
 *********************************************************/
	
	/**
	 * Load all of the Authorizations for the user and cache them
	 * WARNING: not in OSID
	 * 
	 * @return void
	 * @access public
	 * @since 11/10/05
	 */
	function _loadQueue () {
		if (!count($this->_queue))
			return;
		
		$dbHandler =& Services::getService("DatabaseManager");
		$dbIndex = $this->_configuration->getProperty('database_index');
		$idManager =& Services::getService("Id");
		
		$functions = array();	//used by Algorithm A
		
// 		$timer =& new Timer;
// 		$timer->start();
// 		$startingQueries = $dbHandler->getTotalNumberOfQueries();
		
	// Explicit AZs
		// Select and create all of the explicit AZs
		$query =& new SelectQuery();
		$query->addColumn("*");
		$query->addTable("az_authorization");
		$query->addWhere("fk_agent IN('".implode("', '", $this->_agentIdStrings)."')");
		$query->addWhere("(authorization_effective_date IS NULL OR authorization_effective_date < NOW())");
		$query->addWhere("(authorization_expiration_date IS NULL OR authorization_expiration_date > NOW())");
		
// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		$result =& $dbHandler->query(
						$query, 
						$dbIndex);
		
		// Create the explicit AZs
		while ($result->hasMoreRows()) {
			$az =& new HarmoniAuthorization(
						$result->field("authorization_id"),
						$idManager->getId($result->field("fk_agent")),
						$idManager->getId($result->field("fk_function")),
						$idManager->getId($result->field("fk_qualifier")),
						true,
						$this->_authorizationManagerObjectCache,
						$dbHandler->fromDBDate(
								$result->field("authorization_effective_date"),
								$dbIndex),
						$dbHandler->fromDBDate(
								$result->field("authorization_expiration_date"), 
								$dbIndex));
			
			// cache in our explictAZ cache for referencing by implicit AZs
			$explicitAZs[$result->field("authorization_id")] =& $az;
			
			// Build a list of functions for AlogrithmA to use when setting implicitAZs
			$functions[] = $result->field("fk_function");
			
			// Set a boolean for the AZ.
			if(!isset($_SESSION['__isUserAuthorizedCache'][$result->field("fk_qualifier")]))
				$_SESSION['__isUserAuthorizedCache'][$result->field("fk_qualifier")] = array();
			
			$_SESSION['__isUserAuthorizedCache']
				[$result->field("fk_qualifier")]
				[$result->field("fk_function")] = true;
			
			
			$result->advanceRow();
		}
		$result->free();
		
		
	/*********************************************************
	 * Implicit AZs	
	 *********************************************************/
		// Algorithm A:
		// For this algorithm we will do a single traversal of the hierarchy
		// and set implicit authorization bits on the way down as we pass
		// explicit AZs.
// 		$hierarchyManager =& Services::getService("Hierarchy");
// 		$hierarchies =& $hierarchyManager->getHierarchies();
// 		while ($hierarchies->hasNext()) {
// 			$hierarchy =& $hierarchies->next();
// 			$rootNodes =& $hierarchy->getRootNodes();
// 			while ($rootNodes->hasNext()) {
// 				$rootNode =& $rootNodes->next();
// 				
// 				$rootNodeId =& $rootNode->getId();
// // 				print "\n<h1>Traversing from RootNode: ".$rootNodeId->getIdString()."</h1>";
// 				
// 				$timer2 =& new Timer;
// 				$timer2->start();
// 				$traversal =& $hierarchy->traverse(
// 					$rootNode->getId(),
// 					Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(),
// 					Hierarchy::TRAVERSE_DIRECTION_DOWN(),
// 					Hierarchy::TRAVERSE_LEVELS_ALL());
// 				$timer2->end();
// 				printf("<br/>CacheAZ Traversal Time: %1.6f", $timer2->printTime());
// 				
// 				$explicitAZLevels = array();
// 				
// 				while ($traversal->hasNext()) {
// 					$info =& $traversal->next();
// 					$id =& $info->getNodeId();
// 					$idString = $id->getIdString();
// 					$level = $info->getLevel();
// // 					printpre("<strong>$level\t$idString</strong>");
// 					
// 					foreach($functions as $functionId) {
// 						if (!isset($explicitAZLevels[$functionId])) {
// 							if (isset($_SESSION['__isUserAuthorizedCache'][$idString][$functionId])) {
// 								$explicitAZLevels[$functionId] = $level;
// // 								printpre("\tFound Explicit $functionId at level $level");
// 							}
// 						} else {
// 							if ($level <= $explicitAZLevels[$functionId]) {
// 								unset($explicitAZLevels[$functionId]);
// // 								printpre("\tUnsetting ExplicitAZ $functionId at $level");
// 							} else {
// 								$_SESSION['__isUserAuthorizedCache'][$idString][$functionId] = true;
// // 								printpre("\tSetting Implicit $functionId at level $level");
// 							}
// 						}
// 					}
// 				}
// 			}
// 		}
		
		
		// Algorithm B:
		// For this algorithm we want to join all of the explicit AZs to all 
		// nodes who have the qulifier as an ancestor. These will be the implicit AZs
		$query =& new SelectQuery();
		$query->addColumn("authorization_id");
		$query->addColumn("fk_node");
		$query->addTable("az_authorization");
		$query->addTable("node_ancestry", LEFT_JOIN, "fk_qualifier = fk_ancestor");
		$query->addWhere("fk_node IN('".implode("', '", $this->_queue)."')");
		$query->addWhere("fk_agent IN('".implode("', '", $this->_agentIdStrings)."')");
		$query->addWhere("(authorization_effective_date IS NULL OR authorization_effective_date < NOW())");
		$query->addWhere("(authorization_expiration_date IS NULL OR authorization_expiration_date > NOW())");
		
// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		$result =& $dbHandler->query(
						$query, 
						$this->_configuration->getProperty('database_index'));
		
		while ($result->hasMoreRows()) {			
			$explicitAZ =& $explicitAZs[$result->field("authorization_id")];
			$explicitFunction =& $explicitAZ->getFunction();
			$explicitFunctionId =& $explicitFunction->getId();
			
			// cache in our user AZ cache
			if(!isset($_SESSION['__isUserAuthorizedCache'][$result->field("fk_node")]))
				$_SESSION['__isUserAuthorizedCache'][$result->field("fk_node")] = array();
			
			$_SESSION['__isUserAuthorizedCache']
				[$result->field("fk_node")]
				[$explicitFunctionId->getIdString()] = true;
			
			$result->advanceRow();
		}
		$result->free();
		
		// Set flags that each Qualifier in the queue has had its implicit AZs cached.
		foreach ($this->_queue as $qualifierIdString) {
			$_SESSION['__isUserAuthorizedCache']
				[$qualifierIdString]
				['__IMPLICIT_CACHED'] = true;
		}
		
// 		$timer->end();
// 		printf("<br/>CacheAZTime: %1.6f", $timer->printTime());
// 		print "<br/>Num Queries: ".($dbHandler->getTotalNumberOfQueries() - $startingQueries);
		
		$this->_queue = array();
		
// 		@$this->ticker++;
// 		if ($this->ticker > 100) {
// 			printpre($_SESSION['__isUserAuthorizedCache']);
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
		$dbHandler =& Services::getService("DBHandler");
		
		// Select the nodeIds who's authorization situation may have changed
		// since the cache was last synchronized. Clear these Ids from the cache.
		$query =& new SelectQuery();
		$query->addTable("node");
		$query->setColumns(array("node_id"));
		$dbDate = $dbHandler->toDBDate(
					$_SESSION['__isUserAuthorizedCacheTime'],
					$this->_configuration->getProperty('database_index'));
		$query->addWhere("az_node_changed > ".$dbDate);
		
// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		
		$result =& $dbHandler->query($query, $this->_configuration->getProperty('database_index'));
		
		while ($result->hasMoreRows()) {			
			unset($_SESSION['__isUserAuthorizedCache'][$result->field("node_id")]);
			$result->advanceRow();
		}
		$result->free();
		
		$_SESSION['__isUserAuthorizedCacheTime'] =& DateAndTime::now();
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
	function dirtyNode ( &$nodeId ) {
		ArgumentValidator::validate($nodeId, ExtendsValidatorRule::getRule("Id"), true);
		
		$hierarchyManager =& Services::getService("Hierarchy");
		$node =& $hierarchyManager->getNode($nodeId);
		$hierarchy =& $hierarchyManager->getHierarchyForNode($node);
		
		$dbHandler =& Services::getService("DBHandler");
			
		if (isset($this->_configuration))
			$dbIndex = $this->_configuration->getProperty('database_index');
		else
			$dbIndex = $hierarchyManager->_configuration->getProperty('database_index');
		
		$traversalInfo =& $hierarchy->traverse(
    		$nodeId,
    		Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(),
    		Hierarchy::TRAVERSE_DIRECTION_DOWN(),
    		Hierarchy::TRAVERSE_LEVELS_ALL());
    		
    	$nodesToDirty = array();	
    		
		while ($traversalInfo->hasNext()) {
			$info =& $traversalInfo->next();
			$nodeId =& $info->getNodeId();
			
			$idString = $nodeId->getIdString();
			if (isset($_SESSION['__isUserAuthorizedCache'][$idString]))				
				unset($_SESSION['__isUserAuthorizedCache'][$idString]);

			$nodesToDirty[] = "'".addslashes($idString)."'";
			
		}
		// Update the node's az_changed time
		// so that it can be removed from the caches of other users during
		// their synchronization.
		$query =& new UpdateQuery();
		$query->setTable("node");
		$query->setColumns(array("az_node_changed"));
		$query->setValues(array("NOW()"));
		$query->addWhere("node_id IN (".implode(", ", $nodesToDirty).")");
		
// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
					
		$queryResult =& $dbHandler->query($query, $dbIndex);
	}
}

?>