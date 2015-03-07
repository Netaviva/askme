<?php defined('LINKO') or exit;

/**
 * @package Profiler
 * @author Morrison Laju <morrelinko@gmail.com>
 */
class Profiler_Plugin_Application
{
    public function after_layout()
    {
        Linko::Response()->inject('body:end', Linko::Module()->getBlock('profiler/display'));
    }
}