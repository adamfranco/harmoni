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

$dataSet =& $manager->newDataSet(new HarmoniType("gabe","datasettype","supertest"));

//print "<pre>"; print_r($dataSet); print "</pre>";

$dataSet->setValue("number", new IntegerDataType(200));

$valVers =& $dataSet->getValue("number");
$valVer =& $valVers->getActiveVersion();
$val =& $valVer->getValue();

print_r($val);

debug::printAll();