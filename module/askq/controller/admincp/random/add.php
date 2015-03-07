<?php

defined('LINKO') or exit();

/**
 * @author LinkoDEV Team
 * @package linkocms
 * @subpackage askq : add.php
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All Rights Reserved.
 */
class Askq_Controller_Admincp_Random_Add extends Linko_Controller
{
    public function main()
    {
        $sText = Input::post('text');

        if(!empty($sText))
        {
            Linko::Model('askq/action')->save($sText, 0, 1);
            Linko::Response()->redirect('askq:admincp:random');
        }

        Linko::Template()->setTitle('Add Random Questions');
    }
}