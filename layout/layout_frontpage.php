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
 * Layout - Frontpage.
 *
 * @copyright Copyright (c) 2026 WisdmLabs
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* Default globals */
global $CFG, $PAGE, $USER, $SITE, $COURSE;
$hasrightsideblocks = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
if ( \theme_remui\toolbox::get_setting('sidebar') == 'old') {
    $hasrightsideblocks = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
}
// Slider variables
$slideinterval =  \theme_remui\toolbox::get_setting('slideinterval'); 
$sliderautoplay = \theme_remui\toolbox::get_setting('sliderautoplay');
if (!empty($sliderautoplay) && $sliderautoplay == '1') {
    $sliderautoplay = 'wdm_Carousel'; // Adding class for slider to autoplay
} else {
    $sliderautoplay = ''; // slide not to autoplay
}
$sliderdata = \theme_remui\controller\theme_controller::slider_data();


// butttons and their links for all the sections
$enablesectionbutton =  \theme_remui\toolbox::get_setting('enablesectionbutton');
if ($enablesectionbutton) {
    $sectionbuttontext1 = \theme_remui\toolbox::get_setting('sectionbuttontext1');
    $sectionbuttonlink1 =  \theme_remui\toolbox::get_setting('sectionbuttonlink1');

    $sectionbuttontext2 =  \theme_remui\toolbox::get_setting('sectionbuttontext2');
    $sectionbuttonlink2 =  \theme_remui\toolbox::get_setting('sectionbuttonlink2');

    $sectionbuttontext3 =  \theme_remui\toolbox::get_setting('sectionbuttontext3');
    $sectionbuttonlink3 =  \theme_remui\toolbox::get_setting('sectionbuttonlink3');

    $sectionbuttontext4 =  \theme_remui\toolbox::get_setting('sectionbuttontext4');
    $sectionbuttonlink4 =  \theme_remui\toolbox::get_setting('sectionbuttonlink4');
}

// Variable for body section 1
$frontpageblocksection1 =  \theme_remui\toolbox::get_setting('frontpageblocksection1');
$frontpageblockdescriptionsection1 = \theme_remui\toolbox::get_setting('frontpageblockdescriptionsection1');
$frontpageblockiconsection1 =  \theme_remui\toolbox::get_setting( 'frontpageblockiconsection1');
// Variable for body section 2
$frontpageblocksection2 =  \theme_remui\toolbox::get_setting('frontpageblocksection2');
$frontpageblockdescriptionsection2 =  \theme_remui\toolbox::get_setting('frontpageblockdescriptionsection2');
$frontpageblockiconsection2 =  \theme_remui\toolbox::get_setting('frontpageblockiconsection2');
// Variables for body section 3
$frontpageblocksection3 =  \theme_remui\toolbox::get_setting('frontpageblocksection3');
$frontpageblockdescriptionsection3 =  \theme_remui\toolbox::get_setting('frontpageblockdescriptionsection3');
$frontpageblockiconsection3 =  \theme_remui\toolbox::get_setting('frontpageblockiconsection3');
// Variables for body section 4
$frontpageblocksection4 =  \theme_remui\toolbox::get_setting('frontpageblocksection4');
$frontpageblockdescriptionsection4 =  \theme_remui\toolbox::get_setting('frontpageblockdescriptionsection4');
$frontpageblockiconsection4 =  \theme_remui\toolbox::get_setting('frontpageblockiconsection4');

// Front page about us variables.
$frontpageaboutusheading =  \theme_remui\toolbox::get_setting('frontpageaboutusheading');
$frontpageaboutusimage = \theme_remui\toolbox::setting_file_url('frontpageaboutusimage', 'frontpageaboutusimage');
$frontpageaboutustext =  \theme_remui\toolbox::get_setting('frontpageaboutustext');

// @param int $start how many blog should be skipped.
// If specified 0 no recent blog will be skipped.
// @param int $blogcount number of blog posts to be return.
$recentblogs = \theme_remui\controller\theme_controller::get_recent_blog(0, 4);
$url='http://via.placeholder.com/700x300';
$PAGE->set_popup_notification_allowed(false);
echo $OUTPUT->doctype();
?>

<html <?php echo $OUTPUT->htmlattributes(); ?> >
<head>
  <title><?php echo $OUTPUT->page_title(); ?></title>
  <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon() ?>"/>
  <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
  <?php echo $OUTPUT->standard_head_html(); ?>
</head>

<body <?php echo $OUTPUT->body_attributes(); ?> >

  <div class="wrapper"> <!-- main page wrapper -->

    <?php
      echo $OUTPUT->standard_top_of_body_html();

      // Include header navigation
      require_once(\theme_remui\controller\theme_controller::get_partial_element('header'));

      // Include main sidebar.
      require_once(\theme_remui\controller\theme_controller::get_partial_element('pre-aside'));
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
	    <!-- Main content -->
	    <section class="content">

		    <div class="slider-wrapper">
		    <?php
				// Checking of sliderdata contains value or not
				if (!empty($sliderdata) && is_array($sliderdata)) {
				    if ($sliderdata['isslider'] == 2) {
				?>
				        <div id="wdm_Carousel" class="carousel slide  <?php echo $sliderautoplay; ?>"   data-interval="<?php echo $slideinterval; ?>">
				              <!-- Indicators -->
				              <ol class="carousel-indicators">
								<?php  foreach ($sliderdata['slides'] as $slides => $values) { ?>
								                         <li data-target="#wdm_Carousel" data-slide-to="<?php echo $values['img_count'];?>"></li>
								<?php } ?>
				              </ol>
				          <!-- Wrapper for slides -->
				            <div class="carousel-inner" role="listbox">
				                <?php foreach ($sliderdata['slides'] as $slides => $values) {?>
				                    <div class="item <?php if ($values["active"] == 2) { echo 'active';} ?>" > <!--active -->
				                        <div class="fill" style="background-image:url('<?php echo $values['img'];?>');"></div>
				                       	<div class="carousel-caption">
				                            <?php echo $values['img_txt'];?>
				                            <?php if (!empty($values['btn_link']) || !empty($values['btn_txt'])) {?>
				                            <p>
				                                <a class="slider-btn btn btn-lg btn-primary btn-flat btn-responsive" href="<?php echo $values['btn_link'] ?>" role="button">
				                                    <?php echo $values['btn_txt'] ?>
				                                </a>
				                            </p>
				                            <?php }?>
				                        </div>
				                    </div>
				                <?php } ?>
				          			<!-- Left and right controls -->
				                    <a class="left carousel-control" href="#wdm_Carousel" role="button" data-slide="prev">
				                      <span class="fa fa-chevron-left" aria-hidden="true"></span>
				                      <span class="sr-only">Previous</span>
				                    </a>
				                    <a class="right carousel-control" href="#wdm_Carousel" role="button" data-slide="next">
				                      <span class="fa fa-chevron-right" aria-hidden="true"></span>
				                      <span class="sr-only">Next</span>
				                    </a>
				            </div>
				        </div>
				<?php
				    } else {
				?>
				<?php if ($sliderdata['isvideo'] == 2) { ?>
				    <div class="row wdm_static_video">
				       <div class="col-xs-12">
				            <iframe width="100%" height="500" src="<?php echo $sliderdata['video']; ?>" frameborder="0" allowfullscreen></iframe>
				      </div>
				    </div>
				<?php } else {
				?>
                
                <div id="header-category" class="header-category" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)) repeat scroll 0% 0%, transparent url(<?php echo $sliderdata['staticimage']; ?>) no-repeat scroll 0% 0%; background-size:100% 100%;">
    <div class="container-fluid" style="max-width:1300px;">
	<div class="row">
		<div class="col-lg-12 product-speech">
<div class="jumbotron" style="background: rgba(0,0,0,.65);margin-top: 3%;
    margin-left: 3%;
    margin-right: 35%;">
  
  <h2 class="white">Learn Data Science Online.<br />
Courses by Social Scientists, for Social Scientists.</h2>
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
				<?php }
				    }
				}// End of checking of sliderdata contains value or not
				?>
		  	</div>

		  	<!-- general sections -->
            <div class="row">
                <div class="col-lg-4">
                    <h2>Some Header</h2>
                    <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pharetra nulla eros, vel pretium elit egestas eu. In hac habitasse platea dictumst. Donec eu libero nec tortor sagittis accumsan. Nullam vitae auctor mauris, sed cursus metus. Fusce consequat condimentum nisl a sollicitudin.
                    <p>Nam cursus imperdiet tortor, nec laoreet nunc auctor quis. Morbi dapibus velit nisl, vel aliquam tortor faucibus eu. Morbi efficitur mattis volutpat. Vestibulum eget ornare tortor. Nam id pharetra metus. Morbi hendrerit ac est sit amet ultrices. Morbi enim turpis, pharetra sed dui at, ullamcorper mollis mauris. Duis iaculis efficitur lacus, in mattis velit tincidunt at.
                    </p>                 
                </div>
                <div class="col-lg-8">
                 <div class="row wdm_generalbox">
				<?php if (!empty($frontpageblocksection1) && !empty($frontpageblockdescriptionsection1)) {
				?>
                     <a href="#mycourses">
			      <div class="iconbox span3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<?php if(!empty($frontpageblockiconsection1)) { ?>
						<div class="iconcircle">
						<i class="fa fa-<?php echo $frontpageblockiconsection1; ?>"></i>
						</div>
					<?php } ?>
			          
					<div class="iconbox-content ">
						<p style="font-size: 1.2em;"><?php echo $frontpageblocksection1; ?></p>
					</div>

					<?php if (!empty($sectionbuttontext1) && !empty($sectionbuttonlink1)) { ?>
						<a class="btn btn-primary btn-flat" href="<?php echo $sectionbuttonlink1;?>" target="_blank"><?php echo $sectionbuttontext1; ?></a>
					<?php } ?>
			      </div>
                     </a>
				<?php } if (!empty($frontpageblocksection2) && !empty($frontpageblockdescriptionsection2)) {
				?>
                     <a href="#aboutus">
			      <div class="iconbox span3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<?php if(!empty($frontpageblockiconsection2)) { ?>
						<div class="iconcircle">
						<i class="fa fa-<?php echo $frontpageblockiconsection2; ?>"></i>
						</div>
					<?php } ?>
			          
					<div class="iconbox-content">
						<p style="font-size: 1.2em;"><?php echo $frontpageblocksection2; ?></p>
					</div>

					<?php if (!empty($sectionbuttontext2) && !empty($sectionbuttonlink2)) { ?>
						<a class="btn btn-primary btn-flat" href="<?php echo $sectionbuttonlink2;?>" target="_blank"><?php echo $sectionbuttontext2; ?></a>
					<?php } ?>
			      </div>
                     </a>
				<?php }
				if (!empty($frontpageblocksection3) && !empty($frontpageblockdescriptionsection3)) {
				?>
                     <a href="#faqs">
			      <div class="iconbox span3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					
					<?php if(!empty($frontpageblockiconsection3)) { ?>
						<div class="iconcircle">
						<i class="fa fa-<?php echo $frontpageblockiconsection3; ?>"></i>
						</div>
					<?php } ?>

					<div class="iconbox-content">
						<p style="font-size: 1.2em;"><?php echo $frontpageblocksection3; ?></p>
					</div>

					<?php if (!empty($sectionbuttontext3) && !empty($sectionbuttonlink3)) { ?>
						<a class="btn btn-primary btn-flat" href="<?php echo $sectionbuttonlink3;?>" target="_blank"><?php echo $sectionbuttontext3; ?></a>
					<?php } ?>
			      </div>
                     </a>
				<?php }
				if (!empty($frontpageblockiconsection4) && !empty($frontpageblocksection4) && !empty($frontpageblockdescriptionsection4)) {
				?>
                     <a href="#contactus">
			      <div class="iconbox span3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<?php if(!empty($frontpageblockiconsection4)) { ?>
						<div class="iconcircle">
						<i class="fa fa-<?php echo $frontpageblockiconsection4; ?>"></i>
						</div>
					<?php } ?>

					<div class="iconbox-content">
						<p style="font-size: 1.2em;"><?php echo $frontpageblocksection4; ?></p>
					</div>

					<?php if (!empty($sectionbuttontext4) && !empty($sectionbuttonlink4)) { ?>
						<a class="btn btn-primary btn-flat" href="<?php echo $sectionbuttonlink4;?>" target="_blank"><?php echo $sectionbuttontext4; ?></a>
					<?php } ?>
			      </div>
                     </a>
				<?php } ?>
		    </div> <!-- general sections end -->                   
                </div>
            </div>
            <hr class="divider">
            <div class="row pad-20">
                <div class="col-lg-12">
                    <h2>My Courses</h2>
                    <a name="mycourses"></a>
                    <p>This is a standard message we display to users about courses. Something about if you don't see courses what email to contact etc etc.</p>
              <?php 
                    $courses = enrol_get_all_users_courses($USER->id, TRUE, array('format', 'summary', 'summaryformat'));
            if(count($courses)>=1){
                echo'<div class="row course-grid">';
                foreach($courses as $course){
                    $fullcourse=$DB->get_record('course',array('id'=>$course->id));
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
        }
                    
                    echo'
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="box box-shadow">
                      <div class="box-header no-padding wdm-course-img" style="background-image: url('.$url.');
                                    background-size: cover;
                                    background-position: center">
                          <div class="wdm-course-img-info">
                            <h3><a href="/course/view.php?id='.$course->id.'">View Course</a></h3>
                          </div>
                      </div>

                      <div class="box-body text-muted" style="min-height: 133px;">
                        <h4>
                        <a class="wdm_course" href="/course/view.php?id='.$course->id.'" title="'.$course->fullname.'">'.$course->fullname.'                        </a>
                        </h4>
                          '.$course->summary.'                      
                           <a href="/course/view.php?id='.$course->id.'" class="btn btn-primary">Launch Course</a></div>
                      <!-- /.box-body -->
                     
                    </div>
                </div>
                    ';
                    
                }
            }
                    echo'</div>'?>
                </div>
            </div>
            <hr class="divider">
          <div class="row pad-20">
                <div class="col-lg-12">
                   <h2>ABOUT SAGE CAMPUS</h2>
                    <a name="about"></a>
                    <p><strong>Welcome!<br>&nbsp;</strong><br>Here at SAGE&nbsp;Campus&nbsp;we’ve developed a suite of online courses to equip social scientists with data science skills.<br><strong>&nbsp;<br>Social Science Research is Changing<br>&nbsp;</strong><br>We understand that social science research is changing. The increasing availability of data and the development of new computational tools for data collection and analysis provide new opportunities for social science researchers. We want to help you gain the skills&nbsp;you need&nbsp;to embrace the data revolution, build a successful career and, ultimately, produce&nbsp;high quality&nbsp;social science research.</p><br><p></p
                </div>
            </div> 
              <hr class="divider">
<div class="row pad-20">
                <div class="col-lg-12">
                    <h2>Frequently Asked Questions</h2>
                    <a name="faqs"></a>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading1">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1">
                    FAQ Question 1
                </a>
            </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">
            <div class="panel-body">
                <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed eleifend magna. Duis sit amet lacus dictum, rhoncus leo quis, sagittis ante. Etiam suscipit laoreet felis, vel cursus felis facilisis ac. Integer in dignissim odio, sit amet ullamcorper eros. In tempor eu tortor condimentum venenatis. Sed semper et ex et sagittis.</p>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading2">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                    FAQ Question 2
                </a>
            </h4>
        </div>
        <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
            <div class="panel-body">
                <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed eleifend magna. Duis sit amet lacus dictum, rhoncus leo quis, sagittis ante. Etiam suscipit laoreet felis, vel cursus felis facilisis ac. Integer in dignissim odio, sit amet ullamcorper eros. In tempor eu tortor condimentum venenatis. Sed semper et ex et sagittis.</p>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading3">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                    FAQ Question 3
                </a>
            </h4>
        </div>
        <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
            <div class="panel-body">
                <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed eleifend magna. Duis sit amet lacus dictum, rhoncus leo quis, sagittis ante. Etiam suscipit laoreet felis, vel cursus felis facilisis ac. Integer in dignissim odio, sit amet ullamcorper eros. In tempor eu tortor condimentum venenatis. Sed semper et ex et sagittis.</p>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading4">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                    FAQ Question 4
                </a>
            </h4>
        </div>
        <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
            <div class="panel-body">
                <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed eleifend magna. Duis sit amet lacus dictum, rhoncus leo quis, sagittis ante. Etiam suscipit laoreet felis, vel cursus felis facilisis ac. Integer in dignissim odio, sit amet ullamcorper eros. In tempor eu tortor condimentum venenatis. Sed semper et ex et sagittis.</p>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>
		    
		    <div id="region-main" class="default-section" style="display:none">
		        <?php echo $OUTPUT->main_content(); ?>
		    </div>
            <div class="row pad-20">
                <div class="col-lg-12">
                <h2>Contact Us</h2>
                    <a name="contactus"></a> 
                <p>For technical support please contact <a href="campus.info@sagepub.com">campus.info@sagepub.com</a></p>
                </div>
            </div>

		    <!-- frontpage recent blog -->
		    <?php if (isloggedin() && !empty($CFG->enableblogs) && is_array($recentblogs) && !empty($recentblogs)) { ?>
		      <div class="row blog">
		        <!-- Carousel -->
		        <h2 class="">Recent blogs</h2> <br />
		            <?php foreach ($recentblogs as $key => $recentblog) {
		                $link = $CFG->wwwroot.'/blog/index.php?entryid='.$recentblog['id'];
		            ?>
		            <div class="col-md-3 col-sm-4 recent-item">
		                    <div class ="wdm-recent-item-blog "style="background-image: url(<?php echo $recentblog['imagesrc']; ?>);
		                        background-size: cover;
		                        background-position: center; height:200px">
		                        <div class="wdm-recent-item-blog-info">
		                              <h3><a href="<?php echo $link; ?>" ><?php echo get_string('viewblog', 'theme_remui'); ?></a></h3>
		                        </div>
		                    </div>
		                <div class="recent-caption margin-auto pad-20">
		                    <h4><a href="<?php echo $link; ?>"><?php echo $recentblog['subject']; ?></a></h4>
		                    <p class="text-muted"><?php echo $recentblog['summary'];?></p>
		                </div>
		            </div>
		        <?php } ?>
		      </div>
		    <?php } ?>
	  	</section><!-- /.content -->
	</div><!-- /.content-wrapper -->

<?php
	
	// Include post sidebar
	if($hasrightsideblocks || $PAGE->user_is_editing())
    	require_once(\theme_remui\controller\theme_controller::get_partial_element('post-aside'));
	
	// Include footer
	require_once(\theme_remui\controller\theme_controller::get_partial_element('footer'));

	echo $OUTPUT->standard_end_of_body_html();
?>

</div> <!-- end main page wrapper -->
</body>
</html>