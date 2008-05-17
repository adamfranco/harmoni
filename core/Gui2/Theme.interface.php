<?php
/**
 * @since 5/6/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

/**
 * All GUI 2 themes must implement this interface
 * 
 * @since 5/6/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
interface Harmoni_Gui2_ThemeInterface {
	
	
	/*********************************************************
	 * Output
	 *********************************************************/
	
	/**
	 * Answer a block of CSS for the theme
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getCSS ();
	
	/**
	 * Print out the component tree
	 * 
	 * @param object ComponentInterface $rootComponent
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function printPage (ComponentInterface $rootComponent);
	
	/**
	 * Returns the HTML string that needs to be printed before successful rendering
	 * of components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * If the given index is greater than the maximal registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return string The HTML string.
	 * @access public
	 * @since 5/6/08
	 */
	public function getPreHTMLForComponentType ($type, $index);
	
	/**
	 * Returns the HTML string that needs to be printed after successful rendering
	 * of components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * If the given index is greater than the maximal registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return string The HTML string.
	 * @access public
	 * @since 5/6/08
	 */
	public function getPostHTMLForComponentType ($type, $index);
	
	/**
	 * This method is just here for compatability with the original
	 * GUIManager Components, should just return an empty array
	 * 
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * @return array
	 * @access public
	 * @since 5/6/08
	 */
	public function getStylesForComponentType ($type, $index);
	
	
	/*********************************************************
	 * Information
	 *********************************************************/
	
	/**
	 * Answer the Id of this theme.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getIdString ();
	
	/**
	 * Answer the display name of this theme
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getDisplayName ();
	
	/**
	 * Answer a description of this theme
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getDescription ();
	
	/**
	 * Answer a thumbnail file.
	 * 
	 * @return object Harmoni_Filing_FileInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getThumbnail ();
	
	/**
	 * Answer the date when this theme was last modified.
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/13/08
	 */
	public function getModificationDate ();
	
	/**
	 * Answer an array of ThemeHistory items, in reverse chronological order.
	 * 
	 * @return array
	 * @access public
	 * @since 5/8/08
	 */
	public function getHistory ();
	
	/*********************************************************
	 * Accessing Theme Data
	 *********************************************************/
	/**
	 * Answer the global CSS string.
	 * 
	 * @return string
	 * @access public
	 * @since 5/15/08
	 */
	public function getGlobalCss ();
	
	/**
	 * Answer the component types supported.
	 * 
	 * @return array of strings
	 * @access public
	 * @since 5/15/08
	 */
	public function getComponentTypes ();
	
	/**
	 * Get the CSS for a component Type.
	 * 
	 * @param string $componentType
	 * @return string
	 * @access public
	 * @since 5/15/08
	 */
	public function getCssForType ($componentType);
	
	/**
	 * Get the HTML template for a component Type.
	 * 
	 * @param string $componentType
	 * @return string
	 * @access public
	 * @since 5/15/08
	 */
	public function getTemplateForType ($componentType);
	
	/**
	 * Answer the images for this theme
	 * 
	 * @return array of Harmoni_Filing_FileInterface objects
	 * @access public
	 * @since 5/15/08
	 */
	public function getImages ();
	
	/*********************************************************
	 * Theme options
	 *********************************************************/
	
	/**
	 * Answer true if this theme supports options.
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/6/08
	 */
	public function supportsOptions ();
	
	/**
	 * Answer an object that implements the ThemeOptionsInterface
	 * for this theme. This could be the same or a different object.
	 * 
	 * @return object Harmoni_Gui2_ThemeOptionsInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getOptionsSession ();
	
	/*********************************************************
	 * Theme Modification
	 *********************************************************/
	
	/**
	 * Answer true if this theme supports modification.
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/15/08
	 */
	public function supportsModification ();
	
	/**
	 * Answer an object that implements the ThemeModificationInterface
	 * for this theme. This could be the same or a different object.
	 * 
	 * @return object Harmoni_Gui2_ThemeModificationInterface
	 * @access public
	 * @since 5/15/08
	 */
	public function getModificationSession ();
}

?>