<?php

include "../../../../harmoni.inc.php";
include HARMONI."metaData/manager/HarmoniDataManager.abstract.php";
include HARMONI."debugHandler/NewWindowDebugHandlerPrinter.class.php";

$db =& Services::requireService("DBHandler");
$dbid = $db->addDatabase( new MySQLDatabase("localhost","harmoni","root",file_get_contents("passwd")) );
$db->connect($dbid);

HarmoniDataManager::setup($dbid);

$manager =& Services::requireService("DataSetTypeManager");

$def = $manager->newDataSetType( new HarmoniType("gabe","datasettype","supertest2","just a test"));

$def->addNewField( new FieldDefinition("number","integer",false,false) );
$def->addNewField( new FieldDefinition("number2","integer",true,false) );
$def->addNewField( new FieldDefinition("number3","integer",false,true) );

debug::level(15);

$manager->synchronize($def);

print "finished synchronization with a total of ".$db->getTotalNumberOfQueries()." queries.";

NewWindowDebugHandlerPrinter::printDebugHandler(Services::requireService("Debug"));

?>
