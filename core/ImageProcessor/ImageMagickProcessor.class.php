<?php

/**
 * Class for Processing images using ImageMagick
 * 
 * @package harmoni.image_processor
 * @version $Id: ImageMagickProcessor.class.php,v 1.1 2004/10/22 21:58:46 adamfranco Exp $
 * @date $Date: 2004/10/22 21:58:46 $
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
		
		$randomString = time();
		$sourceFilename = $randomString.".".$extension;
		$thumbFilename = $randomString."_thumb.".$thumbExtension;
		$sourcePath = $this->_ImageMagickTempDir."/".$sourceFilename;
		$thumbPath = $this->_ImageMagickTempDir."/".$thumbFilename;
		
		// Write the data to the tmp directory.
		if (!is_writable($this->_ImageMagickTempDir))
			throwError(new Error("Temp dir, '".$this->_ImageMagickTempDir
							."', is not writable.", "ImageProcessor", true));
		if (!$handle = fopen($sourcePath, 'w'))
			throwError(new Error("'".$sourcePath
							."' can not be opened.", "ImageProcessor", true));
		if (fwrite($handle, $data) === FALSE)
			throwError(new Error("'".$sourcePath
							."' is not writable.", "ImageProcessor", true));
		fclose($handle);
		
		// Create the thumbnail.
		$convertString = "convert -size 200x200 ".$sourcePath." -resize 200x200 ".$thumbPath;
		$text = exec($convertString, $ouput, $exitCode);
		
		if ($exitCode) {
			throwError(new Error("Convert Failed: '$convertString' $text ".implode("\n", $output), "ImageProcessor", true));
		}
		
		// read the thumbnail data.
		$thumbData = file_get_contents($thumbPath);
		
		// delete the temporary files;
		unlink($sourcePath);
		unlink($thumbPath);
		
		return $thumbData;
	}
	
}

?>