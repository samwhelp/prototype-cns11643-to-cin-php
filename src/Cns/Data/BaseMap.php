<?php

namespace Cns\Data;

class BaseMap {

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
