<?php

require_once(HARMONI.'authenticationHandler/methods/LDAPMethodOptions.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: LDAPMethodOptionsTestCase.class.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
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
			$this->opt = & new LDAPMethodOptions;
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
			$o->set("LDAPHost","jaguar.middlebury.edu");
			$this->assertEqual($o->get("LDAPHost"),"jaguar.middlebury.edu");
			$o->set("baseDN","ou=Midd,o=MC");
			$this->assertEqual($o->get("baseDN"),"ou=Midd,o=MC");
			
			// bindDN can be blank or a username
			// if it is a username, then searches can be done where that user has priveleges.
			// an example of bindDB is "cn=afranco,cn=midd"
			$o->set("bindDN","cn=afranco,cn=midd");
			$this->assertEqual($o->get("bindDN"),"cn=afranco,cn=midd");
			$o->set("bindDNPassword","testpassword");
			$this->assertEqual($o->get("bindDNPassword"),"testpassword");
			
			$o->set("usernameField","uid");
			$this->assertEqual($o->get("usernameField"),"uid");
			$o->set("agentInformationFields",array("fullname"=>"cn"
													,"email"=>"mail",
													"idnumber"=>"extension-attribute-1",
													"memberof"=>"memberOf"));
			$this->assertEqual($o->get("agentInformationFields"),array("fullname"=>"cn"
													,"email"=>"mail",
													"idnumber"=>"extension-attribute-1",
													"memberof"=>"memberOf"));
		}
		
    }

?>