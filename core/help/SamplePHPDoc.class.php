<?php


/**
 * A constant that defines PI. 
 * Constants have no scope, i.e. cannot be public/private/protected.
 * Must define the package or else a default package will be used.
 * @const integer PI
 * @package harmoni.help
 */
define(PI, 3.14);

/**
 * A simple global variable. 
 * Global variables have no scope, i.e. cannot be public/private/protected.
 * Must define the package or else a default package will be used.
 * @variable string globalVar
 * @package harmoni.help
 */

$globalVar = "Hello!";

/**
 * A simple global function.
 * Global functions have no scope, i.e. cannot be public/private/protected.
 * Must define the package or else a default package will be used.
 * @package harmoni.help
 * @return void Returns nothing.
 */
function globalFunc() {
}



// Sample file showing proper PHPDoc usage

/**
 * This sentence is the brief description AND the first sentence of the detailed
 * description. This is the second sentence of the detailed description. Third
 * sentence of detailed description.
 * 
 * This sentence is still part of the detailed description.
 * 
 * Description can include HTML tags:
 * <br>
 * <i>Italics</i>
 * <br>
 * <a href = "http:\\www.dobomode.com">Link</a>
 * <br>
 * <b>Bold</b>
 * <br>
 * <pre>
 * P
 *  R
 *   E
 *    F
 *     O
 *      R
 *       M
 *        A
 *         T
 *          T
 *           E
 *            D</pre>
 * <br>
 * Sample code:
 * <pre>
 * <code>
 * $this->dobo = "smart";
 * $this->dobo.becomeGod();
 * $this->dobo.rule();
 * echo "Dobo ".(($this->dobo->doesRule()) ? "rulez!" : "doesn't rule... :(");
 * </code>
 * </pre>
 * End of detailed description.
 *
 * @version $Id: SamplePHPDoc.class.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
 * @author Middlebury College, ETS Department
 * @copyright 2003 Middlebury College, ETS Department
 * @package harmoni.help
 * @bug The bug, the bug,..., must fix that nasty bug!
 * @bug Bug ABC was fixed on July 4, 1999
 * @date Created: June 27, 2003
 * @todo Finalize stuff.
 * @todo Eat lunch.
 */
class SamplePHPDoc {

	/**
	 * This is the id of a human. Humans rock!
	 * @attribute private integer _id
	 * @see {@link SamplePHPDoc::_name}
	 */
	var $_id;

	/**
	 * This is the name of a human. It is static. It is a string.
	 * @attribute public string _name
	 * @see {@link SamplePHPDoc::_id}
	 */
	var $_name = "Ivan";

	
	/**
	 * This is the constructor. The constructor is fancy.
	 * @access public
	 * @log 20/07/2003 &nbsp; Added thing 1
	 * @log 22/07/2003 &nbsp; Added thing 2
	 * @log 24/07/2003 &nbsp; Added thing 3
	 * @log 26/07/2003 &nbsp; Added thing 4
	 */
	function SamplePHPDoc() {
	}


	/**
	 * Get accessor for <code>$_id</code> property.
	 *
	 * @method public getId
	 * @see {@link SamplePHPDoc::_id}
	 */
	function getId() {
		return $this->_id;
	}
	
	
	/**
	 * Set accessor for <code>$_id</code> property.
	 *
	 * @method public setId
	 * @see {@link SamplePHPDoc::_id}
	 */
	function setId($id) {
		$this->_id = $id;
	}

	/**
	 * Get the name. Simply returns <code>$_name</code>.
	 * @method static public getName
	 * @use globalVar
	 * @return string The name of the human. A nice human name.
	 */
	function getName() {
		global $globalVar;
	}
	
	/**
	 * A complex method accepting several arguments. Just an example of some
	 * method tags.
	 * <pre>
	 * Be careful!
	 * When doing "@param", with Arachne's PHPDocGen you cannot specify
	 * the class of the object.</pre>
	 * @method private _doComplexStuff
	 * @param object arg1 An object.
	 * @param ref string arg2 A funny string.
	 * @param optional boolean arg3 A wonderful boolean.
	 * @return ref integer An integer result.
	 * @deprecated This function is <b>deprecated</b>. Sorry!
	 */
	function _doComplexStuff($arg1, & $arg2, $arg3 = false) {
	}
	
	
	
}


?>