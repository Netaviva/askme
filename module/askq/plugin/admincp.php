<?php

defined('LINKO') or exit();

/**
 * @author LinkoDEV Team
 * @package linkocms
 * @subpackage blog : plugin - admincp.php
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All Rights Reserved.
 */
class Askq_Plugin_Admincp
{
    public function init()
    {
        // Posts
        Linko::Model('Admincp')->addRoute('askq/random(/[page])', array(
            'id' => 'askq:admincp:random',
            'controller' => 'askq/admincp/random/list',
            'rules' => array(
                'page' => ':int',
            )
        ));

        Linko::Model('Admincp')->addRoute('askq/random/add(/[questionid])', array(
            'id' => 'askq:admincp:random:add',
            'controller' => 'askq/admincp/random/add',
            'rules' => array(
                'questionid' => ':int',

            )));

        Linko::Model('Admincp')->addRoute('askq/random/delete/[questionid]', array(
            'id' => 'askq:admincp:random:delete',
            'controller' => 'askq/admincp/random/delete',
            'rules' => array(
                'questionid' => ':int',

            )));


        //menus
        $aMenu = array
        (
            'Random Questions' => Linko::Url()->make('askq:admincp:random'),
            'Add Random Questions' => Linko::Url()->make('askq:admincp:random:add'),
        );
        Linko::Model('Admincp')->addMenu('Askq', $aMenu);
    }
    
    // called in admincp/controller/dashboard
    public function con_dashboard()
    {

    }
}
?>