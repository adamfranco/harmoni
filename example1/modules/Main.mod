<?php

	class Main {

		function getDefaultAction () {
			return "printContent";
		}
				
		function printContent (& $harmoni) {
			require_once ("harmoni/Layout.inc");
			require_once ("core/UIElements.inc");
			
			$context = $harmoni->getContext();

			$acs = new DisplayBox ();
			$nitle = new DisplayBox ();
			$harmoni = new DisplayBox ();
			$menu = new HorizontalMenu ();
			
			$acs->setContent ("<a href=\"http://colleges.org\" target=\"ACS\">ACS</a>");
			$nitle->setContent ("<a href=\"http://nitle.org\" target=\"NITLE\">NITLE</a>");
			$harmoni->setContent ("<a href=\"http://harmoni.sourceforge.net\" target=\"harmoni\">harmoni</a>");
			
			$item1 = new MenuItem ("About Subcloset", $context->getURL (array("module"=>"AboutSubcloset","action"=>""));
			$itme2 = new MenuItem ("Products", $context->getURL (array("module"=>"Products","action"=>""));
			$item3 = new MenuItem ("Support and Documentation", $context->getURL (array("module"=>"Support","action"=>""));
			$item4 = new MenuItem ("Discussion", $context->getURL (array("module"=>"Discussion", "action"=>""));
			$item5 = new MenuItem ("Contact", $context->getURL (array("module"=>"Contact","action"=>""));
			
			
			
			$layout = new Layout("main");
			$layout->addArea ("content", "hello world!");
			$layout->addArea ("links", "<p>".$acs->render()."</p><p>".$nitle->render()."</p><p>".$harmoni->render()."</p>");
			return $layout;
		}
	
	}
	
?>