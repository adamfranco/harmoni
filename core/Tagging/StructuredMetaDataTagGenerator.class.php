<?php
/**
 * @since 11/21/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StructuredMetaDataTagGenerator.class.php,v 1.4 2007/04/10 18:00:29 adamfranco Exp $
 */ 

/**
 * This is a singleton class that handles auto-generation of tags from structured
 * metadata
 * 
 * @since 11/21/06
 * @package harmoni.tagging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StructuredMetaDataTagGenerator.class.php,v 1.4 2007/04/10 18:00:29 adamfranco Exp $
 */
class StructuredMetaDataTagGenerator {

	/**
	 * Get the instance of StructuredMetaDataTagGenerator.
	 * The StructuredMetaDataTagGenerator class implements the Singleton pattern. 
	 * There is only ever one instance of the StructuredMetaDataTagGenerator object 
	 * and it is accessed only via the StructuredMetaDataTagGenerator::instance() 
	 * method.
	 * 
	 * @return object StructuredMetaDataTagGenerator
	 * @access public
	 * @since 5/26/05
	 * @static
	 */
	function &instance () {
		if (!defined("StructuredMetaDataTagGenerator_INSTANTIATED")) {
			$GLOBALS['__structuredMetaDataTagGenerator'] =& new StructuredMetaDataTagGenerator();
			define("StructuredMetaDataTagGenerator_INSTANTIATED", true);
		}
		
		return $GLOBALS['__structuredMetaDataTagGenerator'];
	}
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function StructuredMetaDataTagGenerator() {
		// Verify that there is only one instance of Harmoni.
		$backtrace = debug_backtrace();
		if (false && $GLOBALS['__structuredMetaDataTagGenerator'] 
			|| !(
				strtolower($backtrace[1]['class']) == 'structuredmetadatataggenerator'
				&& $backtrace[1]['function'] == 'instance'
// 				&& $backtrace[1]['type'] == '::'	// PHP 5.2.1 seems to get this wrong
			))
		{
			die("\n<dl style='border: 1px solid #F00; padding: 10px;'>"
			."\n\t<dt><strong>Invalid StructuredMetaDataTagGenerator instantiation at...</strong></dt>"
			."\n\t<dd> File: ".$backtrace[0]['file']
			."\n\t\t<br/> Line: ".$backtrace[0]['line']
			."\n\t</dd>"
			."\n\t<dt><strong>Access StructuredMetaDataTagGenerator with <em>StructuredMetaDataTagGenerator::instance()</em></strong></dt>"
			."\n\t<dt><strong>Backtrace:</strong></dt>"
			."\n\t<dd>".printDebugBacktrace(debug_backtrace(), true)."</dd>"
			."\n\t<dt><strong>PHP Version:</strong></dt>"
			."\n\t<dd>".phpversion()."</dd>"
			."\n</dl>");
		}
		
		$this->_cache = array();
	}
		
	/**
	 * Answer the PartStructure Ids for which Tags should be auto-generated, in
	 * the given repository.
	 * 
	 * @param object Id $repositoryId
	 * @return object IdIterator
	 * @access public
	 * @since 11/21/06
	 */
	function &getPartStructureIdsForTagGeneration ( $repositoryId ) {	
		if(!isset($this->_cache[$repositoryId->getIdString()])) {
			$this->_cache[$repositoryId->getIdString()] = array();
			$query =& new SelectQuery;
			$query->addColumn('fk_partstruct');
			$query->addTable('tag_part_map');
			$query->addWhere("fk_repository ='".addslashes($repositoryId->getIdString())."'");
			
			$dbc =& Services::getService("DatabaseManager");
			$result =& $dbc->query($query, $this->getDatabaseIndex());
			
			// Add tag objects to an array, still sorted by frequency of usage
			$idManager =& Services::getService('Id');
			while ($result->hasNext()) {
				$row = $result->next();
				$this->_cache[$repositoryId->getIdString()][] =& $idManager->getId($row['fk_partstruct']);
			}
		}
		
		$iterator =& new HarmoniIterator($this->_cache[$repositoryId->getIdString()]);
		return $iterator;
	}
	
	/**
	 * Answer true if the PartStructure should have tags auto-generated for it 
	 * in the given repository.
	 * 
	 * @param object Id $repositoryId
	 * @param object Id $partStructureId
	 * @return boolean
	 * @access public
	 * @since 11/21/06
	 */
	function shouldGenerateTagsForPartStructure ( &$repositoryId, &$partStructureId ) {
		// Check to see if this PartStructure is already added.
		$existing =& $this->getPartStructureIdsForTagGeneration($repositoryId);
		while ($existing->hasNext()) {
			if ($partStructureId->isEqual($existing->next()))
				return true;
		}
		
		return false;
	}
	
	/**
	 * Add a PartStructureId for which Tags should be auto-generated, in the
	 * given repository
	 * 
	 * @param object Id $repositoryId
	 * @param object Id $partStructureId
	 * @return void
	 * @access public
	 * @since 11/21/06
	 */
	function addPartStructureIdForTagGeneration ( &$repositoryId, &$partStructureId ) {
		if ($this->shouldGenerateTagsForPartStructure($repositoryId, $partStructureId))
			return;
		
		// Insert it into the database
		$query =& new InsertQuery;
		$query->setColumns(array('fk_repository', 'fk_partstruct'));
		$query->addRowOfValues(array(
			"'".addslashes($repositoryId->getIdString())."'",
			"'".addslashes($partStructureId->getIdString())."'"));
		$query->setTable('tag_part_map');
		$dbc =& Services::getService("DatabaseManager");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
			
		// Add it to the cache
		$this->_cache[$repositoryId->getIdString()][] =& $partStructureId;
	}
	
	/**
	 * Add a PartStructureId for which Tags should be auto-generated, in the
	 * given repository
	 * 
	 * @param object Id $repositoryId
	 * @return void
	 * @access public
	 * @since 11/21/06
	 */
	function removePartStructureIdForTagGeneration ( &$repositoryId, &$partStructureId ) {
		// Delete it into the database
		$query =& new DeleteQuery;
		$query->setTable('tag_part_map');
		$query->addWhere("fk_repository='".addslashes($repositoryId->getIdString())."'");
		$query->addWhere("fk_partstruct='".addslashes($partStructureId->getIdString())."'");
		$dbc =& Services::getService("DatabaseManager");
		$result =& $dbc->query($query, $this->getDatabaseIndex());
			
		// Remove it from the cache
		if(isset($this->_cache)
			&& isset($this->_cache[$repositoryId->getIdString()]))
		{
			for ($i = 0; $i < count($this->_cache[$repositoryId->getIdString()]); $i++) {
				if ($partStructureId->isEqual($this->_cache[$repositoryId->getIdString()][$i]))
					unset($this->_cache[$repositoryId->getIdString()][$i]);
			}
		}
	}
	
	/**
	 * Regenerate tags for all assets in the given repository
	 * 
	 * @param object Id $repositoryId
	 * @param object Id $agent Id	The agent id to associate with these tags
	 * @param string $system		The system to associate with these tags
	 * @return void
	 * @access public
	 * @since 11/27/06
	 */
	function regenerateTagsForRepository ( &$repositoryId, &$agentId, $system ) {
		$repositoryManager =& Services::getService("Repository");
		$repository =& $repositoryManager->getRepository($repositoryId);
		$this->regenerateTagsForAssets($repository->getAssets(), $agentId, $system, $repositoryId);
		
	}
	
	/**
	 * Regenerate tags for a number of assets
	 * 
	 * @param mixed $assets An AssetIterator, an array of Assets, or a single Asset
	 * @param object Id $agent Id	The agent id to associate with these tags
	 * @param string $system		The system to associate with these tags
	 * @param optional object Id $repositoryId	Not required, but can enhance 
	 *								efficiency if it is known ahead of time.
	 * @return void
	 * @access public
	 * @since 11/27/06
	 */
	function regenerateTagsForAssets ( &$assets, &$agentId, $system, $repositoryId = null ) {
		$status =& new StatusStars(dgettext("polyphony", "Regenerating Tags for Assets"));
	 	
		// array
		if (is_array($assets)) {
			$status->initializeStatistics(count($assets));
			foreach(array_keys($assets) as $key) {
				$this->regenerateTagsForAsset($assets[$key], $agentId, $system, $repositoryId);
				$status->updateStatistics();
			}
		} 
		// iterator
		else if (method_exists($assets, 'next')) {
			$status->initializeStatistics($assets->count());
			while($assets->hasNext()) {
				$this->regenerateTagsForAsset($assets->next(), $agentId, $system, $repositoryId);
				$status->updateStatistics();
			}
		} 
		// Single item
		else if (method_exists($assets, 'getPartValuesByPartStructure')) {
			$status->initializeStatistics(1);
			$this->regenerateTagsForAsset($assets, $agentId, $system, $repositoryId);
			$status->updateStatistics();
		} 
		// Error
		else {
			throwError(new Error("Invalid parameter, $assets, for \$assets", "Tagging"));
		}
	}
	
	/**
	 * Regenerate tags for a single Asset
	 * 
	 * @param object Asset $asset
	 * @param object Id $agent Id	The agent id to associate with these tags
	 * @param string $system		The system to associate with these tags
	 * @param optional object Id $repositoryId	Not required, but can enhance 
	 *								efficiency if it is known ahead of time.
	 * @return void
	 * @access public
	 * @since 11/27/06
	 */
	function regenerateTagsForAsset ( &$asset, &$agentId, $system, $repositoryId = null ) {
		if (!is_object($repositoryId)) {
			$repository =& $asset->getRepository();
			$repositoryId =& $repository->getId();
		}
		
		$assetId =& $asset->getId();
		printpre("<hr/>Asset: ".$assetId->getIdString()." ".$asset->getDisplayName());
		
		$item =& TaggedItem::forId($asset->getId(), $system);
		$item->deleteTagsByAgent($agentId);
		
		// Loop through the records and generate tags from the values
		$partStructIds =& $this->getPartStructureIdsForTagGeneration(
															$repositoryId);
		while ($partStructIds->hasNext()) {
			$values =& $asset->getPartValuesByPartStructure($partStructIds->next());
			while ($values->hasNext()) {
				$value =& $values->next();
				$tag =& new Tag($value->asString());
				$tag->tagItemForAgent($item, $agentId);
				printpre("Adding Tag: ".$tag->getValue());
			}
		}
	}
	
	/**
     * Answer the database index
     * 
     * @return integer
     * @access public
     * @since 11/6/06
     */
    function getDatabaseIndex () {
    	if (!isset($this->_databaseIndex)) {
    		$taggingManager =& Services::getService("Tagging");
    		$this->_databaseIndex = $taggingManager->getDatabaseIndex();
		}
		return $this->_databaseIndex;
    }
}

?>