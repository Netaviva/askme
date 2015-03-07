<?php defined('LINKO') or exit;

/**
 * @package Profiler
 * @author Morrison Laju <morrelinko@gmail.com>
 */

Linko::Template()->setStyle('profiler.css', 'module_profiler');
Linko::Template()->setScript('profiler.js', 'module_profiler');

if(Linko::Module()->getSetting('profiler.auto_maximize'))
{
    Linko::Template()->setHeader(Html::script(
        '$App.profilerAutoMaximize = function(){ $("#profiler-minimize").trigger("click"); }'
    ), 60);
}