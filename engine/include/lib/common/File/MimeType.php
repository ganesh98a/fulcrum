<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * File mime types.
 *
 * @category	Framework
 * @package		File
 *
 */

class File_MimeType {

	/**
	 * File extensions mapped to their media type.
	 *
	 * @var array
	 */
	protected static $arrMimeTypes = array(
		'ai'      => 'application/postscript',
		'aif'     => 'audio/x-aiff',
		'aifc'    => 'audio/x-aiff',
		'aiff'    => 'audio/x-aiff',
		'asc'     => 'text/plain',
		'asf'     => 'video/x-ms-asf',
		'asx'     => 'video/x-ms-asf',
		'au'      => 'audio/basic',
		'avi'     => 'video/x-msvideo',
		'bcpio'   => 'application/x-bcpio',
		'bin'     => 'application/octet-stream',
		'bmp'     => 'image/bmp',
		'bz2'     => 'application/x-bzip2',
		'cdf'     => 'application/x-netcdf',
		'chrt'    => 'application/x-kchart',
		'class'   => 'application/octet-stream',
		'cpio'    => 'application/x-cpio',
		'cpt'     => 'application/mac-compactpro',
		'csh'     => 'application/x-csh',
		'css'     => 'text/css',
		'dcr'     => 'application/x-director',
		'dir'     => 'application/x-director',
		'djv'     => 'image/vnd.djvu',
		'djvu'    => 'image/vnd.djvu',
		'dll'     => 'application/octet-stream',
		'dms'     => 'application/octet-stream',
		'doc'     => 'application/msword',
		'dvi'     => 'application/x-dvi',
		'dxr'     => 'application/x-director',
		'eps'     => 'application/postscript',
		'etx'     => 'text/x-setext',
		'exe'     => 'application/octet-stream',
		'ez'      => 'application/andrew-inset',
		'flv'     => 'video/x-flv',
		'gif'     => 'image/gif',
		'gtar'    => 'application/x-gtar',
		'gz'      => 'application/x-gzip',
		'hdf'     => 'application/x-hdf',
		'hqx'     => 'application/mac-binhex40',
		'htm'     => 'text/html',
		'html'    => 'text/html',
		'ice'     => 'x-conference/x-cooltalk',
		'ief'     => 'image/ief',
		'iges'    => 'model/iges',
		'igs'     => 'model/iges',
		'img'     => 'application/octet-stream',
		'iso'     => 'application/octet-stream',
		'jad'     => 'text/vnd.sun.j2me.app-descriptor',
		'jar'     => 'application/x-java-archive',
		'jnlp'    => 'application/x-java-jnlp-file',
		'jpe'     => 'image/jpeg',
		'jpeg'    => 'image/jpeg',
		'jpg'     => 'image/jpeg',
		'js'      => 'application/x-javascript',
		'kar'     => 'audio/midi',
		'kil'     => 'application/x-killustrator',
		'kpr'     => 'application/x-kpresenter',
		'kpt'     => 'application/x-kpresenter',
		'ksp'     => 'application/x-kspread',
		'kwd'     => 'application/x-kword',
		'kwt'     => 'application/x-kword',
		'latex'   => 'application/x-latex',
		'lha'     => 'application/octet-stream',
		'lzh'     => 'application/octet-stream',
		'm3u'     => 'audio/x-mpegurl',
		'man'     => 'application/x-troff-man',
		'me'      => 'application/x-troff-me',
		'mesh'    => 'model/mesh',
		'mid'     => 'audio/midi',
		'midi'    => 'audio/midi',
		'mif'     => 'application/vnd.mif',
		'mov'     => 'video/quicktime',
		'movie'   => 'video/x-sgi-movie',
		'mp2'     => 'audio/mpeg',
		'mp3'     => 'audio/mpeg',
		'mpe'     => 'video/mpeg',
		'mpeg'    => 'video/mpeg',
		'mpg'     => 'video/mpeg',
		'mpga'    => 'audio/mpeg',
		'ms'      => 'application/x-troff-ms',
		'msh'     => 'model/mesh',
		'mxu'     => 'video/vnd.mpegurl',
		'nc'      => 'application/x-netcdf',
		'odb'     => 'application/vnd.oasis.opendocument.database',
		'odc'     => 'application/vnd.oasis.opendocument.chart',
		'odf'     => 'application/vnd.oasis.opendocument.formula',
		'odg'     => 'application/vnd.oasis.opendocument.graphics',
		'odi'     => 'application/vnd.oasis.opendocument.image',
		'odm'     => 'application/vnd.oasis.opendocument.text-master',
		'odp'     => 'application/vnd.oasis.opendocument.presentation',
		'ods'     => 'application/vnd.oasis.opendocument.spreadsheet',
		'odt'     => 'application/vnd.oasis.opendocument.text',
		'ogg'     => 'application/ogg',
		'otg'     => 'application/vnd.oasis.opendocument.graphics-template',
		'oth'     => 'application/vnd.oasis.opendocument.text-web',
		'otp'     => 'application/vnd.oasis.opendocument.presentation-template',
		'ots'     => 'application/vnd.oasis.opendocument.spreadsheet-template',
		'ott'     => 'application/vnd.oasis.opendocument.text-template',
		'pbm'     => 'image/x-portable-bitmap',
		'pdb'     => 'chemical/x-pdb',
		'pdf'     => 'application/pdf',
		'pgm'     => 'image/x-portable-graymap',
		'pgn'     => 'application/x-chess-pgn',
		'php'     => 'text/plain',
		'png'     => 'image/png',
		'pnm'     => 'image/x-portable-anymap',
		'ppm'     => 'image/x-portable-pixmap',
		'ppt'     => 'application/vnd.ms-powerpoint',
		'ps'      => 'application/postscript',
		'qt'      => 'video/quicktime',
		'ra'      => 'audio/x-realaudio',
		'ram'     => 'audio/x-pn-realaudio',
		'ras'     => 'image/x-cmu-raster',
		'rgb'     => 'image/x-rgb',
		'rm'      => 'audio/x-pn-realaudio',
		'roff'    => 'application/x-troff',
		'rpm'     => 'application/x-rpm',
		'rtf'     => 'text/rtf',
		'rtx'     => 'text/richtext',
		'sgm'     => 'text/sgml',
		'sgml'    => 'text/sgml',
		'sh'      => 'application/x-sh',
		'shar'    => 'application/x-shar',
		'silo'    => 'model/mesh',
		'sis'     => 'application/vnd.symbian.install',
		'sit'     => 'application/x-stuffit',
		'skd'     => 'application/x-koan',
		'skm'     => 'application/x-koan',
		'skp'     => 'application/x-koan',
		'skt'     => 'application/x-koan',
		'smi'     => 'application/smil',
		'smil'    => 'application/smil',
		'snd'     => 'audio/basic',
		'so'      => 'application/octet-stream',
		'spl'     => 'application/x-futuresplash',
		'src'     => 'application/x-wais-source',
		'stc'     => 'application/vnd.sun.xml.calc.template',
		'std'     => 'application/vnd.sun.xml.draw.template',
		'sti'     => 'application/vnd.sun.xml.impress.template',
		'stw'     => 'application/vnd.sun.xml.writer.template',
		'sv4cpio' => 'application/x-sv4cpio',
		'sv4crc'  => 'application/x-sv4crc',
		'swf'     => 'application/x-shockwave-flash',
		'sxc'     => 'application/vnd.sun.xml.calc',
		'sxd'     => 'application/vnd.sun.xml.draw',
		'sxg'     => 'application/vnd.sun.xml.writer.global',
		'sxi'     => 'application/vnd.sun.xml.impress',
		'sxm'     => 'application/vnd.sun.xml.math',
		'sxw'     => 'application/vnd.sun.xml.writer',
		't'       => 'application/x-troff',
		'tar'     => 'application/x-tar',
		'tcl'     => 'application/x-tcl',
		'tex'     => 'application/x-tex',
		'texi'    => 'application/x-texinfo',
		'texinfo' => 'application/x-texinfo',
		'tgz'     => 'application/x-gzip',
		'tif'     => 'image/tiff',
		'tiff'    => 'image/tiff',
		'torrent' => 'application/x-bittorrent',
		'tr'      => 'application/x-troff',
		'tsv'     => 'text/tab-separated-values',
		'txt'     => 'text/plain',
		'ustar'   => 'application/x-ustar',
		'vcd'     => 'application/x-cdlink',
		'vrml'    => 'model/vrml',
		'wav'     => 'audio/x-wav',
		'wax'     => 'audio/x-ms-wax',
		'wbmp'    => 'image/vnd.wap.wbmp',
		'wbxml'   => 'application/vnd.wap.wbxml',
		'wm'      => 'video/x-ms-wm',
		'wma'     => 'audio/x-ms-wma',
		'wml'     => 'text/vnd.wap.wml',
		'wmlc'    => 'application/vnd.wap.wmlc',
		'wmls'    => 'text/vnd.wap.wmlscript',
		'wmlsc'   => 'application/vnd.wap.wmlscriptc',
		'wmv'     => 'video/x-ms-wmv',
		'wmx'     => 'video/x-ms-wmx',
		'wrl'     => 'model/vrml',
		'wvx'     => 'video/x-ms-wvx',
		'xbm'     => 'image/x-xbitmap',
		'xht'     => 'application/xhtml+xml',
		'xhtml'   => 'application/xhtml+xml',
		'xls'     => 'application/vnd.ms-excel',
		'xlsx'    => 'application/vnd.ms-excel',
		'xml'     => 'text/xml',
		'xpm'     => 'image/x-xpixmap',
		'xsl'     => 'text/xml',
		'xwd'     => 'image/x-xwindowdump',
		'xyz'     => 'chemical/x-xyz',
		'zip'     => 'application/zip'
	);

	/**
	 * Get the file extension by "." separator: fileName.fileExtension
	 *
	 * @param string $filename
	 * @return string
	 */
	public static function extractFileExtension($filename)
	{
		// strrchr — Find the last occurrence of a character in a string
		// string strrchr ( string $haystack , mixed $needle )
		// This function returns the portion of haystack which starts at the last occurrence of needle and goes until the end of haystack.
		$fileExtension = strrchr($filename, '.');

		// strip off the "." from the file extension string (e.g. ".xxx" to "xxx")
		$fileExtension = substr($fileExtension, 1);

		// Lower case the file extension string
		$fileExtension = strtolower($fileExtension);

		// Normalize the file extension string
		switch ($fileExtension) {
			case 'jpeg':
			case 'jpg':
				$fileExtension = 'jpg';
				break;

			case 'gif':
			case 'giff':
				$fileExtension = 'gif';
				break;

			default:
				break;
		}

		return $fileExtension;
	}

	/**
	 * Key based lookup of mime-type by well-known file extension
	 *
	 * @param string $fileExtension
	 * @return string
	 */
	public static function deriveMimeTypeFromFileExtension($fileExtension)
	{
		$arrMimeTypes = self::$arrMimeTypes;

		if (isset($arrMimeTypes[$fileExtension])) {
			$mimeType = $arrMimeTypes[$fileExtension];
		} else {
			$mimeType = '';
		}

		return $mimeType;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
