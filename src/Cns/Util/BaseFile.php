<?php

namespace Cns\Util;

class BaseFile {

	public static function newInstance()
	{
        return new static(); //http://php.net/manual/en/language.oop5.late-static-bindings.php
    }

	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		return $this;
	}

	public function prep()
	{
		return $this;
	}

	public function save()
	{
		file_put_contents($this->_Path, $this->_Content);
		return $this;
	}

	protected $_Path = '';
	public function setPath($val)
	{
		$this->_Path = $val;
		return $this;
	}
	public function getPath()
	{
		return $this->_Path;
	}

	protected $_Content = '';
	public function setContent($val)
	{
		$this->_Content = $val;
		return $this;
	}
	public function getContent()
	{
		return $this->_Content;
	}

} // End Class
