<?php

namespace Cns\Mapping;

abstract class Base {

	public static function newInstance()
	{
		//http://php.net/manual/en/language.oop5.late-static-bindings.php
        return new static();
	}

	public function __construct()
	{
		//http://php.net/manual/en/language.oop5.decon.php
		$this->init();
	}

	protected function init()
	{
		return true;
	}

	protected function prep()
	{
		return true;
	}

	public function load()
	{
		//var_dump(__METHOD__);

		if ($this->prep() === false) {
			return false;
		}

		return true;
	}

	public function toArray()
	{
		return $this->_List->toArray();
	}

	protected $_List = null;
	public function getList()
	{
		return $this->_List;
	}

	protected $_Map = null;
	public function getMap()
	{
		return $this->_Map;
	}

	protected $_SourceFilePath = 'Source.txt';
	public function setSourceFilePath($val)
	{
		$this->_SourceFilePath = $val;
		return $this;
	}
	public function getSourceFilePath()
	{
		return $this->_SourceFilePath;
	}

} // End Class
