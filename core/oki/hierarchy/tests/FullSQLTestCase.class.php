<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchyManager.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');
require_once(HARMONI.'/oki/hierarchy/tests/FoodNodeType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: FullSQLTestCase.class.php,v 1.5 2005/02/07 21:38:20 adamfranco Exp $
 * @package harmoni.tests.metadata
 * @copyright 2003
 **/

    class FullSQLTestCase extends UnitTestCase {

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
        	print "<pre>";
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
			print "</pre>";
        }

		//--------------the tests ----------------------
		
/******************************************************************************
 * The following two tests are intended to be used as example of how to start		
 * using the hierarchy service. 
 * 
 * Part 1 will most likely be done by the application
 * framework (i.e. harmoni) and its configuration files.
 *
 * Part 2 is the creation of a hierarchy and a set of nodes within it as well as
 * the saveing of the hierarchy to the database.
 * 
 * Part 3 is the read of the hierarchy out of the database, modifying it, and
 * saving the changes.
 *
 * Part 4 is the deleting of the hierarchy from the database.
 ******************************************************************************/
		function test_1_creation_and_saving() {
		
/******************************************************************************
 * Part 1 - setup
 ******************************************************************************/
			// Connect to the database
			$this->dbc =& Services::requireService("DBHandler");
 			$this->dbIndex = $this->dbc->createDatabase(MYSQL,"devo.middlebury.edu", "harmoniTest", "test", "test");
 			$this->dbc->connect($this->dbIndex);
 			$startingNumQueries = $this->dbc->getTotalNumberOfQueries($this->dbIndex);
 			
/******************************************************************************/
// A temporary query, just clean out the tables so that we can insert into fresh ones.
$query = new DeleteQuery;
$query->setTable("hierarchy");
$this->dbc->query($query, $this->dbIndex);

$query = new DeleteQuery;
$query->setTable("hierarchy_node");
$this->dbc->query($query, $this->dbIndex);

/******************************************************************************/
 			
 			// Create the Hierarchy manager with a configuration for our database.
 			$configuration = array(
				"type" => SQL_DATABASE,
				"database_index" => $this->dbIndex,
				"hierarchy_table_name" => "hierarchy",
				"hierarchy_id_column" => "id",
				"hierarchy_display_name_column" => "display_name",
				"hierarchy_description_column" => "description",
				"node_table_name" => "hierarchy_node",
				"node_hierarchy_key_column" => "fk_hierarchy",
				"node_id_column" => "id",
				"node_parent_key_column" => "lk_parent",
				"node_display_name_column" => "display_name",
				"node_description_column" => "description"
			);
			$manager =& new HarmoniHierarchyManager($configuration);
			
/******************************************************************************
 * Part 2 - hierarchy creation
 ******************************************************************************/
			// Create a hierarchy.
			$hierarchy =& $manager->createHierarchy(FALSE, "Food Hierarchy", "A hierarchy of food categories.", NULL, FALSE);
			
			// Lets store the Id of the hierarchy so that we can reference it later.
			$this->foodHierarchyId = $hierarchy->getId();
			
			// We'll need to create some ids, so lets get the Shared service.
			$sharedManager =& Services::requireService("Shared");
			
			$this->assertTrue(TRUE);
			
			// Lets add some nodes to it.
		// Start with a root node.
			
			// create a Type for the node.
			$foodType =& new FoodNodeType;
			// create an Id
			$foodId =& $sharedManager->createId();
			// add the node
			$food =& $hierarchy->createRootNode($foodId, $foodType, "Food", "All kinds of food.");
			
		// Lets fill out the tree a bit with some second-level nodes
			// create an Id
			$plantId =& $sharedManager->createId();
			// lets store this id so we can get back to it later.
			$this->plantId = $plantId;
			// add the node
			$plant =& $hierarchy->createNode($plantId, $foodId, $foodType, "Plants", "Foods that come from plants.");
			
			// create an Id
			$animalId =& $sharedManager->createId();
			// add the node
			$animal =& $hierarchy->createNode($animalId, $foodId, $foodType, "Animals", "Foods that come from animals.");
			
		// Lets fill out the tree a bit with some third-level nodes
			// create an Id
			$fruitId =& $sharedManager->createId();
			// add the node
			$fruit =& $hierarchy->createNode($fruitId, $plantId, $foodType, "Fruit", "Foods that come from fruits.");
			
			// create an Id
			$vegetableId =& $sharedManager->createId();
			// lets store this id so we can get back to it later.
			$this->vegetableId = $vegetableId;
			// add the node
			$vegetable =& $hierarchy->createNode($vegetableId, $plantId, $foodType, "vegetable", "Foods that come from vegetables.");
			
			// create an Id
			$grainId =& $sharedManager->createId();
			// add the node
			$grain =& $hierarchy->createNode($grainId, $plantId, $foodType, "grain", "Foods that come from grains.");
			
			// create an Id
			$meatId =& $sharedManager->createId();
			// add the node
			$meat =& $hierarchy->createNode($meatId, $animalId, $foodType, "meat", "Foods that come from meats.");
			
			// create an Id
			$dairyId =& $sharedManager->createId();
			// add the node
			$dairy =& $hierarchy->createNode($dairyId, $animalId, $foodType, "dairy", "Foods that come from dairy.");
			
		// Lets fill out the vegetable branch a bit.
			// create an Id
			$tomatoId =& $sharedManager->createId();
			// add the node
			$tomato =& $hierarchy->createNode($tomatoId, $vegetableId, $foodType, "tomato", "Foods that contain tomatos.");

			// create an Id
			$carrotId =& $sharedManager->createId();
			// add the node
			$carrot =& $hierarchy->createNode($carrotId, $vegetableId, $foodType, "carrot", "Foods that contain carrots.");
			
			// create an Id
			$broccoliId =& $sharedManager->createId();
			// add the node
			$broccoli =& $hierarchy->createNode($broccoliId, $vegetableId, $foodType, "broccoli", "Foods that contain broccolis.");
			
			// create an Id
			$celeryId =& $sharedManager->createId();
			// add the node
			$celery =& $hierarchy->createNode($celeryId, $vegetableId, $foodType, "celery", "Foods that contain celerys.");
			
			// create an Id
			$lettuceId =& $sharedManager->createId();
			// add the node
			$lettuce =& $hierarchy->createNode($lettuceId, $vegetableId, $foodType, "lettuce", "Foods that contain lettuces.");
			
			// create an Id
			$onionId =& $sharedManager->createId();
			// add the node
			$onion =& $hierarchy->createNode($onionId, $vegetableId, $foodType, "onion", "Foods that contain onions.");
			
			// create an Id
			$squashId =& $sharedManager->createId();
			// add the node
			$squash =& $hierarchy->createNode($squashId, $vegetableId, $foodType, "squash", "Foods that contain squashs.");
			
		// On looking at a boteny book, I've decided that tomatoes are fruit. Lets move them.
			$tomato->changeParent($vegetableId, $fruitId);
			
		// Lets save the hierarchy
			$hierarchy->save();
			
		// Lets also now move squash to fruit.
			$squash->changeParent($vegetableId, $fruitId);
			
		// Lets save the hierarchy
			$hierarchy->save();
			
		// Lets add a cucumber to vegetables, change it to fruit, then save.
			// create an Id
			$cucumberId =& $sharedManager->createId();
			// add the node
			$cucumber =& $hierarchy->createNode($cucumberId, $vegetableId, $foodType, "cucumber", "Foods that contain cucumbers.");
			// move it to a new parent
			$cucumber->changeParent($vegetableId, $fruitId);
			$hierarchy->save();
			
		// Lets add a pork to vegetables, then delete it, then save.
			// create an Id
			$porkId =& $sharedManager->createId();
			// add the node
			$pork =& $hierarchy->createNode($porkId, $vegetableId, $foodType, "pork", "Foods that contain porks.");
			// delete pork
			$hierarchy->deleteNode($porkId);
			// save the hierarchy
			$hierarchy->save();
			
		// Lets add a chicken to meat, then delete it, then add it again, then save.
			// create an Id
			$chickenId =& $sharedManager->createId();
			// add the node
			$chicken =& $hierarchy->createNode($chickenId, $meatId, $foodType, "chicken", "Foods that contain chickens.");
			// delete chicken
			$hierarchy->deleteNode($chickenId);
			// add the node
			$chicken =& $hierarchy->createNode($chickenId, $meatId, $foodType, "chicken", "Foods that contain chickens.");
			// save the hierarchy
			$hierarchy->save();
			
			$this->assertTrue(TRUE);
			
			$finishingNumQueries = $this->dbc->getTotalNumberOfQueries($this->dbIndex) - $startingNumQueries;
			print $finishingNumQueries;
		}
		
		function test_2_read_and_delete() {
		
/******************************************************************************
 * Part 3 - hierarchy retrieval
 ******************************************************************************/
 		// First, we will create the manager with the nessesary configuration.
 			$startingNumQueries = $this->dbc->getTotalNumberOfQueries($this->dbIndex);
 			
 			// Create the Hierarchy manager with a configuration for our database.
 			$configuration = array(
				"type" => SQL_DATABASE,
				"database_index" => $this->dbIndex,
				"hierarchy_table_name" => "hierarchy",
				"hierarchy_id_column" => "id",
				"hierarchy_display_name_column" => "display_name",
				"hierarchy_description_column" => "description",
				"node_table_name" => "hierarchy_node",
				"node_hierarchy_key_column" => "fk_hierarchy",
				"node_id_column" => "id",
				"node_parent_key_column" => "lk_parent",
				"node_display_name_column" => "display_name",
				"node_description_column" => "description"
			);
			
			$manager =& new HarmoniHierarchyManager($configuration);
			
		// Lets get our hierarchy
			$hierarchy =& $manager->getHierarchy($this->foodHierarchyId);

		// Let's look at vegetables
			$hierarchy->load($this->plantId);
			
			print_r($hierarchy);

		// Lets do some tests to make sure that all is working.
			
 		

/******************************************************************************
 * Part 4 - hierarchy deletion
 ******************************************************************************/
			$finishingNumQueries = $this->dbc->getTotalNumberOfQueries($this->dbIndex) - $startingNumQueries;
			print "Pulling Queries: $finishingNumQueries\n";
			print "Total Queries: ".$this->dbc->getTotalNumberOfQueries($this->dbIndex);
		}
}