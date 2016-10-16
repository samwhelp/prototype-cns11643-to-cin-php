<?php

namespace Cns\Data;

class BaseMap {

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

	protected $_Raw = array();

	public function put($key, $val)
	{
		$this->_Raw[$key] = $val;
		return $this;
	}

	public function ref($key)
	{
		if (!array_key_exists($key, $this->_Raw)) {
			return '';
		}
		return $this->_Raw[$key];
	}

	public function has($key)
	{
		if (array_key_exists($key, $this->_Raw)) {
			return true;
		}
		return false;
	}

	public function toArray()
	{
		return $this->_Raw;
	}
} // End Class
