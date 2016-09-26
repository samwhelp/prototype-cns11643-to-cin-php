<?php

namespace Cns\Converter;

class CnsToCin {

	protected $_EOL = PHP_EOL;
	protected $_SEGMENT = "\t";
	protected $_QUOTE = '"';

	protected $_PhoneticList = null;
	protected $_InvalidPhonetic = null;

	protected $_UnicodePhonetic = null;
	protected $_UnicodePhoneticCollision = null;

	protected $_CnsPhonetic = null;
	protected $_CnsUnicode = null;
	protected $_Unicode = null;
	protected $_Phonetic = null;
	protected $_PhoneticKey = null;

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
		$this->_PhoneticList = \Cns\Data\BaseList::newInstance();
		$this->_InvalidPhonetic = \Cns\Data\BaseList::newInstance();
		$this->_UnicodePhonetic = \Cns\Data\BaseMap::newInstance();
		$this->_UnicodePhoneticCollision = \Cns\Data\BaseList::newInstance();

		$this->_CnsPhonetic = \Cns\Mapping\CnsPhonetic::newInstance();
		$this->_CnsUnicode = \Cns\Mapping\CnsUnicode::newInstance();
		$this->_Unicode = \Cns\Mapping\Unicode::newInstance();
		$this->_Phonetic = \Cns\Mapping\Phonetic::newInstance();

		$this->_PhoneticKey = \Cns\Mapping\PhoneticKey::newInstance()
			->setPhonetic($this->_Phonetic)
		;

	}

	public function prep()
	{
		$this->_PhoneticList
			->prep()
		;

		$this->_InvalidPhonetic
			->prep()
		;

		$this->_UnicodePhonetic
			->prep()
		;

		$this->_UnicodePhoneticCollision
			->prep()
		;

		$this->_CnsPhonetic
			->setDefaultFileList()
			->prep()
		;

		$this->_CnsUnicode
			->setDefaultFileList()
			->prep()
		;

		$this->_Unicode
			->prep()
		;

		$this->_Phonetic
			->prep()
		;

		$this->_PhoneticKey
			->prep()
		;

		return $this;
	}

	public function run()
	{

		$table = $this->_CnsPhonetic->getTable()->toArray();
		foreach ($table as $cns_phonetic) {
			//var_dump($cns_phonetic);

			$cns_unicode = $this->_CnsUnicode->findItem_ByCnsGrp($cns_phonetic->ref('cns'), $cns_phonetic->ref('grp'));

			$item = \Cns\Data\CinItem::newInstance();

			$key_seq = $this->_PhoneticKey->findKeySeq_ByCharSeq_ValidChar($cns_phonetic->ref('phonetic'));

			$item
				//cns_unicode
				->put('grp', $cns_unicode->ref('grp'))
				->put('cns', $cns_unicode->ref('cns'))
				->put('unicode', $cns_unicode->ref('unicode'))
				->put('unicode_string', $this->_Unicode->findChar_ByHex($item->ref('unicode')))
				->put('unicode_number', $this->_Unicode->findDec_ByHex($item->ref('unicode')))
				->put('cnsunicode_line', $cns_unicode->ref('cnsunicode_line'))
				->put('cnsunicode_file', $cns_unicode->ref('cnsunicode_file'))

				//cns_phonetic
				->put('phonetic', $cns_phonetic->ref('phonetic'))
				->put('phonetic_keyseq', $key_seq[1])
				->put('phonetic_keyseq_valid', $key_seq[0])
				->put('cnsphonetic_line', $cns_phonetic->ref('cnsphonetic_line'))
				->put('cnsphonetic_file', $cns_phonetic->ref('cnsphonetic_file'))
				->put('cns_url', $this->_CnsPhonetic->createUrl($item->ref('cns'), $item->ref('grp')))
			;


			//排除「非合法注音的項目」。
			if (!$item->ref('phonetic_keyseq_valid')) { // 非合法注音的項目
				$this->_InvalidPhonetic->push($item);
				continue;
			}


			// 紀錄重複的「phonetic - unicode」
			$collision_key = $item->ref('phonetic_keyseq') . '-' . $item->ref('unicode');

			if ($this->_UnicodePhonetic->has($collision_key)) {
				$collision_list = $this->_UnicodePhonetic->ref($collision_key);
				$collision_list->push($item);
				$this->_UnicodePhoneticCollision->push($collision_list);
			} else {
				$this->_PhoneticList->push($item);
				$this->_UnicodePhonetic->put($collision_key, \Cns\Data\BaseList::newInstance()->push($item));
			}

			//var_dump($item);

		} // End ForEach


		$this->createCin();

		$this->logInvalidPhonetic();
		$this->logUnicodeCollision();


		return $this;
	}

	protected function createCin()
	{
		$char_def = '';
		$csv = '';

		//補48個空白行，讓「CnsPhonetic.csv」的行數可以跟「CnsPhonetic.cin」對齊
		for ($i=0; $i<48; $i++) {
			$csv .= PHP_EOL;
		}

		$csv .= $this->makLine_Csv_Head();

		$list = $this->_PhoneticList->toArray();

		//http://php.net/manual/en/array.sorting.php
		//http://php.net/manual/en/function.usort.php
		usort($list, array($this, 'orderBy_PhoneticKeySeq'));

		foreach ($list as $item) {
			$char_def .= $this->makLine_CharDef($item);
			$csv .= $this->makLine_Csv($item);
		}



		\Cns\Util\CinFile::newInstance()
			->setPath(THE_CNSPHONETIC_CIN_FILE_PATH)
			->setContent_KeyName($this->_PhoneticKey->toString())
			->setContent_CharDef($char_def)
			->save()
		;

		\Cns\Util\BaseFile::newInstance()
			->setPath(THE_CNSPHONETIC_CSV_FILE_PATH)
			->setContent($csv)
			->save()
		;
	}


	protected function makLine_CharDef($item)
	{
		$rtn = '';

		$rtn .= $item->ref('phonetic_keyseq');
		$rtn .= $this->_SEGMENT;
		$rtn .= $item->ref('unicode_string');
		$rtn .= $this->_EOL;

		return $rtn;
	}

	protected function makLine_Csv($item)
	{
		$rtn = '';

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('phonetic_keyseq');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('phonetic');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('unicode_string');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('unicode');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('cns');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('grp');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('cnsphonetic_file');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('cnsphonetic_line');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('cnsunicode_file');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('cnsunicode_line');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= $item->ref('cns_url');
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_EOL;

		return $rtn;
	}

	protected function makLine_Csv_Head()
	{
		$rtn = '';

		$rtn .= $this->_QUOTE;
		$rtn .= '鍵盤按鍵';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= '注音符號';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= '中文字';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= 'unicode (hex)';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= 'cns';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= 'grp';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= 'cnsphonetic_file';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= 'cnsphonetic_line';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= 'cnsunicode_file';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= 'cnsunicode_line';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_SEGMENT;

		$rtn .= $this->_QUOTE;
		$rtn .= 'cns網址';
		$rtn .= $this->_QUOTE;

		$rtn .= $this->_EOL;

		return $rtn;
	}

	public function orderBy_PhoneticKeySeq($a, $b)
	{
		$aa = $a->ref('phonetic_keyseq') . '-' . $a->ref('grp') . '-' . $a->ref('cns');
		$bb = $b->ref('phonetic_keyseq') . '-' . $b->ref('grp') . '-' . $b->ref('cns');
		if ($aa > $bb) {
			return true;
		}
		return false;
	}

	public function logInvalidPhonetic()
	{
		$rtn = '';

		$rtn .= $this->makLine_Csv_Head();

		$list = $this->_InvalidPhonetic->toArray();
		foreach ($list as $item ) {
			$rtn .= $this->makLine_Csv($item);
		}

		\Cns\Util\BaseFile::newInstance()
			->setPath(THE_INVALIDPHONETIC_CSV_FILE_PATH)
			->setContent($rtn)
			->save()
		;

	}

	public function logUnicodeCollision()
	{
		//http://php.net/manual/en/function.count.php
		//http://php.net/manual/en/function.sizeof.php
		$rtn = '';
		$rtn .= $this->makLine_Csv_Head();

		$table = $this->_UnicodePhoneticCollision->toArray();

		foreach ($table as $list) {
			if (count($list)) {
				$rtn .= $this->eachUnicodeCollisionList($list->toArray());
			}
		}

		\Cns\Util\BaseFile::newInstance()
			->setPath(THE_COLLISIONLIST_CSV_FILE_PATH)
			->setContent($rtn)
			->save()
		;

	}

	public function eachUnicodeCollisionList($list)
	{
		$rtn = '';

		foreach ($list as $item) {
			$rtn .= $this->makLine_Csv($item);
		}

		return $rtn;
	}

} // End Class
