<?php

defined('LINKO') or exit();

/**
 * @author LinkoDEV team
 * @package linkocms
 * @subpackage activity : plugin/profile.php
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All rights reserved.
 */
class Follow_Block_Recent_Follower extends Linko_Controller
{
    public function main()
    {

        $aResult = Linko::Model('follow')->getRecent('follower', $this->getParam('recent_limit_follower'));

        Linko::Template()
            ->setStyle('follow.css', 'module_follow')
            ->setVars(array('aRecentFollower' => $aResult));
    }
}