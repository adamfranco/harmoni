<?php

/**
*
*GUIManager.class.php nikthegreek
*@author Middlebury College, ETS
*@copyright 2004 Middlebury College, ETS
*@access public
**/
require_once(HARMONI."GUIManager/Theme.class.php");

require_once(HARMONI."GUIManager/StyleCollection.class.php");

require_once(HARMONI."GUIManager/StyleProperties/BackgroundColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderTopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderRightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderBottomSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderLeftSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontSizeSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontWeightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TextAlignSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TextDecorationSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/DisplaySP.class.php");
require_once(HARMONI."GUIManager/Themes/GenericTheme.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontFamilySP.class.php");


class GUIManager {
	
	
	var $_theme;
	
	var $_dbHandler;
	
	var $_dbIndex;
	

	function GUIManager($dbIndex) {
		
		
		$this->_dbIndex = $dbIndex;
		
		
		Services::requireService("DBHandler");
		$this->_dbHandler =& Services::getService("DBHandler");
		
		
		
		if(!$this->_dbHandler->isConnected($this->_dbIndex))
             $this->_dbHandler->pConnect($this->_dbIndex);
		
        //$this->_theme = null;
	}
	
	
	
	function getTheme($themeId){
		
             
        $query =& new SelectQuery;
        $query->addTable("StyleCollections");
		$query->addColumn("styleCollection_id");
		$query->addColumn("selector");
		$query->addColumn("classSelector");
		$query->addColumn("displayName");
		$query->addColumn("description");
		$query->addColumn("componentType");
		$query->addColumn("componentIndex");
		$query->addWhere("fk_theme_id= $themeId");
		
		$styleCollectionsTableResult =& $this->_dbHandler->query($query, $this->_dbIndex);
		//print $styleCollectionsTableResult->getNumberOfRows();
		$this->_theme =& new GenericTheme;
		while($styleCollectionsTableResult->hasMoreRows()){ 
			
			$array = $styleCollectionsTableResult->getCurrentRow();
			$styleProperties = $this->getStyleProperties($array["styleCollection_id"]);
			$styleCollection =& new StyleCollection($array["selector"],$array["classSelector"], $array["displayName"], $array["description"]);
			
			
			$styleCollection =& new StyleCollection($array["selector"],$array["classSelector"], $array["displayName"], $array["description"]);
			foreach ($styleProperties as $key => $value) {
			$sp = $key;
			$sc = $value;
			$string ="";
			foreach ($sc as $value1){
				if($value!="")
				$string.="'".$value1."',";
			}
			$string = rtrim($string,","); 
			$string2= "\$obj =& new ".$sp."(".$string.");";
			//used for debugging
			//print $string2;
			eval($string2);
			$styleCollection->addSP($obj);	
			
		}
			
			
			if($array["classSelector"]==""){
					$this->_theme->addGlobalStyle($styleCollection);
			}
			else 
					$this->_theme->addStyleForComponentType($styleCollection, $array["componentType"], $array["componentIndex"]);
			
			
			$styleCollectionsTableResult->advanceRow();
				
			
			
		}
		
	return $this->_theme;
		}
	
	
	
		
		
	
	
	
	function getStyleProperties($styleCollectionId){
		
		$query =& new SelectQuery;
        $query->addTable("StyleProperties");
		$query->addColumn("styleProperty_id");
		$query->addColumn("styleProperty");
		$query->addWhere("fk_styleCollection_id=$styleCollectionId");
		
		$stylePropertiesTableResult =& $this->_dbHandler->query($query, $this->_dbIndex);
		
		if($stylePropertiesTableResult->getNumberOfRows()==0){
			return array();
		}
		else{
		
		$propertiesArray = array();
		
		while($stylePropertiesTableResult->hasMoreRows()){
			
			$array = $stylePropertiesTableResult->getCurrentRow();
			$styleComponent = $this->getStyleComponents($array["styleProperty_id"]);
			$styleProperty = $array["styleProperty"];
			$propertiesArray[$styleProperty] = $styleComponent;
			$stylePropertiesTableResult->advanceRow();
		
		}
		
		return $propertiesArray;
		}
	
	}
	
	
	function getStyleComponents($stylePropertyId){
		
		
		$query =& new SelectQuery;
        $query->addTable("StyleComponents");
		$query->addColumn("styleComponent_id");
		$query->addColumn("styleComponent");
		$query->addWhere("fk_styleProperty_id=$stylePropertyId");
		$query->addOrderBy("argsorder");
		
		$styleComponentsTableResult =& $this->_dbHandler->query($query, $this->_dbIndex);
		
		$componentsArray = array();
		while($styleComponentsTableResult->hasMoreRows()){
		$array=$styleComponentsTableResult->getCurrentRow();
		$componentsArray[]=$array["styleComponent"];
		$styleComponentsTableResult->advanceRow();
		}
		
		return $componentsArray;
		
		//use order by and modify the database
		
		}
		
		
		
		function updateStyleComponent($themeId, $selector, $styleProperty, $styleComponentType, $value)
		{
			
			$query=& new SelectQuery;
			$query->addTable("StyleCollections");
			$query->addTable("StyleProperties", LEFT_JOIN, "StyleCollections.styleCollection_id=StyleProperties.fk_styleCollection_id");
			$query->addTable("StyleComponents", LEFT_JOIN, "StyleProperties.styleProperty_id=StyleComponents.fk_styleProperty_id");
			$query->addColumn("StyleComponents.styleComponent_id");
			$query->addWhere("StyleCollections.fk_theme_id=$themeId");
			$query->addWhere("StyleCollections.selector='$selector'");
			$query->addWhere("StyleProperties.styleProperty='$styleProperty'");
			$query->addWhere("StyleComponents.styleComponentType='$styleComponentType'");
			
		
			$styleComponentResult =& $this->_dbHandler->query($query, $this->_dbIndex);
			$styleComponentArray =$styleComponentResult->getCurrentRow();
			$styleComponent_id =$styleComponentArray["styleComponent_id"];
			
			
			
			$this->updateStyleComponentWithId($styleComponent_id, $value);
}
		

		function updateStyleComponentWithId($id, $value){
			
			$query =& new UpdateQuery;
			$query->setTable("StyleComponents");
			$query->setColumns(array("styleComponent"));
			$query->setValues(array("'$value'"));
			$query->addWhere("styleComponent_id=$id");
			$this->_dbHandler->query($query, $this->_dbIndex);
		}
		
		
		function createStyleComponent($themeId, $selector, $styleProperty,$styleComponentType, $order, $value)
		{
			$query=& new SelectQuery;
			$query->addTable("StyleCollections");
			$query->addTable("StyleProperties", LEFT_JOIN, "StyleCollections.styleCollection_id=StyleProperties.fk_styleCollection_id");
			$query->addColumn("StyleProperties.styleProperty_id");
			$query->addWhere("StyleCollections.fk_theme_id=$themeId");
			$query->addWhere("StyleCollections.selector='$selector'");
			$query->addWhere("StyleProperties.styleProperty='$styleProperty'");
			
			
			$stylePropertyIdResult =& $this->_dbHandler->query($query, $this->_dbIndex);
			$stylePropertyIdArray =$stylePropertyIdResult->getCurrentRow();
			$stylePropertyId = $stylePropertyIdArray["styleProperty_id"];
			
			/* Check whether the StyleComponent already exists in the */
			/* specified StyleProperty*/
			$query=& new SelectQuery;
			$query->addTable("StyleComponents");
			$query->addColumn("fk_styleProperty_id");
			$query->addColumn("styleComponent");
			
			$styleComponentTableResult =& $this->_dbHandler->query($query, $this->_dbIndex);
			
			while($styleComponentTableResult->hasMoreRows()){
			$styleComponentTableArray =$styleComponentTableResult->getCurrentRow();
			if($styleComponentTableArray["fk_styleProperty_id"]==$stylePropertyId && $styleComponentTableArray["styleComponent"]==$value){
				throwError(new Error("This styleComponent already exists in the specified styleProperty", "GUIManager",true));
			}
			$styleComponentTableResult->advanceRow();
			}
			
				
			
			$query =& new InsertQuery;
			$query->setTable("StyleComponents");
			$query->setColumns(array("fk_styleProperty_id","styleComponent","styleComponentType", "argsorder"));
			$query->addRowOfValues(array("'$stylePropertyId'","'$value'","'$styleComponentType'", "'$order'"));
			$this->_dbHandler->query($query, $this->_dbIndex);
			
			
			
			
			
			
		}
		
		
		function createStyleProperty($themeId, $selector, $styleProperty){
			
			
			$query2 =& new SelectQuery;
			$query2->addTable("StyleCollections");
			$query2->addColumn("styleCollection_id");
			$query2->addWhere("selector= '$selector'");
			$query2->addWhere("fk_theme_id=$themeId");
			
			
			$styleCollectionIdResult =& $this->_dbHandler->query($query2, $this->_dbIndex);
			$styleCollectionIdArray =$styleCollectionIdResult->getCurrentRow();
			$styleCollectionId = $styleCollectionIdArray["styleCollection_id"];
		
			
			/* Check whether the StyleProperty already exists in the */
			/* specified StyleCollection*/
		    $query=& new SelectQuery;
			$query->addTable("StyleProperties");
			$query->addColumn("fk_styleCollection_id");
			$query->addColumn("styleProperty");
			
			$stylePropertyTableResult =& $this->_dbHandler->query($query, $this->_dbIndex);
			
			while($stylePropertyTableResult->hasMoreRows()){
			$stylePropertyTableArray =$stylePropertyTableResult->getCurrentRow();
			if($stylePropertyTableArray["fk_styleCollection_id"]==$styleCollectionId && $stylePropertyTableArray["styleProperty"]==$styleProperty){
				throwError(new Error("This styleProperty already exists in the specified styleCollection", "GUIManager",true));
			}
			$stylePropertyTableResult->advanceRow();
			}
			
			$query3 =& new InsertQuery;
			$query3->setTable("StyleProperties");
			$query3->setColumns(array("fk_styleCollection_id","styleProperty"));
			$query3->addRowOfValues(array("'$styleCollectionId'","'$styleProperty'"));
			$result =& $this->_dbHandler->query($query3, $this->_dbIndex);
			
			$stylePropertyId= $result->getLastAutoIncrementValue();
			return $stylePropertyId;
			}
		
		
			
			
		function createStyleCollection($themeId, $selector, $classSelector, $displayName, $description, $componentType="null", $componentIndex="null"){
			
			/* Check whether the StyleCollection already exists in the */
			/* specified theme*/
			$query=& new SelectQuery;
			$query->addTable("StyleCollections");
			$query->addColumn("fk_theme_id");
			$query->addColumn("selector");
			
			$styleCollectionTableResult =& $this->_dbHandler->query($query, $this->_dbIndex);
			
			while($styleCollectionTableResult->hasMoreRows()){
			$styleCollectionTableArray =$styleCollectionTableResult->getCurrentRow();
			if($styleCollectionTableArray["fk_theme_id"]==$themeId && $styleCollectionTableArray["selector"]==$selector){
				throwError(new Error("This styleCollection already exists in the specified theme", "GUIManager",true));
			}
			$styleCollectionTableResult->advanceRow();
			}
			
			
			$query2=& new InsertQuery;
			$query2->setTable("StyleCollections");
			$query2->setColumns(array("fk_theme_id","selector", "classSelector", "displayName", "description", "componentType", "componentIndex"));
			$query2->addRowOfValues(array("'$themeId'","'$selector'", "'$classSelector'", "'$displayName'", "'$description'", "'$componentType'", "'$componentIndex'"));
			$result =&$this->_dbHandler->query($query2, $this->_dbIndex);
			
			$styleCollectionId= $result->getLastAutoIncrementValue();
			return $styleCollectionId;
			
		}
		
		
		
		
		
			
		
		
		
		
		
		
		
		
		
		
		
}