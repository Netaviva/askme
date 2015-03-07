<?php

/**
 * Core File
 *
 * @author LinkoDEV Team
 * @package linkocms
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All Rights Reserved.
 */
date_default_timezone_set('UTC');

require 'include/init.php';

$cms = new CMS;

$cms->runWebApplication();