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
	 * Set the global CSS string
	 * 
	 * @param string $css
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function updateGlobalCss ($css);
	
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
	 * Add a new image at the path specified.
	 * 
	 * @param object Harmoni_Filing_FileInterface $image
	 * @param string $filename
	 * @param optional string $prefixPath
	 * @return null
	 * @access public
	 * @since 5/15/08
	 */
	public function addImage (Harmoni_Filing_FileInterface $image, $filename, $prefixPath = '');
	
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