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

// check the query string

$manager->_selectIDsBySearch(array(1,2,3,4,5),
	new FieldValueSearch(new HarmoniType("middlebury.edu","Harmoni","SimpleAgent"),
				"firstName", new ShortStringDataType("hello")));




debug::printAll();

print "queries: ".$db->getTotalNumberOfQueries();