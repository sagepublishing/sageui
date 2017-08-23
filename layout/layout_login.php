<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Layout - Login Page
 *
 * @package   theme_remui
 * @copyright Copyright (c) 2016 WisdmLabs
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* Default globals */
global $CFG, $PAGE, $USER, $SITE, $COURSE, $OUTPUT;

// used variables

$logoorsitename = \theme_remui\toolbox::get_setting('logoorsitename');
$siteicon = \theme_remui\toolbox::get_setting('siteicon');
$checklogo = \theme_remui\toolbox::setting_file_url('logo', 'logo');
if (!empty($checklogo)) {
    $logo = $checklogo;
} else {
    $logo = \theme_remui\toolbox::pix_url('logo', 'theme');
}
$checkbackground = \theme_remui\toolbox::setting_file_url('loginsettingpic', 'loginsettingpic');
if (!empty($checkbackground)) {
    $background = $checkbackground;
} else {
    $background = '';
}

$PAGE->set_popup_notification_allowed(false);
echo $OUTPUT->doctype();
?>

<html <?php echo $OUTPUT->htmlattributes(); ?> style=" 
  background: url('<?php echo $background;?>') no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
  <head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
    <?php echo $OUTPUT->standard_head_html(); ?>
  </head>

  <body <?php echo $OUTPUT->body_attributes(); ?> style=" background:none; background-color:inherit;">

    <div class="remui-wrapper" > <!-- main page wrapper -->
        <?php
          echo $OUTPUT->standard_top_of_body_html();
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="remui-content-wrapper">
            <!-- Main content -->
            <section id="region-main" class="content wdm-login-content">
            <div class="row" id="login-img">
                
            <?php if (!empty($logoorsitename)) {
            ?>
                <div class="row">
                    <div class="col-lg-4">
                    
                    </div>
                    <div class="col-lg-4">
                      <?php if ($logoorsitename == 'logo') { ?>
                    <a href="<?php echo $CFG->wwwroot; ?>" class="logo">
                      <span class="logo-lg"><img class="img-responsive" alt="<?php echo format_string($SITE->shortname); ?>" src="<?php echo $logo;?>" /></span>
                    </a>
                <?php } else if ($logoorsitename == 'sitename') { ?>
                  <h1>
                     <a class="logo" href="<?php echo $CFG->wwwroot; ?>">
                      <span class="logo-lg">
                        <?php echo format_string($SITE->shortname); ?>
                     </span>
                     </a>
                  </h1>
        <?php } else {  ?>
                <h1>
                    <a class="logo" href="<?php echo $CFG->wwwroot; ?>">
                      <span class="logo-lg">
                         <i class="fa fa-<?php echo $siteicon; ?>"></i>
                        <?php echo format_string($SITE->shortname); ?>
                     </span>
                     </a>
                </h1>
        <?php } ?>
                    </div>
                    <div class="col-lg-4">
                    
                    </div>
                </div>
                    <?php } ?>
                        <?php echo $OUTPUT->course_content_header(); ?>
                        <?php echo $OUTPUT->main_content(); ?>
                        <?php echo $OUTPUT->course_content_footer(); ?>
            </div>
            </section>
        </div>
        
        <?php
            echo $OUTPUT->standard_end_of_body_html();
        ?>
    </div> <!-- ./wrapper -->
  </body>
</html>