<?
/**
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: ThumbnailDimensionsPart.class.php,v 1.4 2006/05/04 20:36:19 adamfranco Exp $
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
 * @version $Id: ThumbnailDimensionsPart.class.php,v 1.4 2006/05/04 20:36:19 adamfranco Exp $
 */
class ThumbnailDimensionsPart 
	extends DimensionsPart
{

	/**
	 * Constructor
	 * 
	 * @param object PartStructure $partStructure
	 * @param object Id $recordId
	 * @param object Properties $configuration
	 * @param object Record $record
	 * @return object
	 * @access public
	 * @since 10/17/05
	 */
	function ThumbnailDimensionsPart ( &$partStructure, &$recordId, 
		&$configuration, &$record, &$asset ) 
	{
		$this->DimensionsPart($partStructure, $recordId, $configuration, $record, $asset);
		
		$this->_table = "dr_thumbnail";
		$this->_idColumn = "FK_file";
// 		$this->_widthColumn = 'thumb_width';
// 		$this->_heightColumn = 'thumb_height';
		$idManager =& Services::getService("Id");
		$this->_dataPartStructId =& $idManager->getId("THUMBNAIL_DATA");
		$this->_mimeTypePartStructId =& $idManager->getId("THUMBNAIL_MIME_TYPE");
	}
}
