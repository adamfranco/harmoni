<?php

require_once("DBHandler.class.php");

/**
 * Show Gabe how to use "it"!
 *
 * @version $Id: usage.php,v 1.1 2003/06/24 20:56:26 gabeschine Exp $
 * @copyright 2003 
 **/

$dbHandler =& new DBHandler(MYSQL, "devo.middlebury.edu", "test", "test", "test");
$dbHandler->connect();

$id = $dbHandler->createDatabase(MYSQL, "et.middlebury.edu", "dobo", "dobo", "dobo");
$dbHandler->connect($id);

$query =& new SelectQuery();
$query->setColumns(array("test.id", "test.value AS v1", "test1.value AS v2"));
$query->addTable("test", NO_JOIN);
$query->addTable("test1", INNER_JOIN, "test.FK = test1.id");
$query->setWhere("test1.id < 10");
$query->addOrderBy("test.id", ASCENDING);
$query->limitNumberOfRows(15);
$query->setDistinct(true);
$query->startFromRow(100);

echo "<pre>".MySQL_SQLGenerator::generateSQLQuery($query);

$result =& $dbHandler->query($query);

echo $result->getNumberOfRows();
echo "<br>";

while($result->hasMoreRows()) {
	print_r($result->getCurrentRow());
	$result->advanceRow();
}
	

?>