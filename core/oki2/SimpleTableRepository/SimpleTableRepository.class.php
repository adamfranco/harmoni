<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableRepository.class.php,v 1.5 2008/02/06 15:37:45 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/SimpleTableAssetIterator.class.php");
require_once(dirname(__FILE__)."/SimpleTableAsset.class.php");
require_once(dirname(__FILE__)."/SimpleTableRecordStructure.class.php");
require_once(dirname(__FILE__)."/SimpleTablePartStructure.class.php");


/**
 * This repository provides access to rows in a table as assets
 * 
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableRepository.class.php,v 1.5 2008/02/06 15:37:45 adamfranco Exp $
 */
class SimpleTableRepository
	implements Repository
{

	/**
	 * @var object Id $id;  
	 * @access private
	 * @since 10/4/07
	 */
	private $id;
	
	/**
	 * @var array $config; 
	 * @access private
	 * @since 10/4/07
	 */
	private $config;
	
	/**
	 * @var object IdManager $idMgr;  
	 * @access public
	 * @since 10/4/07
	 */
	public $idMgr;
	
	/**
	 * @var object SimpleTableRecordStructure $dcRecordStructure;  
	 * @access public
	 * @since 10/4/07
	 */
	public $dcRecordStructure;
	
	/**
	 * @var object SimpleTableRecordStructure $customRecordStructure;  
	 * @access public
	 * @since 10/4/07
	 */
	public $customRecordStructure;
	
	/**
	 * Constructor
	 * 
	 * @param object Id $id
	 * @param array $config
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __construct (Id $id, array $config, DBHandler $dbc, $idMgr) {
		$this->id = $id;
		$this->config = $config;
		$this->dbc = $dbc;
		$this->idMgr = $idMgr;
		
		switch ($this->config['db_type']) {
			case MYSQL:
				$dbClass = "MySQLDatabase";
				break;
			case POSTGRESQL:
				$dbClass = "PostgreSQLDatabase";
				break;
			default:
				throw new ConfigurationErrorException('Unknown database type \''.$this->config['db_type'].'\'.');
		}
		$this->dbIndex = $dbc->addDatabase(
			new $dbClass(
				$this->config['host'],
				$this->config['db'],
				$this->config['user'],
				$this->config['password']));
		$this->dbc->pConnect($this->dbIndex);
		
		$this->createRecordStructures();
	}
	
	/**
	 * Destructor
	 * 
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __destruct () {
		$this->dbc->disconnect($this->dbIndex);
	}
	
	/**
	 * Create the record structures
	 *
	 * @return void
	 * @access private
	 * @since 10/4/07
	 */
	private function createRecordStructures () {
		/*********************************************************
		 * Dublin Core
		 *********************************************************/
		$this->dcRecordStructure = new SimpleTableRecordStructure($this->idMgr->getId('dc'),
			'Dublin Core',
			'Dublin Core Metadata Element Set, Version 1.1', 'UTF-8');
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.title'),
			'Title',
			'A name given to the resource.',
			false, false));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.creator'),
			'Creator',
			'An entity primarily responsible for making the content of the resource.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.subject'),
			'Subject',
			'A topic of the content of the resource.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.description'),
			'Description',
			'An account of the content of the resource.',
			false, false));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.publisher'),
			'Publisher',
			'An entity responsible for making the resource available.',
			false, false));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.contributor'),
			'Contributor',
			'An entity responsible for making contributions to the content of the resource.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.date'),
			'Date',
			'A date of an event in the lifecycle of the resource.',
			false, false));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.type'),
			'Type',
			'The nature or genre of the content of the resource.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.format'),
			'Format',
			'The physical or digital manifestation of the resource.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.identifier'),
			'Identifier',
			'An unambiguous reference to the resource within a given context.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.source'),
			'Source',
			'A Reference to a resource from which the present resource is derived.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.language'),
			'Language',
			'A language of the intellectual content of the resource.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.relation'),
			'Relation',
			'A reference to a related resource.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.coverage'),
			'Coverage',
			'The extent or scope of the content of the resource.',
			false, true));
		$this->dcRecordStructure->addPartStructure(new SimpleTablePartStructure(
			$this->idMgr->getId('dc.rights'),
			'Rights',
			'Information about rights held in and over the resource.',
			false, true));
		
		/*********************************************************
		 * Custom Record Structure
		 *********************************************************/
		$this->customRecordStructure = new SimpleTableRecordStructure(
			$this->idMgr->getId('custom'),
			'Custom Metadata',
			'A Custom Record Structure for this table.', 'UTF-8');
		foreach ($this->config['columns'] as $column) {
			$this->customRecordStructure->addPartStructure(new SimpleTablePartStructure(
				$this->idMgr->getId('custom.'.$column),
				ucfirst(str_replace('_', ' ', $column)),
				'',
				false, false));
		}
	}
	
	/**
	 * Update the display name for this Repository.
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
	 * Get the display name for this Repository.
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
		if (isset($this->config['displayName']))
			$this->config['displayName'];
		else
			return ucwords(str_replace('_', ' ', $this->config['table']));
	} 
	
	/**
	 * Get the unique Id for this Repository.
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
		return $this->id;
	} 
	
	/**
	 * Get the RepositoryType of this Repository.
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
	function getType () { 
		return new Type('Repositories', 'edu.middlebury', 'Generic');
	} 
	
	/**
	 * Get the description for this Repository.
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
		if (isset($this->config['description']))
			$this->config['description'];
		else
			return '';
	} 
	
	/**
	 * Update the description for this Repository.
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
	 * Create a new Asset of this AssetType in this Repository.  The
	 * implementation of this method sets the Id for the new object.
	 * 
	 * @param string $displayName
	 * @param string $description
	 * @param object Type $assetType
	 *  
	 * @return object Asset
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
	function createAsset ( $displayName, $description, Type $assetType ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Delete an Asset from this Repository.
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
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteAsset ( Id $assetId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the Assets in this Repository.  Iterators return a set, one at a
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
		$query = new SelectQuery;
		$query->addTable($this->config['table']);
		$query->addColumn($this->config['id_column']);
		foreach ($this->config['columns'] as $column)
			$query->addColumn($column);
		
		if ($this->config['order_column'])
			$query->addOrderBy($this->config['order_column'], $this->config['order_direction']);
		
		return new SimpleTableAssetIterator(
			$this,
			$this->config,
			$this->dbc->query($query, $this->dbIndex));
	} 
	
	/**
	 * Get all the Assets of the specified AssetType in this Asset.  Iterators
	 * return a set, one at a time.
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
	function getAssetsByType ( Type $assetType ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the AssetTypes in this Repository.  AssetTypes are used to
	 * categorize Assets.  Iterators return a set, one at a time.
	 *  
	 * @return object TypeIterator
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
	function getAssetTypes () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the Properties of this Type associated with this Repository.
	 * 
	 * @param object Type $propertiesType
	 *  
	 * @return object Properties
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
	function getPropertiesByType ( Type $propertiesType ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the Property Types for  Repository.
	 *  
	 * @return object TypeIterator
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
	function getPropertyTypes () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the Properties associated with this Repository.
	 *  
	 * @return object PropertiesIterator
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
	function getProperties () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the RecordStructures in this Repository.  RecordStructures are
	 * used to categorize information about Assets.  Iterators return a set,
	 * one at a time.
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
		return new HarmoniIterator(array($this->dcRecordStructure, $this->customRecordStructure));
	} 
	
	/**
	 * Get all the RecordStructures with the specified RecordStructureType in
	 * this Repository.  RecordStructures are used to categorize information
	 * about Assets.  Iterators return a set, one at a time.
	 * 
	 * @param object Type $recordStructureType
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
	function getRecordStructuresByType ( Type $recordStructureType ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the RecordStructures that this AssetType must support.
	 * RecordStructures are used to categorize information about Assets.
	 * Iterators return a set, one at a time.
	 * 
	 * @param object Type $assetType
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
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_TYPE
	 *         UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function getMandatoryRecordStructures ( Type $assetType ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the SearchTypes supported by this Repository.  Iterators return
	 * a set, one at a time.
	 *  
	 * @return object TypeIterator
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
	function getSearchTypes () { 
		return new HarmoniIterator(array(
			new Type(
				"Repository",
				"edu.middlebury.harmoni",
				"Keyword", 
				"Search with a string for keywords.")
// 			,
// 			new Type(
// 				"Repository",
// 				"edu.middlebury.harmoni",
// 				"RootAssets", 
// 				"Search for just the 'root' or 'top level' assets which are not assets of other assets.")
		));
	} 
	
	/**
	 * Get all the StatusTypes supported by this Repository.  Iterators return
	 * a set, one at a time.
	 *  
	 * @return object TypeIterator
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
	function getStatusTypes () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the StatusType of the Asset with the specified unique Id.
	 * 
	 * @param object Id $assetId
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
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getStatus ( Id $assetId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Validate all the Records for an Asset and set its status Type
	 * accordingly.  If the Asset is valid, return true; otherwise return
	 * false.  The implementation may throw an Exception for any validation
	 * failures and use the Exception's message to identify specific causes.
	 * 
	 * @param object Id $assetId
	 *  
	 * @return boolean
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
	function validateAsset ( Id $assetId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Set the Asset's status Type accordingly and relax validation checking
	 * when creating Records and Parts or updating Parts' values.
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
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function invalidateAsset ( Id $assetId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the Asset with the specified unique Id.
	 * 
	 * @param object Id $assetId
	 *  
	 * @return object Asset
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
	function getAsset ( Id $assetId ) { 
		$query = new SelectQuery;
		$query->addTable($this->config['table']);
		$query->addColumn($this->config['id_column']);
		foreach ($this->config['columns'] as $column)
			$query->addColumn($column);
		
		$query->addWhereEqual($this->config['id_column'], 
			substr($assetId->getIdString(), strlen($this->getId()->getIdString().".")));
		
		$assets = new SimpleTableAssetIterator(
			$this,
			$this->config,
			$this->dbc->query($query, $this->dbIndex));
		
		if (!$assets->hasNext())
			throw new UnknownIdException();
		
		return $assets->next();
	} 
	
	/**
	 * Get the Asset with the specified unique Id that is appropriate for the
	 * date specified.  The specified date allows a Repository implementation
	 * to support Asset versioning.
	 * 
	 * @param object Id $assetId
	 * @param int $date
	 *  
	 * @return object Asset
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
	 *         org.osid.repository.RepositoryException#NO_OBJECT_WITH_THIS_DATE
	 *         NO_OBJECT_WITH_THIS_DATE}
	 * 
	 * @access public
	 */
	function getAssetByDate ( Id $assetId, $date ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the dates for the Asset with the specified unique Id.  These
	 * dates allows a Repository implementation to support Asset versioning.
	 * 
	 * @param object Id $assetId
	 *  
	 * @return object LongValueIterator
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
	function getAssetDates ( Id $assetId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Perform a search of the specified Type and get all the Assets that
	 * satisfy the SearchCriteria.  Iterators return a set, one at a time.
	 * 
	 * @param object mixed $searchCriteria (original type: java.io.Serializable)
	 * @param object Type $searchType
	 * @param object Properties $searchProperties
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
	function getAssetsBySearch ( $searchCriteria, Type $searchType, Properties $searchProperties ) { 
		if ($searchType->isEqual(
			new Type(
				"Repository",
				"edu.middlebury.harmoni",
				"Keyword", 
				"Search with a string for keywords.")))
		{
			if (!is_string($searchCriteria))
				throw new OperationFailedException('search criteria should be a string.');
			$query = new SelectQuery;
			$query->addTable($this->config['table']);
			$query->addColumn($this->config['id_column']);
			$query->addWhereLike($this->config['id_column'], '%'.$searchCriteria.'%');
			foreach ($this->config['columns'] as $column) {
				$query->addColumn($column);
				$query->addWhereLike($column, '%'.$searchCriteria.'%', _OR);
			}
			
			if ($this->config['order_column'])
				$query->addOrderBy($this->config['order_column'], $this->config['order_direction']);
			
			return new SimpleTableAssetIterator(
				$this,
				$this->config,
				$this->dbc->query($query, $this->dbIndex));
		} else if ($searchType->isEqual(
			new Type(
				"Repository",
				"edu.middlebury.harmoni",
				"RootAssets", 
				"Search for just the 'root' or 'top level' assets which are not assets of other assets.")))
		{
			return $this->getAssets();
		} else {
			throw new UnknownTypeException('UNKNOWN_TYPE');
		}
	} 
	
	/**
	 * Create a copy of an Asset.  The Id, AssetType, and Repository for the
	 * new Asset is set by the implementation.  All Records are similarly
	 * copied.
	 * 
	 * @param object Asset $asset
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
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function copyAsset ( Asset $asset ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * This method indicates whether this implementation supports Repository
	 * methods getAssetsDates() and getAssetByDate()
	 *  
	 * @return boolean
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
	function supportsVersioning () { 
		return false;
	} 
	
	/**
	 * This method indicates whether this implementation supports Repository
	 * methods: copyAsset, deleteAsset, invalidateAsset, updateDescription,
	 * updateDisplayName. Asset methods: addAsset, copyRecordStructure,
	 * createRecord, deleteRecord, inheritRecordStructure, removeAsset,
	 * updateContent, updateDescription, updateDisplayName,
	 * updateEffectiveDate, updateExpirationDate. Part methods: createPart,
	 * deletePart, updateDisplayName, updateValue. PartStructure methods:
	 * updateDisplayName, validatePart. Record methods: createPart,
	 * deletePart, updateDisplayName. RecordStructure methods:
	 * updateDisplayName, validateRecord.
	 *  
	 * @return boolean
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
	function supportsUpdate () { 
		return false;
	} 
	
}

?>