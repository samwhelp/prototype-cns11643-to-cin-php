<?php

namespace Cns\Mapping;

class CnsPhonetic extends Base {

	protected function prep()
	{
		if ($this->_FileList === null) {
			$this->_FileList = \Cns\Data\BaseList::newInstance();
		}

		if ($this->_Table === null) {
			$this->_Table = \Cns\Data\BaseList::newInstance();
		}

		return true;
	}

	public function load()
	{
		if ($this->prep() === false) {
			return false;
		}

		$list = $this->_FileList->toArray();
		foreach ($list as $path) {
			$this->loadFile($path);
		}

		return $this;
	}

	protected function loadFile($path)
	{
		$text = $this->readFile($path);
		$this->parseText($text, $path);

		return $this;
	}

	protected function readFile($path)
	{
		if (!file_exists($path)) { //http://php.net/manual/en/function.file-exists.php
			echo ('file not exists: ' . $path . PHP_EOL);
			exit(1); //http://php.net/manual/en/function.exit.php
		}

		$text = file_get_contents($path);

		return $text;
	}

	protected function parseText($text, $file)
	{
		$list = explode("\n", $text);

		$line = 0; // line number;

		foreach ($list as $str) {
			$line++;

			$str = trim($str);

			if (strlen($str) <= 0) {
				continue;
			}

			$this->parseLine($str, $line, $file);
		}
		//console.log(this._Table);
	}

	protected function parseLine($str, $line, $file)
	{
		$list = explode("\t", $str); //http://php.net/manual/en/function.explode.php

		$item = \Cns\Data\CnsPhoneticItem::newInstance()
			->put('grp', $list[0])
			->put('cns', $list[1])
			->put('phonetic', $list[2])
			->put('cnsphonetic_line', $line)
			->put('cnsphonetic_file', $file)
		;

		$this->_Table->push($item);

	}

	protected $_Table = null;
	public function getTable()
	{
		return $this->_Table;
	}

	protected $_FileList = null;
	public function getFileList()
	{
		return $this->_FileList;
	}
	public function setFileList($val)
	{
		$this->_FileList = $val;
		return $this;
	}
	public function defFileList()
	{

		return \Cns\Data\BaseList::newInstance()
			->push(THE_DATA_TABLE_PHONETIC_FILE_PATH)
			->push(THE_DATA_TABLE_PHONETIC_OTHER_FILE_PATH) //http://www.cns11643.gov.tw/AIDB/query_symbol_results.do
		;

		/*
		return \Cns\Data\BaseList::newInstance()
			->push('data/CNS_phonetic.txt')
			->push('data/Other_phonetic.txt') //http://www.cns11643.gov.tw/AIDB/query_symbol_results.do
		;
		*/
	}
	public function setDefaultFileList()
	{
		$this->setFileList($this->defFileList());
		return $this;
	}

	public function createUrl($cns, $grp)
	{
		//http://www.cns11643.gov.tw/AIDB/query_general_view.do?page=1&code=4421
		$rtn = '';
		$rtn .= 'http://www.cns11643.gov.tw/AIDB/query_general_view.do';
		$rtn .= '?page=' . $grp;
		$rtn .= '&code=' . $cns;
		return $rtn;
	}


} // End Class
