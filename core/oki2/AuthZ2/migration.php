<?php
/**
 * @since 4/17/08
 * @package  segue.updates
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 
ini_set('display_errors', true);

require_once(dirname(__FILE__)."/../../../harmoni.inc.php");
require_once(HARMONI.'/oki2/AuthZ2/authz/AuthorizationManager.class.php');
require_once(HARMONI.'/oki2/AuthZ2/hierarchy/HierarchyManager.class.php');
require_once(HARMONI.'/utilities/StatusStars.class.php');

/**
 * <##>
 * 
 * @since 4/17/08
 * @package segue.updates
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class AuthZ2Updater
{
		
	/**
	 * Answer the date at which this updator was introduced
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 3/24/08
	 */
	function getDateIntroduced () {
		$date = Date::withYearMonthDay(2008, 4, 17);
		return $date;
	}
	
	/**
	 * Answer the title of this update
	 * 
	 * @return string
	 * @access public
	 * @since 3/24/08
	 */
	function getTitle () {
		return _("Authorization 2");
	}
	
	/**
	 * Answer the description of the update
	 * 
	 * @return string
	 * @access public
	 * @since 3/24/08
	 */
	function getDescription () {
		return _("This update will install the new authorization and hierarchy tables as well as migrate data to them. If the update is successfull, the original Hierarchy and Authorization tables will be removed. 
		
		<br/><br/><strong>Caution: This update will cause irrevocable changes to your database. Back up your data before running it.</strong> 
		
		<br/><br/>Disable user access to your Harmoni applications while running this update. This update should take about 15 minutes to run on a 10,000-node hierarchy.");
	}
	
	/**
	 * Answer true if this update is in place
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/24/08
	 */
	function isInPlace ($dbIndex) {
		$dbc = Services::getService('DatabaseManager');
		
		$az2Tables = array(
			'az2_explicit_az',
			'az2_function',
			'az2_function_type',
			'az2_hierarchy',
			'az2_implicit_az',
			'az2_j_node_node',
			'az2_node',
			'az2_node_ancestry',
			'az2_node_type'
		);
		
		$azTables = array(
			'az_authorization',
			'az_function',
			'hierarchy',
			'j_node_node',
			'node',
			'node_ancestry'
		);
		
		$tables = $dbc->getTableList($dbIndex);
		// Check for new tables
		foreach ($az2Tables as $table) {
			if (!in_array($table, $tables))
				return false;
		}
		
		// Check for old tables
		foreach ($azTables as $table) {
			if (in_array($table, $tables))
				return false;
		}
		
		return true;
	}
	
	/**
	 * Run the update
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/24/08
	 */
	function runUpdate ($dbIndex) {
		$prepStatus =  new StatusStars("Preparing Migration");
		$prepStatus->initializeStatistics(3);
		
		
		// Configure the original Hierarchy and AZ services
		$context = new OsidContext;
		$configuration = new ConfigurationProperties;
		$configuration->addProperty('database_index', $dbIndex);
		$configuration->addProperty('database_name', $_REQUEST['db_name']);
		$configuration->addProperty('harmoni_db_name', 'migration_db');
		Services::startManagerAsService("IdManager", $context, $configuration);
		Services::startManagerAsService("HierarchyManager", $context, $configuration);
		Services::startManagerAsService("AuthorizationManager", $context, $configuration);
		
		// Agent Manager
		$configuration = new ConfigurationProperties;
		// default agent Flavor is one that can be editted
		$agentFlavor="HarmoniEditableAgent";
		$agentHierarchyId = "edu.middlebury.authorization.hierarchy";
		$configuration->addProperty('hierarchy_id', $agentHierarchyId);
		$configuration->addProperty('defaultAgentFlavor', $agentFlavor);
		$configuration->addProperty('database_index', $dbIndex);
		$configuration->addProperty('database_name', $_REQUEST['db_name']);
		Services::startManagerAsService("AgentManager", $context, $configuration);
	
	// :: Set up PropertyManager ::
		//the property manager operates in the same context as the AgentManager and is more or less an adjunct to it
		$configuration->addProperty('database_index', $dbIndex);
		$configuration->addProperty('database_name', $_REQUEST['db_name']);
		Services::startManagerAsService("PropertyManager", $context, $configuration);
		
		// :: Start the AuthenticationManager OSID Impl.
			$configuration = new ConfigurationProperties;
			$tokenCollectors = array(
				serialize(new Type ("Authentication", "edu.middlebury.harmoni", "Harmoni DB")) 
					=> new FormActionNamePassTokenCollector('does not exist')
			);
			$configuration->addProperty('token_collectors', $tokenCollectors);
			Services::startManagerAsService("AuthenticationManager", $context, $configuration);
		
		
		// :: Start and configure the AuthenticationMethodManager
			$configuration = new ConfigurationProperties;
			
				// set up a Database Authentication Method
				require_once(HARMONI."/oki2/agentmanagement/AuthNMethods/SQLDatabaseAuthNMethod.class.php");
				require_once(HARMONI."/oki2/agentmanagement/AuthNMethods/SQLDatabaseMD5UsernamePasswordAuthNTokens.class.php");
				$dbAuthType = new Type ("Authentication", "edu.middlebury.harmoni", "Harmoni DB");
				$dbMethodConfiguration = new ConfigurationProperties;
				$dbMethodConfiguration->addProperty('tokens_class', 'SQLDatabaseMD5UsernamePasswordAuthNTokens');
				$dbMethodConfiguration->addProperty('database_id', $dbIndex);
				$dbMethodConfiguration->addProperty('authentication_table', 'auth_db_user');
				$dbMethodConfiguration->addProperty('username_field', 'username');
				$dbMethodConfiguration->addProperty('password_field', 'password');
				$propertiesFields = array(
					'username' => 'username',
		//			'name'=> 'display_name',
				);
				$dbMethodConfiguration->addProperty('properties_fields', $propertiesFields);
				
				$dbAuthNMethod = new SQLDatabaseAuthNMethod;
				$dbAuthNMethod->assignConfiguration($dbMethodConfiguration);
				
			$configuration->addProperty($dbAuthType, $dbAuthNMethod);
			
			$GLOBALS["NewUserAuthNType"] = $dbAuthType;	
			Services::startManagerAsService("AuthNMethodManager", $context, $configuration);
			
			
		// :: Agent-Token Mapping Manager ::	
			$configuration = new ConfigurationProperties;
			$configuration->addProperty('database_id', $dbIndex);
			$configuration->addProperty('harmoni_db_name', 'migration_db');
			Services::startManagerAsService("AgentTokenMappingManager", $context, $configuration);
		
		
		$prepStatus->updateStatistics();
		
		$dbc = Services::getService("DatabaseManager");
		try {
			
			/*********************************************************
			 * Check for the old tables. They must exist for us to run
			 *********************************************************/
			$azTables = array(
					'az_authorization',
					'az_function',
					'hierarchy',
					'j_node_node',
					'node',
					'node_ancestry'
				);
			// Check for old tables
			$tables = $dbc->getTableList($dbIndex);
			foreach ($azTables as $table) {
				if (!in_array($table, $tables))
					throw new Exception ("Old AZ table, $table, is missing. Can not run Update.");
			}
			
			/*********************************************************
			 * Create the new tables
			 *********************************************************/
			$type = $dbc->getDatabaseType($dbIndex);
			switch ($type) {
				case MYSQL:
					SQLUtils::runSQLfile(HARMONI_BASE."/SQL/MySQL/AuthZ2.sql", $dbIndex);
					break;
				case POSTGRESQL:
					SQLUtils::runSQLfile(HARMONI_BASE."/SQL/PostgreSQL/AuthZ2.sql", $dbIndex);
					break;
				case ORACLE:
					SQLUtils::runSQLfile(HARMONI_BASE."/SQL/PostgreSQL/AuthZ2.sql", $dbIndex);
					break;
				default:
					throw new Exception("Database schemas are not defined for specified database type.");
			}
			
			/*********************************************************
			 * Hierarchy
			 *********************************************************/
			$hierarchyMgr1 = Services::getService("Hierarchy");
			if (get_class($hierarchyMgr1) == "AuthZ2_HierarchyManager")
				throw new OperationFailedException("Original HierarchyManager not configured.");
			
			$hierarchyMgr2 = new AuthZ2_HierarchyManager();
			$azMgr2 = new AuthZ2_AuthorizationManager();
			$azMgr2->setHierarchyManager($hierarchyMgr2);
			
			
			$hierarchyMgr2->assignConfiguration($hierarchyMgr1->_configuration);
			
			/*********************************************************
			 * Authorization
			 *********************************************************/
			$azMgr1 = Services::getService("AuthZ");
			
			if (get_class($hierarchyMgr1) == "AuthZ2_AuthorizationManager")
				throw new OperationFailedException("Original HierarchyManager not configured.");
			
			$azMgr2->assignConfiguration($azMgr1->_configuration);
			
			
			$prepStatus->updateStatistics();
			
			/*********************************************************
			 * Hierarchies
			 *********************************************************/
			
			
			$hierarchies = $hierarchyMgr1->getHierarchies();
			$prepStatus->updateStatistics();
			while ($hierarchies->hasNext()) {
				$hierarchy = $hierarchies->next();
				
				try {
					$newHierarchy = $hierarchyMgr2->getHierarchy($hierarchy->getId());
				} 
				// Create a new hierarchy
				catch (UnknownIdException $e) {
					$newHierarchy = $hierarchyMgr2->createHierarchy(
						$hierarchy->getDisplayName(),
						array(),
						$hierarchy->getDescription(),
						$hierarchy->allowsMultipleParents(),
						$hierarchy->allowsRecursion(),
						$hierarchy->getId());
				}
				
				$query = new SelectQuery;
				$query->addTable("node");
				$query->addColumn("COUNT(*)", "num");
				$query->addWhereEqual("fk_hierarchy", $hierarchy->getId()->getIdString());
				$dbc = Services::getService("DatabaseManager");
				$result = $dbc->query($query);
				$this->nodeStatus = new StatusStars("Migrating nodes in the '".$hierarchy->getDisplayName()."' Hierarchy.");
				$this->nodeStatus->initializeStatistics($result->field("num"));
				
				// Add all of the nodes
				$nodes = $hierarchy->getRootNodes();
				while ($nodes->hasNext()) {
					$this->addNode($newHierarchy, $nodes->next());
				}
			
			}
			
			
			/*********************************************************
			 * Authorizations
			 *********************************************************/
			$azMgr1 = Services::getService("AuthZ");
			
			if (get_class($hierarchyMgr1) == "AuthZ2_AuthorizationManager")
				throw new OperationFailedException("Original HierarchyManager not configured.");
			
			
			// Add all of the Authorization functions
			$functionTypes = $azMgr1->getFunctionTypes();
			while ($functionTypes->hasNext()) {
				$oldFunctions = $azMgr1->getFunctions($functionTypes->next());
				while ($oldFunctions->hasNext()) {
					$oldFunction = $oldFunctions->next();
					
					// Get or create the function
					try {
						$newFunction = $azMgr2->getFunction($oldFunction->getId());
					} catch (UnknownIdException $e) {
						$newFunction = $azMgr2->createFunction(
							$oldFunction->getId(),
							$oldFunction->getReferenceName(),
							$oldFunction->getDescription(),
							$oldFunction->getFunctionType(),
							$oldFunction->getQualifierHierarchyId());
					}
					
					// Get all authorizations for this function.
					$oldAZs = $azMgr1->getExplicitAZs(null, $oldFunction->getId(), null, false);
					
					$status = new StatusStars("Migrating '".$newFunction->getReferenceName()."' Authorizations (".$oldAZs->count().")");
					$status->initializeStatistics($oldAZs->count());
					
					while ($oldAZs->hasNext()) {
						$oldAZ = $oldAZs->next();
						
						$status->updateStatistics();
						
						try {
							$oldQualifier = $oldAZ->getQualifier();
						} catch (UnknownIdException $e) {
							// continue if the qualifier no longer exists.
							continue;
						}
						
						// Add the new authorization
						try {
							$newAZ = $azMgr2->createAuthorization(
									$oldAZ->getAgentId(),
									$oldAZ->getFunction()->getId(),
									$oldQualifier->getId());
							
							if ($oldAZ->getExpirationDate())
								$newAZ->updateExpirationDate($oldAZ->getExpirationDate());
							
							if ($oldAZ->getEffectiveDate())
								$newAZ->updateEffectiveDate($oldAZ->getEffectiveDate());
						}
						// If it already exists, continue
						catch (OperationFailedException $e) {
						
						}
					}
				}
			}
		} catch (Exception $e) {
			printpre($e->getMessage());
			HarmoniErrorHandler::printDebugBacktrace($e->getTrace());
			
			printpre("An error has occurred. Removing new tables.");
			
			try {
				$query = new GenericSQLQuery('TRUNCATE az2_implicit_az');
			} catch (DatabaseException $e) {
			}
			try {
				$query = new GenericSQLQuery('TRUNCATE az2_explicit_az');
			} catch (DatabaseException $e) {
			}
			try {
				$query = new GenericSQLQuery('TRUNCATE az2_node_ancestry');
			} catch (DatabaseException $e) {
			}
			try {
				$query = new GenericSQLQuery('TRUNCATE az2_j_node_node');
			} catch (DatabaseException $e) {
			}
			try {
				$query = new GenericSQLQuery('TRUNCATE az2_function');
			} catch (DatabaseException $e) {
			}
			try {
				$query = new GenericSQLQuery('TRUNCATE az2_function_type');
			} catch (DatabaseException $e) {
			}
			try {
				$query = new GenericSQLQuery('TRUNCATE az2_node');
			} catch (DatabaseException $e) {
			}
			try {
				$query = new GenericSQLQuery('TRUNCATE az2_node_type');
			} catch (DatabaseException $e) {
			}
			try {
				$query = new GenericSQLQuery('TRUNCATE az2_hierarchy');
			} catch (DatabaseException $e) {
			}
			
			
			$query = new GenericSQLQuery('DROP TABLE az2_implicit_az, az2_explicit_az, az2_function, az2_function_type, az2_node_ancestry, az2_j_node_node, az2_node, az2_node_type,  az2_hierarchy;');
			$dbc->query($query, $dbIndex);
			
			return false;
		}

		/*********************************************************
		 * If we have successfully gotten this far, drop the old 
		 * hierarchy and AuthZ tables to prevent confusion.
		 *********************************************************/
		$query = new GenericSQLQuery('DROP TABLE az_authorization, az_function, hierarchy, j_node_node, node, node_ancestry;');
		$dbc->query($query, $dbIndex);
		
		print "Success!";
		return true;
	}
	
	/**
	 * Create a new node and its children
	 * 
	 * @param object Hierarchy $newHierarchy
	 * @param object Node $oldNode
	 * @param optional object Id $parentId 
	 * @return void
	 * @access protected
	 * @since 4/17/08
	 */
	protected function addNode (Hierarchy $newHierarchy, Node $oldNode, Id $parentId = null) {
		// If it has already been created, get it and try to set its parent
		try {
			$newNode = $newHierarchy->getNode($oldNode->getId());
			if (!is_null($parentId)) {
				try {
					$newNode->addParent($parentId);
				} catch (Exception $e) {
					// Do nothing if the child already exists
					if ($e->getMessage() != "A child with the given id already exists!")
						throw $e;
				}
			}
				
		}
		// otherwise, create it
		catch (UnknownIdException $e) {
			if (is_null($parentId))
				$newNode = $newHierarchy->createRootNode(
					$oldNode->getId(),
					$oldNode->getType(),
					$oldNode->getDisplayName(),
					$oldNode->getDescription());
			else
				$newNode = $newHierarchy->createNode(
					$oldNode->getId(),
					$parentId,
					$oldNode->getType(),
					$oldNode->getDisplayName(),
					$oldNode->getDescription());
			
			$this->nodeStatus->updateStatistics();
		}		
		
		$oldChildren = $oldNode->getChildren();
		while ($oldChildren->hasNext()) {
			$oldChild = $oldChildren->next();
			$this->addNode($newHierarchy, $oldChild, $newNode->getId());
		}
	}	
}


$types = array(
	MYSQL 		=> "MySQL",
	POSTGRESQL	=> "PostgreSQL",
	ORACLE		=> "Oracle",
	SQLSERVER	=> "Microsoft SQL Server"
);

function execute_update (array $types) {
	
	if (!array_key_exists($_REQUEST['db_type'], $types))
		throw new Exception("Unknown database type, '".$_REQUEST['db_type']."'.");
	
	switch ($_REQUEST['db_type']) {
		case MYSQL:
			$utilClass = "MySqlUtils";
			break;
		case POSTGRESQL:
			$utilClass = "PostgreSQLUtils";
			break;
		default:
			throw new Exception($types[$_REQUEST['db_type']]." databases are not currently supported for updates.");
	}
	
	
	// Now execute the update.
	$configuration = new ConfigurationProperties;
	$context = new OSIDContext;
	Services::startManagerAsService("DatabaseManager", $context, $configuration);
	$dbc = Services::getService('DBHandler');
	
	$dbIndex = $dbc->createDatabase($_REQUEST['db_type'], $_REQUEST['db_host'], $_REQUEST['db_name'], $_REQUEST['db_user'], $_REQUEST['db_pass']);
	
	$dbc->connect($dbIndex);
	
	// Harmoni_Db
	if ($_REQUEST['use_harmoni_db']) {
		switch ($_REQUEST['db_type']) {
			case MYSQL:
				$dbType = 'Pdo_Mysql';
				break;
			case POSTGRESQL:
				$dbType = 'Pdo_Postgresql';
				break;
			default:
				throw new Exception($types[$_REQUEST['db_type']]." databases are not currently supported for updates.");
		}
		$db = Harmoni_Db::factory($dbType, array(
			'host'     => $_REQUEST['db_host'],
			'username' => $_REQUEST['db_user'],
			'password' => $_REQUEST['db_pass'],
			'dbname'   => $_REQUEST['db_name'],
			'adapterNamespace' => 'Harmoni_Db_Adapter'
		));
		
		Harmoni_Db::registerDatabase('migration_db', $db);	
	}
	
	try {
		$updater = new AuthZ2Updater;
		if ($updater->isInPlace($dbIndex))
			print "Update is already in place.";
		else
			$updater->runUpdate($dbIndex);
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
	<title>AuthZ2 Migration</title>
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
	<h1>AuthZ2 Migration</h1>
<?php
	if (!isset($updater))
		$updater = new AuthZ2Updater();
	print "\n\t<p>".$updater->getDescription()."</p>";

if (isset($_REQUEST['db_type']) && isset($_REQUEST['db_host'])
	&& isset($_REQUEST['db_name']) && isset($_REQUEST['db_user'])
	&& isset($_REQUEST['db_pass']))
{
	print "\n\t\t<h2>"._("Results")."</h2>";
	print "\n\t<div class='results'>";
	
	try {
		execute_update($types);
	} catch (Exception $e) {
		HarmoniErrorHandler::handleException($e);
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
	
	print "\n\t\t\t<div>"._('Use Harmoni_Db/PDO?: ');
	print "\n\t\t\t\t<input type='checkbox' name='use_harmoni_db' value='true' ".((isset($_REQUEST['use_harmoni_db']))?'checked="checked"':"")."/>";
	print "\n\t\t\t</div>";
	
	print "\n\t\t</div>";
?>
		<div>
			<input type='submit'/>
		</div>
	</form>
</body>
</html>