...

if (Services::serviceRunning("ErrorHandler")) {
	$errorHandler =& Services::getService("ErrorHandler");
	$count = $errorHandler->getNumberOfErrors();
	print "We have $count errors!";
}

...