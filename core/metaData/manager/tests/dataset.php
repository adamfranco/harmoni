<?


include "../../../../harmoni.inc.php";
include HARMONI."metaData/manager/HarmoniDataManager.abstract.php";
//include HARMONI."debugHandler/NewWindowDebugHandlerPrinter.class.php";

debug::level(20);

$passwd = ereg_replace("[\n\r ]","",file_get_contents("passwd"));

$db =& Services::requireService("DBHandler");
$dbid = $db->addDatabase( new MySQLDatabase("localhost","harmoni","root",$passwd) );
$db->connect($dbid);

HarmoniDataManager::setup($dbid);

$manager =& Services::requireService("DataSetManager");

$dataSet =& $manager->fetchDataSet(9,true);

/*$dataSet =& $manager->newDataSet(new HarmoniType("gabe","datasettype","supertest"), true);

//print "<pre>"; print_r($dataSet); print "</pre>";

$dataSet->setValue("number", new IntegerDataType(200));
$dataSet->setValue("number", new IntegerDataType(150));
$dataSet->setValue("number2", new IntegerDataType(10));
$dataSet->setValue("number2", new IntegerDataType(20), NEW_VALUE);
$dataSet->setValue("number2", new IntegerDataType(25), 1);
$dataSet->setValue("number2", new IntegerDataType(30), NEW_VALUE);*/

//print_r($val);
//$dataSet->commit();
renderDataSet($dataSet);

debug::printAll();