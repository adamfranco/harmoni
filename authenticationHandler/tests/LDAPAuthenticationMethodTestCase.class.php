<?php

require_once(HARMONI.'authenticationHandler/methods/LDAPAuthenticationMethod.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: LDAPAuthenticationMethodTestCase.class.php,v 1.3 2003/06/30 20:54:23 adamfranco Exp $
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
			$o->set("bindDN","cn=fjones,cn=midd");
			$o->set("bindDNPassword","lk87df");			
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
		 
		function test_aaa_connect_disconnect() {
			$this->assertFalse($this->m->_conn);
			$this->m->_connect();
			$this->assertTrue($this->m->_conn);
			$this->m->_disconnect();
			$this->assertFalse($this->m->_conn);
		}
		
		function test_agent_exists() {
			$this->assertFalse($this->m->agentExists("blablastupid"));
			$this->assertTrue($this->m->agentExists("afranco"));
		}
		
		function test_authenticate() {
			$this->assertFalse($this->m->_conn);
			$this->assertTrue($this->m->authenticate("afranco",""));
			$this->assertFalse($this->m->_conn);
		}
		
		function test_getagentinfo() {
			$a = $this->m->getAgentInformation("afranco");
			print_r($a);
			$this->assertEqual(count($a),3);
			$this->assertEqual($a['email'],"afranco@middlebury.edu");
			$this->assertEqual($a['fullname'],"Franco, Adam");
		}
		
    }

?>