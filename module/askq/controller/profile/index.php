<?php

class Askq_Controller_Profile_Index extends Linko_Controller
{
    public function main()
    {
        $iPage = Input::get('page');

        list($iTotal, $aRow) = Linko::Model('askq')->getUserAnsweredQuestion(Linko::Model('profile')->getOwnerId(), $iPage);


        //arr::dump($aRow);
        $aPager = array
        (
            'total_items' => $iTotal,
            'current_page' => $iPage,
            'rows_per_page' => Linko::Module()->getSetting('askq.questions_answers_limit_per_page'),
            'route_id' => 'user:profile',
            'route_param' => array( 'slug' =>'answered-questions/', 'username' => Linko::Model('profile')->get('username') )

        );

        Linko::Pager()->set($aPager);

        Linko::Template()->setStyle('askq.css', 'module_askq')
            ->setTranslation(array('askq.success_question_asked','askq.error_question_asked'))
            ->setVars(array('aResult' => $aRow))
            ->setScript('askq.js', 'module_askq');
    }
}