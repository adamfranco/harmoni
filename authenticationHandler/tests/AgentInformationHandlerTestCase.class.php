<?php

    require_once(HARMONI.'authenticationHandler/AgentInformationHandler.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AgentInformationHandlerTestCase.class.php,v 1.4 2003/06/30 15:30:51 adamfranco Exp $
 * @copyright 2003 
 **/

    class AgentInformationHandlerTestCase extends UnitTestCase {
	
		function AgentInformationHandlerTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		var $info,$auth;
		function setUp() {
//			print "<pre>";
//			print_r($GLOBALS[SERVICES_OBJECT]);
		
			Services::requireService("Authentication");
			Services::requireService("AgentInformation");
			$this->info = & Services::getService("AgentInformation");
			$this->auth = & Services::getService("Authentication");
			$this->add1();
			$this->add2();
			$this->add3();
			//$this->add4();
		}
		
		function add1() {
			$o = & new DBMethodOptions;
			$o->set("databaseType",MYSQL);
			$o->set("databaseName","harmoniTest");
			$o->set("databaseUsername","test");
			$o->set("databasePassword","test");
			$o->set("databaseHost","devo.middlebury.edu");
			$o->set("tableName","user");
			$o->set("usernameField","user_uname");
			$o->set("passwordField","user_pass");
			$o->set("agentInformationFields",array("email"=>"user_email"
													,"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("db1",0,$m,true);
		}
		function add2() {
			$o = & new DBMethodOptions;
			$o->set("databaseType",MYSQL);
			$o->set("databaseName","harmoniTest");
			$o->set("databaseUsername","test");
			$o->set("databasePassword","test");
			$o->set("databaseHost","devo.middlebury.edu");
			$o->set("tableName","usermd5");
			$o->set("usernameField","user_uname");
			$o->set("passwordField","user_pass");
			$o->set("passwordFieldEncrypted",true);
			$o->set("passwordFieldEncryptionType","databaseMD5");
			$o->set("agentInformationFields",array("email"=>"user_email"
													,"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("db2",1,$m);
		}
		function add3() {
			$o = & new DBMethodOptions;
			$o->set("databaseType",MYSQL);
			$o->set("databaseName","harmoniTest");
			$o->set("databaseUsername","test");
			$o->set("databasePassword","test");
			$o->set("databaseHost","devo.middlebury.edu");
			$o->set("tableName","user2");
			$o->set("usernameField","user_uname");
			$o->set("passwordField","user_pass");
			$o->set("agentInformationFields",array("email"=>"user_email"
													,"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("db3",4,$m,false);
		}
		function add4() {
			$o = & new DBMethodOptions;
			$o->set("databaseType",MYSQL);
			$o->set("databaseName","harmoniTest");
			$o->set("databaseUsername","test");
			$o->set("databasePassword","test");
			$o->set("databaseHost","devo.middlebury.edu");
			$o->set("tableName","user3");
			$o->set("usernameField","user_uname");
			$o->set("passwordField","user_pass");
			$o->set("agentInformationFields",array("email"=>"user_email"
													,"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("db4",3,$m,true);
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			Services::restartService("Authentication");
		}
	
		/**
		 *    Tests getting information for an agent.
		 */ 
		function test_it() {
			// testing... testing... bjones... do you copy
			// same accross all methods
			$a = $this->info->getAgentInformation("bjones","db1");
			print_r($a);
			$a = $this->info->getAgentInformation("bjones","db3");
			print_r($a);
			$a = $this->info->getAgentInformation("bjones","db3");
			print_r($a);
			$a = $this->info->getAgentInformation("bjones");
			print_r($a);
		}
		
    }

?>