<?


include "../../../../harmoni.inc.php";
//include HARMONI."metaData/manager/HarmoniDataManager.abstract.php";
//include HARMONI."debugHandler/NewWindowDebugHandlerPrinter.class.php";

debug::level(20);

$passwd = ereg_replace("[\n\r ]","",file_get_contents("passwd"));

$db =& Services::requireService("DBHandler");
$dbid = $db->addDatabase( new MySQLDatabase("localhost","harmoni","root",$passwd) );
$db->connect($dbid);

HarmoniDataManager::setup($dbid);

$manager =& Services::requireService("DataSetManager");

$dataSet =& $manager->fetchDataSet(228,true);

//$sets =& $manager->fetchArrayOfIDs(array(138, 147, 188, 207), true);

//$dataSet =& $manager->newDataSet(new HarmoniType("middlebury.edu","harmoni","testtype"), false);

//print "<pre>"; print_r($dataSet); print "</pre>";

$dataSet->setValue("smart", new BooleanDataType(false));

//print_r($val);
$dataSet->commit();
renderDataSet($dataSet);

//renderDataSetArray($sets);

/*$dataSet->setValue("number2", new IntegerDataType(60034), 2);
renderDataSet($dataSet);
$dataSet->commit();
*/
debug::printAll();

print "queries: ".$db->getTotalNumberOfQueries();