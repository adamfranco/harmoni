<?php

require_once(HARMONI.'authenticationHandler/AuthenticationHandler.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthenticationHandlerTestCase.class.php,v 1.3 2005/02/07 21:38:18 adamfranco Exp $
 * @copyright 2003 
 **/

    class AuthenticationHandlerTestCase extends UnitTestCase {
	
		function AuthenticationHandlerTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @access public
		*/
		var $auth;
		function setUp() {
			Services::requireService("Authentication");
			$this->auth = & Services::getService("Authentication");
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
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("db3",0,$m,false);
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
			Services::startService("DBHandler");
			$m = &new DBAuthenticationMethod($o);
			$this->auth->addMethod("db4",1,$m,true);
		}
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @access public
		 */
		function tearDown() {
			Services::restartService("Authentication");
		}
	
		/**
		 *    First test Description
		 */ 
		function test_add_one() {
			$this->add1();
			$a = $this->auth->getMethodNames();
			$this->assertEqual($a,array("db1"));
		}
		function test_add_two() {
			$this->add1();
			$this->add2();
			$a = $this->auth->getMethodNames();
			$this->assertEqual($a,array("db1","db2"));
		}
		function test_add_all_and_auth()  {
			$this->add1(); $this->add3(); $this->add2();
			$this->add4();
			
			// check afranco/afrancopasswd against the authoritative db
			// and the md5 db (those are the two in which it's valid)
			$r = & $this->auth->authenticateAllMethods("afranco","afrancopassword");
			$this->assertEqual($r->getValidMethods(),array("db1","db2"));
			$this->assertTrue($r->isValid());
			// now try one that would only work in one db, but not an
			// authoritative one... not valid!
			$r2 =& $this->auth->authenticateAllMethods("afranco","password");
			$this->assertEqual(count($r2->getValidMethods()),0);
			$this->assertFalse($r2->isValid());
			// now try one that would work in *one* of the authoritative
			// db's, but not the other... should still work
			$r3 =& $this->auth->authenticateAllMethods("afranco","authorized");
			$this->assertEqual(count($r3->getValidMethods()),1);
			$this->assertTrue($r3->isValid());
			$this->assertTrue($r3->validInMethod("db4"));
			$this->assertFalse($r3->validInMethod("db2"));
		}
		
    }

?>