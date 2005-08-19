<?
/**
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: ThumbnailDimensionsPart.class.php,v 1.1 2005/08/19 20:16:48 adamfranco Exp $
 */
 
require_once(dirname(__FILE__)."/../getid3.getimagesize.php");

/**
 * The DimensionsPart attempts to extract height, width, and mime type info from
 * a file, in an array similar to that returned from GetImageSize() method. 
 * If the file is not an image and/or such information can not be determined, 
 * this part has a boolean value of false. 
 *
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: ThumbnailDimensionsPart.class.php,v 1.1 2005/08/19 20:16:48 adamfranco Exp $
 */
class ThumbnailDimensionsPart 
	extends DimensionsPart
{

	/**
	 * Get the value for this Part.
	 *	
	 * @return object mixed (original type: java.io.Serializable)
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getValue() {
		// If we don't have the dimensions, fetch the mime type and data and try to
		// populate the dimensions if appropriate.
		if ($this->_dimensions === NULL) {
			// Get the MIME type
			$idManager =& Services::getService("Id");
			$mimeTypeParts =& $this->_record->getPartsByPartStructure(
				$idManager->getId("THUMBNAIL_MIME_TYPE"));
			$mimeTypePart =& $mimeTypeParts->next();
			$mimeType = $mimeTypePart->getValue();
			
			// Only try to get dimensions from image files
			if (ereg("^image.*$", $mimeType)) {
				
				$dataParts =& $this->_record->getPartsByPartStructure(
					$idManager->getId("THUMBNAIL_DATA"));
				$dataPart =& $dataParts->next();
				$this->_dimensions = GetDataImageSize($dataPart->getValue());
				
			} else {
				$this->_dimensions = FALSE;
			}
		}
		
		return $this->_dimensions;
	}
}
