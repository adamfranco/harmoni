<?

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchy.abstract.php');


/**
 * A Hierarchy is a structure comprised of nodes arranged in root, parent, and
 * child form.  The Hierarchy can be traversed in several ways to determine
 * the arrangement of nodes. A Hierarchy can allow multiple parents.  A
 * Hierarchy can allow recursion.  The implementation is responsible for
 * ensuring that the integrity of the Hierarchy is always maintained.
 * 
 * <p>
 * Licensed under the {@link osid.SidLicense MIT O.K.I SID Definition License}.
 * </p>
 * 
 * <p></p>
 *
 * @version $Revision: 1.1 $ / $Date: 2003/10/10 17:31:24 $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class MemoryOnlyHierarchy
	extends HarmoniHierarchy
{ // begin Hierarchy

	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		
	}
	 
	/**
	 * Loads this object from persistable storage.
	 * @access protected
	 */
	function load () {
		
	}	

} // end Hierarchy