<?php

require_once(dirname(__FILE__)."/ImageMagickProcessor.class.php");
//require_once(dirname(__FILE__)."/GDProcessor.class.php");

/**
 * Class for resizing of images
 *
 * @package harmoni.image_processor
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ImageProcessor.class.php,v 1.7 2005/04/04 18:01:35 adamfranco Exp $
 */

class ImageProcessor {

	/**
	 * Constructor
	 * 
	 * @param string $thumbnailFormat The mime type of the format you which thumbnails
	 *			to be generated in. image/jpeg or image/png are recommended
	 * @param boolean $useGD If true, the GD image libraries will be used
	 *			to generate images of the formats that they support.
	 * @param array $gdFormats An array of mime-types to handle with the GD libraries.
	 * @param boolean $useImageMagick If true, the ImageMagick application will be
	 *			called via the shell to resize images that it supports.
	 * @param string $ImageMagickPath The path to the ImageMagick functions if
	 *			ImageMagick is availible.
	 * @param string $ImageMagickTempDir Directory in which to place images while
	 *			processing.
	 * @param array $ImageMagickFormats An array of mime-types to handle with ImageMagick.
	 * @return obj
	 * @access public
	 * @since 10/22/04
	 */
	function ImageProcessor () {}
	
	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *
	 *	thumbnail_format		string	(ex: 'image/jpeg')
	 *
	 *	use_gd					boolean
	 I
	 *	gd_formats				array of strings	(ex: array('image/jpeg', 'image/png'))
	 *							An empty array indicates any/all supported formats.
	 *
	 *	use_imagemagick			boolean
	 *
	 *	imagemagick_path		string	(ex: 'usr/bin' OR '/usr/X11R6/bin')
	 *
	 *	imagemagick_temp_dir	string	(ex: '/tmp')
	 *
	 *	imagemagick_formats		array of strings	(ex: array('image/jpeg', 'image/png'))
	 *							An empty array indicates any/all supported formats.
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
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
		
		ArgumentValidator::validate($configuration->getProperty('thumbnail_format'), 
			StringValidatorRule::getRule());
		ArgumentValidator::validate($configuration->getProperty('use_gd'), 
			BooleanValidatorRule::getRule());
		ArgumentValidator::validate($configuration->getProperty('gd_formats'), 
			ArrayValidatorRuleWithRule::getRule(StringValidatorRule::getRule()));
		ArgumentValidator::validate($configuration->getProperty('use_imagemagick'), 
			BooleanValidatorRule::getRule());
		ArgumentValidator::validate($configuration->getProperty('imagemagick_path'), 
			StringValidatorRule::getRule());
		ArgumentValidator::validate($configuration->getProperty('imagemagick_temp_dir'), 
			StringValidatorRule::getRule());
		ArgumentValidator::validate($configuration->getProperty('imagemagick_formats'), 
			ArrayValidatorRuleWithRule::getRule(StringValidatorRule::getRule()));
		
		$this->_thumbnailFormat = $configuration->getProperty('thumbnail_format');
		$this->_useGD = $configuration->getProperty('use_gd');
		$this->_gdFormats = $configuration->getProperty('gd_formats');
		$this->_useImageMagick = $configuration->getProperty('use_imagemagick');
		$this->_ImageMagickPath = $configuration->getProperty('imagemagick_path');
		$this->_ImageMagickTempDir = $configuration->getProperty('imagemagick_temp_dir');
		$this->_ImageMagickFormats = $configuration->getProperty('imagemagick_formats');
		
		if ($this->_useGD)
			$this->_gdProcessor =& new GDProcessor($configuration->getProperty('thumbnail_format'));
		if ($this->_useImageMagick)
			$this->_ImageMagickProcessor =& new ImageMagickProcessor(
						$configuration->getProperty('thumbnail_format'), $this->_ImageMagickPath, 
						$this->_ImageMagickTempDir);
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
	function &getOsidContext () { 
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
	function assignOsidContext ( &$context ) { 
		$this->_osidContext =& $context;
	}
	
	/**
	 * Return true if the image format is supported.
	 * 
	 * @param string $format The mime type of the format in question.
	 * @return boolean
	 * @access public
	 * @since 10/22/04
	 */
	function isFormatSupported ( $format ) {
		ArgumentValidator::validate($format, StringValidatorRule::getRule());
		
		if (in_array($format, $this->_gdFormats) 
			|| in_array($format, $this->_ImageMagickFormats)
			|| ($this->_useImageMagick
				&& $this->_ImageMagickProcessor->isSupported($format)))
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Generate a thumbnail from the image format/data passed
	 * 
	 * @param string $format The format of the source image
	 * @param string $data	The data of the source image
	 * @return string The thumbnail data of $thumbnailFormat mime type.
	 * @access public
	 * @since 10/22/04
	 */
	function generateThumbnailData ($format, $data) {
		if (in_array($format, $this->_gdFormats))
			return $this->_gdProcessor->generateThumbnailData($format, $data);
		if (in_array($format, $this->_ImageMagickFormats))
			return $this->_ImageMagickProcessor->generateThumbnailData($format, $data);
		if ($this->_useImageMagick
			&& $this->_ImageMagickProcessor->isSupported($format))
			return $this->_ImageMagickProcessor->generateThumbnailData($format, $data);
		
		throwError(new Error("Unsupported Format, '$format'.", "ImageProcessor", true));
	}
	
	/**
	 * Return the format that thumbnails will be generated in.
	 * 
	 * @return string
	 * @access public
	 * @since 10/22/04
	 */
	function getThumbnailFormat () {
		return $this->_thumbnailFormat;
	}
	
	/**
	 * Get the format that a resized image will be returned in
	 * 
	 * @param string $format The format of the source image
	 * @return string The mime type.
	 * @access public
	 * @since 10/22/04
	 */
	function getResizedFormat ($format) {
		if (in_array($format, $this->_gdFormats))
			return $this->_gdProcessor->getResizedFormat($format);
		if (in_array($format, $this->_ImageMagickFormats))
			return $this->_ImageMagickProcessor->getResizedFormat($format);
		if ($this->_useImageMagick
			&& $this->_ImageMagickProcessor->isSupported($format))
			return $this->_ImageMagickProcessor->getResizedFormat($format);
		
		throwError(new Error("Unsupported Format, '$format'.", "ImageProcessor", true));
	}
	
	/**
	 * Generate a resized image from the image format/data passed
	 * 
	 * @param string $format The format of the source image
	 * @param string $data	The data of the source image
	 * @return string The thumbnail data of a mime type that can be obtained with
	 *		getResizedFormat.
	 * @access public
	 * @since 10/22/04
	 */
	function getResizedData ($format, $size, $data) {
		if (in_array($format, $this->_gdFormats))
			return $this->_gdProcessor->getResizedData($format, $size, $data);
		if (in_array($format, $this->_ImageMagickFormats))
			return $this->_ImageMagickProcessor->getResizedData($format, $size, $data);
		if ($this->_useImageMagick
			&& $this->_ImageMagickProcessor->isSupported($format))
			return $this->_ImageMagickProcessor->getResizedData($format, $size, $data);
		
		throwError(new Error("Unsupported Format, '$format'.", "ImageProcessor", true));
	}
	
	/**
	 * Get the format that a resized image will be returned in
	 * 
	 * @param string $format The format of the source image
	 * @return string The mime type.
	 * @access public
	 * @since 10/22/04
	 */
	function getWebsafeFormat ($format) {
		if (in_array($format, $this->_gdFormats))
			return $this->_gdProcessor->getWebsafeFormat($format);
		if (in_array($format, $this->_ImageMagickFormats))
			return $this->_ImageMagickProcessor->getWebsafeFormat($format);
		if ($this->_useImageMagick
			&& $this->_ImageMagickProcessor->isSupported($format))
			return $this->_ImageMagickProcessor->getWebsafeFormat($format);
		
		throwError(new Error("Unsupported Format, '$format'.", "ImageProcessor", true));
	}
	
	/**
	 * Generate a resized image from the image format/data passed
	 * 
	 * @param string $format The format of the source image
	 * @param string $data	The data of the source image
	 * @return string The thumbnail data of a mime type that can be obtained with
	 *		getResizedFormat.
	 * @access public
	 * @since 10/22/04
	 */
	function getWebsafeData ($format, $size, $data) {
		if (in_array($format, $this->_gdFormats))
			return $this->_gdProcessor->getWebsafeData($format, $size, $data);
		if (in_array($format, $this->_ImageMagickFormats))
			return $this->_ImageMagickProcessor->getWebsafeData($format, $size, $data);
		if ($this->_useImageMagick
			&& $this->_ImageMagickProcessor->isSupported($format))
			return $this->_ImageMagickProcessor->getWebsafeData($format, $size, $data);
		
		throwError(new Error("Unsupported Format, '$format'.", "ImageProcessor", true));
	}
}

?>