<?php
/**
 * @since 9/11/07
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: db_updater.php,v 1.3 2007/10/08 19:32:14 adamfranco Exp $
 */ 
ini_set('display_errors', true);

require_once(dirname(__FILE__).'/../../harmoni.inc.php');
require_once(dirname(__FILE__).'/MySQL/MySqlUtils.class.php');

$types = array(
	MYSQL 		=> "MySQL",
	POSTGRESQL	=> "PostgreSQL",
	ORACLE		=> "Oracle",
	SQLSERVER	=> "Microsoft SQL Server"
);

$functions = array (
	"columnNamesToLowercase" => "Make all column names lowercase.",
	"harmoni_0_11_0_update" => "Update the tables from Harmoni-0.10.0 to Harmoni-0.11.0.",
	"harmoni_0_12_0_update" => "Update the tables from Harmoni-0.11.0 to Harmoni-0.12.0."
);

function execute_update (array $types, array $functions) {
	if (!array_key_exists($_REQUEST['function'], $functions))
		throw new Exception("Unknown function, '".$_REQUEST['function']."'.");
	
	if (!array_key_exists($_REQUEST['db_type'], $types))
		throw new Exception("Unknown database type, '".$_REQUEST['db_type']."'.");
	
	switch ($_REQUEST['db_type']) {
		case MYSQL:
			$utilClass = "MySqlUtils";
			break;
		default:
			throw new Exception($types[$_REQUEST['db_type']]." databases are not currently supported for updates.");
	}
	
	if (!class_exists($utilClass))
		throw new Exception("The selected database utility class, '".$utilClass."', does not exist.");
	
	if (!method_exists($utilClass, $_REQUEST['function']))
		throw new Exception("The selected function, ".$_REQUEST['function']."(), is not currently supported by this database.");
	
	
	// Now execute the update.
	$configuration = new ConfigurationProperties;
	$context = new OSIDContext;
	Services::startManagerAsService("DatabaseManager", $context, $configuration);
	$dbc = Services::getService('DBHandler');
	
	$dbIndex = $dbc->createDatabase($_REQUEST['db_type'], $_REQUEST['db_host'], $_REQUEST['db_name'], $_REQUEST['db_user'], $_REQUEST['db_pass']);
	
	$dbc->connect($dbIndex);
	
	try {
		eval($utilClass."::".$_REQUEST['function'].'($dbIndex);');
	} catch (Exception $e) {
		// Close our connection
		$dbc->disconnect($dbIndex);
		
		throw $e;
	}
	
	$dbc->disconnect($dbIndex);
}


?>
<html>
<head>
	<title>Database Updater</title>
	<style type='text/css'>
		.db_type {
			float: left;
			margin-right: 20px;
		}
		
		h2, h3 {
			margin-bottom: 5px;
		}
		
		
		.db_type h3 {
			margin-top: 0px;
		}
		
		.results {
			padding: 10px;
			background-color: #CCC;
			border: 1px dotted #999;
		}
	</style>
</head>
<body>
	<h1>Database Updater</h1>

<?php

if (isset($_REQUEST['db_type']) && isset($_REQUEST['db_host'])
	&& isset($_REQUEST['db_name']) && isset($_REQUEST['db_user'])
	&& isset($_REQUEST['db_pass']) && isset($_REQUEST['function']))
{
	print "\n\t\t<h2>"._("Results")."</h2>";
	print "\n\t<div class='results'>";
	
	try {
		execute_update($types, $functions);
	} catch (Exception $e) {
		printExceptionInHtml($e);
	}

	print "\n\t</div>";
}
	
	print "\n\t<form action='".$_SERVER['PHP_SELF']."' method='post'>";
	
	/*********************************************************
	 * Database Type
	 *********************************************************/
	print "\n\t\t<div class='db_type'>";
	print "\n\t\t\t<h3>"._("Database Type:")."</h3>";
	foreach ($types as $type => $desc) {
		print "\n\t\t\t<div>";
		print "\n\t\t\t\t<input type='radio' name='db_type' value='".$type."' ".((isset($_REQUEST['db_type']) && $_REQUEST['db_type'] == $type)?" checked='checked'":"")." />".$desc;
		print "\n\t\t\t</div>";
	}
	print "\n\t\t</div>";
	
	
	/*********************************************************
	 * Connection Parameters
	 *********************************************************/
	print "\n\t\t<div class='connection_params'>";
	print "\n\t\t\t<h3>"._("Connection parameters:")."</h3>";
	
	print "\n\t\t\t<div>"._('Database Host: ');
	print "\n\t\t\t\t<input type='text' name='db_host' value='".((isset($_REQUEST['db_host']))?$_REQUEST['db_host']:"localhost")."'/>";
	print "\n\t\t\t</div>";
	
	print "\n\t\t\t<div>"._('Database Name: ');
	print "\n\t\t\t\t<input type='text' name='db_name' value='".((isset($_REQUEST['db_name']))?$_REQUEST['db_name']:"")."'/>";
	print "\n\t\t\t</div>";
	
	print "\n\t\t\t<div>"._('Database User: ');
	print "\n\t\t\t\t<input type='text' name='db_user' value='".((isset($_REQUEST['db_user']))?$_REQUEST['db_user']:"")."'/>";
	print "\n\t\t\t</div>";
	
	print "\n\t\t\t<div>"._('Database Password: ');
	print "\n\t\t\t\t<input type='password' name='db_pass' value='".((isset($_REQUEST['db_pass']))?$_REQUEST['db_pass']:"")."'/>";
	print "\n\t\t\t</div>";
	
	print "\n\t\t</div>";
	
	/*********************************************************
	 * Functions
	 *********************************************************/
	print "\n\t\t<div class='functions'>";
	print "\n\t\t\t<h3>"._("Functions to run:")."</h3>";
	foreach ($functions as $function => $desc) {
		print "\n\t\t\t<div>";
		print "\n\t\t\t\t<input type='radio' name='function' value='".$function."' ".((isset($_REQUEST['function']) && $_REQUEST['function'] == $function)?" checked='checked'":"")." />".$desc;
		print "\n\t\t\t</div>";
	}
	print "\n\t\t</div>";
?>
		<div>
			<input type='submit'/>
		</div>
	</form>
</body>
</html>