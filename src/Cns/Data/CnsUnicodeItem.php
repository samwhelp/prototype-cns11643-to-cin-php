<?php

namespace Cns\Data;

class CnsUnicodeItem extends BaseMap {

	public function init()
	{
		$this->_Raw['grp'] = '';
		$this->_Raw['cns'] = '';
		$this->_Raw['unicode'] = '';
		$this->_Raw['cnsunicode_line'] = '';
		$this->_Raw['cnsunicode_file'] = '';

		return $this;
	}
} // End Class
