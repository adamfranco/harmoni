<?php

    if (!defined("SIMPLE_TEST")) {
        define("SIMPLE_TEST", "./");
    }
    require_once(SIMPLE_TEST . 'simple_html_test.php');
	
    /**
	 * An improved HTML display by Dobo Radichkov.
	 * Different colors and visualizations. Also includes pass messages in
	 * addition to the fail messages.
     */
    class DoboTestHtmlDisplay extends TestHtmlDisplay {
	
        /**
         *    Paints the CSS. Add additional styles here.
         *    @protected
         */
        function _getCss() {
			$css = "body { background-color: #222; color: white; font-size: 14px; font-family: monospace;}\n";
            $css .= ".fail { font-size: small; font-size: 16px; color: #f00; font-weight: bold;}\n";
            $css .= ".pass { font-size: small; font-size: 16px; color: #0c0; }\n";
            $css .= ".message { font-size: small; font-size: 14px; color: #0cf; }\n";
			return $css;
        }

        /**
         *    Paints the test failure with a breadcrumbs
         *    trail of the nesting test suites below the
         *    top level test.
         *    @param $message        Failure message displayed in
         *                           the context of the other tests.
         */
        function paintFail($message) {
            TestDisplay::paintFail($message);
            print "<div align=\"left\"><span class=\"fail\">Fail</span>: ";
            $breadcrumb = $this->getTestList();
            array_shift($breadcrumb);
            print implode("-&gt;", $breadcrumb);
            print "-&gt;<span class=\"message\"><pre>$message</pre></span></div>\n";
        }
        
        /**
         *    Paints the test passes with a breadcrumbs
         *    trail of the nesting test suites below the
         *    top level test.
         *    @param $message        Pass message displayed in
         *                           the context of the other tests.
         */
        function paintPass($message) {
            TestDisplay.parent::paintPass($message);
            print "<div align=\"left\"><span class=\"pass\">Pass</span>: ";
            $breadcrumb = $this->getTestList();
            array_shift($breadcrumb);
            print implode("-&gt;", $breadcrumb);
            print "</div>\n";
        }
	}
?>
