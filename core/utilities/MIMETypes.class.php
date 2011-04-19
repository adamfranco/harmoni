<?php

/**
 * Functions for figuring out MIME types.
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MIMETypes.class.php,v 1.13 2008/02/06 15:37:56 adamfranco Exp $
 */
class MIMETypes {

	/**
	 * Constructor, set up our mapping of known types.
	 * 
	 * @return obj
	 * @access public
	 * @since 10/22/04
	 */
	function MIMETypes () {

		$this->textTypes = array (
		//	extension => subType
			"css"	=> "css",
			"html"	=> "html",
			"htm"	=> "html",
			"xhtml"	=> "xhtml+xml",
			"lyx"	=> "x-lyx",
			"txt"	=> "plain",
			"rtf"	=> "richtext",
			"rtx"	=> "richtext",
			"sgml"	=> "sgml",
			"talk"	=> "x-speech",
			"xml"	=> "xml"
		);
		
		$this->imageTypes = array (
		//	extension => subType
			"gif"	=> "gif",
			"xbm"	=> "x-xbitmap",
			"xpm"	=> "x-xpixmap",
			"png"	=> "png",
			"ief"	=> "ief",
			"jpg"	=> "jpeg",
			"jpeg"	=> "jpeg",
			"jpe"	=> "jpeg",
			"tif"	=> "tiff",
			"tiff"	=> "tiff",
			"rgb"	=> "rgb",
			"g3f"	=> "g3fax",
			"xwd"	=> "x-xwindowdump",
			"pict"	=> "x-pict",
			"ppm"	=> "x-portable-pixmap",
			"pgm"	=> "x-portable-graymap",
			"pbm"	=> "x-portable-bitmap",
			"pnm"	=> "x-portable-anymap",
			"bmp"	=> "x-ms-bmp",
			"ras"	=> "x-cmu-raster",
			"pcd"	=> "x-photo-cd",
			"cgm"	=> "cgm",
			"mil"	=> "x-cals",
			"cal"	=> "x-cals",
			"fif"	=> "fif",
			"dsf"	=> "x-mgx-dsf",
			"cmx"	=> "x-cmx",
			"wi"	=> "wavelet",
			"dwg"	=> "vnd.dwg",
			"dxf"	=> "vnd.dxf",
			"svf"	=> "vnd.svf"
		);
		
		$this->audioTypes = array (
		//	extension => subType
			"au"	=> "basic",
			"snd"	=> "basic",
			"aif"	=> "x-aiff",
			"aiff"	=> "x-aiff",
			"aifc"	=> "x-aiff",
			"wav"	=> "x-wav",
			"mpa"	=> "mpeg",
			"abs"	=> "mpeg",
			"mpega"	=> "mpeg",
			"mp2a"	=> "mpeg",
			"mp3"	=> "mpeg",		//	"x-mpeg-3" ?
			"mid"	=> "midi",
			"midi"	=> "midi",
			"mmid"	=> "midi",
			"es"	=> "echospeech",
			"vox"	=> "voxware"
		);

		$this->videoTypes = array (
		//	extension => subType
			"mpeg"	=> "mpeg",
			"mpg"	=> "mpeg",
			"mpe"	=> "mpeg",
			"mpv2"	=> "mpeg",
			"mp2v"	=> "mpeg",
			"mpa2"	=> "mpeg",
			"mp2"	=> "mpeg",
			"mp4"	=> "mp4",
			"m4v"	=> "x-m4v",
			"qt"	=> "quicktime",
			"mov"	=> "quicktime",
			"moov"	=> "quicktime",
			"asf"	=> "x-ms-asf",
			"avi"	=> "x-msvideo",
			"movie"	=> "x-sgi-movie",
			"vdo"	=> "vdo",
			"viv"	=> "vnd.vivo",
			"wmv"	=> "x-ms-wmv",
			"flv"	=> "x-flv",
			"dv"	=> "x-dv",
			"mjp"	=> "x-motion-jpeg",
			"mj2"	=> "x-motion-jpeg",
			"mjpg"	=> "x-motion-jpeg",
			"mkv"	=> "x-matroska",
			"ogv"	=> "ogg",
			"rv"	=> "vnd-rn-realvideo",
			"qt"	=> "quicktime ",
			"wm"	=> "x-ms-wm",
		);
		
		$this->applicationTypes = array (
		//	extension => subType
			"lcc"	=> "fastman",
			"skp"	=> "vnd.koan",
			"ra"	=> "x-pn-realaudio",
			"ram"	=> "x-pn-realaudio",
			"rm"	=> "vnd.rn-realmedia",
			
			"ai"	=> "postscript",
			"eps"	=> "postscript",
			"ps"	=> "postscript",
			"rtf"	=> "rtf",
			"pdf"	=> "pdf",
			"mif"	=> "vnd.mif",
			
			"t"		=> "x-troff",
			"tr"	=> "x-troff",
			"roff"	=> "x-troff",
			"man"	=> "x-troff-man",
			"me"	=> "x-troff-me",
			"ms"	=> "x-troff-ms",
			
			"latex"	=> "x-latex",
			"tex"	=> "x-tex",
			"texinfo"	=> "x-texinfo",
			"texi"	=> "x-texinfo",
			"dvi"	=> "x-dvi",
			
			"doc"	=> "msword",
			"xls"	=> "vnd.ms-excel",
			"ppt"	=> "mspowerpoint",
			"ppz"	=> "mspowerpoint",
			
			"oda"	=> "oda",
			"evy"	=> "envoy",
			
			"fm"	=> "vnd.framemaker",
			"frm"	=> "vnd.framemaker",
			"frame"	=> "vnd.framemaker",
			
			"gtar"	=> "x-gtar",
			"tar"	=> "x-tar",
			"ustar"	=> "x-ustar",
			"bz"	=> "x-bzip",
			"bz2"	=> "x-bzip2",
			"gz"	=> "x-gzip",
			"gzip"	=> "x-gzip",
			"bcpio"	=> "x-bcpio",
			"cpio"	=> "x-cpio",
			"shar"	=> "x-shar",
			"zip"	=> "zip",
			"hqx"	=> "mac-binhex40",
			"sit"	=> "x-stuffit",
			"sea"	=> "x-stuffit",
			"fif"	=> "fractals",
			"bin"	=> "octet-stream",
			"uu"	=> "octet-stream",
			"exe"	=> "octet-stream",
			"src"	=> "x-wais-source",
			"wsrc"	=> "x-wais-source",
			"hdf"	=> "hdf",
			
			"js"	=> "x-javascript",
			"ls"	=> "x-javascript",
			"mocha"	=> "x-javascript",
			"sh"	=> "x-sh",
			"csh"	=> "x-csh",
			"pl"	=> "x-perl",
			"tcl"	=> "x-tcl",
			"spl"	=> "futuresplash",
			"mbd"	=> "mbedlet",
			"rad"	=> "x-rad-powermedia",
			
			"asp"	=> "x-asap",
			"asn"	=> "astound",
			"axs"	=> "x-olescript",
			"ods"	=> "x-oleobject",
			"opp"	=> "x-openscape",
			"wba"	=> "x-webbasic",
			"frm"	=> "x-alpha-form",
			"wfx"	=> "x-wfxclient",
			"pcn"	=> "x-pcn",

			"svd"	=> "vnd.svd",
			"ins"	=> "x-net-install",
			"ccv"	=> "ccv",
			"vts"	=> "formulaone",
			
			"sxw"	=> "vnd.sun.xml.writer",
			"sxc"	=> "vnd.sun.xml.calc",
			
			"swf"	=> "x-shockwave-flash",
		);
	}
	

	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	database_index			integer
	 *	database_name			string
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.OsidException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.OsidException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( Properties $configuration ) { 
		$this->_configuration =$configuration;
	}

	/**
	 * Return context of this OsidManager.
	 *	
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function getOsidContext () { 
		return $this->_osidContext;
	} 

	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( OsidContext $context ) { 
		$this->_osidContext =$context;
	} 
		
	/**
	 * Get the MIME Type for the specified filename.
	 * 
	 * @param string $filename
	 * @return string
	 * @access public
	 * @since 10/20/04
	 */
	function getMIMETypeForFileName ( $filename ) {
		// If we have an extension, sniff for it.
		if (preg_match("/.+\.([^\.]+)/", $filename, $parts)) {
			$extension = $parts[1];
			return MIMETypes::getMIMETypeForExtension($extension);
		} else {
			return "application/octet-stream";
		}
	}
	
	/**
	 * Get the MIME Type for a particular extension.
	 * 
	 * @param string $extension
	 * @return string
	 * @access public
	 * @since 10/20/04
	 */
	function getMIMETypeForExtension ( $extension ) {
		trim($extension, ".");
		$extension = strtolower($extension);
		
		if (array_key_exists($extension, $this->textTypes))
			return "text/".$this->textTypes[$extension];
			
		if (array_key_exists($extension, $this->imageTypes))
			return "image/".$this->imageTypes[$extension];
			
		if (array_key_exists($extension, $this->audioTypes))
			return "audio/".$this->audioTypes[$extension];
		
		if (array_key_exists($extension, $this->videoTypes))
			return "video/".$this->videoTypes[$extension];
		
		if (array_key_exists($extension, $this->applicationTypes))
			return "application/".$this->applicationTypes[$extension];
		
		// If we still can't figure it out, send application.octet-stream.
		return "application/octet-stream";
	}
	
	/**
	 * Get the first known extension for a given MIME Type.
	 * 
	 * @param string $type
	 * @return string
	 * @access public
	 * @since 10/20/04
	 */
	function getExtensionForMIMEType ( $type ) {
		$parts = explode("/", $type);
		$type = $parts[0];
		if (isset($parts[1]))
			$subType = $parts[1];
		else
			$subType = NULL;
		
		if ($type == 'text') {
			if ($keys = array_search($subType, $this->textTypes)) {
				if (is_array($keys))
					return $keys[0];
				else
					return $keys;
			
			} else
				return "txt";
		}
		
		if ($type == 'image') {
			if ($keys = array_search($subType, $this->imageTypes)) {
				if (is_array($keys))
					return $keys[0];
				else
					return $keys;
			}
// 			else
// 				return "";
		}
			
		if ($type == 'audio') {
			if ($keys = array_search($subType, $this->audioTypes)) {
				if (is_array($keys))
					return $keys[0];
				else
					return $keys;
			}
// 			else
// 				return "";
		}
		
		if ($type == 'video') {
			if ($keys = array_search($subType, $this->videoTypes)) {
				if (is_array($keys))
					return $keys[0];
				else
					return $keys;
			}
// 			else
// 				return "";
		}
		
		if ($type == 'application') {
			if ($keys = array_search($subType, $this->applicationTypes)) {
				if (is_array($keys))
					return $keys[0];
				else
					return $keys;
			}
// 			else
// 				return "";
		}
		
		// If we still can't figure it out, send application.octet-stream.
		return "";
	}
}

?>