$query =& new DeleteQuery;
$query->setTable("table1");
$query->setWhere("column1='yodle'");

$result =& $dbHandler->query($query,$dbIndex);

print "The yodle family just lost " . $result->getNumberOfRows() . " members.";