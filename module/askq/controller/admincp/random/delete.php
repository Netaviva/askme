<?php

defined('LINKO') or exit();

/**
 * @author LinkoDEV Team
 * @package linkocms
 * @subpackage askq : add.php
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All Rights Reserved.
 */
class Askq_Controller_Admincp_Random_Delete extends Linko_Controller
{
    public function main()
    {

        if(Linko::Model('askq')->delete($this->getParam('questionid')))
        {
            Linko::Response()->redirect('askq:admincp:random');
        }

    }
}