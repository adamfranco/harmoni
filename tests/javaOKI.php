<?php // :: Java OKI Proof of concept test file ::

require_once("../harmoni.inc.php");

require_once(HARMONI."core/oki/shared/JavaPOCSharedManager.class.php");

$sharedManager =& new JavaPOCSharedManager("osid.shared.impl2.SharedManager");

$id = $sharedManager->createId();

print "we have an ID object. string = ".$id->getIdString()."<BR>\n";
