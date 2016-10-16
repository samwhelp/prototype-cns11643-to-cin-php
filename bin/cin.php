#!/usr/bin/env php
<?php
	require_once(__DIR__ . '/Boot.php');

	\Cns\Converter\CnsToCin::newInstance()
		->run()
	;


	return;
