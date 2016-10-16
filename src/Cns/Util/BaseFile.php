<?php

namespace Cns\Util;

class BaseFile extends Base {

	public function save()
	{
		if ($this->prep() === false) {
			return false;
		}

		file_put_contents($this->_Path, $this->_Content);

		return true;
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
