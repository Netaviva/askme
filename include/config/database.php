<?php

/**
 * Core File
 *
 * @author LinkoDEV Team
 * @package linkocms
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All Rights Reserved.
 */

defined('LINKO') or exit();

Linko::Config()->set('Database.connection', array(
		'default' => array(
			'driver' => 'mysqli',
			'host' => 'localhost',
			'username' => 'stanley',
			'password' => 'warri',
			'database' => 'linkodev_cms_askfm',
			'prefix' => 'app_',
			'charset' => 'utf8_bin'
		),
	)
);