<?php

	###########################################################
	# Layout 												  #
	# handles diplaying of html based on layout file template #
	###########################################################

	class Layout {

		var $layout_file = "";
		var $areas = array();

		// Constructor
		function Layout($file) {
			$this->layout_file = $file;
		}

        // Adds a set of anmed content to a layout
        function addArea($name,$content) {
			$this->areas[$name] = $content;
        }

        // Renders a layout;
        // returns the layout code as a string
        function render() {

			// create a series of variables for each area
			foreach ($this->areas as $key => $elem) {
				
				$code = "\$$key = \"".Layout::escapeString($elem)."\";";
				//print $code;
				eval($code);
			}

			$file = $this->layout_file;

			// turn on output buffering
			ob_start();
			?>

				<? require($file) ?>

			<?php
			$s = ob_get_contents();
			ob_end_clean();
			
			return $s;
		}
		
		function escapeString ($string) {
			// Since these strings will be placed withing eval
			// statements, we must escape special characters
			// so that they will execute correctly
			$trans["\\"] = "\\\\";	
			$trans["\$"] = "\\\$";	
			$trans["\""] = "\\\"";
			
			return strtr ($string, $trans);
		}
	}
	
?>