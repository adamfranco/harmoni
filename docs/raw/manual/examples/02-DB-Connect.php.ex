$dbHandler =& Services::getService("DBHandler");

$dbIndex = $dbHandler->addDatabase(
		new PostgreSQLDatabase(
			"my.host.com",
			"myDatabaseName",
			"myUser",
			"secret")
		);
		
$dbHandler->connect($dbIndex);
// you could also use $dbHandler->pConnect($dbIndex);
// for a persistent connection.

if ($dbHandler->isConnected($dbIndex)) print "We're connected!";
else print "Doh.";

$dbHandler->disconnect($dbIndex);