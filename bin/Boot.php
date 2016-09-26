<?php
	require_once(dirname(__DIR__) . '/vendor/autoload.php');

	ini_set('memory_limit', '2048M');

	define('THE_ROOT_DIR_PATH', dirname(__DIR__));
	define('THE_ASSET_DIR_PATH', THE_ROOT_DIR_PATH . '/asset');
	define('THE_VAR_DIR_PATH', THE_ROOT_DIR_PATH . '/var');

	define('THE_DATA_DIR_PATH', THE_ASSET_DIR_PATH . '/data');
	define('THE_CNS_DIR_PATH', THE_ASSET_DIR_PATH . '/Open_Data');

	define('THE_CNS_TABLE_UNICODE_DIR_PATH', THE_CNS_DIR_PATH . '/MapingTables/Unicode');
	define('THE_CNS_TABLE_CNS2UNI_BMP_FILE_PATH', THE_CNS_TABLE_UNICODE_DIR_PATH . '/CNS2UNICODE_Unicode BMP.txt');
	define('THE_CNS_TABLE_CNS2UNI_2_FILE_PATH', THE_CNS_TABLE_UNICODE_DIR_PATH . '/CNS2UNICODE_Unicode 2.txt');
	define('THE_CNS_TABLE_CNS2UNI_15_FILE_PATH', THE_CNS_TABLE_UNICODE_DIR_PATH . '/CNS2UNICODE_Unicode 15.txt');

	define('THE_CNS_PROPERTIES_DIR_PATH', THE_CNS_DIR_PATH . '/Properties');
	define('THE_CNS_PHONETIC_FILE_PATH', THE_CNS_PROPERTIES_DIR_PATH . '/CNS_phonetic.txt');

	define('THE_DATA_TABLE_CNS2UNI_BMP_FILE_PATH', THE_DATA_DIR_PATH . '/CNS2UNICODE_Unicode_BMP.txt');
	define('THE_DATA_TABLE_CNS2UNI_2_FILE_PATH', THE_DATA_DIR_PATH . '/CNS2UNICODE_Unicode_2.txt');
	define('THE_DATA_TABLE_CNS2UNI_15_FILE_PATH', THE_DATA_DIR_PATH . '/CNS2UNICODE_Unicode_15.txt');

	define('THE_DATA_TABLE_PHONETIC_FILE_PATH', THE_DATA_DIR_PATH . '/CNS_phonetic.txt');
	define('THE_DATA_TABLE_PHONETIC_OTHER_FILE_PATH', THE_DATA_DIR_PATH . '/Other_phonetic.txt');

	define('THE_CNSPHONETIC_CIN_FILE_PATH', THE_VAR_DIR_PATH . '/CnsPhonetic.cin');
	define('THE_CNSPHONETIC_CSV_FILE_PATH', THE_VAR_DIR_PATH . '/CnsPhonetic.csv');
	define('THE_INVALIDPHONETIC_CSV_FILE_PATH', THE_VAR_DIR_PATH . '/InvalidPhonetic.csv');
	define('THE_COLLISIONLIST_CSV_FILE_PATH', THE_VAR_DIR_PATH . '/CollisionList.csv');	
