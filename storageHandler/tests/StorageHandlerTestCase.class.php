<?php

require_once(HARMONI . 'storageHandler/StorageHandler.class.php');
require_once(HARMONI . "storageHandler/StorageMethods/DummyStorageMethod.class.php");

/**
* A single unit test case. This class is intended to test one particular
* class. Replace 'testedclass.php' below with the class you would like to
* test.
* 
* @version $Id: StorageHandlerTestCase.class.php,v 1.2 2003/07/04 01:38:12 gabeschine Exp $
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
	var $m,$er;
	function setUp()
	{
		$this->m = & new StorageHandler;
		Services::requireService("ErrorHandler");
		$er = & Services::getService("ErrorHandler");
		$er->setDebugMode(true);
		$this->er =& $er;
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
		$this->er->clearErrors();
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
	
	function test_backups_and_others() {
		$this->m->addMethod(new DummyStorageMethod, "/");				// id=0
		$this->m->addMethod(new DummyStorageMethod, "/test");			// id=1
		$this->m->addMethod(new DummyStorageMethod, "/test/crap/stuff");// id=2
		
		$this->er->clearErrors();
		print "<BR><B>THERE SHOULD BE A FATAL ERROR BELOW</b><BR>";
		$this->m->addBackupMethod(new DummyStorageMethod, "/no_primary", MIRROR_SHALLOW);
		$this->er->clearErrors();
		
		$this->m->addBackupMethod(new DummyStorageMethod, "/", MIRROR_DEEP); // id=3
		$this->assertEqual($this->m->_getBackupsForPath("/"), array(3));
		
		$this->m->addBackupMethod(new DummyStorageMethod,"/test/crap/stuff",MIRROR_SHALLOW); // id=4
		$this->assertEqual($this->m->_getBackupsForPath("/"), array(3));
		$this->assertEqual($this->m->_getBackupsForPath("/test/crap/stuff/more/stuff/"), array(4,3));
		// we now have primaries for /, /test/ and /test/crap/stuff/
		// and backups for / (which is deep), and a shallow one for /test/crap/stuff/
		
		$file =& new DummyStorable("/a/folder","test1.txt","Backed-up content!");
		// when we store the above file, it should appear on id 0 and 3.
		$this->m->store($file,"/a/folder","test1.txt");
		$this->assertEqual($this->m->_methods[0]->getCount("/",true),1);
		$this->assertEqual($this->m->_methods[1]->getCount("/",true),0);
		$this->assertEqual($this->m->_methods[2]->getCount("/",true),0);
		$this->assertEqual($this->m->_methods[3]->getCount("/",true),1);
		$this->assertEqual($this->m->_methods[4]->getCount("/",true),0);
		
		$storable =& $this->m->retrieve("/a/folder","test1.txt");
		$this->assertEqual($storable->getData(),"Backed-up content!");
		
		// now let's delete the file on the primary.
		$this->m->_methods[0]->delete("/a/folder/","test1.txt");
		$this->assertEqual($this->m->_methods[0]->getCount("/",true),0);
		// the file won't even show up on a StorageHandler->getCount();
		$this->assertEqual($this->m->getCount("/",true),0);
		
		// but we should still be able to recieve it
		$backedup =& $this->m->retrieve("/a/folder","test1.txt");
		$this->assertTrue(is_object($backedup));
		$this->assertEqual($backedup->getData(),"Backed-up content!");
		$this->assertTrue($this->m->exists("/a/folder","test1.txt"));
		// yee-haw!
		
		// now let's try deep backups
		$this->m->store($file,"/test/crap/stuff/more","test2.txt");
		$this->assertEqual($this->m->getCount("/",false),0);
		$this->assertEqual($this->m->getCount("/test/crap/stuff/more",false),1);
		$this->assertEqual($this->m->getCount("/test/crap/stuff",false),0);
		$this->assertEqual($this->m->getCount("/test/crap/stuff",true),1);
		$this->assertEqual($this->m->getCount("/",true),1);
		
		// let's test the listinpath stuff
		$list = $this->m->listInPath("/");
		$this->assertEqual(count($list),0);
		$list = $this->m->listInPath("/",true);
		$this->assertEqual(count($list),2);
		
		// now let's REMOVE the file from... well, the primary. (id 2)
		// it's on backups 3 (deep) and 4 (shallow)
		$this->m->_methods[2]->delete("/more/","test2.txt");
		$this->assertEqual($this->m->getCount("/test/",true),0);
		$backup =& $this->m->retrieve("/test/crap/stuff/more","test2.txt");
		$this->assertTrue(is_object($backup));
		$this->assertEqual($backup->getPath(),"/test/crap/stuff/more/");
		$this->assertEqual($backup->getName(),"test2.txt");
		$this->assertEqual($backup->getData(),"Backed-up content!");
		unset($backup);
		
		// now remove it from one of the backups.. the shallow one
		$this->m->_methods[4]->delete("/more/","test2.txt");
		$backup =& $this->m->retrieve("/test/crap/stuff/more","test2.txt");
		$this->assertTrue(is_object($backup));
		$this->assertEqual($backup->getPath(),"/test/crap/stuff/more/");
		$this->assertEqual($backup->getName(),"test2.txt");
		$this->assertEqual($backup->getData(),"Backed-up content!");
		
		// and now from the deep as well.
		$this->m->_methods[3]->delete("/test/crap/stuff/more/","test2.txt");
		$this->assertFalse($this->m->retrieve("/test/crap/stuff/more","test2.txt"));
		
		// now let's just test a delete recursive
		$this->m->deleteRecursive("/");
		$this->m->store($backup, "/dir1/","file1.txt");
		$this->m->store($backup, "/dir1/dir12","file1.txt");
		$this->m->store($backup, "/dir1/dir12/","file2.txt");
		$this->m->store($backup, "/dir2/","file1.txt");
		$this->m->store($backup, "/dir3/","file1.txt");
		$this->m->store($backup, "/dir1/dir13/","file1.txt");
		$this->assertEqual($this->m->getCount("/",false),0);
		$this->assertEqual($this->m->getCount("/",true),6);
		$this->assertEqual(count($this->m->listInPath("/",true)),6);
		
		// before we go ahead and delete -- let's test getSizeOf
		$this->assertEqual($this->m->getSizeOf("/dir1/","file1.txt"),18);
		$this->assertEqual($this->m->getSizeOf("/dir1/dir12"),18*2);
		$this->assertEqual($this->m->getSizeOf("/dir1/"),18*4);
		$this->assertEqual($this->m->getSizeOf("/"),18*6);
		
		$this->m->deleteRecursive("/dir1/dir12");
		$this->assertEqual($this->m->getCount("/",true),4);
		$this->m->deleteRecursive("/dir1/");
		$this->assertEqual($this->m->getCount("/",true),2);
		$this->m->deleteRecursive("/dir2");
		$this->assertEqual($this->m->getCount("/",true),1);
		$this->m->deleteRecursive("/dir3");
		$this->assertEqual($this->m->getCount("/",true),0);
	}
	
	function test_move_copy() {
		$this->m->addMethod(new DummyStorageMethod, "/");				// id=0
		$this->m->addMethod(new DummyStorageMethod, "/test");			// id=1
		$this->m->addMethod(new DummyStorageMethod, "/test/crap/stuff");// id=2
		$this->m->addBackupMethod(new DummyStorageMethod, "/", MIRROR_DEEP); // id=3
		$this->m->addBackupMethod(new DummyStorageMethod,"/test/crap/stuff",MIRROR_SHALLOW); // id=4
		
		$backup =& new DummyStorable("/a/folder","test1.txt","Some stupid content!");
		
		$this->m->store($backup, "/dir1/","file1.txt");
		$this->m->store($backup, "/dir1/dir12","file1.txt");
		$this->m->store($backup, "/dir1/dir12/","file2.txt");
		$this->m->store($backup, "/dir2/","file1.txt");
		$this->m->store($backup, "/dir3/","file1.txt");
		$this->m->store($backup, "/dir1/dir13/","file1.txt");
		
		$this->assertTrue($this->m->exists("/dir1","file1.txt"));
		$this->m->move("/dir1","file1.txt","/","rootfile.txt");
		$this->assertFalse($this->m->exists("/dir1","file1.txt"));
		$this->assertTrue($this->m->exists("/","rootfile.txt"));
		
		$this->assertTrue($this->m->exists("/dir2","file1.txt"));
		$this->m->copy("/dir2","file1.txt","/","rootfile2.txt");
		$this->assertTrue($this->m->exists("/dir2","file1.txt"));
		$this->assertTrue($this->m->exists("/","rootfile2.txt"));
	}
}

?>