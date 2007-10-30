<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableAsset.class.php,v 1.4 2007/10/30 16:32:47 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/SimpleTableRecord.class.php");
require_once(dirname(__FILE__)."/SimpleTablePart.class.php");


/**
 * This asset maps to a row in a database table.
 * 
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableAsset.class.php,v 1.4 2007/10/30 16:32:47 adamfranco Exp $
 */
class SimpleTableAsset
	extends Asset
	// implements Asset
{
	
	/**
	 * @var object SimpleTableRepository $repository;  
	 * @access private
	 * @since 10/4/07
	 */
	private $repository;
	
	/**
	 * @var array $config;  
	 * @access private
	 * @since 10/4/07
	 */
	private $config;
	
	/**
	 * @var object $dcRecord;  
	 * @access private
	 * @since 10/4/07
	 */
	private $dcRecord;
	
	/**
	 * @var object $customRecord;  
	 * @access private
	 * @since 10/4/07
	 */
	private $customRecord;
	
	/**
	 * @var object Id $id;  
	 * @access private
	 * @since 10/4/07
	 */
	private $id;
	
	/**
	 * Constructor
	 * 
	 * @param object SimpleTableRepository $repository
	 * @param array $config
	 * @param array $row
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __construct (SimpleTableRepository $repository, array $config, array $row) {
		$this->repository = $repository;
		$this->config = $config;
		
		if (!isset($row[$this->config['id_column']]))
			throw new ConfigurationErrorException("Can't find id column, '".$this->config['id_column']."' in ".implode(', ', array_keys($row)).".");
		
		if (!strlen($row[$this->config['id_column']]))
			throw new ConfigurationErrorException("Zero-length Id, in column '".$this->config['id_column']."'.");
		
		$this->id = $this->repository->idMgr->getId(
			$this->repository->getId()->getIdString().".".
			$row[$this->config['id_column']]);
		
		$this->createCustomRecord($row);
		$this->createDcRecord($row);
	}
	
	/**
	 * Create a custom record from a row.
	 * 
	 * @param array $row
	 * @return void
	 * @access private
	 * @since 10/4/07
	 */
	private function createCustomRecord ($row) {
		$recordStructure = $this->repository->customRecordStructure;
		$this->customRecord = new SimpleTableRecord($this->repository->idMgr, $recordStructure);
		
		$partStructures = $recordStructure->getPartStructures();
		while($partStructures->hasNext()) {
			$partStructure = $partStructures->next();
			$columnId = str_replace('custom.', '', $partStructure->getId()->getIdString());
			if (!isset($row[$columnId]))
				throw new ConfigurationErrorException("Can't find part value for '".$columnId."' in ".implode(", ", array_keys($row)).".");
				
			$this->customRecord->addPart(
				new SimpleTablePart($partStructure, $row[$columnId], $this->config['encoding']));
		}
	}
	
	/**
	 * Create a Dublin Core record from a row.
	 * 
	 * @param array $row
	 * @return void
	 * @access private
	 * @since 10/4/07
	 */
	private function createDcRecord ($row) {
		$dc = $this->repository->dcRecordStructure;
		$this->dcRecord = new SimpleTableRecord($this->repository->idMgr, $dc);
		
		foreach ($this->config['dc_mapping'] as $dcField => $mapping) {
			$partStructure = $dc->getPartStructure(
				$this->repository->idMgr->getId($dcField));
			
			$value = '';
			foreach ($mapping as $component) {
				if (preg_match('/^[\'"](.+)[\'"]$/i', $component, $matches))
					$value .= $matches[1];
				else if (preg_match('/^[a-z_-]+$/i', $component))
					$value .= $row[$component];
				else
					throw new ConfigurationErrorException('Unknown DC mapping component, "'.$component.'".');
			}
			
			$this->dcRecord->addPart(
				new SimpleTablePart($partStructure, $value, $this->config['encoding']));
		}
	}
	

	/**
	 * Update the display name for this Asset.
	 * 
	 * @param string $displayName
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDisplayName ( $displayName ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Update the date at which this Asset is effective.
	 * 
	 * @param int $effectiveDate
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * 
	 * @access public
	 */
	function updateEffectiveDate ( $effectiveDate ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Update the date at which this Asset expires.
	 * 
	 * @param int $expirationDate
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * 
	 * @access public
	 */
	function updateExpirationDate ( $expirationDate ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the display name for this Asset.
	 *  
	 * @return string
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getDisplayName () { 
		try {
			$partId = $this->repository->idMgr->getId('dc.title.0');
			return $this->dcRecord->getPart($partId)->getValue();
		} catch (Exception $e) {
			return 'Untitled';
		}
	} 
	
	/**
	 * Get the description for this Asset.
	 *  
	 * @return string
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getDescription () { 
		try {
			$partId = $this->repository->idMgr->getId('dc.description.0');
			return $this->dcRecord->getPart($partId)->getValue();
		} catch (Exception $e) {
			return 'Untitled';
		}
	} 
	
	/**
	 * Get the unique Id for this Asset.
	 *  
	 * @return object Id
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getId () { 
		if (!isset($this->id))
			throw new OperationFailedException();
		return $this->id;
	} 
	
	/**
	 * Get the AssetType of this Asset.  AssetTypes are used to categorize
	 * Assets.
	 *  
	 * @return object Type
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getAssetType () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the date at which this Asset is effective.
	 *  
	 * @return int
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getEffectiveDate () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the date at which this Asset expires.
	 *  
	 * @return int
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getExpirationDate () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Update the description for this Asset.
	 * 
	 * @param string $description
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDescription ( $description ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the Id of the Repository in which this Asset resides.  This is set
	 * by the Repository's createAsset method.
	 *  
	 * @return object Id
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getRepository () { 
		return $this->repository;
	} 
	
	/**
	 * Get an Asset's content.  This method can be a convenience if one is not
	 * interested in all the structure of the Records.
	 *  
	 * @return object mixed (original type: java.io.Serializable)
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getContent () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Update an Asset's content.
	 * 
	 * @param object mixed $content (original type: java.io.Serializable)
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateContent ( $content ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Add an Asset to this Asset.
	 * 
	 * @param object Id $assetId
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID},
	 *         {@link org.osid.repository.RepositoryException#ALREADY_ADDED
	 *         ALREADY_ADDED}
	 * 
	 * @access public
	 */
	function addAsset ( $assetId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Remove an Asset from this Asset.  This method does not delete the Asset
	 * from the Repository.
	 * 
	 * @param object Id $assetId
	 * @param boolean $includeChildren
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function removeAsset ( $assetId, $includeChildren ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the Assets in this Asset.  Iterators return a set, one at a
	 * time.
	 *  
	 * @return object AssetIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getAssets () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the Assets of the specified AssetType in this Repository.
	 * Iterators return a set, one at a time.
	 * 
	 * @param object Type $assetType
	 *  
	 * @return object AssetIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_TYPE
	 *         UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function getAssetsByType ( $assetType ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Create a new Asset Record of the specified RecordStructure.   The
	 * implementation of this method sets the Id for the new object.
	 * 
	 * @param object Id $recordStructureId
	 *  
	 * @return object Record
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function createRecord ( $recordStructureId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Add the specified RecordStructure and all the related Records from the
	 * specified asset.  The current and future content of the specified
	 * Record is synchronized automatically.
	 * 
	 * @param object Id $assetId
	 * @param object Id $recordStructureId
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID},
	 *         {@link
	 *         org.osid.repository.RepositoryException#ALREADY_INHERITING_STRUCTURE
	 *         ALREADY_INHERITING_STRUCTURE}
	 * 
	 * @access public
	 */
	function inheritRecordStructure ( $assetId, $recordStructureId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Add the specified RecordStructure and all the related Records from the
	 * specified asset.
	 * 
	 * @param object Id $assetId
	 * @param object Id $recordStructureId
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID},
	 *         {@link
	 *         org.osid.repository.RepositoryException#CANNOT_COPY_OR_INHERIT_SELF
	 *         CANNOT_COPY_OR_INHERIT_SELF}
	 * 
	 * @access public
	 */
	function copyRecordStructure ( $assetId, $recordStructureId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Delete a Record.  If the specified Record has content that is inherited
	 * by other Records, those other Records will not be deleted, but they
	 * will no longer have a source from which to inherit value changes.
	 * 
	 * @param object Id $recordId
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteRecord ( $recordId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the Records for this Asset.  Iterators return a set, one at a
	 * time.
	 *  
	 * @return object RecordIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getRecords () { 
		return new HarmoniIterator(array($this->dcRecord, $this->customRecord));
	} 
	
	/**
	 * Get all the Records of the specified RecordStructure for this Asset.
	 * Iterators return a set, one at a time.
	 * 
	 * @param object Id $recordStructureId
	 *  
	 * @return object RecordIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getRecordsByRecordStructure ( $recordStructureId ) { 
		switch ($recordStructureId->getIdString()) {
			case 'dc':
				return new HarmoniIterator(array($this->dcRecord));
			case 'custom':
				return new HarmoniIterator(array($this->customRecord));
			default:
				throw new UnknownIdException();
		}
	} 
	
	/**
	 * Get all the Records of the specified RecordStructureType for this Asset.
	 * Iterators return a set, one at a time.
	 * 
	 * @param object Type $recordStructureType
	 *  
	 * @return object RecordIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getRecordsByRecordStructureType ( $recordStructureType ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the RecordStructures for this Asset.  RecordStructures are used
	 * to categorize information about Assets.  Iterators return a set, one at
	 * a time.
	 *  
	 * @return object RecordStructureIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getRecordStructures () { 
		return $this->repository->getRecordStructures();
	} 
	
	/**
	 * Get the RecordStructure associated with this Asset's content.
	 *  
	 * @return object RecordStructure
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getContentRecordStructure () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the Record for this Asset that matches this Record's unique Id.
	 * 
	 * @param object Id $recordId
	 *  
	 * @return object Record
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getRecord ( $recordId ) { 
		if ($recordId->isEqual($this->dcRecord->getId()))
			return $this->dcRecord;
		if ($recordId->isEqual($this->customRecord->getId()))
			return $this->customRecord;
		else
			throw new UnknownIdException();
	} 
	
	/**
	 * Get the Part for a Record for this Asset that matches this Part's unique
	 * Id.
	 * 
	 * @param object Id $partId
	 *  
	 * @return object Part
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getPart ( $partId ) { 
		try {
			return $this->dcRecord->getPart($partId);
		} catch (Exception $e) {
			try {
				return $this->customRecord->getPart($partId);
			} catch (Exception $e) {
				throw new UnknownIdException();
			}
		}
	} 
	
	/**
	 * Get the Value of the Part of the Record for this Asset that matches this
	 * Part's unique Id.
	 * 
	 * @param object Id $partId
	 *  
	 * @return object mixed (original type: java.io.Serializable)
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getPartValue ( $partId ) { 
		try {
			$part = $this->getPart($partId);
		} catch (Exception $e) {
			throw new UnknownIdException();
		}
		
		return $part->getValue();
	} 
	
	/**
	 * Get the Parts of the Records for this Asset that are based on this
	 * RecordStructure PartStructure's unique Id.
	 * 
	 * @param object Id $partStructureId
	 *  
	 * @return object PartIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getPartsByPartStructure ( $partStructureId ) { 
		try {
			return $this->dcRecord->getPartsByPartStructure($partStructureId);
		} catch (Exception $e) {
			try {
				return $this->customRecord->getPartsByPartStructure($partStructureId);
			} catch (Exception $e) {
				throw new UnknownIdException();
			}
		}
	} 
	
	/**
	 * Get the Values of the Parts of the Records for this Asset that are based
	 * on this RecordStructure PartStructure's unique Id.
	 * 
	 * @param object Id $partStructureId
	 *  
	 * @return object ObjectIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getPartValuesByPartStructure ( $partStructureId ) { 
		try {
			$parts = $this->getPartsByPartStructure($partStructureId);
		} catch (Exception $e) {
			throw new UnknownIdException();
		}
		$values = array();
		while ($parts->hasNext()) {
			$values[] = $parts->next()->getValue();
		}
		return new HarmoniIterator($values);
	}
	
	/**
     * Get the parents of this asset, Iterators return a set one at a time.
     *
     * WARNING: NOT IN OSID 
     *
     * @return object AssetIterator
     * 
     * @throws object RepositoryException An exception with one of
     *         the following messages defined in
     *         org.osid.repository.RepositoryException may be thrown: {@link
     *         org.osid.repository.RepositoryException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.repository.RepositoryException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.repository.RepositoryException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getParents () { 
    	throw new UnimplementedException();
	}    
	
	/**
	 * Update the modification date and set the creation date if needed.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @return void
	 * @access public
	 * @since 5/4/06
	 */
	function updateModificationDate () {
		throw new UnimplementedException();
	}
	
	/**
     * Get the date at which this Asset was created.
     *  
     * WARNING: NOT IN OSID
     *
     * @return object DateAndTime
     * 
     * @throws object RepositoryException An exception with one of
     *         the following messages defined in
     *         org.osid.repository.RepositoryException may be thrown: {@link
     *         org.osid.repository.RepositoryException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.repository.RepositoryException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.repository.RepositoryException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getCreationDate () { 
		throw new UnimplementedException();
	}
	
	/**
	 * Answer the Id of the agent that created the asset
	 * 
	 * WARNING: NOT IN OSID
	 * 
	 * @return object Id
	 * @access public
	 * @since 7/9/07
	 */
	function getCreator () {
		throw new UnimplementedException();
	}
	
	/**
     * Get the date at which this Asset was created.
     *  
     * WARNING: NOT IN OSID
     *
     * @return object DateAndTime
     * 
     * @throws object RepositoryException An exception with one of
     *         the following messages defined in
     *         org.osid.repository.RepositoryException may be thrown: {@link
     *         org.osid.repository.RepositoryException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.repository.RepositoryException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.repository.RepositoryException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getModificationDate () { 
		throw new UnimplementedException();
	}

	/**
     * Answer an iterator of the TraversalInfo of the decendent Assets 
     * (children, grandchildren, etc).
     * WARNING: NOT IN OSID
     * 
     * @return object TraversalInfoIterator
     * @access public
     * @since 12/15/05
     */
    function getDescendentInfo () {
		throw new UnimplementedException();
    }	
}

?>