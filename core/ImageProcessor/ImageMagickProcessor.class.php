<?php

/**
 * Class for Processing images using ImageMagick
 * 
 * @package harmoni.image_processor
 * @version $Id: ImageMagickProcessor.class.php,v 1.3 2004/11/06 02:18:27 adamfranco Exp $
 * @date $Date: 2004/11/06 02:18:27 $
 * @copyright 2004 Middlebury College
 */

class ImageMagickProcessor {
		
	/**
	 * Constructor
	 * 
	 * @param string $thumbnailFormat The mime type of the format you which thumbnails
	 *			to be generated in. image/jpeg or image/png are recommended.
	 * @param string $ImageMagickPath The path to the ImageMagick functions if
	 *			ImageMagick is availible.
	 * @param string $ImageMagickTempDir Directory in which to place images while
	 *			processing.
	 * @return object
	 * @access public
	 * @date 10/22/04
	 */
	function ImageMagickProcessor ($thumbnailFormat, $ImageMagickPath = "/usr/bin", 
			$ImageMagickTempDir = "/tmp") 
	{
		$this->_thumbnailFormat = $thumbnailFormat;
		$this->_ImageMagickPath = $ImageMagickPath;
		$this->_ImageMagickTempDir = $ImageMagickTempDir;
		
		$this->_formatConversions = array (
			"art" => "jpg",
			"avi" => "jpg",
			"avs" => "avs",
			
			"bmp" => "bmp",
			
			"cgm" => "jpg",
			"cin" => "cin",
			"cmyk" => "cmyk",
			"cmyka" => "cmyka",
			"cur" => "jpg",
			"cut" => "jpg",
			
			"dcm" => "jpg",
			"dcx" => "dcx",
			"dib" => "dib",
			"dpx" => "dpx",
			
			"emf" => "jpg",
			"edpf" => "edpf",
			"epi" => "epi",
			"eps" => "eps",
// 			"eps2" => "eps2",
// 			"eps3" => "eps3",
			"epsf" => "epsf",
			"epsi" => "epsi",
			"ept" => "ept",
			
			"fax" => "fax",
			"fits" => "fits",
			"fpx" => "fpx",
			
			"gif" => "gif",
			"gplt" => "jpg",
			"gray" => "gray",
			
			"hpgl" => "jpg",
			"html" => "html",
			
			"ico" => "png",
			"icon" => "png",
			
			"jbig" => "jbig",
			"jnp" => "jng",
			"jpg" => "jpg",
			"jpeg" => "jpg",
			"jp2" => "jp2",
			"jpc" => "jpc",
			
			"man" => "jpg",
			"mat" => "jpg",
			"miff" => "miff",
			"mono" => "mono",
			"mng" => "mng",
			"m2v" => "m2v",
			"mpc" => "mpc",
			"msl" => "msl",
			"mtv" => "mtv",
			"mvg" => "mvg",
			
			"otb" => "otb",
			
			"p7" => "jpg",
			"palm" => "palm",
			"pbm" => "pbm",
			"pcd" => "pcd",
			"pcds" => "pcds",
//			"pcl" => "pcl",
			"pcx" => "pcx",
			"pdb" => "pdb",
			"pdf" => "pdf",
			"pfa" => "jpg",
			"pfb" => "jpg",
			"pgm" => "pgm",
			"picon" => "picon",
			"png" => "png",
			"pnm" => "pnm",
			"ppm" => "ppm",
			"ps" => "ps",
			"ps2" => "ps2",
			"ps3" => "ps3",
			"psd" => "psd",
			"ptif" => "ptif",
			"pwp" => "jpg",
			
			"rad" => "jpg",
			"rgb" => "rgb",
			"rgba" => "rgba",
			"rla" => "jpg",
			
			"sct" => "jpg",
			"sfw" => "jpg",
			"sgi" => "sgi",
//			"shtml" => "shtml",
			"sun" => "sun",
			"svg" => "svg",
			
			"tga" => "tga",
			"tiff" => "tif",
			"tif" => "tif",
			"tim" => "jpg",
			"ttf" => "png",
			"txt" => "txt",
			
//			"uil" => "uil",
			"uyvy" => "uyvy",
			
			"vicar" => "vicar",
			"viff" => "viff",
			
			"wbmp" => "wbmp",
//			"wmf" => "jpg",
			"wpg" => "jpg",
			
			"xbm" => "xbm",
			"xcf" => "png",
			"xpm" => "xpm",
			"xwd" => "xwd",
			
			"ycbcr" => "ycbcr",
			"ycbcra" => "ycbcra",
			"yuv" => "yuv"
		);
		
		$this->_websafeFormats = array(
			"png",
			"gif",
			"jpg"
		);
	}
	
	/**
	 * Return True if we support this format
	 * 
	 * @param string $format
	 * @return boolean
	 * @access public
	 * @date 11/5/04
	 */
	function isSupported ($format) {
		// Get the extension coresponding to the format.
		$mime =& Services::getService("MIME");
		$extension = $mime->getExtensionForMIMEType($format);
		
		if ($this->_formatConversions[$extension])
			return TRUE;
		else
			return FALSE;
	}
	
	
	
	/**
	 * Generate a thumbnail from the image format/data passed
	 * 
	 * @param string $format The format of the source image
	 * @param string $data	The data of the source image
	 * @return string The thumbnail data of $thumbnailFormat mime type.
	 * @access public
	 * @date 10/22/04
	 */
	function generateThumbnailData ($format, $data) {
		// Get the extension coresponding to the format.
		$mime =& Services::getService("MIME");
		$extension = $mime->getExtensionForMIMEType($format);
		$thumbExtension = $mime->getExtensionForMIMEType($this->_thumbnailFormat);
		
		return $this->_generateData($extension, $thumbExtension, 200, $data);
	}
	
		
	/**
	 * Get the format that a resized image will be returned in
	 * 
	 * @param string $format The format of the source image
	 * @return string The mime type.
	 * @access public
	 * @date 10/22/04
	 */
	function getResizedFormat ($format) {
		$mime =& Services::getService("MIME");
		$extension = $mime->getExtensionForMIMEType($format);
		if ($newExtension = $this->_formatConversions[$extension]) {
			return $mime->getMIMETypeForExtension($newExtension);
		} else
			throwError(new Error("Unsupported Format for conversion Conversion, '$format'.",
				"ImageProcessor", true));
	}
	
	/**
	 * Generate a resized image from the image format/data passed
	 * 
	 * @param string $format The format of the source image
	 * @param integer $size The max size in pixels of the resulting image
	 * @param string $data	The data of the source image
	 * @return string The thumbnail data of a mime type that can be obtained with
	 *		getResizedFormat.
	 * @access public
	 * @date 10/22/04
	 */
	function getResizedData ($format, $size, $data) {
		// get the original extension and our new one.
		$mime =& Services::getService("MIME");
		$extension = $mime->getExtensionForMIMEType($format);
		if ($newExtension = $mime->getExtensionForMIMEType($this->getResizedFormat($format))) {
			return $this->_generateData($extension, $newExtension, $size, $data);
		} else
			throwError(new Error("Unsupported Format for conversion Conversion, '$format'.",
				"ImageProcessor", true));
	}
	
	/**
	 * Get the format that a web-safe resized image will be returned in
	 * 
	 * @param string $format The format of the source image
	 * @return string The mime type.
	 * @access public
	 * @date 10/22/04
	 */
	function getWebsafeFormat ($format) {
		$mime =& Services::getService("MIME");
		$extension = $mime->getExtensionForMIMEType($format);
		$newExtension = $this->_formatConversions[$extension];
		if (!in_array($newExtension, $this->_websafeFormats))
			$newExtension = "jpg";
		
		if ($newExtension) {
			return $mime->getMIMETypeForExtension($newExtension);
		} else
			throwError(new Error("Unsupported Format for conversion Conversion, '$format'.",
				"ImageProcessor", true));
	}
	
	/**
	 * Generate a web-safe resized image from the image format/data passed
	 * 
	 * @param string $format The format of the source image
	 * @param integer $size The max size in pixels of the resulting image
	 * @param string $data	The data of the source image
	 * @return string The thumbnail data of a mime type that can be obtained with
	 *		getResizedFormat.
	 * @access public
	 * @date 10/22/04
	 */
	function getWebsafeData ($format, $size, $data) {
		// get the original extension and our new one.
		$mime =& Services::getService("MIME");
		$extension = $mime->getExtensionForMIMEType($format);
		if ($newExtension = $mime->getExtensionForMIMEType($this->getWebsafeFormat($format))) {
			return $this->_generateData($extension, $newExtension, $size, $data);
		} else
			throwError(new Error("Unsupported Format for conversion Conversion, '$format'.",
				"ImageProcessor", true));
	}
	
	/**
	 * Generate a new image with possible conversion to a new type and size
	 * 
	 * @param string $inputExtension The extension that corresponds to the input data.
	 * @param string $ouputExtension The extension that corresponds to the output data.
	 * @param integer $size	The max size in pixels of the output image
	 * @param string $inputData	The input data.
	 * @return string
	 * @access public
	 * @date 11/5/04
	 */
	function _generateData ($inputExtension, $ouputExtension, $size, $inputData) {
		if ($inputExtension == $ouputExtension && !$size) {
			return $inputData;
		} else {
			$randomString = time();
			$sourceFilename = $randomString."_in.".$inputExtension;
			$destFilename = $randomString."_out.".$ouputExtension;
			$sourcePath = $this->_ImageMagickTempDir."/".$sourceFilename;
			$destPath = $this->_ImageMagickTempDir."/".$destFilename;
			
			// Write the data to the tmp directory.
			if (!is_writable($this->_ImageMagickTempDir))
				throwError(new Error("Temp dir, '".$this->_ImageMagickTempDir
								."', is not writable.", "ImageProcessor", true));
			if (!$handle = fopen($sourcePath, 'w'))
				throwError(new Error("'".$sourcePath
								."' can not be opened.", "ImageProcessor", true));
			if (fwrite($handle, $inputData) === FALSE)
				throwError(new Error("'".$sourcePath
								."' is not writable.", "ImageProcessor", true));
			fclose($handle);
			
			// Create the thumbnail.
			$convertString = "convert ";
			if ($size)
				$convertString .= "-size ".$size."x".$size." ";
			$convertString .= $sourcePath." ";
			if ($size)
				$convertString .= " -resize ".$size."x".$size." ";
			$convertString .= $destPath;
			
			$text = exec($convertString, $ouput, $exitCode);
			
			if ($exitCode) {
				unlink($sourcePath);
				unlink($destPath);
//				throwError(new Error("Convert Failed: '$convertString' $text ", "ImageProcessor", true));
				print "Convert Failed: '$convertString'";
				exit;
			} else {			
				// read the thumbnail data.
				$outData = file_get_contents($destPath);
			}
			
			// delete the temporary files;
			unlink($sourcePath);
			unlink($destPath);
			
			return $outData;
		}
	}
	
	
}

?>