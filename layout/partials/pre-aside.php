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
 * Partial - Pre Sidebar
 *
 * @package   theme_remui
 * @copyright Copyright (c) 2016 WisdmLabs
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// get and set sidebar state
user_preference_allow_ajax_update("presidebar_state", PARAM_TEXT);
$presidebar_open = json_decode(get_user_preferences("presidebar_state", 1));

// get main color scheme
$sidebar = "dark-sidebar";
if (empty($search)) {
    $search = '';
}
$colorscheme = \theme_remui\toolbox::get_setting('colorscheme');
// Get course renederer
$courserenderer = $PAGE->get_renderer('core', 'course');
if (!empty($colorscheme) && strpos($colorscheme, 'light') !== false) {
    $sidebar = "light-sidebar";
}

// check if its activity page, get activity id
$activity_id = (isset($PAGE->cm->id)?$PAGE->cm->id:false);

?>
<aside class="main-sidebar moodle-has-zindex <?php echo $sidebar; ?>">
  
      <!-- sidebar: style can be found in sidebar.less -->
       <section class="sidebar">
        
        
        <?php
          // moodle side-pre block
          if ( \theme_remui\toolbox::get_setting('sidebar') == 'old') {
            // course search form
            echo $courserenderer->course_search_form($search);
            echo $OUTPUT->blocks('side-pre', array(), 'div');
          } else {

              if ($activity_id) {
                  global $COURSE;
                  $modinfo = get_fast_modinfo($COURSE);
                  $sections_data = $modinfo->sections;
                  $excluded_mods = array('label');
                  $count = 0; // to print section count in sidebar
                ?>

                <div style="" class="back-course">
                  <ul class="sidebar-menu">
                    <li>
                  <a href="<?php echo course_get_url($COURSE->id); ?>">
                    <i class="fa fa-chevron-left text-center"></i>
                    <span style=" vertical-align:middle;"><?php echo get_string('backtocourse', 'theme_remui'); ?></span>
                  </a>
                  </li></ul>
                </div>

                <?php

                echo '<ul class="sidebar-menu activities">';
                  foreach($modinfo->get_section_info_all() as $mod => $value){
                    // return if sections does not have activities or section is hidden to current user
                    if(!array_key_exists($mod, $sections_data) || !$value->uservisible) {
                      continue;
                    }
                    // increase count only if section is visible to current user
                    $count++;

                    $section_name = $value->__get('name');
                    
                    // check if current section is being viewed
                    $open_section = '';
                    if(in_array($PAGE->cm->id, $sections_data[$mod])) {
                      $open_section = 'active';
                    }

                    // handle empty section heading
                    if(empty($section_name) && $mod == 0) {
                      $section_name = get_string('sectionnotitle', 'theme_remui');
                    } elseif (empty($section_name)) {
                      $section_name = get_string('sectiondefaulttitle', 'theme_remui').' '.($mod+1);
                    }

                    echo '<li class="treeview '.$open_section.'">
                      <a href="#">
                        <i class="" style="font-style: normal;">'.($count).'.</i> 
                        <span>'.$section_name.'</span>

                        <!-- <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span> -->
                      </a> ';

                    // activity list
                    echo '<ul class="treeview-menu">';
                    foreach($sections_data[$mod] as $activity_id){

                      $activity = $modinfo->get_cm($activity_id);
                      $classes = '';
                      $completioninfo = new completion_info($COURSE);
                      $activity_completion = $courserenderer->course_section_cm_completion($COURSE, $completioninfo, $activity, array());

                      if(!in_array($activity->modname, $excluded_mods)) {
                          // check if current activity
                          $active = ' ';
                          if($PAGE->cm->id == $activity_id) {
                            $active = 'active ';
                          }
                          
                          $completion = $completioninfo->is_enabled($activity);
                          if ($completion == COMPLETION_TRACKING_NONE) {
                              $classes = '';
                          } else {
                              $completiondata = $completioninfo->get_data($activity, true);
                              switch($completiondata->completionstate) {
                                case COMPLETION_INCOMPLETE:
                                    $classes = 'incomplete';
                                    break;
                                case COMPLETION_COMPLETE:
                                    $classes = 'complete';
                                    break;
                                case COMPLETION_COMPLETE_PASS:
                                    $classes = 'complete';
                                    break;
                                case COMPLETION_COMPLETE_FAIL:
                                    $classes = 'fail';
                                    break;
                              }
                          }

                          echo '<li class="activity '.$active.$classes.'" id="'.$active.'">';
                          echo $courserenderer->course_section_cm_name_title($activity, array());
                          echo '</li>';
                      }
                    }
                    echo '</ul>';
                    echo '</li>';
                  }

                  echo '</ul>';
            } else {

                // course search form
                echo $courserenderer->course_search_form($search);

                $a = $PAGE->flatnav->get_key_list();

                // For course with sections on top of the left sidebar
                /*$arr = $arr1 = $arr2 = array();
                $count1 = $count2 = 0;
                foreach ($a as $value)
                {
                  $b = $PAGE->flatnav->get($value);
                  if ($value == 'coursehome') {
                    $arr1[$count1] = $value;
                    $count1++;
                    continue;
                  }
                  if (preg_match('#section#', $b->action) && $value != 'addblock') {
                    $arr1[$count1] = $value;
                    $count1++;
                    continue;
                  }
                  $arr2[$count2] = $value;
                  $count2++;
                }
                $arr = array_merge($arr1,$arr2);*/

                $count = $flag = $active = $activelink = $courselink = 0; $attr;
                $showdivider = false;
                ?>
                <ul class="sidebar-menu">
                <?php

                // just a hack :p
                $pf = get_string('privatefiles');
                $cmpt = get_string('competencies', 'core_competency');

                // foreach ($arr as $value)
                foreach ($a as $value)
                {
                  $b = $PAGE->flatnav->get($value);
            if($value=='myhome'){
                continue;
            }
                  if($b->showdivider()) {
                    $showdivider = true;
                  } else {
                    $showdivider = false;
                  }

                  if ($b->isactive) {
                    $class = "class='active'";
                  } else {
                    if ($value == 'grades' && preg_match('#/grade/report/#', $PAGE->url)) {
                      $class = "class='active'";
                    } elseif ($value == 'mycourses' && optional_param('mycourses', -1, PARAM_INT) == 1) {
                      $class = "class='active'";
                    } else {
                      $class = "class=''";
                    }
                  }
					if($value=='calendar'){
						continue;
					}
                  if ($value == 'home') {
                    $count++;
                    $flag = 1;
                    if ($b->isactive) {
                      $class = "class='active'";
                      $active = 1;
                    }
                  }

                  if ($value == 'home' && $count == 2) {
                    $showdivider = false;
                    if ($b->isactive && $active == 1) {
                      $class = "class=''";
                    }
                  }

                  switch ($value) {
                    case 'myhome' : $icon = 'fa fa-dashboard'; break;
                    case 'home': $icon = 'fa fa-home'; break;
                    case 'calendar' : $icon = 'fa fa-calendar'; break;
                    case 'mycourses' : $icon = 'fa fa-book'; break;
                    case 'sitesettings' : $icon = 'fa fa-cog'; break;
                    case 'addblock' : $icon = 'fa fa-plus-circle'; break;
                    case 'badgesview' : $icon = 'fa fa-certificate'; break;
                    case 'participants' : $icon = 'fa fa-users'; break;
                    case 'grades' : $icon = 'fa fa-star'; break;
                    case 'coursehome' : $icon = 'fa fa-book'; break;
                    default : $icon = 'fa fa-folder'; break;
                  }

                  switch($b->text) {
                    case $pf : $icon = 'fa fa-files-o'; break;
                    case $cmpt : $icon = 'fa fa-check-circle'; break;
                  }

                  if ($value == 'home' && $count == 2 && $flag == 1) {
                      $class='class="hidden-xl-down"';
                      continue;
                    $b->action = $CFG->wwwroot."/my/";
                    if ($PAGE->url == $CFG->wwwroot."/my/index.php") {
                      $class = "class='active'";
                    }
                    $b->text = get_string('myhome');
                    $icon = 'fa fa-dashboard';
                  }
                  if ($value == 'mycourses') {
                    $b->action = $CFG->wwwroot."/course/?mycourses=1"; // redirect to course archive page with user enrolled courses only.
                  }
                  if ($b->action) {
                    $attr = "href='".$b->action."'";
                  } else {
                    $attr = "href='/' onclick='return false;'";
                  }

                  if (preg_match('#section#', $b->action) && $value != 'addblock') {
                    $b->set_indent(true);
                  }

                  //

                  if ($COURSE->fullname == $b->text || $COURSE->shortname == $b->text) {
                    if ($courselink == 1) {
                      $class = "class=''";
                      $b->set_indent(true);
                      $courselink = 0;
                    }
                    if ($activelink == 1) {
                      $class = "class=''";
                      $b->set_indent(true);
                      $activelink = -1;
                    }
                    if ($activelink != -1) {
                      $activelink = 1;
                    }
                  }

                  if ($COURSE->format == 'singleactivity') {
                    if ($value == 'coursehome') {
                      $class = "class='active'";
                      $courselink = 1;
                    }
                  }

                  if ($b->action.'?query' == $PAGE->url) {
                    $class = "class='active'";
                  }

                  //

                  if($showdivider) {
                  ?>
                  <li class="sidebar-separator"></li>
                  <?php
                  }
                  ?>
                  <li <?= $class?> data-key="<?= $value?>">
                  <?php
                  if($b->get_indent()) {
                  ?>
                    <a <?= $attr?> class="sidebar-extra-pad-left">
                  <?php
                  } else {
                  ?>
                    <a <?= $attr?>>
                  <?php
                  }
                  ?>
                      <i class="<?= $icon?>" style="display: table-cell; vertical-align: top;padding-top: 3px;"></i>
                      <span style="display: table-cell; vertical-align: top;"><?= $b->text?></span>
                    </a>
                  </li>
                  <?php
                }
                ?>
                </ul>
                <?php
              }
          }
        ?>
      </section> 
      <!-- /.sidebar -->
      <!-- </section> -->
</aside>