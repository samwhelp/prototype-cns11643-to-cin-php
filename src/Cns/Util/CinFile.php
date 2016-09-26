<?php

namespace Cns\Util;

class CinFile extends BaseFile {

	public function save()
	{
		if ($this->_Content === null) {
			$this->_Content = $this->defContent();
		}

		parent::save();
	}

	protected $_Path = 'CnsPhonetic.cin';

	protected $_Content = null;
	public function defContent()
	{
		$rtn = '';
		$rtn .= $this->createBlock_Head();
		$rtn .= $this->createBlock_KeyName();
		$rtn .= $this->createBlock_CharDef();
		return $rtn;
	}

	protected $_Content_Cname = '全字庫注音';
	public function setContent_Cname($val)
	{
		$this->_Content_Cname = $val;
		return $this;
	}

	protected $_Content_Ename = 'CnsPhonetic';
	public function setContent_Ename($val)
	{
		$this->_Content_Ename = $val;
		return $this;
	}

	protected $_Content_SelKey = '1234567890';
	public function setContent_SelKey($val) {
		$this->_Content_SelKey = $val;
		return $this;
	}

	protected $_Content_EndKey = '3467';
	public function setContent_EndKey($val)
	{
		$this->_Content_EndKey = $val;
		return $this;
	}

	protected $_Content_KeyName = '';
	public function setContent_KeyName($val)
	{
		$this->_Content_KeyName = $val;
		return $this;
	}

	protected $_Content_CharDef = '';
	public function setContent_CharDef($val)
	{
		$this->_Content_CharDef = $val;
		return $this;
	}

	public function createBlock_Head()
	{
		$rtn = '';
		$rtn .= '%gen_inp' . PHP_EOL;
		$rtn .= '%ename ' . $this->_Content_Ename . PHP_EOL;
		$rtn .= '%cname ' . $this->_Content_Cname . PHP_EOL;
		$rtn .= '%selkey ' . $this->_Content_SelKey . PHP_EOL;
		$rtn .= '%endkey ' . $this->_Content_EndKey . PHP_EOL;
		return $rtn;
	}

	public function createBlock_KeyName()
	{
		$rtn = '';
		$rtn .= '%keyname begin' .  PHP_EOL;
		$rtn .= $this->_Content_KeyName;
		$rtn .= '%keyname end' .  PHP_EOL;

		return $rtn;
	}

	public function createBlock_CharDef()
	{
		$rtn = '';
		$rtn .= '%chardef begin' .  PHP_EOL;
		$rtn .= $this->_Content_CharDef;
		$rtn .= '%chardef end' .  PHP_EOL;
		return $rtn;
	}


} // End Class
