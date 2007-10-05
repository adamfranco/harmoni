<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: test.php,v 1.1 2007/10/05 14:02:58 adamfranco Exp $
 */ 

require_once('../../../harmoni.inc.php');
require_once(dirname(__FILE__).'/SimpleTableRepositoryManager.class.php');

print "
<html>
<head>
	<title>Simple Table Repository Test</title>
	<style type='text/css'>
		.recstruct {
			float: left;
			margin: 5px;
			background-color: #AFA;
			border: 1px dotted;
			padding: 5px;
		}
		dt {
			margin-left: 10px;
			font-weight: bold;
		}
		dd {
			margin-left: 20px;
		}
		div.desc {
			font-style: italic;
		}
		h2 {
			border-top: 1px dotted;
			clear: both;
		}
	</style>
</head>
<body>
	<form action='".$_SERVER['PHP_SELF']."' method='post'>
		Database Type:
		<select name='db_type'>
			<option value='MYSQL' ".((isset($_REQUEST['db_type']) && $_REQUEST['db_type'] == 'MYSQL')?" selected='selected'":'').">MySQL</option>
			<option value='POSTGRESQL' ".((isset($_REQUEST['db_type']) && $_REQUEST['db_type'] == 'POSTGRESQL')?" selected='selected'":'').">PostgreSQL</option>
		</select>
		<br/>Host: <input type='text' name='host' value='".((isset($_REQUEST['host']))?$_REQUEST['host']:'')."'/>
		<br/>Database: <input type='text' name='db' value='".((isset($_REQUEST['db']))?$_REQUEST['db']:'')."'/>
		<br/>Table: <input type='text' name='table' value='".((isset($_REQUEST['table']))?$_REQUEST['table']:'')."'/>
		<br/>User: <input type='text' name='user' value='".((isset($_REQUEST['user']))?$_REQUEST['user']:'')."'/>
		<br/>Password: <input type='password' name='password' value='".((isset($_REQUEST['password']))?$_REQUEST['password']:'')."'/>
		<br/>Asset Id Column: <input type='text' name='id_column' value='".((isset($_REQUEST['id_column']))?$_REQUEST['id_column']:'')."'/>
		<br/>Order Column: <input type='text' name='order_column' value='".((isset($_REQUEST['order_column']))?$_REQUEST['order_column']:'')."'/>
		
		<br/>Order Direction:
		<select name='order_direction'>
			<option value='ASCENDING' ".((isset($_REQUEST['order_direction']) && $_REQUEST['order_direction'] == 'ASCENDING')?" selected='selected'":'').">Ascending</option>
			<option value='DESCENDING' ".((isset($_REQUEST['order_direction']) && $_REQUEST['order_direction'] == 'DESCENDING')?" selected='selected'":'').">Descending</option>
		</select>
		
		<br/>Columns to use (one per line): 
		<br/><textarea name='columns' rows='10' cols='80'>".((isset($_REQUEST['columns']))?$_REQUEST['columns']:'')."</textarea>
		<br/>Columns mapped to Dublin Core (one per line): 
		<br/><textarea name='dc_mapping' rows='10' cols='80'>".((isset($_REQUEST['dc_mapping']))?$_REQUEST['dc_mapping']:'')."</textarea>
		<br/><input type='submit'/>
";

if (isset($_REQUEST['host'])) {
	$manager = new SimpleTableRepositoryManager();
	
	/*********************************************************
	 * Configuration
	 *********************************************************/
	$configuration = new ConfigurationProperties;
	switch ($_REQUEST['db_type']) {
		case 'MYSQL':
			$configuration->addProperty('db_type', MYSQL);
			break;
		case 'POSTGRESQL':
			$configuration->addProperty('db_type', POSTGRESQL);
			break;
	}
	$configuration->addProperty('host', $_REQUEST['host']);
	$configuration->addProperty('db', $_REQUEST['db']);
	$configuration->addProperty('table', $_REQUEST['table']);
	$configuration->addProperty('user', $_REQUEST['user']);
	$configuration->addProperty('password', $_REQUEST['password']);
	$configuration->addProperty('id_column', $_REQUEST['id_column']);
	$configuration->addProperty('order_column', $_REQUEST['order_column']);
	switch ($_REQUEST['order_direction']) {
		case 'ASCENDING':
			$configuration->addProperty('order_direction', ASCENDING);
			break;
		case 'DESCENDING':
			$configuration->addProperty('order_direction', DESCENDING);
			break;
	}
	
	$columns = explode("\n", $_REQUEST['columns']);
	$columns = array_map('trim', $columns);
// 	print "Columns: ";
// 	printpre($columns);
	$configuration->addProperty('columns', $columns);
	
	$dc_mapping = explode("\n", $_REQUEST['dc_mapping']);
	$new_mapping = array();
	foreach ($dc_mapping as $val) {
		$mapping = explode("=", $val);
		$new_mapping[trim($mapping[0])] = trim($mapping[1]);
	}
// 	print "DC Mapping: ";
// 	printpre($new_mapping);
	$configuration->addProperty('dc_mapping', $new_mapping);
	
	$manager->assignConfiguration($configuration);
	
	
	/*********************************************************
	 * Testing
	 *********************************************************/
	$repositories = $manager->getRepositories();
	while ($repositories->hasNext()) {
		$repository = $repositories->next();
		print "\n<hr/>";
		print "\n<h1>".$repository->getDisplayName()."</h1>";
		print "\n<div class='desc'>".$repository->getDescription()."</div>";
		
		$assets = $repository->getAssets();
		
		if (isset($_REQUEST['start']))
			$start = intval($_REQUEST['start']);			
		else
			$start = 0;
			
		
		print "\n<div>Assets ".($start + 1)." - ".($start + 10)." of ".$assets->count()." ";
		
		print "<input type='hidden' name='start' value='0'/>";
		print "<input type='button' value='previous' ";
		if ($start > 0) {
			print " onclick=\"this.form.start.value='".max(0, $start - 10)."'; this.form.submit();\"";
		} else {
			print " disabled='disabled'";
		}
		print "/>";
		
		print "<input type='button' value='next' ";
		if ($start < $assets->count() - 10) {
			print " onclick=\"this.form.start.value='".($start + 10)."'; this.form.submit();\"";
		} else {
			print " disabled='disabled'";
		}
		print "/>";
		
		print "</div>";
		
		$i = 0;
		while ($assets->hasNext() && $i < $start + 10) {
			if ($i < $start) {
				$assets->skipNext();
				$i++;
				continue;
			}
			
			$asset = $assets->next();
			print "\n<h2>".$asset->getDisplayName()."</h2>";
			print "\n<div class='desc'>".$asset->getDescription()."</div>";
			
			$recordStructures = $asset->getRecordStructures();
			while ($recordStructures->hasNext()) {
				$recordStructure = $recordStructures->next();
				print "\n<div class='recstruct'>";
				print "\n<h3>".$recordStructure->getDisplayName()."</h3>";
				print "\n<div class='desc'>".$recordStructure->getDescription()."</div>";
				
				$records = $asset->getRecordsByRecordStructure($recordStructure->getId());
				while ($records->hasNext()) {
					$record = $records->next();
					print "\n<dl>";
					
					$partStructures = $recordStructure->getPartStructures();
					while($partStructures->hasNext()) {
						$partStructure = $partStructures->next();
						print "\n\t<dt>".$partStructure->getDisplayName()."</dt>";
						
						$parts = $record->getPartsByPartStructure($partStructure->getId());
						while ($parts->hasNext()) {
							$part = $parts->next();
							print "\n\t<dd>".$part->getValue()."</dd>";
						}
					}
					print "\n</dl>";
				}
				print "</div>";
				
			}
			
			$i++;
		}
	}
}
?>

	</form>
</body>
</html>