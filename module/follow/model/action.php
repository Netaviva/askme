<?php

defined('LINKO') or exit();

/**
 * @author LinkoDEV team
 * @package linkocms
 * @subpackage activity : plugin/profile.php
 * @version 1.0.0
 * @copyright Copyright (c) 2013. All rights reserved.
 */
class Follow_Model_Action extends Linko_Model
{
    public function add($sRefId, $sModuleId = 'user', $iUserId = null)
    {
        $iUserId = (empty($iUserId)) ? Linko::Model('User/Auth')->getUserId() : $iUserId;

        $query = Linko::Database()->table('follow')
                        ->insert(array(
                        'time_created' => time(),
                        'user_id' => $iUserId,
                        'reference_id' => $sRefId,
                        'module_id' => $sModuleId
                        ))->query();

        return $query->getInsertId();
    }

    public function remove($sRefId, $sModuleId = 'user', $iUserId = null)
    {
        $iUserId = (empty($iUserId)) ? Linko::Model('User/Auth')->getUserId() : $iUserId;

        $query = Linko::Database()->table('follow')
            ->delete()
            ->where('user_id', '=', $iUserId)->where('reference_id' ,'=', $sRefId)
            ->query();

        return $query->getInsertId();
    }
}