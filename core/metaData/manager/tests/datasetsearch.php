<?

define("LOAD_HIERARCHY", false);
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
$typeManager =& Services::requireService("DataSetTypeManager");

// check the query string

$agent =& new HarmoniType("middlebury.edu","Harmoni","SimpleAgent");
$comp =& new HarmoniType("middlebury.edu","Harmoni","Computer");
$ar = array($agent, $comp);
$it =& new HarmoniTypeIterator($ar);
$typeManager->loadMultiple($it);

//$s =& new AndSearch;
//$s->addCriteria(new DataSetTypeSearch($comp));
//$s->addCriteria(new DataSetTypeSearch($agent));
//$s->addCriteria(new FieldValueSearch($comp,"vendor",new ShortStringDataType("Dell")));
$s =& new OnlyThisSearch(new FieldValueSearch($comp,"vendor",new ShortStringDataType("Dell")));

$ids = $manager->selectIDsBySearch(
//		new FieldValueSearch(
//			$agent,"firstName", 
//				new ShortStringDataType("Gabe"))
//		new DataSetTypeSearch($comp)
		$s
		);

print_r($ids);


debug::printAll();

print "queries: ".$db->getTotalNumberOfQueries();