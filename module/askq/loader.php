<?php

defined('LINKO') or exit();

/**
 * @author LinkoDEV Team
 * @package linkocms
 * @subpackage askq : loader
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All Rights Reserved.
 */
if(Linko::Module()->isModule('gamification'))
{
    Linko::Model('gamification')->addActivity(
        array
        (
            'id'=>'user-ask-questions',
            'use-activity'=>1,
            'name' => 'User Ask Question',
            'description' => 'User activity when asking other users questions'
        )
        ,array('name' =>'askq', 'method' => 'question')
    );

    Linko::Model('gamification')->addActivity(
        array
        (
            'id'=>'user-answer-questions',
            'use-activity'=>1,
            'name' => 'User Answer Question',
            'description' => 'User activity when answering questions from other users'
        )
        ,array('name' =>'askq', 'method' => 'answer')
    );
}

Linko::Template()
    ->setStyle('askq_notify.css', 'module_askq')
    ->registerPlugin('askq', Linko::Config()->get('dir.module') . 'askq' . DS . 'include' . DS . 'template' . DS . 'plugin.php');

?>