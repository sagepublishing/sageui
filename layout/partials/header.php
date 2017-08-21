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
 * Partial - Header
 * This layout is baed on a moodle site index.php file but has been adapted to show news items in a different
 * way.
 *
 * @package   theme_remui
 * @copyright Copyright (c) 2016 WisdmLabs
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
global $DB, $USER, $OUTPUT;

$hasrightsideblocks = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
if ( \theme_remui\toolbox::get_setting('sidebar') == 'old') {
    $hasrightsideblocks = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
}

$logoorsitename = \theme_remui\toolbox::get_setting('logoorsitename');
$siteicon = \theme_remui\toolbox::get_setting('siteicon');
$checklogo = \theme_remui\toolbox::setting_file_url('logo', 'logo');
if (!empty($checklogo)) {
    $logo = $checklogo;
} else {
    $logo = \theme_remui\toolbox::pix_url('logo','theme');
}

$checklogomini = \theme_remui\toolbox::setting_file_url('logomini', 'logomini');
if (!empty($checklogomini)) {
    $logomini = $checklogomini;
} else {
    $logomini = \theme_remui\toolbox::pix_url('logomini','theme');
}

// login popup 
$loginpopup = \theme_remui\toolbox::get_setting('navlogin_popup');

// get current user info
if (isloggedin() && !isguestuser()) {

    // get license data from license controller
    $lcontroller = new \theme_remui\controller\license_controller();
    $getlidatafromdb = $lcontroller->getDataFromDb();

    $userfullname = fullname($USER);
    $userpicture = \theme_remui\controller\theme_controller::get_user_image_link($USER->id, 100);

    // Header events
    $eventslist = \theme_remui\controller\theme_controller::get_events();
    $seealleventslink = new moodle_url('/calendar/view.php?view=upcoming');


    $userprofileurl = new moodle_url('/user/profile.php', array('id' => $USER->id));
    $userdashboardurl = new moodle_url('/my');
    $userlogouturl = new moodle_url('/login/logout.php', array('sesskey' => sesskey(), 'alt' => 'logout'));
    $coursearchive = new moodle_url('/course/index.php');
    $preferences = new moodle_url('/user/preferences.php');
    $switchroleurl ='';
    
      if(is_siteadmin()) {
        $switchroleurl = new moodle_url('/course/switchrole.php', array('id' => 1,'switchrole' => -1,'returnurl' => '/my/index.php'));
      }
} else {
    $userloginurl = new moodle_url('/login/index.php', array('alt' => get_string('login')));
    $forgotpasswordurl = new moodle_url('/login/forgot_password.php');
    $userregisterurl = new moodle_url('/login/signup.php', array('alt' => get_string('startsignup')));
}

$isregistration = $DB->get_record('config', array('name' => 'registerauth'));
?>
<script src="https://use.typekit.net/zfr1tsm.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<!-- Main Header -->
<header class="main-header moodle-has-zindex">
    <!-- logo -->
    <?php
        
        if ($logoorsitename == 'logo') { ?>
            <a href="<?php echo $CFG->wwwroot; ?>" class="logo">
              <span class="logo-mini" style="background-image: url(<?php echo $logomini;?>);
                    background-position: center; height:50px; background-size: contain; background-repeat: no-repeat;"></span>
              <span class="logo-lg" style="background-image: url(<?php echo $logo;?>);
                    background-position: center; height:50px; background-size: contain; background-repeat: no-repeat;">
              </span>
            </a>
        <?php } else if ($logoorsitename == 'sitename') { ?>
            <a class="logo" href="<?php echo $CFG->wwwroot; ?>">
              <span class="logo-mini"><i class="fa fa-<?php echo $siteicon; ?>"></i></span>
              <span class="logo-lg">
                <?php echo format_string($SITE->shortname); ?>
              </span>
            </a>
        <?php } else {  ?>
            <a class="logo" href="<?php echo $CFG->wwwroot; ?>">
              <span class="logo-mini"><i class="fa fa-<?php echo $siteicon; ?>"></i></span>
              <span class="logo-lg">
                  <i class="fa fa-<?php echo $siteicon; ?>"></i>
                  <?php echo format_string($SITE->shortname); ?>
              </span>
            </a>
        <?php }
    ?>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- render custom menu -->
    <div class="pull-left hidden-xs mdl-custom-menu">
        <?php echo $OUTPUT->custom_menu(); ?>
    </div>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
          <li>
            <?php echo $OUTPUT->search_box(); ?>
          </li>
      <?php echo $OUTPUT->navbar_plugin_output(); ?>

      <!-- section to be shown for logged in users -->
      <?php if (isloggedin() && !isguestuser()) { ?>
        <!-- removed remui's Message and Notification to use default moodle message and notification  -->
           <!-- Events Menu  -->
          <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Upcoming Events">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger"><?php
    if (count($eventslist)) {
        echo count($eventslist);
    }
    ?></span>
            </a>
            <ul class="dropdown-menu">
    <?php
    if (count($eventslist)) {
        ?><li class="header"><?php echo get_string('youhaveupcomingevents', 'theme_remui', count($eventslist)); ?></li>
        <?php
    } else {
        ?><li class="header"><?php echo get_string('youhavenoupcomingevents', 'theme_remui'); ?></li>
        <?php
    }
    ?>
              <li>
                <!-- Inner menu: contains the tasks -->
                <ul class="menu">
    <?php
    foreach ($eventslist as $event) { ?>
                  <li><!-- Task item -->
                    <a href="<?php echo $seealleventslink; ?>">
                      <!-- Task title and progress text -->
                      <h3>
                        <?php echo $event->name; ?>
                        <small class="pull-right">
        <?php
        if ($event->timestart < time()) {
            echo get_string('startedsince', 'theme_remui') . " " . \theme_remui\controller\theme_controller::get_time_format(time() - $event->timestart);
        } else {
            echo get_string('startingin', 'theme_remui') . " " . \theme_remui\controller\theme_controller::get_time_format($event->timestart - time());
        }
        ?>
                        </small>
                        <br />
                        <small class="pull-right">
        <?php
        if ($event->timeduration) {
            echo get_string('duration', 'search') . " : " . \theme_remui\controller\theme_controller::get_time_format($event->timeduration);
        }
        ?>
                        </small>
                      </h3>

                    </a>
                  </li><!-- end task item -->
    <?php
    }
    ?>
                </ul>
              </li>
              <li class="footer">
                <a href="<?php echo $seealleventslink; ?>"><?php echo get_string('viewallupcomingevents', 'theme_remui'); ?></a>
              </li>
            </ul>
          </li>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src=" <?php echo $userpicture; ?>" class="user-image" alt="<?php echo get_string('userimage', 'theme_remui'); ?>">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $userfullname; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src=" <?php echo $userpicture; ?>" class="img-circle" alt="<?php echo get_string('userimage', 'theme_remui'); ?>">
                <p>
                    <?php echo $userfullname; ?>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="col-xs-4 text-center">
                  <a href="<?php echo $userdashboardurl ?>"><?php echo get_string('myhome');?></a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="<?php echo $CFG->wwwroot;?>/#mycourses">My Courses</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="<?php echo $preferences ?>"><?php echo get_string('preferences');?></a>
                </div>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $userprofileurl; ?>" class="btn btn-default btn-flat"><?php echo get_string('profile'); ?></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $userlogouturl; ?>" class="btn btn-default btn-flat"><?php echo get_string('logout'); ?></a>
                </div>
                <?php if(!empty($switchroleurl)) { ?>
                 <div class="btn-group btn-block margin-t-5">
                  <a href="<?php echo $switchroleurl; ?>" class="btn btn-default btn-flat btn-block"><?php echo get_string('switchroleto'); ?></a>
                </div>
                <?php } ?>
              </li>
            </ul>
          </li>
        <?php } else { ?>
          <!-- User login panel -->
          <?php if($loginpopup) { ?>
            <li class="dropdown user user-menu login-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-sign-in"></i>&nbsp;<?php echo get_string('login'); ?>
              </a>

              <ul class="dropdown-menu">
                <!-- Menu Body -->
                <li class="box-body">
                  <form class="login-form" method="post" action="<?php echo $CFG->wwwroot; ?>/login/index.php?authldap_skipntlmsso=1">
                    
                    <div class="input-group form-group">
                      <span class="input-group-addon bg-gray"><i class="fa fa-user text-muted"></i>&nbsp;</span>
                      <input type="text" class="form-control" id="username" name="username" placeholder="<?php echo get_string('username'); ?>">
                    </div>

                    <div class="input-group form-group">
                      <span class="input-group-addon bg-gray"><i class="fa fa-key text-muted"></i></span>
                      <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo get_string('password'); ?>">
                    </div>

                    <div class="form-group">
                      <div class="checkbox">
                        <label class="text-muted">
                          <input type="checkbox" name="rememberusername" id="rememberusername" value="1" style="margin: 4px -19px 0px;"> <?php echo get_string('remember_me', 'theme_remui'); ?>
                        </label>
                      </div>
                    </div>
                </li>

                <!-- Menu Footer-->
                <li class="box-footer">
                    <div class="pull-left">
                      <a href="<?php echo $forgotpasswordurl; ?>" class="btn text-black"> <?php echo get_string('forgotaccount'); ?></a>
                    </div>
                    <div class="pull-right">
                      <input type="submit" class="btn btn-default btn-flat" id="submit" name="submit" value="<?php echo get_string('login'); ?>"/>
                    </div>
                    </form>
                </li>
              </ul>
            </li>
            <?php } else { ?>
              <li>
                <a href="<?php echo $CFG->wwwroot.'/login'; ?>"><i class="fa fa-sign-in"></i>&nbsp;<?php  echo get_string('login'); ?></a>
              </li>
            <?php } ?>

        <?php if ($isregistration->value == 'email') {
                ?>
          <li>
            <a href=" <?php echo $CFG->wwwroot.'/login/signup.php'; ?>"><i class="fa fa-user"></i>&nbsp;<?php  echo get_string('startsignup'); ?></a>
          </li>
            <?php }
} ?>

    <!-- Control/Post Sidebar Toggle Button -->
  <?php
    if($hasrightsideblocks || $PAGE->user_is_editing()) {
        $iconclass = 'fa-arrow-left';
        $postsidebar_open   = json_decode(get_user_preferences("postsidebar_state", 0));
        $postsidebar_pinned = json_decode(get_user_preferences("postsidebar_pinned", 0));
        $slide = 1;
        if ($postsidebar_pinned) {
            $slide = 0;
            
            if($postsidebar_open) {
              $iconclass = 'fa-arrow-right';
            }

            if($PAGE->pagetype == 'site-index' && !isloggedin()) {
              $iconclass = 'fa-arrow-left';
            }
        }
    ?>

 <li>
   <a href="#" data-toggle="control-sidebar" class="rightsidebar-toggle" data-slide="<?php echo $slide; ?>"><i class="fa <?php echo $iconclass; ?>"></i></a>
 </li>
<?php } ?>
      </ul>
    </div>
  </nav>
</header>
<!-- </header> -->

<?php if (isloggedin() && !isguestuser()) { ?>
<?php if ('available' != $getlidatafromdb) { ?>
  <!-- l nag -->
  <div class="alert alert-danger text-center license-nag">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php if (is_siteadmin()) {
            echo get_string('licensenotactiveadmin', 'theme_remui');
} else {
    echo get_string('licensenotactive', 'theme_remui');
}
        ?>
  </div>
<?php }
}