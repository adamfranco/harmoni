$query =& new UpdateQuery;
$query->setTable("table1");
$query->setColumns(array("column1"));
$query->setValues(array("yodle"));
$query->setWhere("column1='jones'");

$result =& $dbHandler->query($query,$dbIndex);

print "There were " . $result->getNumberOfRows() . " members of the jones family.";