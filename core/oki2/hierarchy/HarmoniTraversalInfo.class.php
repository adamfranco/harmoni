<?

require_once(OKI2."/osid/hierarchy/TraversalInfo.php");

/**
 * TraversalInfo contains a Node unique Id, a Node displayName, and a Node
 * Level.  The level of the Node represented by the node unique Id is in
 * relation to the startId of the Hierarchy traverse method call. Children
 * Nodes are represented by positive levels, parent Nodes by negative levels.
 * For example, a traverse of a Hierarchy has level -1 for parents of the Node
 * represented by startId, and a level -2 for grandparents.	 Similarly, the
 * children of the Node would have level 1, and grandchildren would have level
 * 2.
 * 
 * <p>
 * OSID Version: 2.0
 *
 * @package harmoni.osid_v2.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniTraversalInfo.class.php,v 1.6 2005/02/07 21:38:25 adamfranco Exp $
 */

class HarmoniTraversalInfo
	extends TraversalInfo
{
	/**
	 * @var object Id $_id The id for this Node.
	 */
	var $_id;
	
	/**
	 * @var string $_displayName The display name for this Node.
	 */
	var $_displayName;

	/**
	 * @var integer $_depth The depth for this Node.
	 */
	var $_depth;
	
	/**
	 * Constructor.
	 *
	 * @param object ID	  $id	The Id of this Node.
	 * @param string $displayName The displayName of the Node.
	 * @param integer $depth The depth of the Node.
	 * @access public
	 */
	function HarmoniTraversalInfo(& $id, $displayName, $depth) {
		// Check the arguments
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($displayName, new StringValidatorRule);
		ArgumentValidator::validate($depth, new IntegerValidatorRule);
		
		// set the private variables
		$this->_id =& $id;
		$this->_displayName = $displayName;
		$this->_depth = $depth;
	}

	/**
	 * Get the unique Id for this Node.
	 *	
	 * @return object Id
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getNodeId () { 
		return $this->_id;
	}

	/**
	 * Get the display name for this Node.
	 *	
	 * @return string
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getDisplayName () {
		return $this->_displayName;
	}

	/**
	 * Get the level of this Node in relation to the startId of the Hierarchy
	 * traversal method call.  Descendants are assigned increasingly positive
	 * levels; ancestors increasingly negative levels.
	 *	
	 * @return int
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getLevel () { 
		return $this->_depth;
	}

}

?>