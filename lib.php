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

function theme_sageui_process_css($css, $theme) {
    global $PAGE, $OUTPUT;
    $outputus = $PAGE->get_renderer('theme_remui', 'core');
    \theme_remui\toolbox::set_core_renderer($outputus);
    // Set the background image for the logo.
    $logo = \theme_remui\toolbox::setting_file_url('loginsettingpic', 'loginsettingpic');
    $css = \theme_remui\toolbox::set_logo($css, $logo);
    $tag = '[[setting:loginsettingpic]]';
    if (is_null($logo)) {
        $logo = \theme_remui\toolbox::pix_url('login_texture', 'theme');
        $replacement = "#page-login-index {background-image: url($logo); background-color: #eee;}";
        $replacement .= "#page-login-signup {background-image: url($logo); background-color: #eee;}";
    } else {
        $replacement = "#page-login-index {background-image: url($logo);  background-size: auto 100%; background-position: center top; background-color: #eee;}";
        $replacement .= "#page-login-signup {background-image: url($logo);  background-size: auto 100%; background-position: center top; background-color: #eee;}";

    }
    $css = str_replace($tag, $replacement, $css);

    // Set the signup panel text color
    $signuptextcolor = \theme_remui\toolbox::get_setting('signuptextcolor');
    $css = \theme_remui\toolbox::set_color($css, $signuptextcolor, '[[setting:signuptextcolor]]', '#FFFFFF');

    // Set the theme colour.
     $colorscheme = \theme_remui\toolbox::get_setting('colorscheme');
    switch ($colorscheme) {
        case 'skin-blue dark-skin ':
            $themecolor = '#3c8dbc'; // setting the blue color
            break;
        case 'skin-purple dark-skin ':
            $themecolor = '#605ca8';
            break;
        case 'skin-green dark-skin ':
            $themecolor = '#00a65a';
            break;
        case 'skin-red dark-skin ':
            $themecolor = '#dd4b39';
            break;
        case 'skin-yellow dark-skin ':
            $themecolor = '#f39c12';
            break;
            // For light skin
        case 'skin-blue-light light-skin ':
            $themecolor = '#3c8dbc'; // setting the blue light color
            break;
        case 'skin-purple-light light-skin ':
            $themecolor = '#605ca8';
            break;
        case 'skin-green-light light-skin ':
            $themecolor = '#00a65a';
            break;
        case 'skin-red-light light-skin ':
            $themecolor = '#dd4b39';
            break;
        case 'skin-yellow-light light-skin ':
            $themecolor = '#f39c12';
            break;
        case 'skin-custom dark-skin ' :
            $themecolor = \theme_remui\toolbox::get_setting('customskin_color');
            if(!$themecolor) {
                $themecolor = '#3c8dbc';
            }
            break;
        case 'skin-custom-light light-skin ' :
            $themecolor = \theme_remui\toolbox::get_setting('customskin_color');
            if(!$themecolor) {
                $themecolor = '#3c8dbc';
            }
            break;
        default:
            $themecolor = '#3c8dbc'; // setting the default color blue
            break;
    }

       $css = \theme_remui\toolbox::set_color($css, $themecolor, '[[setting:themecolor]]', '#3c8dbc');

       $activecolor = new \theme_remui\Color($themecolor);

       // calculate default dark and light
       $css = \theme_remui\toolbox::set_color($css, '#'.$activecolor->lighten(2), '[[setting:themecolorlight]]', '#3c8dbc');
       $css = \theme_remui\toolbox::set_color($css, '#'.$activecolor->darken(2), '[[setting:themecolordark]]', '#3c8dbc');

       // calculate darker based on above dark color output
       $new_dark    = new \theme_remui\Color('#'.$activecolor->darken(2));
       $css = \theme_remui\toolbox::set_color($css, '#'.$new_dark->darken(1), '[[setting:themecolordarker]]', '#3c8dbc');

        // calculate lighter based on above light color output
       $new_light    = new \theme_remui\Color('#'.$activecolor->lighten(2));
       $css = \theme_remui\toolbox::set_color($css, '#'.$new_light->lighten(1), '[[setting:themecolorlighter]]', '#3c8dbc');


    if (\theme_remui\toolbox::get_setting('fontselect') === "2" ) {
        // Get the theme font from setting
        $fontnameheading = \theme_remui\toolbox::get_setting('fontnameheading');
        $fontnameheading = ucwords($fontnameheading);
        $fontnamebody = \theme_remui\toolbox::get_setting('fontnamebody');
        $fontnamebody = ucwords($fontnamebody);
        // Set the theme font.
        $css = \theme_remui\toolbox::set_font($css, 'heading', $fontnameheading);
        $css = \theme_remui\toolbox::set_font($css, 'body', $fontnamebody);
    }

    // Set the theme text colour.
    $themetextcolor = \theme_remui\toolbox::get_setting('themetextcolor');
    
    $css = \theme_remui\toolbox::set_color($css, $themetextcolor, '[[setting:themetextcolor]]', '#047797');

    // Set custom CSS.
    $customcss = \theme_remui\toolbox::get_setting('customcss');
    $css = \theme_remui\toolbox::set_customcss($css, $customcss);

    return $css;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_sageui_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    static $theme;
    $course = $course;
    $cm = $cm;
    if (empty($theme)) {
        $theme = theme_config::load('remui');
    }
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        if ($filearea === 'frontpageaboutusimage') {
            return $theme->setting_file_serve('frontpageaboutusimage', $args, $forcedownload, $options);
        } else if ($filearea === 'loginsettingpic') {
            return $theme->setting_file_serve('loginsettingpic', $args, $forcedownload, $options);
        } else if ($filearea === 'logo') {
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } else if ($filearea === 'logomini') {
            return $theme->setting_file_serve('logomini', $args, $forcedownload, $options);
        } else if (preg_match("/^(slideimage|testimonialimage)[1-5]/", $filearea)) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if ($filearea === 'faviconurl') {
            return $theme->setting_file_serve('faviconurl', $args, $forcedownload, $options);
        } else if ($filearea === 'staticimage') {
            return $theme->setting_file_serve('staticimage', $args, $forcedownload, $options);
        } else if ($filearea === 'layoutimage') {
            return $theme->setting_file_serve('layoutimage', $args, $forcedownload, $options);
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}
