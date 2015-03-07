<?php

class Askq_Model_Action extends Linko_Model
{
    /*
     * Method to save questions
     */
    public function save($sText, $iUserId, $iAnonymous)
    {
        //if(empty($sText)) return false;

        $oQuery = Linko::Database()->table('askq_questions')
            ->insert(array(
            'question_content' => $sText,
            'user_id' => $iUserId,
            'time' => time(),
            'is_anonymous' => $iAnonymous,
            'questionaire_user_id' => Linko::Model('User/Auth')->getUserId()
        ))->query();

        if($iUserId != '0')
        {
            Linko::Plugin()->call('askq.question',array
            (
                'question_id' => $oQuery->getInsertId(),
                'user_id' => $iUserId,
                'is_anonymous' => $iAnonymous,
                'question_content' => $sText
            ));

        }
    }

    public function answer($sText, $qid)
    {
        $iUserId = Linko::Model('user/auth')->getUserId();
        //insert into the answer table
        $oQuery = Linko::Database()->table('askq_answers')
            ->insert(array('question_id' => $qid,'question_answer' => $sText, 'time' => time(),'user_id' =>$iUserId))
            ->query();

        Linko::Plugin()->call('askq.answer',array
        (
            'question_id' => $qid,
            'answer_id' => $oQuery->getInsertId(),
            'answer_content' => $sText
        ));

        //now update the question table to make question answered by this user
        $aDetails = Linko::Model('askq')->get($qid);
        if($aDetails['user_id'] != '0')
        {
            //update normal
            $value = 1;
        }else
        {
           $answerdUsers = (empty($aDetails['has_answered'])) ? array() : unserialize($aDetails['has_answered']);

            $answerdUsers[] = 'user_'.$iUserId;
            $value = serialize($answerdUsers);
        }

            Linko::Database()->table('askq_questions')
                ->update(array('has_answered' => $value))
                ->where('question_id' ,'=', $qid)
                ->query();



    }


}