<?php

/**
 * Translate the changelog.xml into an HTML page.
 *
 * @version $Id: changelog.php,v 1.1 2003/07/12 16:10:17 gabeschine Exp $
 * @copyright 2003 
 **/
$xml = 'changelog.xml';
$xsl = 'xslt/changelog-simplehtml.xsl';

$xh = xslt_create();

$html = xslt_process($xh,$xml,$xsl);

xslt_free($xh);

print $html;

?>