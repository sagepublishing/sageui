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
 * Layout - Course
 *
 * @package   theme_remui
 * @copyright Copyright (c) 2016 WisdmLabs
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* Default globals */
global $CFG, $PAGE, $USER, $SITE, $COURSE;
$hasrightsideblocks = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
if ( \theme_remui\toolbox::get_setting('sidebar') == 'old') {
    $hasrightsideblocks = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
}
$PAGE->set_popup_notification_allowed(false);
echo $OUTPUT->doctype();
?>

<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
    <?php echo $OUTPUT->standard_head_html(); ?>
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

    <div class="wrapper"> <!-- main page wrapper -->

        <?php
        echo $OUTPUT->standard_top_of_body_html();

        // Include header navigation.
        require_once(\theme_remui\controller\theme_controller::get_partial_element('header'));

        // Include main sidebar.
        require_once(\theme_remui\controller\theme_controller::get_partial_element('pre-aside'));
?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <?php $regionmainsettingsmenu = $OUTPUT->context_header_settings_menu();
                     if(empty($regionmainsettingsmenu)){
                        $regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
                     }
               ?>
              <div class="action-buttons">
                <div id="region-main-settings-menu" class="hidden-print">
                    <div>
                	    <?php echo $OUTPUT->page_heading_button(); ?>
                      <?php  echo $regionmainsettingsmenu;?> 
                    </div>
                </div>
                <?php echo $OUTPUT->course_header(); ?>
              </div>
            </section>
<?php 
            $url='';
                    $course=$DB->get_record('course',array('id'=>$COURSE->id));
                    if ($course instanceof stdClass) {
            require_once($CFG->libdir. '/coursecatlib.php');
            $course = new course_in_list($course);
        }
        $content = '';
        // Display course overview files.
        $contentimages = $contentfiles = '';
        foreach ($course->get_course_overviewfiles() as $file) {
            $isimage = $file->is_valid_image();
            $url = file_encode_url("$CFG->wwwroot/pluginfile.php",
                    '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                    $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
            if ($isimage) {
                    $contentimages .= html_writer::start_tag('div', array('class' => 'imagebox'));
                    $images = html_writer::empty_tag('img', array('src' => $url, 'alt' => 'Course Image '. $course->fullname,
                        'class' => 'courseimage'));
                    $contentimages .= html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)), $images);
                    $contentimages .= html_writer::end_tag('div');
            } else {
                $url='http://ec2-204-236-215-10.compute-1.amazonaws.com/theme/remui/data/nopic.jpg';
                $image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
                $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
                        html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
                $contentfiles .= html_writer::tag('span',
                        html_writer::link($url, $filename),
                        array('class' => 'coursefile fp-filename-icon'));
            }
        }?>
            
            <div id="header-category" class="header-category" style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)) repeat scroll 0% 0%, transparent url(<?php echo $url;?>) no-repeat scroll 0% 0%; background-size:cover;">
    <div class="container-fluid" style="max-width:1300px;">
	<div class="row">
		<div class="col-lg-12 product-speech">
<div class="jumbotron" style="background: rgba(0,0,0,.40);margin-top: 3%;
    margin-left: 3%;
    margin-right: 35%;padding:15px;">
  
  <h2 class="white" style="font-size:24px"><?php echo $OUTPUT->page_title(); ?></h2>
</div>
        </div>
	</div>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 text-center">  
               
        </div>
        <div class="col-lg-3"></div>
    </div>
    </div>	
</div>
             <section class="content-breadcrumb">
              <ol class="breadcrumb">
                <?php echo $OUTPUT->navbar(); ?>
              </ol>
            </section><!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div id="region-main" >
                    <?php
                    echo $OUTPUT->course_content_header();
                    echo $OUTPUT->main_content();
                    echo $OUTPUT->course_content_footer();
                    ?>
                </div><!--end region-->

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <?php
        // Include post sidebar
        if($hasrightsideblocks || $PAGE->user_is_editing())
            require_once(\theme_remui\controller\theme_controller::get_partial_element('post-aside'));

        // Include footer
        require_once(\theme_remui\controller\theme_controller::get_partial_element('footer'));

        echo $OUTPUT->standard_end_of_body_html();
        $params = array();
        $this->page->requires->js_call_amd('theme_remui/course', 'initialise', $params);
        $this->page->requires->strings_for_js(array('hidesection', 'showsection', 'hidesections', 'showsections'), 'theme_remui');
        user_preference_allow_ajax_update("activities_expanded_".$COURSE->id, PARAM_TEXT);
        $activities_expanded  = json_decode(get_user_preferences("activities_expanded_".$COURSE->id, 1));
        ?>

    </div> <!-- ./wrapper -->
</body>
</html>


