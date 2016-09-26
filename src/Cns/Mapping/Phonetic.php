<?php

namespace Cns\Mapping;

class Phonetic extends Unicode {


	public function findChar_ByDec($dec)
	{
		if (!$this->isValidCharDec($dec)) {
			return '';
		}

		$char = $this->fromCodePoint($dec);

		return $char;
	}

	public function findChar_ByHex($hex)
	{
		if (!$this->isValidCharHex($hex)) {
			return '';
		}

		$dec = hexdec($hex);

		$char = $this->fromCodePoint($dec);

		return $char;
	}

	public function findDec_ByChar($char)
	{
		$dec = $this->fromCharToDec($char);

		if (!$this->isValidCharDec($dec)) {
			return 0;
		}

		return $dec;

	}

	public function findHex_ByChar($char)
	{
		$dec = $this->fromCharToDec($char);

		if (!$this->isValidCharDec($dec)) {
			return '';
		}

		return dechex($dec);
	}


	public function isValidChar($char)
	{
		$dec = $this->fromCharToDec($char);

		return $this->isValidCharDec($dec);
	}

	public function isValidCharDec($dec)
	{
		$dec = intval($dec);

		if ($dec === 711) { // 'ˇ' , '711', '2c7', '0x2c7'
			return true;
		}

		if ($dec === 714) { // 'ˊ' , '714', '2ca', '0x2ca'
			return true;
		}

		if ($dec === 715) { // 'ˋ' , '715', '2cb', '0x2cb'
			return true;
		}

		if ($dec === 729) { // '˙' , '729', '2d9', '0x2d9'
			return true;
		}

		if (($dec >= 12549) && ($dec <= 12569)) { // ('ㄅ' ~ 'ㄙ') ('0x3105' ~ '0x3119')
			return true;
		}

		if (($dec >= 12583) && ($dec <= 12585)) { // ('ㄧ' ~ 'ㄩ') ('0x3127' ~ '0x3129')
			return true;
		}

		if (($dec >= 12570) && ($dec <= 12582)) { // ('ㄚ' ~ 'ㄦ') ('0x311a' ~ '0x3126')
			return true;
		}

		return false;
	}

	public function isValidCharHex($hex)
	{
		//http://php.net/manual/en/function.hexdec.php
		//http://php.net/manual/en/function.base-convert.php

		$dec = hexdec($hex);

		return $this->isValidCharDec($dec);
	}

	public function toArray()
	{
		$rtn = array();

		array_push($rtn, $this->findChar_ByDec(714)); // 'ˊ'
		array_push($rtn, $this->findChar_ByDec(711)); // 'ˇ'
		array_push($rtn, $this->findChar_ByDec(715)); // 'ˋ'
		array_push($rtn, $this->findChar_ByDec(729)); // '˙'


		 // ('ㄅ' ~ 'ㄙ') ('0x3105' ~ '0x3119')
		$start = 12549;
		$end = 12569;
		for ($dec=$start; $dec<=$end; $dec++) {
			array_push($rtn, $this->findChar_ByDec($dec));
		}

		// ('ㄧ' ~ 'ㄩ') ('0x3127' ~ '0x3129')
		$start = 12583;
		$end = 12585;
		for ($dec=$start; $dec<=$end; $dec++) {
			array_push($rtn, $this->findChar_ByDec($dec));
		}

		 // ('ㄚ' ~ 'ㄦ') ('0x311a' ~ '0x3126')
		$start = 12570;
		$end = 12582;
		for ($dec=$start; $dec<=$end; $dec++) {
			array_push($rtn, $this->findChar_ByDec($dec));
		}

		return $rtn;
	}

	public function toString()
	{

		$rtn = '';
		$list = $this->toArray();

		foreach ($list as $char) {
			$rtn .= $char;
			$rtn .= PHP_EOL;
		}

		return $rtn;
	}

	public function toPhoneticDecMap()
	{
		$rtn = array();
		$list = $this->toArray();
		foreach ($list as $char) {
			$hex = $this->findDec_ByChar($char);
			$rtn[$char] = $hex;
		}
		return $rtn;
	}

	public function toPhoneticHexMap()
	{
		$rtn = array();
		$list = $this->toArray();
		foreach ($list as $char) {
			$hex = $this->findHex_ByChar($char);
			$rtn[$char] = $hex;
		}
		return $rtn;
	}

	public function toPhoneticHexExpMap()
	{
		$rtn = array();
		$list = $this->toArray();
		foreach ($list as $char) {
			$hex = $this->findHexExp_ByChar($char);
			$rtn[$char] = $hex;
		}
		return $rtn;
	}



} // End Class
