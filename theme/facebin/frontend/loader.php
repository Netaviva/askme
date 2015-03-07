<?php

Linko::Template()->setStyle('font-awesome.css', 'theme_css');

// Set the blank layout for these pages. Overrides what the user sets.
$aBlankPages = array('user:login', 'user:register', 'user:reset-password');

if(in_array(Linko::Router()->getId(), $aBlankPages))
{
	Linko::Template()->setLayout('blank');
}

// i could also do
if(Linko::Model('User/Auth')->isUser() && Linko::Model('Page')->isHome())
{

}