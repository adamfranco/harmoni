<?

require_once(dirname(__FILE__)."/String.class.php");

/**
 * A HtmlString data type. This class allows for HTML-safe string shortening.
 *
 * @package harmoni.datamanager.primitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HtmlString.class.php,v 1.5 2005/12/14 22:16:59 adamfranco Exp $
 */
class HtmlString 
	extends String 
{
	var $_children;
	
	function HtmlString($string="") {
		$this->_string = (string) $string;
	}
	
	/**
	 * Instantiates a new String object with the passed value.
	 * @param string $value
	 * @return ref object
	 * @access public
	 * @static
	 */
	function &withValue($value) {
		$string =& new HtmlString($value);
		return $string;
	}
	
	/**
	 * Shorten the string to a number of words, preserving HTML tags
	 * while enforcing the closing of html tags.
	 * 
	 * @param integer $numWords
	 * @param boolean $addElipses
	 * @return void
	 * @access public
	 * @since 12/12/05
	 */
	function trim ( $numWords, $addElipses = true ) {
		$tags = array();
		$wordCount = 0;
		$output = '';
		$inWord = false;
		
		for ($i=0; $i < strlen($this->_string) && $wordCount < $numWords; $i++) {
			$char = $this->_string[$i];
			
			switch($char) {
				case '>':
					$inWord = true;
					$output .= '&gt;';
					break;
				case '<':
					if ($this->isInvalidLessThan($this->_string, $i)) {
						$inWord = true;
						$output .= '&lt;';
						break;
					}
					
					// We are at a tag:
					//	- 	if we are starting a tag, push that tag onto the tag
					// 		stack and print it out.
					//	- 	If we are closing a tag, pop it off of the tag stack.
					//		and print it out.
					$tag = $this->getTag($this->_string, $i);
					$tagHtml = '';
					$isCloseTag = ($this->_string[$i+1] == '/')?true:false;
					$isSingleTag = $this->isSingleTag($this->_string, $i);
					
// 					print "<hr>Tag: $tag<br/>isCloseTag: ".(($isCloseTag)?'true':'false')."<br/>isSingleTag: ".(($isSingleTag)?'true':'false');
					
					// iterate over the tag
					while ($char != '>') {
						$char = $this->_string[$i];
						$i++;
						$tagHtml .= $char;
					}
					$i--; // we've overrun to print the end tag, so decrement $i
					
					// Enforce trailing slashes in single tags for more valid
					// HTML.
					if ($isSingleTag && $tagHtml[strlen($tagHtml) - 2] != '/') {
						$tagHtml[strlen($tagHtml) - 1] = '/';
						$tagHtml .= '>';
					}
					
					if ($isCloseTag) {
						$topTag = array_pop($tags);
						$output .= '</'.$topTag.'>';
					} else if ($isSingleTag) {
						$output .= $tagHtml;
					} else {			
						array_push($tags, $tag);
						$output .= $tagHtml;
					}
					
					break;
				case " ":
				case "\n":
				case "\r":
				case "\t":
					if ($inWord) {
						$wordCount++;
						$inWord = false;
					}
					$output .= $char;
					break;
				default:
					$inWord = true;
					$output .= $char;
			}
		}
		
		// trim off any trailing whitespace
		$output = trim($output);
		
		
		// If we have text that we aren't printing, print elipses
		// properly nested in HTML
		if ($i < strlen($this->_string) && $addElipses) {
			$addElipses = true;
			
			$tagsToSkip = 0;
			$nestingTags = array("table", "tr", "ul", "ol", "select");
			for ($i = count($tags); $i > 0; $i--) {
				if (in_array($tags[$i-1], $nestingTags))
					$tagsToSkip++;
				else
					break;
			}
		} else {
			$addElipses = false;
			$tagsToSkip = NULL;
		}
				
		// if we've hit our word limit and not closed all tags, close them now.
		if (count($tags)) {
			while ($tag = array_pop($tags)) {
				
				// Ensure that our elipses appear in the proper place in the HTML
				if ($addElipses && $tagsToSkip === 0)
					$output .= dgettext('harmoni', '...');
				$tagsToSkip--;
				
				$output .= '</'.$tag.'>';
				
			}
			
			if ($addElipses && $tagsToSkip === 0)
				$output .= dgettext('harmoni', '...');
		} else {
			if ($addElipses)
				$output .= dgettext('harmoni', '...');
		}
		
// 		print "<pre>'".htmlspecialchars($output)."'</pre>"; 
		
		$this->_string = $output;
	}
	
	/**
	 * Trim the passed text to a shorter length, stripping the HTML tags
	 *
	 * Originally posted to php.net forums 
	 * by webmaster at joshstmarie dot com (55-Sep-2005 05:58).
	 * Modified by Adam Franco (afranco at middlebury dot edu).
	 * 
	 * @param string $text
	 * @param integer $maxLength
	 * @return string
	 * @access public
	 * @since 11/21/05
	 */
	function stripTagsAndTrim ($word_count) {
		$string = strip_tags($this->_string);
		
		$trimmed = "";
		$string = preg_replace("/\040+/"," ", trim($string));
		$stringc = explode(" ",$string);

		if($word_count >= sizeof($stringc))
		{
			// nothing to do, our string is smaller than the limit.
			return $string;
		}
		elseif($word_count < sizeof($stringc))
		{
			// trim the string to the word count
			for($i=0;$i<$word_count;$i++)
			{
				$trimmed .= $stringc[$i]." ";
			}
			
			if(substr($trimmed, strlen(trim($trimmed))-1, 1) == '.')
				return trim($trimmed).'..';
			else
				return trim($trimmed).'...';
		}
	}
	
	/**
	 * Clean up the html as much as possible
	 * 
	 * @return void
	 * @access public
	 * @since 12/14/05
	 */
	function clean () {
		$this->trim(strlen($this->_string));
	}
	
	/**
	 * Answer the tag that starts at the given index.
	 * 
	 * @param string $inputString
	 * @param integer $tagStart // index of the opening '<'
	 * @return string
	 * @access public
	 * @since 12/13/05
	 */
	function getTag ( $inputString, $tagStart ) {
		if ($inputString[$tagStart + 1] == '/')
			$string = substr($inputString, $tagStart + 2);
		else
			$string = substr($inputString, $tagStart + 1);
			
		$nextSpace = strpos($string, ' ');
		$nextClose = strpos($string, '>');
		
		if ($nextSpace && $nextSpace < $nextClose)
			$tagEnd = $nextSpace;
		else
			$tagEnd = $nextClose;
			
		$tag = substr($string, 0, $tagEnd);
			
// 		print "<hr>NextSpace: $nextSpace<br/>NextClose: $nextClose<pre>".htmlspecialchars($string)."</pre>"; 
// 		print "<pre>".htmlspecialchars($tag)."</pre>"; 
		
		return $tag;
	}
	
	/**
	 * Answer true if the tag begining at $tagStart does not have a close-tag,
	 * examples are <br/>, <hr/>, <img src=''/>
	 * 
	 * @param string $inputString
	 * @param integer $tagStart // index of the opening '<'
	 * @return string
	 * @access public
	 * @since 12/13/05
	 */
	function isSingleTag ( $inputString, $tagStart ) {
		// if this is a close tag itself, return false
		if ($inputString[$tagStart + 1] == '/')
			return false;
		
		// if this is a tag that ends in '/>', return true
		$string = substr($inputString, $tagStart + 1);
		$nextClose = strpos($string, '>');
		if ($string[$nextClose - 1] == '/')
			return true;
		
		// check the tag to allow exceptions for commonly invalid tags such as
		// <br>, <hr>, <img src=''>
		$tag = $this->getTag($inputString, $tagStart);
		$singleTags = array ('br', 'hr', 'img');
		if (in_array($tag, $singleTags))
			return true;
		
		// Otherwise
		return false;
	}
	
	/**
	 * Answer true if the '<' doesn't seem to be the start of a tag and is 
	 * instead an invalid 'less-than' character. 
	 * 
	 * This will be the case if:
	 * 		- There is a space, line-return, new-line, or '=' following the '<'
	 *		- Another '<' is found in the string before a '>'
	 * 
	 * @param string $inputString
	 * @param integer $tagStart // index of the opening '<'
	 * @return string
	 * @access public
	 * @since 12/14/05
	 */
	function isInvalidLessThan ( $inputString, $tagStart ) {
		// if this '<' is followed by one of our invalid following chars
		$invalidFollowingChars = array("\s", "\t", "\n", "\r", "=");
		if (in_array($inputString[$tagStart + 1], $invalidFollowingChars))
			return true;
		
		// grap the substring starting at our tag.
		for ($i = $tagStart + 1; $i < strlen($inputString); $i++) {
			if ($inputString[$i] == '<')
				return true;
			if ($inputString[$i] == '>')
				return false;
		}	
		
		// If we have gotten to the end of the string and not found a
		// closing '>', then the tag must be invalid.
		return true;
	}
}