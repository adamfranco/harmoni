<?
/**
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: registerPrimitives.inc.php,v 1.4 2005/04/07 16:33:27 adamfranco Exp $
 */
 
$this->addDataType("integer","Integer","StorableInteger");
$this->addDataType("string","String","StorableString");
$this->addDataType("blob","Blob","StorableBlob");
$this->addDataType("shortstring","String","StorableShortString");
$this->addDataType("float","Float","StorableFloat");
$this->addDataType("boolean","Boolean","StorableBoolean");
$this->addDataType("time","Time","StorableTime");
$this->addDataType("okitype","OKIType","StorableOKIType");