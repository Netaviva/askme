<?php

class Askq_Model_Task extends Linko_Model
{
    /*
     * filter method to return default slug for the profile page
     *
     * if set by the admin
     */
    public function profile_default_slug()
    {
        return 'answered-questions';
    }

}