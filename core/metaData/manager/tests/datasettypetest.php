<?php

include "../../../../harmoni.inc.php";
include HARMONI."metaData/manager/HarmoniDataManager.abstract.php";
//include HARMONI."debugHandler/NewWindowDebugHandlerPrinter.class.php";

$passwd = ereg_replace("[\n\r ]","",file_get_contents("passwd"));

$db =& Services::requireService("DBHandler");
$dbid = $db->addDatabase( new MySQLDatabase("localhost","harmoni","root",$passwd) );
$db->connect($dbid);

HarmoniDataManager::setup($dbid);

$manager =& Services::requireService("DataSetTypeManager");

$def = $manager->newDataSetType( new HarmoniType("gabe","datasettype","supertest","just a test"));

$def->addNewField( new FieldDefinition("number","integer",false,true) );
$def->addNewField( new FieldDefinition("number2","integer",true,true) );
$def->addNewField( new FieldDefinition("number3","integer",false,true) );

debug::level(15);

$manager->synchronize($def);

print "finished synchronization with a total of ".$db->getTotalNumberOfQueries()." queries.";

NewWindowDebugHandlerPrinter::printDebugHandler(Services::requireService("Debug"));

?>
