<?

require_once(OKI."/hierarchy/hierarchyAPI.interface.php");

require_once(HARMONI."oki/hierarchy/HarmoniHierarchy.class.php");
require_once(HARMONI."oki/hierarchy/HarmoniHierarchyIterator.class.php");
require_once(HARMONI."oki/hierarchy/HarmoniNodeIterator.class.php");
require_once(HARMONI."oki/hierarchy/HarmoniTraversalInfoIterator.class.php");

class HarmoniHierarchyManager
	extends HierarchyManager
{ // begin HierarchyManager


	/**
	 * @var array $_hierarchies An array of Hierarchies.
	 */
	var $_hierachies = array ();
	
	/**
	 * @var array $_hierarchyTypes An array of the supported Types
	 */
	var $_hierarchyTypes = array();
	
	
	/**
	 * Constructor
	 * @param array $hierarchies An array of the hierarchies to add to the
	 * manager.
	 * @access public
	 */
	function HarmoniHierarchyManager ($hierarchies = NULL) {
	 	$this->_hierarchyTypes[] =& new HarmoniHierarchyType();
	 
	 	if ($hierarchies != NULL) {
		 	if (count($hierarchies)) {
				ArgumentValidator::validate($hierarchies, ArrayValidatorRuleWithRule(new ExtendsValidatorRule("Hierarchy")));
				
				foreach ($hierarchies as $key => $val) {
					$this->_addHierarchy($hierarchies[$key]);
				}
			}
	 	}
	 }

	/**
	 * Add a hierarchy by id
	 * @param object Id $id The id of this dr.
	 * @access private
	 */
	function & _addHierarchy(& $hierarchy) {
		// Check the arguments
		ArgumentValidator::validate($hierarchy, new ExtendsValidatorRule("Hierarchy"));
		
		// Make sure the hierarchy is loaded
		$hierarchy->load();
				
		// Add it to our array
		$this->hierarchies[$hierarchy->getId()] =& $hierarchy;
		
		// Save this Manager to persistable storage
		$this->save();
	}

	// public Hierarchy & createHierarchy(boolean $allowsMultipleParents, String $description, String $name, osid.shared.Type[] & $nodeTypes, boolean $allowsRecursion);
	function & createHierarchy($allowsMultipleParents, $description, $name, & $nodeTypes, $allowsRecursion) {
		// Check the arguments
		ArgumentValidator::validate($allowsMultipleParents, new BooleanValidatorRule);
		ArgumentValidator::validate($description, new StringValidatorRule);
		ArgumentValidator::validate($name, new StringValidatorRule);
		ArgumentValidator::validate($nodeTypes, ArrayValidatorRuleWithRule(new ExtendsValidatorRule("Type")));
		ArgumentValidator::validate($allowsRecursion, new BooleanValidatorRule);
		
		// if allowsMultipleParents is false and allowsRecursion is true
		if ($allowsMultipleParents && !$allowsRecursion)
			throwError(new Error(ILLEGAL_HIERARCHY, "HierarchyManager", 1));
		
		// if allowsMultipleParents is false and allowsRecursion is true
		if ($allowsMultipleParents || $allowsRecursion)
			throwError(new Error(UNSUPPORTED_HIERARCHY, "HierarchyManager", 1));

		// Create a new hierarchy and add it to the manager array;
		$hierarchy =& new HarmoniHierarchy($description, $name, $nodeTypes);
		$hierarchy->save();
		$this->_hierarchies[] =& $hierarchy;
		
		// Save this Manager to persistable storage
		$this->save();
		
		return $hierarchy;
	}

	// public Hierarchy & getHierarchy(osid.shared.Id & $hierarchyId);
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

	// public HierarchyIterator & getHierarchies();
	function & getHierarchies() {
		foreach ($this->_hierarchies as $key => $val) {
			$this->_hierarchies[$key]->load();
		}
		$hierarchyIterator =& new HarmoniHierarchyIterator($this->_hierarchies);
		return $hierarchyIterator;
	}

	// public void deleteHierarchy(osid.shared.Id & $hierarchyId);
	function deleteHierarchy(& $hierarchyId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end HierarchyManager