<?php

class Template_Plugin_Askq
{
    public function start($aParams = array())
    {

        if(!Linko::Model('user/auth')->isUser())
        {
            return false;
        }

        $sHtml = Html::openTag('span', array( 'id' => 'askq-notification-span'));

        $iNo = Linko::Model('askq')->countUnanswered();
        if($iNo>0)
        {
            $sHtml .= $iNo;
        }

        $sHtml.= Html::closeTag('span');

        $sHtml= Html::link($sHtml, Linko::Url()->make('askq:index'), array('id' => 'askq-notification-link'));

        echo $sHtml;


    }

}