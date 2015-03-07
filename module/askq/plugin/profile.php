<?php

class Askq_Plugin_Profile
{
    public function init()
    {
        Linko::Model('profile')->registerMenu(Lang::t('askq.answered_questions'), array('link' => Linko::Model('profile')->buildUrl('answered-questions/'),'id' => 'answered-questions'));

        Linko::Router()->add('answered-questions' , array(
            'id' => 'askq:profile:index',
            'controller' => 'askq/profile/index',
            'rules' => array
            (
                //'page' => ':int',

            )

        ));

    }

}