<?
//apd_set_pprof_trace();
define("LOAD_HIERARCHY", false);
include "../../../../harmoni.inc.php";
include HARMONI."utilities/QueryCounter.class.php";
include HARMONI."utilities/Timer.class.php";
//include HARMONI."metaData/manager/HarmoniDataManager.abstract.php";
//include HARMONI."debugHandler/NewWindowDebugHandlerPrinter.class.php";
class EverythingCounter {

	var $query;
	var $time;
	
	function EverythingCounter() {
		$this->query =& new QueryCounter();
		$this->time =& new Timer();
	}
	
	function start() {
		$this->query->start();
		$this->time->start();
	}
	
	function end() {
		$this->query->end();
		$this->time->end();
	}
	
	function getQueries() {
		return $this->query->count();
	}

	function getTime() {
		return $this->time->printTime();
	}
	
}
debug::level(20);

$passwd = ereg_replace("[\n\r ]","",file_get_contents("passwd"));

$db =& Services::requireService("DBHandler");
$dbid = $db->addDatabase( new MySQLDatabase("localhost","harmoni","root",$passwd) );
$db->connect($dbid);

HarmoniDataManager::setup($dbid);

$manager =& Services::requireService("DataSetManager");

// check the query string

$toClone = array(341, 351, 359, 387, 397, 410, 420);

//$sets =& $manager->fetchArrayOfIDs($toClone, true);
//
// get all our DataSet ids.
$query =& new SelectQuery;
$query->addTable("dataset");
$query->addColumn("dataset_id");
$result =& $db->query($query,$dbid);
while ($result->hasMoreRows()) {
	$idsToFetch[] = $result->field(0);
	$result->advanceRow();
}

$tMgr =& Services::getService("DataSetTypeManager");
$availableTypes =& $tMgr->getAllDataSetTypes();
while ($availableTypes->hasNext()) {
	$type =& $availableTypes->next();
	$def =& $tMgr->getDataSetTypeDefinition($type);
	$def->load();
}
	
$superTimer =& new EverythingCounter();
$superTimer->start();

$sets =& $manager->fetchArrayOfIDs(array_slice($idsToFetch,0,98), false);

print "fetched ".count($sets)." datasets.<br />";
//foreach ($toClone as $id) {
//	$newSet =& $sets[$id]->clone();
//	$newSet->commit();
//}



$superTimer->end();

print "first operation, ".$superTimer->getTime()." and ".$superTimer->getQueries()." queries.<br />";
exit;
$agent =& new HarmoniType("middlebury.edu","Harmoni","SimpleAgent");
$comp =& new HarmoniType("middlebury.edu","Harmoni","Computer");

$s =& new AndSearch;
$s->addCriteria(new DataSetTypeSearch($comp));
//$s->addCriteria(new DataSetTypeSearch($agent));
$s->addCriteria(new FieldValueSearch($comp,"vendor",new ShortStringDataType("Dell")));

$timer=&new EverythingCounter();
$timer->start();
$ids = $manager->selectIDsBySearch(
		$s
		);
$timer->end();

print "second operation, ".$timer->getTime()." and ".$timer->getQueries()." queries.<br />";

print_r($ids);


debug::printAll();

print "queries: ".$db->getTotalNumberOfQueries();