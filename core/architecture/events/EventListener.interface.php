<?php
/**
 * @since Jul 18, 2005
 * @package harmoni.architecture.events
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: EventListener.interface.php,v 1.1 2005/07/18 21:41:08 gabeschine Exp $
 */ 

/**
 * An event listener can be attached to an {@link EventTrigger} to handle events as they occur.
 * 
 * @since Jul 18, 2005
 * @package harmoni.architecture.events
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: EventListener.interface.php,v 1.1 2005/07/18 21:41:08 gabeschine Exp $
 */
class EventListener {
	/**
	 * Handles an event triggered by an {@link EventTrigger}. The event type is passed in case this
	 * particular EventListener is handling more than one type of event.
	 * @param string $eventType
	 * @param ref object $source The source object of the event.
	 * @param array $context An array of contextual parameters - the content will be dependent on the thrown event.
	 * @access public
	 * @return void
	 */
	function handleEvent ($eventType, &$source, $context) {
		
	}
}


?>