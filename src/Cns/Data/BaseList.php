<?php

namespace Cns\Data;

class BaseList {

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

	public function push($val)
	{
		array_push($this->_Raw, $val);
		return $this;
	}

	public function ref($key)
	{
		if (!array_key_exists($key, $this->_Raw)) {
			return '';
		}
		return $this->_Raw[$key];
	}

	public function toArray()
	{
		return $this->_Raw;
	}

} // End Class
