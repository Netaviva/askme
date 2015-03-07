<?php

Linko::Template()->setStyle('bootstrap.css', 'theme_css');
Linko::Template()->setStyle('bootstrap-responsive.css', 'theme_css');
Linko::Template()->setScript(array(
    'jquery.equalheight.js',
    'script.js',
    'bootstrap.js'
), 'theme_js');

// Set the blank layout for these pages. Overrides what the user sets.
$aStartPages = array('user:login', 'user:register', 'user:reset-password');

if(in_array(Linko::Router()->getId(), $aStartPages))
{
	Linko::Template()->setLayout('template');
       
}
if(!Linko::Model('User/Auth')->isUser() && Linko::Model('Page')->isHome())
{
    Linko::Template()->setLayout('home-guest');
}

 Linko::Template()->setStyle('homepage.css', 'theme_css');

?>