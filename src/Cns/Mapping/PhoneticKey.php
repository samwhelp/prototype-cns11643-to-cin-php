<?php

namespace Cns\Mapping;

class PhoneticKey {

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
		$this->_Phonetic = new Phonetic();
		return $this;
	}

	public function prep()
	{
		return $this;
	}

	protected $_Map = [
		'ˊ' => '6',
		'ˇ' => '3',
		'ˋ' => '4',
		'˙' => '7',

		'ㄅ' => '1',
		'ㄆ' => 'q',
		'ㄇ' => 'a',
		'ㄈ' => 'z',

		'ㄉ' => '2',
		'ㄊ' => 'w',
		'ㄋ' => 's',
		'ㄌ' => 'x',

		'ㄍ' => 'e',
		'ㄎ' => 'd',
		'ㄏ' => 'c',

		'ㄐ' => 'r',
		'ㄑ' => 'f',
		'ㄒ' => 'v',

		'ㄓ' => '5',
		'ㄔ' => 't',
		'ㄕ' => 'g',
		'ㄖ' => 'b',

		'ㄗ' => 'y',
		'ㄘ' => 'h',
		'ㄙ' => 'n',

		'ㄧ' => 'u',
		'ㄨ' => 'j',
		'ㄩ' => 'm',

		'ㄚ' => '8',
		'ㄛ' => 'i',
		'ㄜ' => 'k',
		'ㄝ' => ',',

		'ㄞ' => '9',
		'ㄟ' => 'o',
		'ㄠ' => 'l',
		'ㄡ' => '.',

		'ㄢ' => '0',
		'ㄣ' => 'p',
		'ㄤ' => ';',
		'ㄥ' => '/',

		'ㄦ' => '-'
	];



	protected $_Phonetic = null;
	public function setPhonetic($val)
	{
		$this->_Phonetic = $val;
		return $this;
	}


	public function findKeySeq_ByCharSeq($str)
	{
		//http://php.net/manual/en/language.types.string.php
		//http://php.net/manual/en/function.mb-substr.php
		//http://php.net/manual/en/function.mb-strlen.php

		$rtn = '';
		$len = mb_strlen($str, 'UTF-8');
		for ($i=0; $i<$len; $i++) {
			$char = mb_substr($str, $i, 1, 'UTF-8');
			$rtn .= $this->findKey_ByChar($char);
		}

		return $rtn;

	}

	public function findKeySeq_ByCharSeq_ValidChar($str)
	{
		$rtn = '';
		$len = mb_strlen($str, 'UTF-8');
		for ($i=0; $i<$len; $i++) {
			$char = mb_substr($str, $i, 1, 'UTF-8');
			if (!$this->_Phonetic->isValidChar($char)) {
				return [false, ''];
			}
			$rtn .= $this->findKey_ByChar($char);
		}

		return [true, $rtn];
	}

	public function findKey_ByChar($char)
	{

		if (!$this->_Phonetic->isValidChar($char)) {
			return '';
		}

		return $this->_Map[$char];
	}

	public function testValidPhoneticMap()
	{
		$rtn = [];
		foreach ($this->_Map as $char => $key) {
			$rs = $this->_Phonetic->isValidChar($char);
			$rtn[$char] = $rs;
		}
		return $rtn;
	}

	public function toString()
	{
		$rtn = '';
		foreach ($this->_Map as $key => $val) {

			//console.log(key + " = " + val);
			$rtn .= $key;
			$rtn .= "\t";
			$rtn .= $val;
			$rtn .= PHP_EOL;
		}

		return $rtn;
	}

} // End Class
