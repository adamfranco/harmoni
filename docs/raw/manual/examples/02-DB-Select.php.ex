$query =& new SelectQuery;

$query->setTable("table1");
$query->addColumn("column1");
$query->addColumn("column2", "anAlias"); // fetch column2 AS anAlias
$query->setWhere("column1 = 'jones'");

// execute the query!
$result =& $dbHandler->query($query, $dbIndex);

print "Our query has ". $result->getNumberOfRows() . "rows!\n";

while ($result->hasMoreRows()) {
	$array = $result->getCurrentRow();
	
	print "Result row: column1 = " . $array['column1'] . ", column2 AS anAlias: " .
						$array['anAlias'] . "\n";
	
	$result->advanceRow();
}