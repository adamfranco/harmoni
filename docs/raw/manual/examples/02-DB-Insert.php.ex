$query =& new InsertQuery;
$query->setTable("table1");

$query->setColumns(
	array(
		"column1",
		"column2")
	);

$query->addRowOfValues(
	array(
		"jones",
		"margy")
	);
$query->addRowOfValues(
	array(
		"jameson",
		"bobby")
	);

$result =& $dbHandler->query($query, $dbIndex);

if ($result) {
	print "Success! We inserted " . $query->getNumberOfRows() . " rows into the database!\n";
} else {
	print "Ergh. Something happened.\n";
}