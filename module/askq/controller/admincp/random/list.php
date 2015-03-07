<?php
defined('LINKO') or exit();

/**
 * @author LinkoDEV Team
 * @package linkocms
 * @subpackage askq : list.php
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All Rights Reserved.
 */

class Askq_Controller_Admincp_Random_List extends Linko_Controller
{
    public function main()
    {


        $iPage = $this->getParam('page');
        list($iTotal, $aRow) = Linko::Model('askq')->getAdminAddedQuestions($iPage);


        $aPager = array
        (
            'total_items' => $iTotal,
            'current_page' => $iPage,
            'rows_per_page' => Linko::Module()->getSetting('askq.questions_answers_limit_per_page'),
            'route_id' => 'askq:admincp:random',
            //'route_param' => array( 'slug' =>$sSlug, 'username' => Linko::Model('profile')->get('username') )

        );

        Linko::Pager()->set($aPager);

        Linko::Template()
            ->setTitle('Random Questions')
            ->setVars(array( 'aResult' => $aRow ));


    }
}