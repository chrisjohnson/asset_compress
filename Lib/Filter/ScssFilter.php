<?php
App::uses('AssetFilter', 'AssetCompress.Lib');

/**
 * Pre-processing filter that adds support for SCSS files.
 *
 * Requires ruby and sass rubygem to be installed
 *
 * @see http://sass-lang.com/
 */
class ScssFilter extends AssetFilter {

	protected $_settings = array(
		'ext' => '.scss',
		'extOnly' => true,
		'sass' => '/usr/bin/sass',
		'path' => '/usr/bin',
		'lang' => 'sass',
		'compressed' => false,
	);

/**
 * Runs SCSS compiler against any files that match the configured extension.
 *
 * @param string $filename The name of the input file.
 * @param string $input The content of the file.
 * @return string
 */
	public function input($filename, $input) {
		if (!empty($this->_settings['extOnly']) && substr($filename, strlen($this->_settings['ext']) * -1) !== $this->_settings['ext']) {
			return $input;
		}
		$filename = preg_replace('/ /', '\\ ', $filename);
		$bin = $this->_settings['sass'] . ' ' . $filename;
		if ($this->_settings['lang'] == 'scss') {
			$bin .= ' --scss';
		}
		if (!empty($this->_settings['compressed'])) {
			$bin .= ' --style compressed';
		}
		$return = $this->_runCmd($bin, '', array('PATH' => $this->_settings['path']));
		return $return;
	}

}
