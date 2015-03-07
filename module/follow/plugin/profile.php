<?php

defined('LINKO') or exit();

/**
 * @author LinkoDEV team
 * @package linkocms
 * @subpackage activity : plugin/profile.php
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All rights reserved.
 */

class Follow_Plugin_Profile
{
    public function tools_start()
    {
        Linko::Template()->setScript('follow.js', 'module_follow');
        echo Linko::Template()->getTemplate('follow/controller/profile/_snipet/follow-button',null,true);
    }

    public function init()
    {

        Linko::Router()->add('interact/[slug](/[page])' , array(
            'id' => 'follow:profile:index',
            'controller' => 'follow/profile/index',
            'rules' => array
            (
                'slug' => 'follow|followers',
                'page' => ':int',

            )

        ));

        //add profile statisticts
        Linko::Model('profile')->addStatistic(array('link' => Linko::Model('profile')->buildUrl('interact/follow/'), 'name' => Lang::t('total-user-following'), 'number' => Linko::Model('follow')->count('follow',Linko::Model('Profile')->getOwnerId())));
        Linko::Model('profile')->addStatistic(array('link' => Linko::Model('profile')->buildUrl('interact/followers/'), 'name' => Lang::t('total-user-followers'), 'number' => Linko::Model('follow')->count('followers',Linko::Model('Profile')->getOwnerId())));

        //add to profile menus
        Linko::Model('profile')->registerMenu(Lang::t('following'), array('link' => Linko::Model('profile')->buildUrl('interact/follow/'),'id' => 'interact'));
        Linko::Model('profile')->registerMenu(Lang::t('followers'), array('link' => Linko::Model('profile')->buildUrl('interact/followers/'),'id' => 'interact'));
    }
}
?>