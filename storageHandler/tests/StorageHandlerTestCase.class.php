<?php

require_once(HARMONI . 'storageHandler/StorageHandler.class.php');
require_once(HARMONI . "storageHandler/StorageMethods/DummyStorageMethod.class.php");

/**
* A single unit test case. This class is intended to test one particular
* class. Replace 'testedclass.php' below with the class you would like to
* test.
* 
* @version $Id: StorageHandlerTestCase.class.php,v 1.1 2003/07/03 18:03:20 gabeschine Exp $
* @copyright 2003
*/

class StorageHandlerTestCase extends UnitTestCase {
	function StorageHandlerTestCase()
	{
		$this->UnitTestCase();
	}

	/**
	* Sets up unit test wide variables at the start
	*     of each test method.
	* 
	* @public 
	*/
	var $m;
	function setUp()
	{
		$this->m = & new StorageHandler;
		Services::requireService("ErrorHandler");
		$er = & Services::getService("ErrorHandler");
		$er->setDebugMode(true);
	}

	/**
	* Clears the data set in the setUp() method call.
	* 
	* @public 
	*/
	function tearDown()
	{ 
		// perhaps, unset $obj here
	}

	/**
	* First test Description.
	*/
	function test_path_functions()
	{
		$path = "/path/to/something";
		$this->m->_checkPath($path);
		$this->assertEqual($path, "/path/to/something/");
		$path = "path/to";
		$this->m->_checkPath($path);
		$this->assertEqual($path,"/path/to/");

		$this->m->_chopPath($path);
		$this->assertEqual($path, "/path/to");

		$path = "/";
		$this->m->_chopPath($path);
		$this->assertEqual($path, "/");

		$this->assertEqual($this->m->_getLevel("/"), 0);
		$this->assertEqual($this->m->_getLevel("/onedir"), 1);
		$this->assertEqual($this->m->_getLevel("/onedir/twodir/"), 2);
		$this->assertEqual($this->m->_getLevel("/onedir/twodir/threedir"), 3);
	}

	function test_check_methods()
	{
		print "<BR><b>*** THERE SHOULD BE A FATAL ERROR BELOW ***</b><BR>";
		$this->m->_checkMethods();
	}

	function test_add_method()
	{

		$this->assertFalse($this->m->_hasPrimary('/'));
		$this->assertFalse($this->m->_hasPrimary('/test/'));
		
		$this->assertFalse($this->m->_pathDefined('/'));
		$this->m->addMethod(new DummyStorageMethod, "/");
		$this->assertTrue($this->m->_pathDefined('/'));
		
		$this->m->addMethod(new DummyStorageMethod,"/test");
		$this->assertTrue($this->m->_pathDefined('/test/'));
		
		$this->assertTrue($this->m->_hasPrimary('/'));
		$this->assertTrue($this->m->_hasPrimary('/test/'));
		
		$this->assertEqual($this->m->_getIDs('/'),array(0));
		$this->assertEqual($this->m->_getIDs('/test/'),array(1));
		
		$this->assertEqual($this->m->_getPrimaryForPath('/'),0);
		$this->assertEqual($this->m->_getPrimaryForPath('/testtwo/'),0);
		$this->assertEqual($this->m->_getPrimaryForPath('/more/stuff/'),0);
		$this->assertEqual($this->m->_getPrimaryForPath('/test/'),1);
		$this->assertEqual($this->m->_getPrimaryForPath('/test/more/'),1);
		
		$this->assertEqual($this->m->_findDefinedMethodsBelow('/'),array(1));
		$this->assertEqual($this->m->_findDefinedPathsBelow('/'),array("/test/"));
		
		$this->assertEqual($this->m->_getBackupsForPath('/'),array());
		$this->assertEqual($this->m->_getBackupsForPath('/test/'),array());
		
		$this->assertEqual($this->m->_translatePathForMethod(1,"/test/more/crap/"),"/more/crap/");
		$this->assertEqual($this->m->_translatePathForMethod(0,"/"),'/');
		$this->assertEqual($this->m->_translatePathForMethod(0,"/hopeful/poo/"),'/hopeful/poo/');
		$this->assertEqual($this->m->_translatePathForMethod(1,"/"),"/");
	}
	
	function test_store () {
		$this->m->addMethod(new DummyStorageMethod, "/");
		$this->m->addMethod(new DummyStorageMethod, "/test");
		$this->m->addMethod(new DummyStorageMethod, "/test/crap/stuff");
		
		$this->assertFalse($this->m->exists('/'));
		$this->assertFalse($this->m->exists("/","test1.txt"));
		$file =& new DummyStorable("/","test1.txt","This is test1!");
		$this->m->store($file,"/","test1.txt");
		$this->assertTrue($this->m->exists("/","test1.txt"));
		$this->assertTrue($this->m->exists("/"));
		
		$storable=& $this->m->retrieve("/","test1.txt");
		$this->assertFalse($this->m->retrieve("/","nofile.txt"));
		$this->assertEqual($storable->getSize(),14);
		$this->assertEqual($storable->getName(),"test1.txt");
		$this->assertEqual($storable->getPath(),"/");
		$this->assertEqual($storable->getData(),"This is test1!");
		
		$file2 =& new DummyStorable("/test/","test2.txt","This is test2!");
		$this->assertFalse($this->m->exists('/test'));
		$this->assertFalse($this->m->exists("/test/","test2.txt"));
		$this->m->store($file2,"/test","test2.txt");
		$this->assertTrue($this->m->exists("/test","test2.txt"));
		
		$this->assertEqual(count($this->m->listInPath("/")),1);
		
		$this->assertTrue(count($this->m->_methods[0]->_files),1);
		$this->assertTrue(count($this->m->_methods[1]->_files),1);
		$this->assertEqual($this->m->getCount("/"),1);
		$this->assertEqual($this->m->getCount("/test"),1);
		$this->assertEqual($this->m->getCount("/test/crap"),0);
		$this->assertEqual($this->m->getCount("/test/crap/stuff"),0);
		$this->assertEqual($this->m->getCount("/",true),2);
	}
}

?>