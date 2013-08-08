<?php
$page_title = ($action == 'add' ? 'Add a Check' : 'Editing : ' . $check->encodeName());
$tmpl->set('title', $page_title);
$breadcrumbs[] = array('name' => $page_title, 'url' => ($action == 'add' ? Check::makeURL($action,$check_type) : Check::makeURL($action,$check_type,$check)), 'active' => true);
$tmpl->set('breadcrumbs',$breadcrumbs);
$tmpl->set('addeditdocready', true);
$tmpl->place('header');
?>
  <div class="row">
    <div class="span4">
      <form class="form-stacked" action="?action=<?php echo $action; ?>&type=<?php echo $check_type; ?>&check_id=<?php echo $check_id; ?>" method="post">
        <div class="main" id="main">
          <fieldset>
            <div class="clearfix">
              <label class="masterTooltip" title="Name used to identify this check" for="check-name">Name<em>*</em></label>
              <div class="input">
                <input id="check-name" class="span3" type="text" size="30" name="name" value="<?php echo $check->encodeName(); ?>" />
              </div>
            </div><!-- /clearfix -->
            <div class="clearfix">
              <label class="masterTooltip" title="The path of your new Graph Target to check up on" for="check-target">Graphite Target<em>*</em></label>
              <div class="input">
                <input id="check-target" class="span3" type="text" size="30" name="target" value="<?php echo $check->encodeTarget(); ?>" />
              </div>
            </div><!-- /clearfix -->
            <div class="clearfix">
              <label class="masterTooltip" title="The threshold level at which an Error will be triggered" for="check-error">Error Threshold<em>*</em></label>
              <div class="input">
                <input id="check-error" class="span3" type="text" name="error" value="<?php echo $check->encodeError(); ?>" />
              </div>
            </div><!-- /clearfix -->
            <div class="clearfix">
              <label class="masterTooltip" title="The threshold level at which a Warning will be triggered" for="check-warn">Warn Threshold<em>*</em></label>
              <div class="input">
                <input id="check-warn" class="span3" type="text" name="warn" value="<?php echo $check->encodeWarn(); ?>" />
              </div>
            </div><!-- /clearfix -->
         </fieldset>
         <fieldset class="startCollapsed">
            <legend>Advanced</legend>
            <div class="clearfix">
              <label class="masterTooltip" title="Number of data points to use when calculating the moving average. Each data point spans one minute" for="check-sample">Sample Size in Minutes<em>*</em></label>
              <div class="input">
                <input id="check-warn" class="span3" type="text" name="sample" value="<?php echo $check->encodeSample(); ?>" />
              </div>
            </div><!-- /clearfix -->
            <div class="clearfix">
              <label class="masterTooltip" title="Over will trigger an alert when the value retrieved from Graphite is greater than the warning or error threshold. Under will trigger an alert when the value retrieved from Graphite is less than the warning or the error threshold" for="check-over_under">Over/Under<em>*</em></label>
              <div class="input">
                <select name="over_under" class="span3">
                <?php
                  foreach ($over_under_array as $value => $text) {
                    fHTML::printOption($text, $value, $check->getOverUnder());
                  }
                ?>
                </select>
              </div>
            </div><!-- /clearfix -->
            <div class="clearfix">
             <label class="masterTooltip" title="Public checks can be subscribed to by any user while private checks remain hidden from other users" for="check-visibility">Visibility<em>*</em></label>
             <div class="input">
               <select name="visibility" class="span3">
               <?php
                foreach ($visibility_array as $value => $text) {
                    fHTML::printOption($text, $value, $check->getVisibility());
                }
?>
               </select>
             </div>
           </div><!-- /clearfix -->
           <div class="clearfix">
             <label class="masterTooltip" title="After an alert is triggered, the number of minutes to wait before sending another one" for="check-repeat_delay">Repeat Delay<em>*</em></label>
             <div class="input">
<?php
                $check_delay = (is_null($check->getRepeatDelay()) ? 30 : $check->encodeRepeatDelay());
?>
                <input id="check-repeat_delay" class="span3" type="text" size="20" name="repeat_delay" value="<?php echo $check_delay; ?>" />
              </div>
           </div><!-- /clearfix -->
           </fieldset>
           <fieldset>
             <div class="actions">
             <input class="btn primary" type="submit" value="Save" />
             <?php if ($action == 'edit') { ?><a href="<?php echo Check::makeURL('delete', $check_type, $check); ?>" class="btn" >Delete</a><?php } ?>
             <div class="required"><em>*</em> Required field</div>
             <input type="hidden" name="token" value="<?php echo fRequest::generateCSRFToken(); ?>" />
<?php if ($action == 'add') { ?>
             <input type="hidden" name="user_id" value="<?php echo fSession::get('user_id'); ?>" />
             <input type="hidden" name="type" value="<?php echo $check_type; ?>" />
<?php } ?>
           </div>
         </fieldset>
       </div>
     </form>
    </div>
    <div class="span10">
      <?php if ($action == 'edit') { ?>
        <div class="sidebar" id="sidebar">
          <fieldset>
            <p>Check : <?php echo $check->prepareName(); ?></p>
            <p>Target : <?php echo Check::constructTarget($check); ?></p>
            <p id="graphiteGraph"><?php echo Check::showGraph($check); ?></p>
            <input class="btn primary" type="submit" value="Reload Graph" onClick="reloadGraphiteGraph()"/>
            <select id="graphiteDateRange" class="span3">
              <?php $dateRange = array('-12hours'   => '12 Hours', '-1days' => '1 Day', '-3days' => '3 Days', '-7days' => '7 Days', '-14days' => '14 Days', '-30days' => '30 Days', '-60days' => '60 Days');
                foreach ($dateRange as $value => $text) {
                  fHTML::printOption($text, $value, '-3days');
                }
              ?>
            </select>
          </fieldset>
        </div>
      <?php } ?>
    </div>
</div>
</div>
<?php
$tmpl->place('footer');
