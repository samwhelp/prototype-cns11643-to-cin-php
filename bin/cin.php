#!/usr/bin/env php
<?php
	require_once(__DIR__ . '/Boot.php');

	\Cns\Converter\CnsToCin::newInstance()
		->prep()
		->run()
	;

	//var_dump($converter);

	return;
