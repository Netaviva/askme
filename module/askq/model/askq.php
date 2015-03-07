<?php

class Askq_Model_Askq extends Linko_Model
{
    /*
     * Method to confirm if we are to show the form
     * or not base on admin settings or user is loggin
     */
    public function canShowAskForm()
    {
       $bAdminSettings = Linko::Module()->getSetting('askq.allow_quest_ask_question');

        if($bAdminSettings || Linko::Model('User/Auth')->isUser()) return true;

        return false;
    }

    /*
     * method to count user unanswerred questions
     */
    public function countUnanswered()
    {
        return Linko::Database()->table('askq_questions')
            ->select()
            ->where('user_id', '=', Linko::Model('user/auth')->getUserId())
            ->where('has_answered', '!=', '1')
            ->query()->getCount();

    }

    public function getUnansweredQuestions($iPage)
    {
        $iLimit = Linko::Module()->getSetting('askq.questions_answers_limit_per_page');
        $aQuery = Linko::Database()->table('askq_questions')
            ->select()
            ->where(function($obj)
            {
                $obj->where('user_id', '=', Linko::Model('User/Auth')->getUserId())->orWhere('user_id', '=', '0');
            })
            ->where(function($oObj)
            {
                $oObj->where('has_answered', '!=', '1')
                    ->where('has_answered', 'NOT LIKE', '%user_'.Linko::Model('user/auth')->getUserId().'%');
            })
            ->order('time desc')->query()->paginate($iPage, $iLimit);
        //list($iTotal,$aResult) = $aQuery;

        return $aQuery;

    }

    public function getAdminAddedQuestions($iPage)
    {
        $iLimit = Linko::Module()->getSetting('askq.questions_answers_limit_per_page');
        $aQuery = Linko::Database()->table('askq_questions')
            ->select()
            ->where(function($obj)
            {
                $obj->where('user_id', '=', '0');
            })
            ->order('time desc')->query()->paginate($iPage, $iLimit);
        //list($iTotal,$aResult) = $aQuery;

        return $aQuery;

    }

    public function getUserAnsweredQuestion($iUser, $iPage = 1)
    {
        $iLimit = Linko::Module()->getSetting('askq.questions_answers_limit_per_page');

        $this->_user = $iUser;

        $aQuery = Linko::Database()->table('askq_questions', 'aq')
            ->select('aq.*, aa.question_answer')
            ->leftJoin('askq_answers', 'aa', 'aq.question_id = aa.question_id')
            ->where(function($obj)
            {
                $obj->where('aq.user_id', '=', Linko::Model('askq')->_user)
                    ->orWhere('aq.user_id', '=', '0');
            })
            ->where(function($oObj)
            {
                $oObj
                    ->where('aq.has_answered', 'LIKE', '%user_'.Linko::Model('askq')->_user.'%')
                    ->orWhere('aq.has_answered', '=', '1');
            })
        ->order('time desc')->query()->paginate($iPage, $iLimit);
        //list($iTotal,$aResult) = $aQuery;

        return $aQuery;

    }

    public function get($questionId)
    {
        return Linko::Database()->table('askq_questions')
            ->select()
            ->where('question_id', '=', $questionId)
            ->query()->fetchRow();
    }

    public function delete($id)
    {
        Linko::Database()->table('askq_questions')
            ->delete()
            ->where('question_id', '=', $id)
            ->query();
        return true;
    }
}
