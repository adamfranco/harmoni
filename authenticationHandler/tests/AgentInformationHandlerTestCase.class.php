<?php

    require_once(HARMONI.'authenticationHandler/AgentInformationHandler.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AgentInformationHandlerTestCase.class.php,v 1.5 2003/06/30 18:43:13 adamfranco Exp $
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
			$this->add4();
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
			$o->set("agentInformationFields",array("username"=>"user_uname",
													"email"=>"user_email",
													"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("user",1,$m,true);
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
			$o->set("agentInformationFields",array("username"=>"user_uname",
													"email"=>"user_email",
													"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("usermd5",2,$m);
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
			$o->set("agentInformationFields",array("username"=>"user_uname",
													"email"=>"user_email",
													"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("user2",0,$m,false);
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
			$o->set("agentInformationFields",array("username"=>"user_uname",
													"email"=>"user_email",
													"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("user3",3,$m,true);
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
		function test_various_methods() {
			// testing... testing... bjones... do you copy
			// bjones' info is the same accross all dbs except the last one
			$a = $this->info->getAgentInformation("bjones","user");
			$this->assertEqual($a[username],"bjones");
			$this->assertEqual($a[email],"bjones@email.net");
			$this->assertEqual($a[firstname],"Bob");
			$this->assertEqual($a[lastname],"Jones");
			
			$a = $this->info->getAgentInformation("bjones","user2");
			$this->assertEqual($a[username],"bjones");
			$this->assertEqual($a[email],"bjones@email.net");
			$this->assertEqual($a[firstname],"Bob");
			$this->assertEqual($a[lastname],"Jones");
			
			$a = $this->info->getAgentInformation("bjones","usermd5");
			$this->assertEqual($a[username],"bjones");
			$this->assertEqual($a[email],"bjones@email.net");
			$this->assertEqual($a[firstname],"Bob");
			$this->assertEqual($a[lastname],"Jones");

			// bjones isn't in this database
			$a = $this->info->getAgentInformation("bjones","user3");
			$this->assertEqual($a[username],"");
			$this->assertEqual($a[email],"");
			$this->assertEqual($a[firstname],"");
			$this->assertEqual($a[lastname],"");
		}
		
		function test_all_methods_at_once() {
			$a = $this->info->getAgentInformation("bjones");
			$this->assertEqual($a[username],"bjones");
			$this->assertEqual($a[email],"bjones@email.net");
			$this->assertEqual($a[firstname],"Bob");
			$this->assertEqual($a[lastname],"Jones");
		}
		
		function test_priorities() {
			// Linda Smith in db record, before marrage
			$a = $this->info->getAgentInformation("lsmith","user");
			$this->assertEqual($a[username],"lsmith");
			$this->assertEqual($a[email],"lsmith@email.net");
			$this->assertEqual($a[firstname],"Linda");
			$this->assertEqual($a[lastname],"Smith");
			
			// Linda Smith's info was updated in the higherpriority DBs.
			$a = $this->info->getAgentInformation("lsmith");
			$this->assertEqual($a[username],"lsmith");
			$this->assertEqual($a[email],"ljones@email.net");
			$this->assertEqual($a[firstname],"Linda");
			$this->assertEqual($a[lastname],"Jones");
			
			// Adam Franco has a bad db record in user3
			$a = $this->info->getAgentInformation("afranco","user3");
			$this->assertEqual($a[username],"afranco");
			$this->assertEqual($a[email],"afranco@is.fluffy.com");
			$this->assertEqual($a[firstname],"Adam");
			$this->assertEqual($a[lastname],"Franco'machine");
			
			// Adam Franco info should be right in the higher priority dbs
			$a = $this->info->getAgentInformation("afranco");
			$this->assertEqual($a[username],"afranco");
			$this->assertEqual($a[email],"afranco@email.net");
			$this->assertEqual($a[firstname],"Adam");
			$this->assertEqual($a[lastname],"Franco");
		}
		
    }

?>