<?php
/**
 * @package  harmoni.gui.examples
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: sample_page2.php,v 1.8 2005/08/22 15:11:56 adamfranco Exp $
 */

// =============================================================================
// Load Harmoni stuff.
// =============================================================================

	define("LOAD_HIERARCHY", false);
	define("LOAD_STORAGE",false);
	define("LOAD_AUTHN",false);
	define("LOAD_AGENTINFORMATION", false);
	define("LOAD_DATAMANAGER", false);
	define("LOAD_AUTHN", false);
	define("LOAD_DR", false);
	define("LOAD_SETS", false);
	
	if (!defined('HARMONI')) {
	    require_once("../../../harmoni.inc.php");
	}
	
	$errorHandler =& Services::getService("ErrorHandler");

// =============================================================================
// Include all needed files.
// =============================================================================

	require_once(HARMONI."GUIManager/Themes/SimpleTheme1.class.php");

	require_once(HARMONI."GUIManager/Component.class.php");

	require_once(HARMONI."GUIManager/Components/Block.class.php");
	require_once(HARMONI."GUIManager/Components/Menu.class.php");
	require_once(HARMONI."GUIManager/Components/MenuItemHeading.class.php");
	require_once(HARMONI."GUIManager/Components/MenuItemLink.class.php");
	require_once(HARMONI."GUIManager/Components/Heading.class.php");
	require_once(HARMONI."GUIManager/Components/Footer.class.php");
	require_once(HARMONI."GUIManager/Container.class.php");

	require_once(HARMONI."GUIManager/Layouts/XLayout.class.php");
	require_once(HARMONI."GUIManager/Layouts/YLayout.class.php");
	require_once(HARMONI."GUIManager/Layouts/FlowLayout.class.php");
	
// =============================================================================
// Create some containers & components. This stuff would normally go in an action.
// =============================================================================

	// initialize layouts and theme
	$theme =& new SimpleTheme1();
	$xLayout =& new XLayout();
	$yLayout =& new YLayout();
	$flowLayout =& new FlowLayout();
	
	// now create all the containers and components
	$block1 =& new Container(new yLayout(), BLOCK, 1);
	
		$row1 =& new Container($yLayout, OTHER, 1);

			$header1 =& new Heading("A Harmoni GUI example.<br />Level-1 heading.\n", 1);

		$row1->add($header1, "100%", null, LEFT, CENTER);
		
			$menu1 =& new Menu($xLayout, 1);
			
				$menu1_item1 =& new MenuItemHeading("Main Menu:\n", 1);
				$menu1_item2 =& new MenuItemLink("Home", "http://www.google.com", true, 1);
				$menu1_item3 =& new MenuItemLink("Theme Settings", "http://www.middlebury.edu", false, 1);
				$menu1_item4 =& new MenuItemLink("Manage Themes", "http://www.cnn.com", false, 1);
			
			$menu1->add($menu1_item1, "125px", null, CENTER, CENTER);
			$menu1->add($menu1_item2, "125px", null, CENTER, CENTER);
			$menu1->add($menu1_item3, "125px", null, CENTER, CENTER);
			$menu1->add($menu1_item4, "125px", null, CENTER, CENTER);
			
		$row1->add($menu1, "500px");
		
	$block1->add($row1, "100%", null, RIGHT, BOTTOM);

		$row2 =& new Block("
			This is some text in a Level-2 text block.
			<p>Welcome to the <strong>Harmoni Architecture/Framework</strong> web site. The Harmoni Project is a joint effort
			between PHP Web/Database programmers located at <a href=\"http://et.middlebury.edu/\">Middlebury College's
			Educational Technology</a> department and the <a href=\"http://www.colleges.org/\">Associated Colleges
			of the South</a>. The project is built entirely using PHP's OOP (Object Oriented Programming) model, allowing
			the code to be easily extended and enhanced with no loss of functionality or backward-compatibility. Our
			programmers also document all their code with <strong>PHPDoc</strong> inline comments to make use of our API's a
			little easier for you.</p>\n", 2);
		
	$block1->add($row2, "100%", null, CENTER, CENTER);
	
		$row3 =& new Container($flowLayout, OTHER, 1);
					
			$menu2 =& new Menu($yLayout, 2);
			
				$menu2_item1 =& new MenuItemHeading("Sub-menu:\n", 1);
				$menu2_item2 =& new MenuItemLink("The Architecture", "http://www.google.com", true, 1);
				$menu2_item3 =& new MenuItemLink("The Framework", "http://www.middlebury.edu", false, 1);
				$menu2_item4 =& new MenuItemLink("Google: Searching", "http://www.cnn.com", false, 1);
				$menu2_item5 =& new MenuItemLink("Slashdot", "http://www.slashdot.org", false, 1);
				$menu2_item6 =& new MenuItemLink("Background Ex", "http://www.depechemode.com", false, 1);
			
			$menu2->add($menu2_item1, "100%", null, LEFT, CENTER);
			$menu2->add($menu2_item2, "100%", null, LEFT, CENTER);
			$menu2->add($menu2_item3, "100%", null, LEFT, CENTER);
			$menu2->add($menu2_item4, "100%", null, LEFT, CENTER);
			$menu2->add($menu2_item5, "100%", null, LEFT, CENTER);
			$menu2->add($menu2_item6, "100%", null, LEFT, CENTER);
			
		$row3->add($menu2, "150px", null, LEFT, TOP);
		
			$contributors =& new Block("
				<h2>
					Contributors
				</h2>
				
				<h3>
					Funding
				</h3>
				
				<p>
					Funding for the Harmoni Project is provided by both <a href=\"http://www.middlebury.edu/\">Middlebury College</a> and
					<a href=\"http://www.nitle.org/\">The NITLE Foundation</a>. We would all like to extend our deepest
					gratitude to both organizations for allowing us to continue working on that which we love. And yes, we
					are all big geeks.
				</p>
			
				<h3>
					Project Leaders
				</h3>
				
				<div class=\"person\">
					<strong>Gabe Schine</strong> - Middlebury College and Kenyon College
				</div>
				
				<div class=\"person\">
					<strong>Eric Jansson</strong> - Associated Colleges of the South
				</div>
			
				<h3>
					Developers
				</h3>
			
				<div class=\"person\">
					<strong>Adam Franco</strong> - Middlebury College
				</div>
			
				<div class=\"person\">
					<strong>Dobromir Radichkov</strong> - Middlebury College
				</div>
			
				<div class=\"person\">
					<strong>Kylie Verkest</strong> - Associated Colleges of the South
				</div>
				
				<div class=\"person\">
					<strong>Maksim Ovsjanikov</strong> - Middlebury College
				</div>", 3);

		$row3->add($contributors, "250px", null, LEFT, TOP);
				
			$stories =& new Container($flowLayout, OTHER, 1);
			
				$heading2_1 =& new Heading("The Architecture. Level-2 heading.", 2);
				
			$stories->add($heading2_1, "100%", null, CENTER, CENTER);
			
				$story1 =& new Block("	
	<p>
		Harmoni's architecture is built on a popular <strong>module/action</strong> model, in which your PHP program
		contains multiple <em>modules</em>, each of which contain multiple executable <em>actions</em>. All you,
		as an application developer, need to write are the action files (or classes, or methods, however you
		choose to do it). The following diagram gives a (simplified) example of the execution path/flow of
		a typical PHP program written under Harmoni:
	</p>", 2);
			
			$stories->add($story1, "100%", null, CENTER, CENTER);
			
				$heading2_2 =& new Heading("The Framework. Level-2 heading.", 2);
				
			$stories->add($heading2_2, "100%", null, CENTER, CENTER);
			
				$story2 =& new Block("	
					<p>
						Alongside the architecture, Harmoni offers a number of <strong>Services</strong>. The services are built with two
						goals: 1) to save you the time of writing the same code over and over again, and 2) to offer a uniform
						environment and abstraction layer between a specific function and the back-end implementation of that function.
						In simpler words, the File StorageHandler, for example, is used by your program by calling methods like
						<em>$storageHandler->store($thisFile, $here)</em>. Someone using your program can configure Harmoni
						to store that file in a database, on a filesystem, to make backups transparently, or store on a 
						mixture of databases and filesystems and other mediums. This allows your program, using the same 
						code, to store files in a very flexible manner, extending your audience and making for easier installation.
					</p>
					
					<p>
						A short list of the included Services follows:
					</p>
					
					<ul>
						<li><strong>DBHandler</strong> - an abstraction for database connections to various database backends, including: 
						<em>MySQL, PostreSQL, Oracle 8/9</em> and (soon) <em>Microsoft SQL Server</em>. Using an object-based Query Model,
						the same Queries can be sent to multiple databases without changing program code.</li>
						<li><strong>Authentication</strong> - allows for user authentication across multiple back-ends, completely
						transparent to your program. Back-ends include, but not limited to: <em>Local Database, LDAP, PAM</em>, planned
						to include: <em>IMAP, Kerberos, RADIUS, flat file</em> and others.</li>
						<li><strong>StorageHandler</strong> - allows for file storage across multiple mediums, with advances options including: 
						transparent backups, unix-like \"mount points\" for extending storage space to new locations.</li>
						<li><strong>DataManager</strong> - a combination of classes and database tables for efficient storage of meta data
						sets using customizable (on the fly) schemas. <strong>Very</strong> useful for application upgrades so your end user
						doesn't need to muck around with database tables, risking data corruption. Also includes optional version-controlled
						data storage, for those clients who enjoy rolling back to previous versions of their data.</li>
						<li><strong>ThemeHandler</strong> - a framework for outputting content separated from form, allowing both clients
						to change the look/feel of your program (if you choose to add that functionality), and allowing you to
						ignore form while developing your application and fine tune it later when your core functionality is completed.</li>
						<li><strong>OKI-compliant HierarchyManager</strong> - allows for easy maintenance of complex hierarchy trees, using
						interfaces provided by the <a href=\"http://www.sourceforge.net/projects/okiproject\">OKI OSIDs</a>.</li>
						<li><strong>OKI-compliant DigitalRepository</strong> - making use of the OKI HierarchyManager and our DataManager, 
						provides an implementation of the OKI Digital Repository, allowing for hierarchical meta data/object storage with
						version control/rollback features.</li>
						<li><strong>ErrorHandler</strong> - allows for easy tracking and output of program-level and user-level errors.</li>
						<li>other utilities - a number of useful classes providing convenient access to functionality we find
						useful. Examples include:
						<ul>
				
							<li>Output Template classes</li>
							<li>Data containers with on-the-fly data validation (useful for HTML form validation)</li>
							<li>Micro-timer, useful for timing the efficiency of your code</li>
							<li>RGB and HTML color class, useful for simple color manipulation (lightening, darkening, value shifting, etc)</li>
							<li>Simple statistics class</li>
						</ul></li>
					</ul>", 2);
			
			$stories->add($story2, "100%", null, CENTER, CENTER);
			
		$row3->add($stories, null, null, CENTER, TOP);
		
	$block1->add($row3, "100%", null, CENTER, CENTER);
	
		$row4 =& new Footer("Harmoni is Licenced under the GNU General Public License (GPL). Level-1 footer.", 1);
		
	$block1->add($row4, "100%", null, CENTER, CENTER);
	
		$row5 =& new Component("
	      	\n\n\t\t\t<a href=\"http://validator.w3.org/check/referer\"><img
	       	\n\n\t\t\tsrc=\"http://www.w3.org/Icons/valid-xhtml11\"
	        \n\n\t\t\talt=\"Valid XHTML 1.1!\" height=\"31\" width=\"88\" style=\"border: 0;\" /></a>
	        
	        \n\n\t\t\t<a href=\"http://jigsaw.w3.org/css-validator/check/referer\"><img
	       	\n\n\t\t\tsrc=\"http://jigsaw.w3.org/css-validator/images/vcss\"
	        \n\n\t\t\talt=\"Valid CSS!\" height=\"31\" width=\"88\" style=\"border:0;width:88px;height:31px;\" /></a>", OTHER, 1);

	$block1->add($row5, "100%", null, CENTER, CENTER);

	// use this to center the main block
	$wrapper =& new Container($xLayout, OTHER, 1);
	$wrapper->add($block1, "100%", null, CENTER, TOP);
	
	// print the page
	$theme->setComponent($wrapper);
	$theme->printPage();
	
	// instead of td with XLayout, tables one after another?

?>