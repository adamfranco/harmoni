<?

include "../../../../harmoni.inc.php";
include "../DataSetTypeManager.class.php";
//include HARMONI."oki/shared/HarmoniType.class.php";
//include HARMONI."debugHandler/NewWindowDebugHandlerPrinter.class.php";

print Harmoni::getVersionStr();
debug::level(DEBUG_SYS5);

$db =& Services::requireService("DBHandler");

$passwd = ereg_replace("[\n\r ]","",file_get_contents("passwd"));

$dbid = $db->addDatabase( new MySQLDatabase("localhost","harmoni","root",$passwd));
$db->connect($dbid);

$manager =& new DataSetTypeManager($dbid);

// :: if we are adding a new one

if ($_REQUEST['action'] == "addnew") {
	$type = new HarmoniType(
				$_REQUEST['domain'],
				$_REQUEST['authority'],
				$_REQUEST['keyword'],
				$_REQUEST['description']);
	
	$definition =& $manager->newDataSetType($type);
	$manager->synchronize($definition);
	if ($definition) print "<p><b>Successfully added new type.</b>";
}

// :: done


print "<p>Manager returned <b>".$manager->numberOfTypes()."</b> registered DataSetTypes.";

if ($manager->numberOfTypes()) {
	$allTypes =& $manager->getAllDataSetTypes();
	print "<br /><br />\n";
	while($allTypes->hasNext() && $type =& $allTypes->next()) {
		print "<div><li />".OKITypeToString($type)."</div>\n";
		print "<div style='padding-left: 20px; font-size: smaller;'>".$type->getDescription()."</div>\n";
	}
}

?>

<p>
<form method="POST">
Domain: <input type="text" name="domain" size=40> <br />
Authority: <input type="text" name="authority" size=40> <br />
Keyword: <input type="text" name="keyword" size=40> <br />
Description: <input type="text" name="description" size=80> <br />
<input type="hidden" name="action" value="addnew">
<input type="submit" value="Add New">
</form>



<?

NewWindowDebugHandlerPrinter::printDebugHandler(Services::requireService("Debug"));

?>
