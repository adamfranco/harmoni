<?php


/**
*  Since the assert methods we have don't really support iterators, these 
* methods are mostly designed to test OKI objects in iterators.  There are
* a few other useful methods.
*
*
* @copyright Copyright &copy; 2006, Middlebury College
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
*
* @version $Id: oki_simple_unit.php,v 1.5 2006/12/12 17:18:18 adamfranco Exp $
*/

 if (!defined("SIMPLE_TEST")) {
        define("SIMPLE_TEST", "./");
    }
    require_once(SIMPLE_TEST . 'simple_test.php');


   class OKIUnitTestCase extends UnitTestCase{
   	
   
	
		
		
		
		
		//@TODO  currently assumes the types are not null
		function assertNotEqualTypes(&$typeA, &$typeB) {  
			if(!$typeA->isEqual($typeB)){
				$this->assertTrue(true);
			}else{
				$this->assertTrue(false);
				print "<p align=center><font size=4 color=#FF2200>The Types are equal: '".$typeA->getDomain()."'::'".$typeA->getAuthority()."'::'".$typeA->getKeyword()."' but <b>should NOT</b> be equal </font></p>\n";
			}
		}
		
		function assertEqualTypes(&$typeA,&$typeB){
			
			//parameter validation
			ArgumentValidator::validate($typeA, ExtendsValidatorRule::getRule("Type"), true);
			ArgumentValidator::validate($typeB, ExtendsValidatorRule::getRule("Type"), true);
			
			if(is_null($typeA)){
				$this->assertTrue(is_null($typeB));
				if(!is_null($typeB)){
					print "<p align=center><font size=4 color=#FF2200>The Type '".$typeA->getDomain()."'::'".$typeA->getAuthority()."'::'".$typeA->getKeyword()."' is not equal to null </font></p>\n";					
				}
				return;
			}
			if(is_null($typeB)){
				print "<p align=center><font size=4 color=#FF2200>Null is not equal to Type '".$typeA->getDomain()."'::'".$typeA->getAuthority()."'::'".$typeA->getKeyword()."'</font></p>\n";					
				
				return;
				
			}
			
			$this->assertTrue($typeA->isEqual($typeB));
			if($typeA->getDomain()!=$typeB->getDomain()){
				print "<p align=center><font size=4 color=#FF2200>The domains '".$typeA->getDomain().
				"' and '".$typeB->getDomain()."'  <b>should</b> be equal </font></p>\n";
			}
			if($typeA->getAuthority()!=$typeB->getAuthority()){
				print "<p align=center><font size=4 color=#FF2200>The domains '".$typeA->getAuthority().
				"' and '".$typeB->getAuthority()."'  <b>should </b> be equal </font></p>\n";
			}
			if($typeA->getKeyword()!=$typeB->getKeyword()){
				print "<p align=center><font size=4 color=#FF2200>The domains '".$typeA->getKeyword().
				"' and '".$typeB->getKeyword()."'  <b>should </b> be equal </font></p>\n";
			}
			
		}
		
		function assertEqualIds(&$idA,&$idB){
			
			
			//parameter validation
			ArgumentValidator::validate($idA, ExtendsValidatorRule::getRule("Id"), true);
			ArgumentValidator::validate($idB, ExtendsValidatorRule::getRule("Id"), true);
			
		
			if($idA->isEqual($idB)){
				$this->assertTrue(true);
			}else{
				$this->assertTrue(false);
				print "<p align=center><font size=4 color=#FF2200>The Ids with strings '".$idA->getIdString()."' and '".$idB->getIdString()."' are not equal but <b>should</b> be. </font></p>\n";
			}
			
		}
		
		//currently assumes the ids are not null
		function assertNotEqualIds(&$idA,&$idB){
			
			
			//parameter validation
			ArgumentValidator::validate($idA, ExtendsValidatorRule::getRule("Id"), true);
			ArgumentValidator::validate($idB, ExtendsValidatorRule::getRule("Id"), true);
			
			
			if($idA->isEqual($idB)){
				$this->assertFalse(true);
				print "<p align=center><font size=4 color=#FF4444>The Ids with strings '".$idA->getIdString()."' and '".$idB->getIdString()."' <b>should NOT</b> be equal. </font></p>\n";
			}else{
				$this->assertFalse(false);
				
			}
			
		}
		
		//currently assumes the ids are not null
		function assertHaveEqualIds(&$thingA,&$thingB){
			
			
			$idA =& $thingA->getId();
			$idB =& $thingB->getId();
			
			if($idA->isEqual($idB)){
				$this->assertTrue(true);
			}else{
				$this->assertTrue(false);
				print "<p align=center><font size=4 color=#FF2200>'".$thingA->getDisplayName()."'[".$idA->getIdString()."] should equal 
				'".$thingB->getDisplayName()."'[".$idB->getIdString()."].";
			}
	
		}
		
		
		function write($size, $text){
			
			print "<p align=center><font size=".$size." color=#8888FF>".$text."</font></p>\n";
			
			
		} 
		
		
		//This method only works if the items have a getDisplayName() method.
		//Relies extensively on weak typing
		
		
		function iteratorHas($iter, $name){
			//this relies on usage of the HarmoniIterator
			$iter->_i=-1;
			/*$bool=false;
			print "(";
			while($iter->hasNext()){
				
					$item =& $iter->next();
				print $item->getDisplayName().",";
					if($name == $item->getDisplayName()){
						$bool=true;;
					}
					
				}
			print ")";
			print "has ".$name."? --> ".$bool;
				return $bool;*/
			
				while($iter->hasNext()){
					//$am =& Services::GetService("AgentManager");
					$item =& $iter->next();
					if($name == $item->getDisplayName()){
						return true;
					}
				}
				return false;
		}
		
		function primitiveIteratorHas($iter, $goal){
			//this relies on usage of the HarmoniIterator
			$iter->_i=-1;
			
				while($iter->hasNext()){
					//$am =& Services::GetService("AgentManager");
					$item =& $iter->next();
					if($goal === $item){
						return true;
					}
				}
				return false;
		}
		
		
		
		
		function stringIteratorHas($iter, $string){
				//this relies on usage of the HarmoniIterator
				$iter->_i=-1;
				while($iter->hasNextString()){
					$item = $iter->nextString();
					if($item===$string){						
						return true;
					}
				}
				return false;
		}
		
		
		function idIteratorHas($iter, $id){
				//this relies on usage of the HarmoniIterator
				$iter->_i=-1;
				while($iter->hasNextId()){
					$item =& $iter->nextId();
					if($item->isEqual($id)){						
						return true;
					}
				}
				return false;
		}
		
		//hiLARious.  Evaulates the parameter.
		function assertDoesNotCrashTheSystem($ignore){
			$this->assertTrue(true);
		}
		
		function typeIteratorHas($iter, $type){
				//this relies on usage of the HarmoniIterator
				$iter->_i=-1;
				while($iter->hasNext()){
					$item =& $iter->next();
					if($item->isEqual($type)){						
						return true;
					}
				}
				return false;
		}
		
		
		function assertIteratorLacksItemWithId($iter, $theItem){
				//this relies on usage of the HarmoniIterator
				$iter->_i=-1;
				$id =& $theItem->getId();
				while($iter->hasNext()){
					$item =& $iter->next();
					if($id->isEqual($item->getId())){						
						$this->assertFalse(true);
						print "<p align=center><font size=4 color=#FF0044> Iterator should not have '".$theItem->getDisplayName()."'[".$id->getIdString()."] but...</font></p>";
						$this->printIterator($iter);
						return;
					}
				}
				$this->assertFalse(false);		
		}
		
		function assertIteratorHasItemWithId($iter, $theItem){
				//this relies on usage of the HarmoniIterator
				$iter->_i=-1;
				$id =& $theItem->getId();
				while($iter->hasNext()){
					$item =& $iter->next();
					if($id->isEqual($item->getId())){						
						$this->assertTrue(true);
						return;
					}
				}
				$this->assertTrue(false);	
				print "<p align=center><font size=4 color=#FF0044> Iterator should have '".$theItem->getDisplayName()."'[".$id->getIdString()."] but...</font></p>";
				$this->printIterator($iter);
					
		}
		
		function printIterator($iter){
			//this relies on usage of the HarmoniIterator
			$iter->_i=-1;
				print "<p align=center><font size=4 color=#88FF66> Iterator contains: {";
				$first = true;
				while($iter->hasNext()){					
					$item =& $iter->next();
					if(!$first){
						print ", ";
					}
					$id =& $item->getId();
					print "'".$item->getDisplayName()."'[".$id->getIdString()."]";
					$first=false;
				}
				print "}</font></p>\n";		
		}
   	
   	
    }
?>