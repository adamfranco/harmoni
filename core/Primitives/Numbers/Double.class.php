<?

require_once(dirname(__FILE__)."/Float.class.php");

/**
 * A simple Double data type.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Double.class.php,v 1.1 2005/07/13 21:38:07 adamfranco Exp $
 */
class Double 
	extends Float 
{

	function Double($value=0) {
		parent::Float($value);
	}
	
	/**
	 * Returns the Double value of this object.
	 * @access public
	 * @return double
	 */
	function getDoubleValue()
	{
		return $this->getFloatValue();
	}
}