$someUser = "gabeschine";
$somePass = "secret";

$result =& $authHandler->authenticateAllMethods($someUser, $somePass);

if ($result->isValid()) {
	print "Hey, ".$result->getSystemName().", looks like you're in!<br />";
	print "You authenticated in ".$result->getValidMethodCount()." methods, named: " . 
				implode(", ", $result->getValidMethods()) .
				"<br />";
} else {
	print "Sorry, ".$result->getSystemName().". No go my friend.<br />";
}