<?php

defined('LINKO') or exit();

/**
 * @author LinkoDEV team
 * @package linkocms
 * @subpackage activity : plugin/profile.php
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All rights reserved.
 */
class Follow_Ajax extends Linko_Ajax
{
    public function add()
    {
        $iRefId = $this->getParam('refid');

        if(Linko::Model('follow')->isFollowing($iRefId))
        {
            $this->output(Lang::t('follow-error-following'));
        }else
        {
            Linko::Model('follow/action')->add($iRefId);
            $this->output(Lang::t('follow-success-following'));
        }

    }

    public function remove()
    {
        $iRefId = $this->getParam('refid');

        if(Linko::Model('follow')->isFollowing($iRefId))
        {
            //$this->output(Lang::t('follow-error-following'));
            Linko::Model('follow/action')->remove($iRefId);
            $this->output(Lang::t('follow-success-unfollowed'));
        }

    }
}