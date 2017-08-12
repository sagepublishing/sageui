<?php
 
// Every file should have GPL and copyright in the header - we skip it in tutorials but you should not skip it for real.
 
// This line protects the file from being accessed by a URL directly.                                                               
defined('MOODLE_INTERNAL') || die();
 
// We will add callbacks here as we add features to our theme.

function theme_sageui_extend_navigation(global_navigation $nav)
{
    if ($participants = $nav->find('dashboard', navigation_node::TYPE_CONTAINER)) {
    	$participants->remove();
    }
}