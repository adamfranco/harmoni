<?

require_once(OKI."/hierarchy.interface.php");

/**
 * A TraversalInfo contains a Node unique Id, a Node displayName, and a Node
 * Level.  The level of the Node represented by the node unique Id is in
 * relation to the startId of the Hierarchy traverse method call. Children
 * Nodes are represented by positive levels, parent Nodes by negative levels.
 * For example, a traverse of a Hierarchy has level -1 for parents of the Node
 * represented by startId, and a level -2 for grandparents.  Similarly, the
 * children of the Node would have level 1, and grandchildren would have level
 * 2.
 *
 * @package harmoni.osid_v1.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniTraversalInfo.class.php,v 1.9 2005/03/29 19:44:18 adamfranco Exp $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniTraversalInfo
	extends TraversalInfo
{ // begin TraversalInfo

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
	 * @param object ID   $id   The Id of this Node.
	 * @param string $displayName The displayName of the Node.
	 * @param integer $depth The depth of the Node.
	 * @access public
	 */
	function HarmoniTraversalInfo(& $id, $displayName, $depth) {
		// Check the arguments
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"));
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule());
		ArgumentValidator::validate($depth, IntegerValidatorRule::getRule());
		
		// set the private variables
		$this->_id =& $id;
		$this->_displayName = $displayName;
		$this->_depth = $depth;
	}

	/**
	 * Get the unique Id for this Node.
	 *
	 * @return object osid.shared.Id A unique Id that is usually set by a create
	 *		   method's implementation
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getNodeId() {
		return $this->_id;
	}

	/**
	 * Get the display name for this Node.
	 *
	 * @return String the display name
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function getDisplayName() {
		return $this->_displayName;
	}

	/**
	 * Get the level of this Node in relation to the startId of the Hierarchy
	 * traversal method call.  Descendents are assigned increasingly positive
	 * levels; ancestors increasingly negative levels.
	 *
	 * @return int level
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function getLevel() {
		return $this->_depth;
	}

} // end TraversalInfo