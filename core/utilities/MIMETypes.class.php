<?php

/**
 * Functions for figuring out MIME types.
 * 
 * @package harmoni.utilities
 * @version $Id: MIMETypes.class.php,v 1.1 2004/10/20 19:09:56 adamfranco Exp $
 * @date $Date: 2004/10/20 19:09:56 $
 * @copyright 2004 Middlebury College
 */

class MIMETypes {
		
	/**
	 * Get the MIME Type for the specified filename.
	 * 
	 * @param string $filename
	 * @return string
	 * @access public
	 * @date 10/20/04
	 */
	function getMIMETypeForFileName ( $filename ) {
		// If we have an extension, sniff for it.
		if (ereg(".+\.([^\.]+)", $filename, $parts)) {
			$extension = $parts[1];
			return $this->getMIMETypeForExtension($extension);
		} else {
			return "application/octet-stream";
		}
	}
	
	/**
	 * Get the MIME Type for a particular extension.
	 * 
	 * @param string $extension
	 * @return string
	 * @access public
	 * @date 10/20/04
	 */
	function getMIMETypeForExtension ( $extension ) {
		trim($extension, ".");
		
		$text = array (
			"html" => "htm",
			"html" => "html",
			"plain" => "txt",
			"richtext" => "rtf",
			"richtext" => "rtx",
			"xml" => "xml",
			"html" => "htm",
			"html" => "htm",
			"html" => "htm"
		);
	}
	
	
	
}

?>