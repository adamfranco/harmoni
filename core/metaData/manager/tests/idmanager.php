<?php

error_reporting(E_ALL);

print "...";

include "../../../../harmoni.inc.php";
include HARMONI."oki/shared/HarmoniType.class.php";
include HARMONI."debugHandler/NewWindowDebugHandlerPrinter.class.php";
include HARMONI."debugHandler/PlainTextDebugHandlerPrinter.class.php";

print Harmoni::getVersionStr();
debug::level(DEBUG_SYS5);
print "debug level is: ".debug::level();

//throwError( new Error("aaaaah","3434",true));

//Services::requireService("ErrorHandler");

//Services::requireService("ErrorHandler");

//$db =& Services::requireService("DBHandler");
var_dump(Services::startService("DBHandler"));
if (Services::serviceRunning("DBHandler")) print "started";
$db =& Services::getService("DBHandler");

print "...";

$dbid = $db->addDatabase( new MySQLDatabase("localhost","harmoni","root",file_get_contents("passwd")));
$db->connect($dbid);

print "...";

print "trying to get new ID...<br />";

$type =& new HarmoniType("chunky","harmoni","testidtype");

print "...";

$sharedManager =& Services::getService("Shared");
$id =& $sharedManager->createId();
$newid = $id->getIdString();

print "got $newid from database!<br />";

print "<br />Now checking if the two are equal... ";
// 
// $type2 =& $idmanager->getIDType($newid);
// 
// if ($type->isEqual($type2)) print "yes";
// else print "no";
// 
// print "<br /><br />";
// 
// print_r($type2);


print "<br /><br />";

$errorHandler =& Services::requireService("ErrorHandler");

if ($errorHandler->getNumberOfErrors()) {
	print "we have errors!";
	$errorHandler->printErrors();
} else print "no errors";

$debug =& Services::requireService("Debug");

print "<pre>";

NewWindowDebugHandlerPrinter::printDebugHandler($debug);

print "</pre>";
?>
