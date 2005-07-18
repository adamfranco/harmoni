<?php
/**
 * @since Jul 18, 2005
 * @package harmoni.architecture.events
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: EventTrigger.abstract.php,v 1.1 2005/07/18 21:41:08 gabeschine Exp $
 */ 

require_once(HARMONI."/Primitives/Objects/SObject.class.php");

/**
 * The event trigger is an abstract class which handles the aggregation of {@link EventListener}s and can trigger events.
 * 
 * @since Jul 18, 2005
 * @package harmoni.architecture.events
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: EventTrigger.abstract.php,v 1.1 2005/07/18 21:41:08 gabeschine Exp $
 * @abstract
 */
class EventTrigger extends SObject {
	/**
	 * @var array $_eventListeners
	 * @access private
	 */
	var $_eventListeners = array();
	
	/**
	 * Adds an {@link EventListener} to be triggered whenever an event is thrown.
	 * @param string $eventType The string event type for which this {@link EventListener} is listening (example: "edu.middlebury.harmoni.action_executed")
	 * @param ref object $eventListener the {@link EventListener} object.
	 * @access public
	 * @return ref object
	 */
	function addEventListener ($eventType, &$eventListener) {
		ArgumentValidator::validate($eventListener, HasMethodsValidatorRule::getRule("handleEvent"), true);
		if (!isset($this->_eventListeners[$eventType]) || !is_array($this->_eventListeners[$eventType])) {
			$this->_eventListeners[$eventType] = array();
		}
		
		$this->_eventListeners[$eventType][] =& $eventListener;
	}
	
	/**
	 * Notifies all of the {@link EventListener}s that have been added that an event has
	 * occured.
	 * @param string $eventType The event type string.
	 * @param ref object $source The source object of this event.
	 * @param optional array $context An array of contextual parameters for the specific event. The content of the array will depend on the event.
	 * @access public
	 * @return void
	 */
	function triggerEvent ($eventType, &$source, $context = null) {
//		print "event triggered: $eventType<br/>";
		if (isset($this->_eventListeners[$eventType]) && is_array($this->_eventListeners[$eventType])) {
			$list =& $this->_eventListeners[$eventType];
			foreach (array_keys($list) as $key) {
				$list[$key]->handleEvent($eventType, $source, $context);
			}
		}
	}
}

?>