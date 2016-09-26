<?php

namespace Cns\Data;

class CinItem extends BaseMap {

	public function init()
	{
		//cns_unicode
		$this->_Raw['grp'] = '';
		$this->_Raw['cns'] = '';
		$this->_Raw['unicode'] = '';
		$this->_Raw['unicode_string'] = '';
		$this->_Raw['unicode_number'] = '';
		$this->_Raw['cnsunicode_line'] = '';
		$this->_Raw['cnsunicode_file'] = '';

		//cns_phonetic
		$this->_Raw['phonetic'] = '';
		$this->_Raw['phonetic_keyseq'] = '';
		$this->_Raw['phonetic_keyseq_valid'] = false;
		$this->_Raw['cnsphonetic_line'] = '';
		$this->_Raw['cnsphonetic_file'] = '';
		$this->_Raw['cns_url'] = '';


		return $this;
	}

} // End Class
