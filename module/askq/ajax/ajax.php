<?php

class Askq_Ajax extends Linko_Ajax
{

    public function submitQuestion()
    {
        $iUserId = $this->getParam('userid');
        $aData = Str::parseArray($this->getParam('data'));

        $iAnonymous = (isset($aData['anonymous'])) ? 1 : 0;

        Linko::Model('Askq/Action')->save($aData['text'],$iUserId, $iAnonymous);
    }

    public function answer()
    {


        $sText = $this->getParam('text');

        echo $sText;
        echo 'kkldskdskllk';
        //if(empty($sText)) return false;

        Linko::Model('Askq/Action')->answer($sText,$this->getParam('question_id'));

    }
}