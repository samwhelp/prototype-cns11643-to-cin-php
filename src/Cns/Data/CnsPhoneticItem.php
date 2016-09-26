<?php

namespace Cns\Data;

class CnsPhoneticItem extends BaseMap {

	public function init()
	{
		$this->_Raw['grp'] = '';
		$this->_Raw['cns'] = '';
		$this->_Raw['phonetic'] = '';
		$this->_Raw['cnsphonetic_line'] = '';
		$this->_Raw['cnsphonetic_file'] = '';

		return $this;
	}
} // End Class
