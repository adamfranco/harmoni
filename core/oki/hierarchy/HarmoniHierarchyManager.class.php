<?

require_once(OKI."/hierarchy/hierarchyApi.interface.php");

require_once(HARMONI."oki/hierarchy/HarmoniHierarchy.class.php");
require_once(HARMONI."oki/hierarchy/HarmoniHierarchyIterator.class.php");
require_once(HARMONI."oki/hierarchy/HarmoniNodeIterator.class.php");
require_once(HARMONI."oki/hierarchy/HarmoniTraversalInfoIterator.class.php");

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
 * @version $Revision: 1.7 $ / $Date: 2003/10/10 17:31:24 $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniHierarchyManager
	extends HierarchyManager
{ // begin HierarchyManager


	/**
	 * @var array $_hierarchies An array of Hierarchies.
	 */
	var $_hierachies = array ();
	
	/**
	 * Constructor
	 * @param array $hierarchies An array of the hierarchies to add to the
	 * manager.
	 * @access public
	 */
	function HarmoniHierarchyManager ($hierarchies = NULL) {
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
		foreach ($this->_hierarchies as $key => $val) {
			$this->_hierarchies[$key]->load();
		}
		$hierarchyIterator =& new HarmoniHierarchyIterator($this->_hierarchies);
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end HierarchyManager