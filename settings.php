<?php

date_default_timezone_set('America/Sao_Paulo');

// Settings
$settings = [];

// Path settings
$settings['root'] 		= dirname(__DIR__);
$settings['context'] 	= $settings['root'] . '/todolist/';
$settings['src'] 		= $settings['root'] . '/src';
$settings['temp']	 	= $settings['root'] . '/tmp';
$settings['public'] 	= $settings['root'] . '/public';

return $settings;