<?php
/**
 * @since 5/15/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

/**
 * This interface defines the methods that a theme modification session must implement.
 * 
 * @since 5/15/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
interface Harmoni_Gui2_ThemeModificationInterface {
	
	/*********************************************************
	 * Info
	 *********************************************************/
	
	/**
	 * Set the display name.
	 * 
	 * @param string $displayName
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function updateDisplayName ($displayName);
	
	/**
	 * Update the description
	 * 
	 * @param string $description
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function updateDescription ($description);
	
	/**
	 * Update the thumbnail
	 * 
	 * @param object Harmoni_Filing_FileInterface $thumbnail
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function updateThumbnail (Harmoni_Filing_FileInterface $thumbnail);
	
	/*********************************************************
	 * Options
	 *********************************************************/
	
	/**
	 * Answer an XML document for the options for this theme
	 * 
	 * @return object Harmoni_DOMDocument
	 * @access public
	 * @since 5/15/08
	 */
	public function getOptionsDocument ();
	
	/**
	 * Update the options XML with a new document
	 * 
	 * @param object Harmoni_DOMDocument $optionsDocument
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function updateOptionsDocument (Harmoni_DOMDocument $optionsDocument);
	
	/*********************************************************
	 * CSS and HTML Templates
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
	 * Set the global CSS string
	 * 
	 * @param string $css
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function updateGlobalCss ($css);
	
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
	 * Set the CSS for a component Type
	 * 
	 * @param string $componentType
	 * @param string $css
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function updateCssForType ($componentType, $css);
	
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
	 * Set the CSS for a component Type
	 * 
	 * @param string $componentType
	 * @param string $templateHtml
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function updateTemplateForType ($componentType, $templateHtml);
	
	/*********************************************************
	 * Images
	 *********************************************************/
	
	/**
	 * Answer the images for this theme
	 * 
	 * @return array of Harmoni_Filing_FileInterface objects
	 * @access public
	 * @since 5/15/08
	 */
	public function getImages ();
	
	/**
	 * Add a new image at the path specified.
	 * 
	 * @param object Harmoni_Filing_FileInterface $image
	 * @param string $destinationPath
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function addImage (Harmoni_Filing_FileInterface $image, $destinationPath);
	
	/**
	 * Delete an image at the path specified.
	 * 
	 * @param string $path
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function deleteImage ($path);
}

?>