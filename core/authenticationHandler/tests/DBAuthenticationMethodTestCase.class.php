<?php

require_once(HARMONI.'authenticationHandler/methods/DBAuthenticationMethod.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DBAuthenticationMethodTestCase.class.php,v 1.3 2005/02/07 21:38:18 adamfranco Exp $
 * @copyright 2003 
 **/

    class DBAuthenticationMethodTestCase extends UnitTestCase {
	
		function DBAuthenticationMethodTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @access public
		*/
		var $m;
		var $o;
		function setUp() {
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
			$this->m = &new DBAuthenticationMethod($o);
			$this->o = &$o;
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @access public
		 */
		function tearDown() {
			unset($this->m);
		}
	
		/**
		 *    First test Description
		 */ 
		 
		function test_aaa_connect_disconnect() {
			$this->assertFalse($this->m->_connected);
			$this->m->_connect();
			$this->assertTrue($this->m->_connected);
			$this->m->_disconnect();
			$this->assertFalse($this->m->_DBHandler->isConnected($this->m->_id));
			$this->assertFalse($this->m->_connected);
			$this->m->_connect();
			$this->assertTrue($this->m->_connected);
			$this->m->_disconnect();
			$this->assertFalse($this->m->_DBHandler->isConnected($this->m->_id));
			$this->assertFalse($this->m->_connected);

		}
		function test_agent_exists() {
			$this->assertFalse($this->m->agentExists("blablastupid"));
			$this->assertTrue($this->m->agentExists("afranco"));
		}
		function test_authenticate() {
			$this->assertFalse($this->m->_connected);
			$this->assertTrue($this->m->authenticate("afranco","afrancopassword"));
			$this->assertFalse($this->m->_connected);
			$this->assertTrue($this->m->authenticate("jdoe","jdoepassword"));
			$this->assertFalse($this->m->authenticate("gschine","notthepasswd"));
		}
		function test_getagentinfo() {
			$this->o->set("agentInformationFields",array("email"=>"user_email"
													,"firstname"=>"user_fname",
													"lastname"=>"user_lname"));
			$a = $this->m->getAgentInformation("gschine");
			$this->assertEqual(count($a),1);

			$this->assertEqual($a['gschine']['email'],"gschine@email.net");
			$this->assertEqual($a['gschine']['firstname'],"Gabriel");
			$this->assertEqual($a['gschine']['lastname'],'Schine');
		}
		function test_encrypted_passwd() {
			// we are only testing Database-driven MD5 encryption here.
			// the other two types supported: Database-driven SHA1 and
			// system-driven crypt() are not being tested.
			$this->o->set("passwordFieldEncrypted",true);
			$this->o->set("tableName","usermd5");
			$this->o->set("passwordFieldEncryptionType","databaseMD5");
			$this->m->_connect();
			var_dump($this->m->_getEncryptedPassword("gschine","pass"));
			$this->assertTrue($this->m->authenticate("gschine","gschinepassword"));
			$this->assertFalse($this->m->authenticate("afranco","weewee"));
		}
		
    }

?>