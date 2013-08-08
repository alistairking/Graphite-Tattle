<?php fHTML::sendHeader() ?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->prepare('title'); ?><?php echo (strpos($this->get('title'), 'Tattle') === FALSE ? ' - Tattle' : ''); ?></title>
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

   <?php
       $this->place('css');
       $this->place('js');
    if ($this->get('graphlot')) { ?>
    <script type="text/javascript" src="<?php echo $GLOBALS['GRAPHITE_URL']; ?>/content/js/jquery.flot.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['GRAPHITE_URL']; ?>/content/js/jquery.autocomplete.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['GRAPHITE_URL']; ?>/content/js/jquery.flot.selection.js"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['GRAPHITE_URL']; ?>/content/js/jquery.flot.crosshair.js"></script>
    <script type="text/javascript">

    $(document).ready(function () {
        $('.graphite').graphiteGraph();
    });

    </script>

<?php }

if ($this->get('addeditdocready')) { ?>
  <script type="text/javascript">
    $(document).ready(function() {
      $("fieldset.startCollapsed").collapse( { closed: false } );
      reloadGraphiteGraph();
      attachTooltips();
    });
  </script>
<?php }

if (!$this->get('full_screen')) { ?>
    <style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>
<?php } ?>

    <script type="text/javascript">
      $(function() {
        $("#check-target").autocomplete({
          source: "ajax/autocomplete.php",
          minLength: 2,
          select: function(event, ui) {
            $('#check-target').val(ui.item.id);
          }
        });
      });

    </script>
    <script type="text/javascript">
      $(function() {
        $("#line-target").autocomplete({
          source: "ajax/autocomplete.php",
          minLength: 2,
          select: function(event, ui) {
            $('#line-target').val(ui.item.id);
          }
        });
      });

    </script>
<?php
if ($this->get('full_screen') && $this->get('refresh') > 0) {
  echo '<meta http-equiv="refresh" content="' . $this->get('refresh') . '">';
} ?>
  </head>
  <body>

<?php
if (!$this->get('full_screen')) { ?>
   <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="index.php">Tattle </a>
          <ul class="nav">
            <?php

              $current_url = '?'.fURL::getQueryString();
              echo '<li' . ($current_url == '' ? ' class="active"' : '') . '><a href="index.php">Alerts</a></li>'. "\n";
              $threshold_check_list = Check::makeURL('list', 'threshold');
              echo '<li' . ($current_url == $threshold_check_list ? ' class="active"' : '') . '><a href="' . $threshold_check_list . '" >Threshold Checks</a></li>' . "\n";
              $predictive_check_list = Check::makeURL('list', 'predictive');
              echo '<li' . ($current_url == $predictive_check_list ? ' class="active"' : '') . '><a href="' . $predictive_check_list . '" >Predictive Checks</a></li>' . "\n";
              $subscription_list = Subscription::makeURL('list');
              echo '<li' . ($current_url == $subscription_list ? ' class="active"' : '') .'><a href="' . $subscription_list . '" >Subscriptions</a></li>' . "\n";
              $dashboard_list = Dashboard::makeURL('list');
              echo '<li' . ($current_url == $dashboard_list ? ' class="active"' : '') . '><a href="' . $dashboard_list . '">Dashboards</a></li>';
              $setting_list = Setting::makeURL('list','user');
              echo '<li' . ($current_url == $setting_list ? ' class="active"' : '') . '><a href="' . $setting_list . '" >Settings</a></li>' . "\n";
if (fAuthorization::checkAuthLevel('admin')) {
              $setting_list = Setting::makeURL('list','system');
              echo '<li' . ($current_url == $setting_list ? ' class="active"' : '') . '><a href="' . $setting_list . '" >System Settings</a></li>' . "\n";
              $user_list = User::makeURL('list');
              echo '<li><a href="' . User::makeURL('list') . '" >Users</a></li>';
}
?>
          </ul>
 <?php   if (is_numeric(fSession::get('user_id'))) { ?>
 <p class="pull-right">
     Logged in as <a href="<?php echo User::makeUrl('edit',fSession::get('user_id'));?>"><?php echo fSession::get('user_name'); ?></a>
</p>
    <?php } ?>
</div>
        </div>
      </div>
<?php } ?>
<div class="container-fluid">
<?php
    $breadcrumbs = $this->get('breadcrumbs');
    if (is_array($breadcrumbs)) {
    echo '<ul class="breadcrumb">';
      $crumb_count = count($breadcrumbs);
      $crumb_counter = 1;
      foreach($breadcrumbs as $crumb) {
        echo '<li' . (isset($crumb['class']) ? ' class="' . $crumb['class'] .'"' : ' class="active"' ) .'><a href="'. $crumb['url'] . '">' . $crumb['name'] . '</a>';
        if ($crumb_counter < $crumb_count) {
          echo '<span class="divider">/</span></li>';
        }
        $crumb_counter++;
      }
     echo '</ul>';
    } ?>
<?php

if (fMessaging::check('error', fURL::get())) {
  echo '<div class="alert-message error">';
    fMessaging::show('error', fURL::get());
  echo '</div>';
}


if (fMessaging::check('success', fURL::get())) {
  echo '<div class="alert-message success">';
    fMessaging::show('success', fURL::get());
  echo '</div>';
}

