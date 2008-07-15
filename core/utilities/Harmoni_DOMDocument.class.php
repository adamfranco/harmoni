<?php
/**
 * @since 1/23/08
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Harmoni_DOMDocument.class.php,v 1.2 2008/04/18 14:57:59 adamfranco Exp $
 */ 

/**
 * This is an extention of the PHP5 DOMDocument that adds a few shortcuts and fixes
 * a few issues
 * 
 * @since 1/23/08
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Harmoni_DOMDocument.class.php,v 1.2 2008/04/18 14:57:59 adamfranco Exp $
 */
class Harmoni_DOMDocument 
	extends DOMDocument
{
		
	/**
	 * This is a helper method to get an element from a document by id without
	 * going through the trouble of setting an id attribute in the document
	 * 
	 * @param string $id
	 * @param optional string $attribute The attribute to use as an Id.
	 * @return DOMElement
	 * @access public
	 * @since 1/22/08
	 */
	public function getElementByIdAttribute ($id, $attribute = 'id') {
		$xpath = new DOMXPath($this);
		$elements = $xpath->query("//*[@$attribute ='$id']");
		if ($elements->length > 1)
			throw new DOMException("".$elements->length." elements found with $attribute = '$id'. There must be no more than 1.");
		
		if ($elements->length == 1)
			return $elements->item(0);
		
		return null;
	}
	
/*********************************************************
 * Load-Error catching
 *********************************************************/
	
	/**
	 * Load an XML Document from a file. This implementation will throw an exception
	 * on error rather than raising a warning.
	 * 
	 * @param string $filename
	 * @param optional int $options
	 * @return mixed
	 * @access public
	 * @since 1/23/08
	 */
	public function load ($filename, $options = null) {
		$tmpErrorHandler = set_error_handler(array($this, 'handleLoadError'));
		try {
			$result = parent::load($filename, $options);
		} catch (Exception $e) {
			set_error_handler($tmpErrorHandler);
			throw $e;
		}
		set_error_handler($tmpErrorHandler);
		return $result;
	}
	
	/**
	 * Load an XML Document from a string. This implementation will throw an exception
	 * on error rather than raising a warning.
	 * 
	 * @param string $source
	 * @param optional int $options
	 * @return mixed
	 * @access public
	 * @since 1/23/08
	 */
	public function loadXML ($source, $options = null) {
		$tmpErrorHandler = set_error_handler(array($this, 'handleLoadError'));
		try {
			$result = parent::loadXML($source, $options);
		} catch (Exception $e) {
			set_error_handler($tmpErrorHandler);
			throw $e;
		}
		set_error_handler($tmpErrorHandler);
		return $result;
	}
	
	/**
	 * re-throw a DOM loading error as an exception.
	 * 
	 * @param int $errno
	 * @pararm string $errstr
	 * @param string $errfile
	 * @param int $errline
	  *@param array $errcontext
	 * @return void
	 * @access public
	 * @since 1/23/08
	 */
	public function handleLoadError ($errno, $errstr, $errfile, $errline, array $errcontext) {
		throw new DOMException($errstr, $errno);
	}
	
/*********************************************************
 * Whitespace adding methods
 *********************************************************/
	
	
	/**
	 * Dumps the internal XML tree back into a file with added whitespace 
	 * (new-lines and tabbing).
	 * 
	 * @param string $source
	 * @param optional int $options
	 * @return void
	 * @access public
	 * @since 1/23/08
	 */
	public function saveWithWhitespace ($filename, $options = null) {
		$doc = new Harmoni_DOMDocument;
		if ($this->documentElement)
			$doc->appendChild($doc->importNode($this->documentElement, true));
		$doc->addWhitespaceToDocument();
		
		$doc->save($filename, $options);
	}
	
	/**
	 * Dumps the internal XML tree back into a string with added whitespace 
	 * (new-lines and tabbing).
	 * 
	 * @param optional object DOMNode $node
	 * @param optional int $options
	 * @return string
	 * @access public
	 * @since 1/23/08
	 */
	public function saveXMLWithWhitespace (DOMNode $node = null, $options = null) {
		$doc = new Harmoni_DOMDocument;
		if (is_null($node)) {
			if ($this->documentElement)
				$doc->appendChild($doc->importNode($this->documentElement, true));
		} else
			$doc->appendChild($doc->importNode($node, true));
		
		$doc->addWhitespaceToDocument();
		
		return $doc->saveXML($doc->documentElement, $options);
	}
	
	/**
	 * Add Whitespace to a document. This will add whitespace to all children of 
	 * the document element, but not preceeding whitespace to the document
	 * 
	 * @return void
	 * @access protected
	 * @since 1/29/08
	 */
	protected function addWhitespaceToDocument () {
		if ($this->documentElement) {
			$this->addWhitespace($this->documentElement);
			
			// Remove any whitespace before the document element
			while ($this->documentElement->previousSibling) {
				$this->removeChild($this->documentElement->previousSibling);
			}
		}
	}
	
	/**
	 * Add whitespace to the element tree below the element passed.
	 * 
	 * @param object DOMNode $node
	 * @return boolean TRUE if indenting was done, false if it wasn't.
	 * @access protected
	 * @since 1/23/08
	 */
	protected function addWhitespace (DOMNode $node) {
		switch ($node->nodeType) {
			case XML_ELEMENT_NODE:
				$node->parentNode->insertBefore($this->getWhiteSpace(),	$node);
				$this->tabs++;
				$childrenTabbed = false;
				foreach ($node->childNodes as $child) {
					if ($this->addWhitespace($child))
						$childrenTabbed = true;
				}
				$this->tabs--;
				if ($childrenTabbed)
					$node->appendChild($this->getWhitespace());
				return true;
			default:
				return false;
		}
	}
	
	/**
	 * @var int $tabs; The current indent level 
	 * @access private
	 * @since 1/23/08
	 */
	private $tabs = 0;
	
	/**
	 * Answer the current whitespace.
	 * 
	 * @return DOMTextNode
	 * @access private
	 * @since 1/23/08
	 */
	private function getWhitespace () {
		$whitespace = "\n";
		for ($i = 0; $i < $this->tabs; $i++)
			$whitespace .= "\t";
		return $this->createTextNode($whitespace);
	}
	
	/**
	 * Validate the document against a schema and throw an exception on any errors.
	 * 
	 * @param string $schemaFilename
	 * @return boolean
	 * @access public
	 * @since 2/4/08
	 */
	public function schemaValidateWithException ($schemaFilename) {
		// Make sure that errors are stored internally
		$xmlErrorTmp = libxml_use_internal_errors(true);
		libxml_clear_errors();
		
		$valid = @$this->schemaValidate($schemaFilename);
		$errors = libxml_get_errors();
		
		// reset libxml errors
		libxml_clear_errors();
		libxml_use_internal_errors($xmlErrorTmp);
		
		if ($valid)
			return true;
		
		// Throw an exception with the errors
		throw new ValidationFailedException($errors);
				
	}
}

/**
 * An exception for failed document validation
 * 
 * @since 2/4/08
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Harmoni_DOMDocument.class.php,v 1.2 2008/04/18 14:57:59 adamfranco Exp $
 */
class ValidationFailedException
	extends Exception
{
	/**
	 * Constructor
	 * 
	 * @param array $errors
	 * @return void
	 * @access public
	 * @since 2/4/08
	 */
	public function __construct (array $errors) {
		$message = 'Validation failed with the following errors: ';
		$message .= "\n".$this->getLibXmlErrorTable($errors);
		
		parent::__construct($message);
	}
	
	/**
	 * Answer an HTML table of libxml errors
	 * 
	 * @param array $errors
	 * @return string
	 * @access protected
	 * @since 2/4/08
	 */
	protected function getLibXmlErrorTable (array $errors) {
		ob_start();
		print "\n<table>";
		print "\n<thead>";
		print "\n\t<tr>";
		print "\n\t\t<th>Kind</th>";
		print "\n\t\t<th>Line</th>";
		print "\n\t\t<th>Message</th>";
		print "\n\t</tr>";
		print "\n</thead>";
		print "\n<tbody>";
		foreach ($errors as $error) {
			print "\n\t<tr>";
			print "\n\t\t<td>";
			switch ($error->level) {
				case LIBXML_ERR_WARNING:
					print "Warning";
					break;
				case LIBXML_ERR_ERROR:
					print "Error";
					break;
				case LIBXML_ERR_FATAL:
					print "Fatal Error";
					break;
			}
			print " ".$error->code;
			print "</td>\n\t\t<td>";
			print $error->line;
			print "</td>\n\t\t<td>";
			print $error->message;
			print "</td>";
			print "\n\t</tr>";
		}
		print "\n</tbody>";
		print "\n</table>";
		return ob_get_clean();
	}
	
	/**
	 * Answer an HTML-formatted message.
	 * 
	 * @return string
	 * @access public
	 * @since 4/18/08
	 */
	public function getHtmlMessage () {
		return $this->getMessage();
	}
}

?>