<?php

/**
 * A Template allows you to choose a template file and print the contents of that template
 * with certain values filled in. The format of a template file is:<br/>
 * <br/>
 * some html ... &lt?=$value1=&gt; ... more html ...
 *
 * @package harmoni.utilities.template
 * @version $Id: Template.class.php,v 1.1 2003/07/18 03:23:14 gabeschine Exp $
 * @copyright 2003 
 **/

class TemplateInterface {
	/**
	 * @access private
	 * @var string $_fullPath The template's full path.
	 **/
	var $_fullPath;
	
	/**
	 * The constructor.
	 * @param string $file The filename or full path of the template file.
	 * @param optional mixed $searchPaths Either a string or array of strings specifying
	 * where to search for $file.
	 * @access public
	 * @return void
	 **/
	function Template($file, $searchPaths=null) {
		$fullPath = null;
		if (file_exists($file)) $fullPath = $file;
		else {
			// go through the searchPaths and find the file.
			if ($searchPaths && !is_array($searchPaths)) $searchPaths = array($searchPaths);
			foreach ($searchPaths as $path) {
				$try = $path . DIRECTORY_SEPARATOR . $file;
				if (file_exists($try)) { $fullPath = $try; break; }
			}
		}
		
		// if we found the file...
		if ($fullPath)
			$this->_fullPath = $fullPath;
		else {
			// throw an error
			throwError(new Error("Template - could not create new template from file '$file' because it could not be found!","Template",true));
		}
	}
	
	/**
	 * Outputs the content of the current template with $variables containing
	 * the variable output.
	 * @param mixed $variables Either an associative array or a {@link FieldSet} containing
	 * a number of [key]=>content pairs.
	 * @access public
	 * @return void
	 **/
	function output( $variables ) {
		// so that we don't interfere with the template, rename $variables
		// to something very obscure
		$__v =& $variables; unset($variables);
		// first check if what we have is good
		if (is_array($__v)) {
			// ok, register them all as local variables
			foreach(array_keys($__v) as $__k)
				$$__k = $__v[$__k];
		} else if (is_a($__v,"FieldSetInterface")) {
			$__keys = $__v->getKeys();
			foreach ($__keys as $__k)
				$$__k = $__v->get($__k);
		} else {
			throwError(new Error("Template::output() - could not output: variables passed to method do not seem to be an associative array or a FieldSet."));
			return false;
		}
		
		// otherwise, let's continue and output the file.
		include($this->_fullPath);
	}
	
	/**
	 * Calls output() but catches whatever is printed and returns the output in a string.
	 * @param mixed $variables See description under {@link TemplateInterface::output()}
	 * @access public
	 * @return string The output from the template.
	 **/
	function catchOutput( $variables ) {
		// start the output buffer
		ob_start();
		
		// output
		$this->output(&$variables);
		
		// catch the output
		$output = ob_get_contents();
		
		// end
		ob_end_clean();
		
		return $output;
	}
}

?>