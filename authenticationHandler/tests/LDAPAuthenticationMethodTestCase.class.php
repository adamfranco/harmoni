<?php

require_once(HARMONI.'authenticationHandler/methods/LDAPAuthenticationMethod.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: LDAPAuthenticationMethodTestCase.class.php,v 1.2 2003/06/30 20:40:42 adamfranco Exp $
 * @copyright 2003 
 **/

    class LDAPAuthenticationMethodTestCase extends UnitTestCase {
	
		function LDAPAuthenticationMethodTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		var $m;
		var $o;
		function setUp() {
			$o = & new LDAPMethodOptions;
			$o->set("LDAPHost","jaguar.middlebury.edu");
			$o->set("baseDN","ou=Midd,o=MC");
			
			// bindDN can be blank or a username
			// if it is a username, then searches can be done where that user has priveleges.
			// an example of bindDB is "cn=afranco,cn=midd"
//			$o->set("bindDN","cn=afranco,cn=midd");
//			$o->set("bindDNPassword","testpassword");			
			$o->set("usernameField","uid");
			$o->set("agentInformationFields",array("fullname"=>"cn"
													,"email"=>"mail",
													"idnumber"=>"extension-attribute-1",
													"memberof"=>"memberOf"));
			$this->m = &new LDAPAuthenticationMethod($o);
			$this->o = &$o;
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			unset($this->m);
		}
	
		/**
		 *    First test Description
		 */ 
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
			$this->assertEqual(count($a),3);
			$this->assertEqual($a['email'],"gschine@email.net");
			$this->assertEqual($a['firstname'],"Gabriel");
			$this->assertEqual($a['lastname'],'Schine');
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