<?php

namespace Cns\Mapping;

class CnsUnicode extends Base {

	protected function prep()
	{
		if ($this->_FileList === null) {
			$this->_FileList = \Cns\Data\BaseList::newInstance();
		}

		if ($this->_Map === null) {
			$this->_Map = \Cns\Data\BaseMap::newInstance();
		}

		if ($this->_Collision === null) {
			$this->_Collision = \Cns\Data\BaseList::newInstance();
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

		$item = \Cns\Data\CnsUnicodeItem::newInstance()
			->put('grp', $list[0])
			->put('cns', $list[1])
			->put('unicode', $list[2])
			->put('cnsunicode_line', $line)
			->put('cnsunicode_file', $file)
		;


		$key = $item->ref('grp') . '-' . $item->ref('cns');

		if ($this->_Map->has($key)) {
			$this->_Collision->push($item);
			return;
		}

		$this->_Map->put($key, $item);
	}
	

	protected $_Map = null;
	public function getMap()
	{
		return $this->_Map;
	}

	protected $_Collision = null;
	public function getCollision()
	{
		return $this->_Collision;
	}

	protected $_FileList = null;
	public function setFileList($val)
	{
		$this->_FileList = $val;
		return $this;
	}
	public function getFileList()
	{
		return $this->_FileList;
	}
	public function defFileList()
	{

		return \Cns\Data\BaseList::newInstance()
			->push(THE_DATA_TABLE_CNS2UNI_BMP_FILE_PATH)
			->push(THE_DATA_TABLE_CNS2UNI_2_FILE_PATH)
			->push(THE_DATA_TABLE_CNS2UNI_15_FILE_PATH)
		;

/*
		return \Cns\Data\BaseList::newInstance()
			->push('data/CNS2UNICODE_Unicode_BMP.txt')
			->push('data/CNS2UNICODE_Unicode_2.txt')
			->push('data/CNS2UNICODE_Unicode_15.txt')
		;
*/
	}
	public function setDefaultFileList()
	{
		$this->setFileList($this->defFileList());
		return $this;
	}


	public function findUnicode_ByCnsGrp($cns, $grp)
	{
		$key = $grp . '-' . $cns;

		if (!$this->_Map->has($key)) {
			return null;
		}

		$item = $this->_Map->ref($key);

		return $item->unicode;

	}

	public function findItem_ByCnsGrp($cns, $grp)
	{
		$key = $grp . '-' . $cns;

		if (!$this->_Map->has($key)) {
			return null;
		}

		$item = $this->_Map->ref($key);

		return $item;

	}

} // End Class
