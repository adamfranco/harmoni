<?php

require_once(HARMONI.'authenticationHandler/methods/LDAPMethodOptions.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: LDAPMethodOptionsTestCase.class.php,v 1.1 2003/06/30 19:11:53 adamfranco Exp $
 * @copyright 2003 
 **/

    class LDAPMethodOptionsTestCase extends UnitTestCase {
	
		function LDAPMethodOptionsTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		var $opt;
		function setUp() {
			$this->opt = & new DBMethodOptions;
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			unset($this->opt);
		}
	
		/**
		 *    First test Description
		 */ 
		function test_set_all_options() {
			$o = &$this->opt;
			$o->set("databaseType",MYSQL);
			$this->assertEqual($o->get("databaseType"),MYSQL);
			$o->set("databaseName","harmoniTest");
			$this->assertEqual($o->get("databaseName"),"harmoniTest");
			$o->set("databaseUsername","test");
			$this->assertEqual($o->get("databaseUsername"),"test");
			$o->set("databasePassword","test");
			$this->assertEqual($o->get("databasePassword"),"test");
			$o->set("databaseHost","devo.middlebury.edu");
			$this->assertEqual($o->get("databaseHost"),"devo.middlebury.edu");
			$o->set("tableName","user");
			$this->assertEqual($o->get("tableName"),"user");
			$o->set("usernameField","user_uname");
			$this->assertEqual($o->get("usernameField"),"user_uname");
			$o->set("passwordField","user_pass");
			$this->assertEqual($o->get("passwordField"),"user_pass");
			$o->set("passwordFieldEncrypted",true);
			$this->assertEqual($o->get("passwordFieldEncrypted"),true);
			$o->set("passwordFieldEncryptionType","databaseSHA1");
			$this->assertEqual($o->get("passwordFieldEncryptionType"),"databaseSHA1");
			$o->set("agentInformationFields",array("email"=>"user_email"
													,"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
		}
		
    }

?>