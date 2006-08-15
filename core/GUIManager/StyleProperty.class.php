<?php

require_once(HARMONI."GUIManager/StyleProperty.interface.php");

/**
 * This StyleProperty generic class allows one to create a StyleProperty of arbitrary nature
 * from scratch. It has no default StyleComponents attached.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. To clarify the relationship between these three
 * building pieces, consider the following example:
 * <pre>
 * div {
 *     margin: 20px;
 *     border: 1px solid #000;
 * }
 * </pre>
 * <code>div</code> is a <code>StyleCollection</code> consisting of 2 
 * <code>StyleProperties</code>: <code>margin</code> and <code>border</code>. Each
 * of the latter consists of one or more <code>StyleComponents</code>. In
 * specific, <code>margin</code> consists of one <code>StyleComponent</code>
 * with the value <code>20px</code>, and <code>border</code> has three 
 * <code>StyleComponents</code> with values <code>1px</code>, <code>solid</code>,
 * and <code>#000</code> correspondingly.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StyleProperty.class.php,v 1.11 2006/08/15 20:44:57 sporktim Exp $
 */
class StyleProperty extends StylePropertyInterface {

	/**
	 * The display name of this StyleProperty.
	 * @var string _displayName 
	 * @access private
	 */
	var $_displayName;
	
	/**
	 * The description of this StyleProperty.
	 * @var string _description 
	 * @access private
	 */
	var $_description;
	
	/**
	 * The name of this StyleProperty.
	 * @var string _name 
	 * @access private
	 */
	var $_name;
	
	/**
	 * An array of the StyleComponents contained by this StyleProperty.
	 * @var array _SCs 
	 * @access private
	 */
	var $_SCs;
	
	/**
	 * The constructor.
	 * @access public
	 * @param string name The name of this StyleProperty.
	 * @param ref mixed SCs Either one or an array of a few StyleComponents to be contained
	 * by this StyleProperty.
	 * @param string displayName The display name of this StyleProperty.
	 * @param string description The description of this StyleProperty.
	 **/
	function StyleProperty($name, $displayName, $description) {
		$this->_name = $name;
		$this->_SCs = array();

		$this->_displayName = $displayName;
		$this->_description = $description;
	}
	
	/**
	 * Sets the id
	 * 
	 * @param object HarmoniId $id
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function setId (&$id) {
		if (!is_object($id))
			throwError(new Error("GUIMANAGER", "STRING ID PASSED"));
		$this->_id =& $id;
	}
	
	/**
	 * Answers the id
	 * 
	 * @return object HarmoniId
	 * @access public
	 * @since 4/26/06
	 */
	function &getId () {
		if (isset($this->_id)){
			return $this->_id;
		}else{
			$im =& Services::getService("Id");		
			$this->_id = 	$im->createId();
			return $this->_id;
		}
	}

	/**
	 * Returns the CSS code for this StyleProperty.
	 * @access public
	 * @return string The CSS code for this StyleProperty.
	 **/
	function getCSS() {
		if (count($this->_SCs) == 0) 
			return "";
	
		$css = $this->_name.": ";

		$values = array();
		foreach (array_keys($this->_SCs) as $key)
			$values[] = $this->_SCs[$key]->getValue();

		$css .= implode(" ", $values);

		$css .= ";";
		return $css;
	}
	
	/**
	 * Returns the name of this StyleProperty.
	 * @access public
	 * @return string The name of this StyleProperty.
	 **/
	function getName() {
		return $this->_name;
	}

	/**
	 * Returns the display name of this StyleProperty.
	 * @access public
	 * @return string The display name of this StyleProperty.
	 **/
	function getDisplayName() {
		return $this->_displayName;
	}
	
	/**
	 * Returns the description of this StlyeProperty.
	 * @access public
	 * @return string The description of this StlyeProperty.
	 **/
	function getDescription() {
		return $this->_description;
	}

	/**
	 * Adds one StyleComponent to this StyleProperty.
	 * @access public
	 * @param ref object A StyleComponent object.
	 **/
	function addSC(& $sc) {
		ArgumentValidator::validate($sc, ExtendsValidatorRule::getRule("StyleComponentInterface"), true);
//		$this->_SCs[] =& $sc;
//		print "_SCs[".get_class($sc)."] =& ".$sc->getDisplayName().";<br/>";
		$this->_SCs[get_class($sc)] =& $sc;
	}

	/**
	 * Returns the StyleComponents of this StyleProperty in a suitable
	 * for CSS generation order.
	 * @access public$this->_SCs
	 * @return array An array of the StyleComponents of this StyleProperty.
	 **/
	function &getSCs() {
		return $this->_SCs;
	}
	
	/**
	 * Returns the StyleComponent with the given class
	 * 
	 * @param string $class the class of the StyleComponent
	 * @access public
	 * @return ref object StyleComponent
	 **/
	function &getStyleComponent($class) {
		$class = strtolower($class);
		if(isset($this->_SCs[$class])){
			return $this->_SCs[$class];
		}else{
			$null=null;
			return $null;
		}
	}
	
	/**
	 * Answers the list of possible SCs for the SP as an array of class names.
	 * 
	 * @return array
	 * @access public
	 * @static
	 * @since 5/2/06
	 */
	function getSCList () {
		if (isset($this->_SCList))
			return $this->_SCList;
		return array();
	}
	
	/**
	 * Answers a WizardStep, this step is a simple container of the inputs
	 * necessary for populating this SP from a wizard.  The step will be 
	 * populated with all data from the DB, and empty SC's for unpopulated SCs
	 * allowed for in the SP.
	 * 
	 * @return ref object WizardStep
	 * @access public
	 * @since 5/2/06
	 */
	function &getWizardRepresentation ($callBack,$collection) {
		$wizSP =& new WizardStep();
		// the list of existing SCs
		$scs =& $this->getSCs();
		// the list of SC types for this SP
		$scList = $this->getSCList();
		ob_start();
		print "<table border=1>";
		// for each existing SC built request an input for it
		$i = 0;
		
		

		
		foreach (array_keys($scs) as $key) {
			$class = get_class($scs[$key]);
			
			//printpre($scs);
			
			//print "   $key>-->'".$class."' ";
			
			$scComp =& new WStyleComponent($callBack, $class ,$this->getName(),$collection,true);
			$wizSP->addComponent("comp".$i, $scComp);
			// table row [displayName][input][description]
			print "<tr><td>".$scs[$key]->getDisplayName().":</td>";
			print "<td>[["."comp".$i."]]</td>";
			print "<td>".$scs[$key]->getDescription()."</td></tr>";
			$i++;	
		}
		
		
		
		$empties = array_diff($scList, array_keys($scs));
		// for each SC not populated create their options too
		foreach ($empties as $empty) {
			$emptySC =& new $empty();
			$emptyComp =& new WStyleComponent($emptySC,true);
			$wizSP->addComponent("comp".$i, $emptyComp);
			// table row [displayName][input][description]
			print "<tr><td>".$emptySC->getDisplayName().":</td>";
			print "<td>[["."comp".$i."]]</td>";
			print "<td>".$emptySC->getDescription()."</td></tr>";
			$i++;
		}
		print "</table>";
		$wizSP->setContent(ob_get_clean());
		return $wizSP;
	}
	
	/**
	 * Return HTML to nested inside of the component's block. This includes
	 * things such as corner images.
	 *
	 * See the example below:
	 * 	<pre>
	 * 	<div class='block3'>
	 *
	 *		<!-- preHTML start -->
	 *		<div class="content">
     *  		<img class="borderTL" src="images/block3_TL.gif" width="14" height="14" />
     *  		<img class="borderTR" src="images/block3_TR.gif" width="14" height="14" />
     *		<!-- preHTML end -->
     *		
     *			<h1>Hello world! (this is when my component renders itself)</h1>
     *
     *		<!-- postHTML start -->
	 *			<div class="roundedCornerSpacer">&nbsp;</div>
	 *		</div>
	 *	    <div class="bottomCorners">
     *  		<img class="borderBL" src="images/block3_BL.gif" width="14" height="14" />
     *  		<img class="borderBR" src="images/block3_BR.gif" width="14" height="14" />
     *		</div>
     *		<!-- postHTML end -->
     *
     *	</div>
     *	</pre>
	 * 
	 * @param string $tabs
	 * @return string
	 * @access public
	 * @since 11/22/05
	 */
	function getPreHTML ($tabs) {
		return "";
	}
	
	/**
	 * Return HTML to nested inside of the component's block. This includes
	 * things such as corner images.
	 *
	 * See the example below:
	 * 	<pre>
	 * 	<div class='block3'>
	 *
	 *		<!-- preHTML start -->
	 *		<div class="content">
     *  		<img class="borderTL" src="images/block3_TL.gif" width="14" height="14" />
     *  		<img class="borderTR" src="images/block3_TR.gif" width="14" height="14" />
     *		<!-- preHTML end -->
     *		
     *			<h1>Hello world! (this is when my component renders itself)</h1>
     *
     *		<!-- postHTML start -->
	 *			<div class="roundedCornerSpacer">&nbsp;</div>
	 *		</div>
	 *	    <div class="bottomCorners">
     *  		<img class="borderBL" src="images/block3_BL.gif" width="14" height="14" />
     *  		<img class="borderBR" src="images/block3_BR.gif" width="14" height="14" />
     *		</div>
     *		<!-- postHTML end -->
     *
     *	</div>
     *	</pre>
	 * 
	 * @param string $tabs
	 * @return string
	 * @access public
	 * @since 11/22/05
	 */
	function getPostHTML ($tabs) {
		return "";
	}
}

?>