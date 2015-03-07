<?php

class Askq_Controller_Index extends Linko_Controller
{

    public function main()
    {
        $iPage = $this->getParam('page');

        list($iTotal, $aRow) = Linko::Model('askq')->getUnansweredQuestions($iPage);


        $aPager = array
        (
            'total_items' => $iTotal,
            'current_page' => $iPage,
            'rows_per_page' => Linko::Module()->getSetting('askq.questions_answers_limit_per_page'),
            'route_id' => 'askq:index',
            //'route_param' => array( 'slug' =>$sSlug, 'username' => Linko::Model('profile')->get('username') )

        );

        Linko::Pager()->set($aPager);

        Linko::Template()
            ->setStyle('askq.css', 'module_askq')
            ->setScript('askq.js', 'module_askq')
            ->setVars(array( 'aResult' => $aRow ));



    }
}