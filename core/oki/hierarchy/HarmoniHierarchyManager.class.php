<?

require_once(OKI."/hierarchy.interface.php");

require_once(HARMONI."oki/hierarchy/HarmoniHierarchy.class.php");
require_once(HARMONI."oki/hierarchy/HarmoniHierarchyIterator.class.php");
require_once(HARMONI."oki/hierarchy/HarmoniNodeIterator.class.php");
require_once(HARMONI."oki/hierarchy/HarmoniTraversalInfoIterator.class.php");

require_once(HARMONI."oki/hierarchy/MemoryOnlyHierarchyManagerStore.class.php");
require_once(HARMONI."oki/hierarchy/SQLDatabaseHierarchyManagerStore.class.php");

require_once(HARMONI.'/oki/shared/HarmoniSharedManager.class.php');
Services::registerService("Shared","HarmoniSharedManager");

define("SQL_DATABASE", 1000);
define("MEMORY_ONLY", 1001);

/**
 * All implementors of OsidManager provide create, delete, and get methods for
 * the various objects defined in the package.  Most managers also include
 * methods for returning Types.  We use create methods in place of the new
 * operator.  Create method implementations should both instantiate and
 * persist objects.  The reason we avoid the new operator is that it makes the
 * name of the implementating package explicit and requires a source code
 * change in order to use a different package name. In combination with
 * OsidLoader, applications developed using managers permit implementation
 * substitution without source code changes.
 * 
 * <p>
 * Licensed under the {@link osid.SidLicense MIT O.K.I SID Definition License}.
 * </p>
 * 
 * <p></p>
 *
 * @version $Revision: 1.13 $ / $Date: 2003/11/04 22:37:38 $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniHierarchyManager
	extends HierarchyManager
//	impliments ServicesInterface	// start() and stop() methods are provided
{ // begin HierarchyManager


	/**
	 * @var object HierarchyManagerStore $_managerStore A save/load handler for the hierarchies
	 *			Hierarchies in this manager.
	 */
	var $_managerStore = NULL;
	
	/**
	 * @var array $_configuration An array of configurations for this manager. Holds where to
	 * 			locate hierarchies referenced by the manager.
	 */
	var $_configuration = NULL;
	
	/**
	 * Constructor
	 * @param array $configuration	An array of the configuration options nessisary to load
	 * 								this manager. To use the a specific manager store, a
	 *								store data source must be configured as noted in the class
	 * 								of said manager store.
	 * manager.
	 * @access public
	 */
	function HarmoniHierarchyManager ($configuration = NULL) {
		if ($configuration == NULL) {
			// create a store that isn't saved
			$this->_managerStore =& new MemoryOnlyHierarchyManagerStore(); 
		} else {
			if ($configuration[type] == SQL_DATABASE) {
				$dbIndex = $configuration[database_index];
				$hierarchyTableName = $configuration[hierarchy_table_name];
				$hierarchyIdColumn = $configuration[hierarchy_id_column];
				$hierarchyDisplayNameColumn = $configuration[hierarchy_display_name_column];
				$hierarchyDescriptionColumn = $configuration[hierarchy_description_column];
				$nodeTableName = $configuration[node_table_name];
				$nodeHierarchyKeyColumn = $configuration[node_hierarchy_key_column];
				$nodeIdColumn = $configuration[node_id_column];
				$nodeParentKeyColumn = $configuration[node_parent_key_column];
				$nodeDisplayNameColumn = $configuration[node_display_name_column];
				$nodeDescriptionColumn = $configuration[node_description_column];
						
				// create the store
				$this->_managerStore =& new SQLDatabaseHierarchyManagerStore($dbIndex,
						$hierarchyTableName, $hierarchyIdColumn, $hierarchyDisplayNameColumn,
						$hierarchyDescriptionColumn, $nodeTableName, $nodeHierarchyKeyColumn,
						$nodeIdColumn, $nodeParentKeyColumn, $nodeDisplayNameColumn, 
						$nodeDescriptionColumn, $nodeTypes); 
				
			} else if ($configuration[type] == MEMORY_ONLY) {
				$this->_managerStore =& new MemoryOnlyHierarchyManagerStore();
				
			} else {
				throwError(new Error("Unknown Manager Store Type: ".$configuration[type], "Hierarchy", 1));
			}
		}
		
		$this->_configuration = $configuration;
		
		$this->load();
	}

	/**
	 * Create a Hierarchy.
	 *
	 * @param String name
	 * @param String description
	 * @param boolean allowsMultipleParents
	 * @param boolean allowsRecursion
	 *
	 * @return Hierarchy
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message HierarchyException.ILLEGAL_HIERARCHY
	 *		   if allowsMultipleParents is false and allowsResursion is true.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & createHierarchy($allowsMultipleParents, $description, $name, & $nodeTypes, $allowsRecursion) {
		// Check the arguments
		ArgumentValidator::validate($allowsMultipleParents, new BooleanValidatorRule);
		ArgumentValidator::validate($description, new StringValidatorRule);
		ArgumentValidator::validate($name, new StringValidatorRule);
		ArgumentValidator::validate($nodeTypes, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("Type")));
		ArgumentValidator::validate($allowsRecursion, new BooleanValidatorRule);
		
		// if allowsMultipleParents is false and allowsRecursion is true
		if ($allowsMultipleParents && !$allowsRecursion)
			throwError(new Error(ILLEGAL_HIERARCHY, "HierarchyManager", 1));
		
		// if allowsMultipleParents is false and allowsRecursion is true
		if ($allowsMultipleParents || $allowsRecursion)
			throwError(new Error(UNSUPPORTED_HIERARCHY, "HierarchyManager", 1));
		
		// Load this Manager from persistable storage
		$this->load();
		
		// Create an Id for the Hierarchy
		$sharedManager =& Services::requireService("Shared");
		$hierarchyId =& $sharedManager->createId();
		
		// Create a HierarchyStore and id based on the given configuration.
		$hierarchyStore =& $this->_managerStore->createHierarchyStore($hierarchyId);

		// Create a new hierarchy and add it to the managerStore;
		$hierarchy =& new HarmoniHierarchy($hierarchyId, $description, $name, $nodeTypes, $hierarchyStore);
		$this->_managerStore->addHierarchy($hierarchy);
		
		// Save this Manager to persistable storage
		$this->save();
		
		return $hierarchy;
	}

	/**
	 * Get a Hierarchy by unique Id.
	 *
	 * @param osid.shared.Id hierarchyId
	 *
	 * @return Hierarchy
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message HierarchyException.HIERARCHY_UNKNOWN
	 *		   if there is no Hierarchy matching hierarchyId.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getHierarchy(& $hierarchyId) {
		ArgumentValidator::validate($hierarchyId, new ExtendsValidatorRule("Id"));
		
		// if the Id is valid
		$hierarchies =& $this->getHierarchies();
		while ($hierarchies->hasNext()) {
			$hierarchy =& $hierarchies->next();
			if ($hierarchyId->isEqual($hierarchy->getId())) {
				// if the hierarchy has the requested Id.
				$hierarchy->load();
				return $hierarchy;	
			}
		}
		
		// if we don't find a matching Id, throw an error
		throwError(new Error(UNKNOWN_ID, "HierarchyManager", 1));
	}

	/**
	 * Get all Hierarchies.
	 *
	 * @return HierarchyIterator  Iterators return a set, one at a time.  The
	 *		   Iterator's hasNext method returns true if there are additional
	 *		   objects available; false otherwise.  The Iterator's next method
	 *		   returns the next object.  The order of the objects returned by
	 *		   the Iterator is not guaranteed.
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getHierarchies() {
		$hierarchies =& $this->_managerStore->getHierarchyArray();
		foreach ($hierarchies as $key => $val) {
			$hierarchies[$key]->load();
		}
		$hierarchyIterator =& new HarmoniHierarchyIterator($hierarchies);
		return $hierarchyIterator;
	}

	/**
	 * Delete a Hierarchy by unique Id. All Nodes must be removed from the
	 * Hierarchy before this method is called.
	 *
	 * @param osid.shared.Id hierarchyId
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message HierarchyException.HIERARCHY_UNKNOWN
	 *		   if there is no Hierarchy matching hierarchyId and throws an
	 *		   exception with the message
	 *		   HierarchyException.HIERARCHY_NOT_EMPTY if the Hierarchy
	 *		   contains nodes.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function deleteHierarchy(& $hierarchyId) {
		ArgumentValidator::validate($hierarchyId, new ExtendsValidatorRule("Id"));
		
		if (!$hierarchy =& $this->getHierarchy($hierarchyId))
			throwError(new Error(HIERARCHY_UNKNOWN, "Hierarchy", 1));
			
		$nodeIterator =& $hierarchy->getAllNodes();
		if ($nodeIterator->hasNext()) 
			throwError(new Error(HIERARCHY_NOT_EMPTY, "Hierarchy", 1));
		
		$this->_managerStore->deleteHierarchy($hierarchyId);
		$this->save();
	}

	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		$this->_managerStore->save();
	}
	 
	/**
	 * Loads this object from persistable storage.
	 * @access protected
	 */
	function load () {
		$this->_managerStore->load();
	}	

	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
	}

} // end HierarchyManager