<?php

require_once(HARMONI.'authenticationHandler/methods/LDAPAuthenticationMethod.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: LDAPAuthenticationMethodTestCase.class.php,v 1.2 2005/01/19 16:32:56 adamfranco Exp $
 * @copyright 2003 
 **/

    class LDAPAuthenticationMethodTestCase extends UnitTestCase {
	
		function LDAPAuthenticationMethodTestCase() {
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
			$o = & new LDAPMethodOptions;
			$o->set("LDAPHost","jaguar.middlebury.edu");
			$o->set("baseDN","ou=Midd,o=MC");
			$o->set("userDNSuffix","cn=midd");
			
			// bindDN can be blank or a username
			// if it is a username, then searches can be done where that user has priveleges.
			// an example of bindDB is "cn=afranco,cn=midd"
			$o->set("bindDN","");
			$o->set("bindDNPassword","");			
			$o->set("usernameField","uid");
			$o->set("agentInformationFields",array("fullname"=>"cn"
													,"email"=>"mail",
													"idnumber"=>"extension-attribute-1",
													"memberof"=>"memberof"));
			$this->m = &new LDAPAuthenticationMethod($o);
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
			$this->assertFalse($this->m->_conn);
			$this->m->_connect();
			$this->assertTrue($this->m->_conn);
			$this->m->_disconnect();
			$this->assertFalse($this->m->_conn);
		}
		
		function aaa_getDN() {
			$this->m->_connect();
	//		print "DN: ".$this->m->_getDN("afranco");
			$this->assertTrue(true);
			$this->m->_disconnect();
		}
		
		function test_agent_exists() {
			$this->assertFalse($this->m->agentExists("blablastupid"));
			$this->assertTrue($this->m->agentExists("afranco"));
		}
		
		function test_authenticate() {
			$this->assertFalse($this->m->_conn);
			// works, but needs a valid password.
//			$this->assertTrue($this->m->authenticate("gschine",""));
			$this->assertFalse($this->m->_conn);
		}
		
		function test_getagentinfo() {
			$a = $this->m->getAgentInformation("afranco");
//			print_r($a);
			$this->assertEqual($a['afranco']['email'],"afranco@middlebury.edu");
			$this->assertEqual($a['afranco']['fullname'],"Franco, Adam");
		}
		
    }

?>