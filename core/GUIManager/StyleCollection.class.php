<?php

require_once(HARMONI."GUIManager/StyleCollection.interface.php");

/**
 * A StyleCollection is one of the tree building pieces of CSS styles. As the  name
 * suggests it handles a collection of StyleProperties.
 * 
 * The other two CSS styles building pieces are <code>StylePropertiy</code> and
 * <code>StyleComponent</code>. To clarify the relationship between these three
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
 * @version $Id: StyleCollection.class.php,v 1.11 2006/06/02 15:56:06 cws-midd Exp $
 */
class StyleCollection extends StyleCollectionInterface {

	var $_id;

	/**
	 * The display name of this StyleCollection.
	 * @var string _displayName 
	 * @access private
	 */
	var $_displayName;
	
	/**
	 * The description of this StyleCollection.
	 * @var string _description 
	 * @access private
	 */
	var $_description;
	
	/**
	 * The selector of this StyleCollection.
	 * @var string _selector 
	 * @access private
	 */
	var $_selector;
	
	/**
	 * The class selector of this style collection. A class selector is the string
	 * that would be included in the 'class' attribute of HTML tags. 
	 * @var string _classSelector 
	 * @access private
	 */
	var $_classSelector;
	
	/**
	 * An array of the StyleProperties contained by this StyleCollection.
	 * @var array _SPs 
	 * @access private
	 */
	var $_SPs;
	
	/**
	 * HTML to place around the the component's content.
	 *
	 * @var string $_preHTML;  
	 * @access private
	 * @since 11/22/05
	 */
	var $_preHTML = "";
	
	/**
	 * HTML to place around the the component's content.
	 *
	 * @var string $_preHTML;  
	 * @access private
	 * @since 11/22/05
	 */
	var $_postHTML = "";

	/**
	 * The constructor.
	 * @access public
	 * @param string selector The selector of this StyleCollection.
	 * @param string classSelector The class selector of this style collection. If <code>null</code>,
	 * it will be ignored, but the collection will not be able to be applied 
	 * to components.
	 * @param string displayName The display name of this StyleCollection.
	 * @param string description The description of this StyleCollection.
	 **/
	function StyleCollection($selector, $classSelector, $displayName, $description) {
		$this->_selector = $selector;
		$this->_classSelector = $classSelector;
		$this->_SPs = array();
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
		if (isset($this->_id))
			return $this->_id;
	}

	/**
	 * Sets the index
	 * 
	 * @param string $component
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function setComponent ($component) {
		$this->_component = $component;
	}
	
	/**
	 * Answers the component this style collection acts on ie BLANK, BLOCK, etc.
	 * 
	 * @return string
	 * @access public
	 * @since 4/26/06
	 */
	function getComponent () {
		if (isset($this->_component))
			return $this->_component;
	}

	/**
	 * Sets the Index
	 * 
	 * @param string $index
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function setIndex ($index) {
		$this->_index = $index;
	}
	
	/**
	 * Answers the component this style collection acts on ie BLANK, BLOCK, etc.
	 * 
	 * @return string
	 * @access public
	 * @since 4/26/06
	 */
	function getIndex () {
		if (isset($this->_index))
			return $this->_index;
	}

	/**
	 * Returns the CSS code for this StyleCollection.
	 * @access public
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @return string The CSS code for this StyleCollection.
	 **/
	function getCSS($tabs = "") {
		// nothing to return
		if (count($this->_SPs) == 0) 
			return "";

		$css = $tabs.$this->_selector." {\n\t".$tabs;

		$values = array();
		foreach (array_keys($this->_SPs) as $key)
			$values[] = $this->_SPs[$key]->getCSS();

		$css .= implode("\n\t".$tabs, $values);

		$css .= "\n".$tabs."}\n";

		return $css;
	}
	
	/**
	 * Returns the class selector of this style collection. A class selector is the string
	 * that would be included in the 'class' attribute of HTML tags. One can use
	 * this method in order to apply the style collection to an arbitrary component.
	 * @access public
	 * @return string The class name of this style collection.
	 **/
	function getClassSelector() {
		return $this->_classSelector;
	}

	/**
	 * Determines whether this <code>StyleCollection</code> can be applied to <code>Components</code>.
	 * @access public
	 * @return boolean <code>TRUE</code> if this <code>StyleCollection</code> can be applied to <code>Components</code>.
	 **/
	function canBeApplied() {
		return isset($this->_classSelector);
	}

	/**
	 * Returns the selector of this StyleCollection.
	 * @access public
	 * @return string The selector of this StyleCollection.
	 **/
	function getSelector() {
		return $this->_selector;
	}

	/**
	 * Returns the display name of this StyleCollection.
	 * @access public
	 * @return string The display name of this StyleCollection.
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
	 * Adds one StyleProperty to this StyleCollection.
	 * @access public
	 * @param ref object sc A StyleProperty object.
	 * @return ref object The style property that was just added.
	 **/
	function &addSP(& $sp) {
		ArgumentValidator::validate($sp, ExtendsValidatorRule::getRule("StylePropertyInterface"), true);
		$this->_SPs[$sp->getName()] =& $sp;
		
		return $sp;
	}

	/**
	 * Returns the StyleProperties of this StyleCollection in a suitable
	 * for CSS generation order.
	 * @access public
	 * @return ref array An array of the StyleProperties of this StyleCollection.
	 **/
	function &getSPs() {
		return $this->_SPs;
	}
	
	/**
	 * Remove the given StyleProperty from this Style Collection.
	 * @access public
	 * @param ref object The style property to remove.
	 * @return ref object The style property that was removed. <code>NULL</code>
	 * if it could not be found.
	 **/
	function &removeSP(& $sp) {
		ArgumentValidator::validate($sp, ExtendsValidatorRule::getRule("StylePropertyInterface"), true);

		$result =& $this->_SPs[$sp->getName()];
		unset($this->_SPs[$sp->getName()]);
		
		return $result;
	}
	
	/**
	 * Answers the wizard representation for the style collection
	 * if the style is removable then it should support removing SPs
	 * 
	 * @param boolean $removable whether or not the collection (and SPs) are removable
	 * @return ref object WizardStep
	 * @access public
	 * @since 5/4/06
	 */
	function &getWizardRepresentation ($removable = false) {
		$wizStyle =& new WizardStep();
		$guiManager =& Services::getService('GUI');
		
		// table in buffer for WHOLE Style Collection
		ob_start();
		print "<table border=3>";

		print "<td>".$this->getDisplayName()."</td>";
		print "<td><table border=2>";

		// build individula SP markup chunks that can be unset
		$SPs =& $this->getSPs();
		foreach ($SPs as $SP) {
			$spid =& $SP->getId();
			$wizStyle->addComponent($spid->getIdString(),
									$SP->getWizardRepresentation());
			
			// buffer for SP markup
			ob_start();
			print "<tr><td>".$SP->getDisplayName()."</td>";
			print "<td>[[".$spid->getIdString()."]]</td>";

			// create remove button for each SP
			if ($removable) {
				$wizStyle->addComponent('remove-'.$spid->getIdString(),
										WEventButton::withLabel('-'));
				print "<td>[[remove-".$spid->getIdString()."]]</td>";
			}
			print "</tr>";
			$wizStyle->setMarkupForComponent(ob_get_clean(), 
											 $spid->getIdString());
		}
		
		print "</table></td>";
		
		// insert all the markup chunks that exist
		foreach ($wizStyle->getMarkups() as $key => $markup) {
			print $markup;
		}
		
		// create list and button for adding SPs
		if ($removable) {
			$SL =& $wizStyle->addComponent('add-SP', new WSelectList());		
			$wizStyle->addComponent('plus', WEventButton::withLabel('+'));
			$SupSPs = $guiManager->getSupportedSPs();
			$available = array_diff($SupSPs, array_keys($SPs));
			
			foreach ($available as $option) {
				$SL->addOption($option, $option);
			}
			
			ob_start();
			print "<tr><td>"._("Add another Property:")."</td>";
			print "<td>[[add-SP]]</td><td>[[plus]]</td></tr>";
			$wizStyle->setMarkupForComponent(ob_get_clean(), 'add-property');
			
			// why? i don't know!
			print $wizStyle->getMarkupForComponent('add-property');
		}
		
		print "</table>";
		$wizStyle->setContent(ob_get_clean());
		
		return $wizStyle;
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
		$html = "";
		foreach (array_keys($this->_SPs) as $key)
			$html .= $this->_SPs[$key]->getPreHTML($tabs);

		return $html;
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
		$html = "";
		foreach (array_reverse(array_keys($this->_SPs), true) as $key)
			$html .= $this->_SPs[$key]->getPostHTML($tabs);

		return $html;
	}
	
}

?>