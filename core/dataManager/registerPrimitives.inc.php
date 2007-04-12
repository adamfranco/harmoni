<?php
/**
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: registerPrimitives.inc.php,v 1.8 2007/04/12 15:37:24 adamfranco Exp $
 */
 
$this->addDataType("integer","Integer","StorableInteger", "asAnInteger");
$this->addDataType("string","String","StorableString", "asAString");
$this->addDataType("blob","Blob","StorableBlob", "asABlob");
$this->addDataType("shortstring","String","StorableShortString", "asAString");
$this->addDataType("float","Float","StorableFloat", "asAFloat");
$this->addDataType("boolean","Boolean","StorableBoolean", "asABoolean");
$this->addDataType("datetime","DateAndTime","StorableTime", "asADateTime");
$this->addDataType("okitype","Type","StorableOKIType", "asAnOKIType");