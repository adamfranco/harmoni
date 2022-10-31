<?php
/**
 * @since 06/10/05
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Dearchiver.class.php,v 1.8 2007/10/17 19:07:55 adamfranco Exp $
 *
 * @link http://sourceforge.net/projects/concerto
 */ 

/**
* Uncompresses and dearchives files from the input file.
 *
 * @package harmoni.utilities
 *
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Dearchiver.class.php,v 1.8 2007/10/17 19:07:55 adamfranco Exp $
 */

// PEAR Libraries raise some E_STRICT runtime notices. Ignore these since we can't 
// change them.
$tmpReporting = error_reporting();
if ($tmpReporting & E_STRICT)
	error_reporting(E_ALL & ~ E_STRICT & ~ E_DEPRECATED);

$handler = HarmoniErrorHandler::instance();
$tmpFatal = $handler->fatalErrors();
if ($tmpFatal & E_STRICT)
	$handler->fatalErrors(E_ALL & ~ E_STRICT);

// Use a custom version of Archive/Tar if requested.
if (defined('ARCHIVE_TAR_PATH'))
	require_once(ARCHIVE_TAR_PATH);
else
	require_once("Archive/Tar.php");


if ($tmpReporting & E_STRICT)
	error_reporting($tmpReporting);

if ($tmpFatal & E_STRICT)
	$handler->fatalErrors($tmpFatal );
	



require_once(HARMONI."utilities/mkdirr.function.php");

class Dearchiver {
	
	/**
	* Figures out the type of archive.
	 * 
	 * @param string filename
	 * @return string the extension of the file (zip, gz, bz2, tar.gz, tar.bz2)
	 * @access  private
	 * @since 06/10/05
	 *
	 */
	function _getFileType($filename) {
		$filenameParts = explode(".", $filename);
		$filenamePartsCount = count($filenameParts);
		if (strcasecmp($filenameParts[$filenamePartsCount-1], "tgz") == 0)
			return "tar.gz";
		else if (strcasecmp($filenameParts[$filenamePartsCount-1], "tbz2") == 0)
			return "tar.bz2";
		else if(strcasecmp($filenameParts[$filenamePartsCount-2], "tar") == 0) {
			if(strcasecmp($filenameParts[$filenamePartsCount-1], "gz") == 0)
				return "tar.gz";
			else if(strcasecmp($filenameParts[$filenamePartsCount-1], "bz2") == 0)
				return "tar.bz2";			
		}
		else {
			return strtolower($filenameParts[$filenamePartsCount-1]);
		}
	}
	
	/** Function to unzip $file in $dir to $destination with $permissions
 	* 
 	* modified  candido1212 at yahoo dot com dot br's code on php.net manual
 	* http://us3.php.net/zip
 	* @param path, filename, destination, permissions (refer to mkdir)
 	*/

	function unzip($dir, $file, $destination="", $permissions = 0755)
	{
		if (substr($dir, -1) != DIRECTORY_SEPARATOR) $dir .= DIRECTORY_SEPARATOR;
		if (substr($destination, -1) != DIRECTORY_SEPARATOR) $destination .= DIRECTORY_SEPARATOR;
		$path_file = $dir . $file;
		$zip = zip_open($path_file);
		$_tmp = array();
		if ($zip)
		{
			while ($zip_entry = zip_read($zip))
			{
				if (zip_entry_open($zip, $zip_entry, "r"))
				{
					if($destination)
					{
						$path_file = $destination . zip_entry_name($zip_entry);
					}
					else
					{
						$path_file = $dir . zip_entry_name($zip_entry);
					}
					$new_dir = dirname($path_file);

					// Create Recursive Directory
					mkdirr($new_dir, $permissions);
					//change: do not try to read file if is a directory
					if (!(substr(zip_entry_name($zip_entry), -1) == "/")) {
						$fp = fopen($path_file, "w");
						while ($buf = zip_entry_read($zip_entry, 4096))
							fwrite($fp, $buf, 4096);
						fclose($fp);
						$_tmp[] = $path_file;
					}
					zip_entry_close($zip_entry);
				}
			}
			zip_close($zip);
		}
		return $_tmp;
	}
	/**
	* Uncompresses the archive appropriate to its filetype to the given path.
	 * 
	 * @param string $filename
	 * @return boolean
	 * @access public
	 * @since 06/10/05
	 *
	 */
	function uncompressFile($filename, $path) {
		$fileType = $this->_getFileType($filename);
		switch ($fileType) {
			case "tar":
				$tar = new Archive_Tar($filename);
				$tar->extract($path);
				unlink($filename);
				break;
			case "tar.gz":
				$tar = new Archive_Tar($filename, "gz");
				$tar->extract($path);
				unlink($filename);
				break;
			case "tar.bz2":
				$tar = new Archive_Tar($filename, "bz2");
				$tar->extract($path);
				unlink($filename);
				break;
			case "zip":
				$this->unzip(dirname($filename), basename($filename), $path,
					0700);
				unlink($filename);
				break;
			case "gz":
				$file = gzopen($filename, "rb");
				$outFile = fopen($path, "wb");
				while (!gzeof($file)) {
					$buffer = gzread($file, 4096);
					fwrite ($outFile, $buffer, 4096);
				}
				gzclose($file);
				fclose($outFile);
				unlink($filename);
				break;
			case "bz2":
				$file = bzopen($filename, "rb");
				$outFile = fopen($path. "wb");
				while ($buffer = bzread($file, 4096)) 
					fwrite($outFile, $buffer, 4096);
					fclose($outFile);
				bzclose($file);
				unlink($filename);
				break;
			default:
				return false;
		}
		return true;
	}
}
