
<?php
defined('LINKO') or exit();


/**

* @author LinkoDEV team

* @package linkocms

* @subpackage Gamification plugin : askq.php

* @version 1.0.0

* @copyright Copyright (c) 2013. All rights reserved.

*/

class Gamification_Plugin_Askq
     {

       public function question()
       {


          $args = func_get_args();

           Linko::Model('Gamification')->gamify('user-ask-questions',$args);

       }



            
     public function answer()
     {

         $args = func_get_args();

         Linko::Model('Gamification')->gamify('user-answer-questions',$args);

    }

/*endclass*/}
              