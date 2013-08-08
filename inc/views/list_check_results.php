<?php
$tmpl->set('title', 'Check Results &middot; Tattle &middot; Charthouse');
$tmpl->set('graphlot',true);
$tmpl->place('header');

 try {
        $check = new Check($check_id);
        $affected = fMessaging::retrieve('affected', fURL::get());
  } catch (fEmptySetException $e) {
?>
        <p class="info">There are currently no Tattle checks. Add a <a href="<?php echo Check::makeURL('add', 'threshold'); ?>">threshold</a> based or a <a href="<?php echo Check::makeURL('add', 'predictive'); ?>">predictive</a> based check now.</p>
        <?php
  } ?>
<fieldset>
    <div style="padding-bottom:15px;">
        <span>Name : <?php echo $check->prepareName(); ?></span> |
        <span>Target : <?php echo Check::constructTarget($check); ?></span>
    </div>
    <span><?php echo Check::showGraph($check,true,'-48hours',620,true); ?></span>
</fieldset>
<?php
  try {
    $check_results->tossIfEmpty();
    $affectd = fMessaging::retrieve('affected',fURL::get());
   ?>
        <a class="btn small primary" href="<?php echo CheckResult::makeURL('ackAll', $check = new Check($check_id)); ?>">Clear All</a>
        <table class="zebra-striped">
    <tr>
    <th>Status</th>
    <th>Value</th>
    <th>Error</th>
    <th>Warn</th>
    <th>State</th>
    <th>Time</th>
       </tr>
<?php
    $first = TRUE;
    foreach ($check_results as $check_result) {
        $check = new Check($check_result->getCheck_Id());
?>
        <tr>
        <td><?php echo $status_array[$check_result->prepareStatus()]; ?></td>
        <td><?php echo $check_result->prepareValue(); ?></td>
        <td><?php echo $check->prepareError(); ?></td>
        <td><?php echo $check->prepareWarn(); ?></td>
        <td><?php echo $check_result->prepareState(); ?></td>
        <td><?php echo $check_result->prepareTimestamp('Y-m-d H:i:s'); ?></td>
        </tr>
    <?php } ?>
    </table></div>
    <?php
    //check to see if paging is needed
    $total_pages = ceil($check_results->count(TRUE) / $GLOBALS['PAGE_SIZE']);
    if ($total_pages > 1) {
      $prev_class = 'previous';
      $current_link = "?action=$action&check_id=$check_id";
      $prev_link = $current_link . '&page=' . ($page_num - 1);
      $next_class = 'next';
      $next_link = $current_link . '&page=' . ($page_num + 1);
      if ($page_num == 1) {
        $prev_class .= ' disabled';
        $prev_link = '#';
      } elseif ($page_num == $total_pages) {
        $next_class .= ' disabled';
        $next_link = '#';
      }
      ?>
      <div class="pagination">
        <ul class="pager">
          <li class="<?php echo $prev_class; ?>">
            <a href="<?php echo $prev_link; ?>">&larr; Previous</a>
          </li>
          <li class="<?php echo $next_class; ?>">
            <a href="<?php echo $next_link; ?>">Next &rarr;</a>
          </li>
        </ul>
      </div>
    <?php }
} catch (fEmptySetException $e) {
?>
        <p class="info">There are currently no alerts for this checks.</p>
<?php
}
?>
<?php $tmpl->place('footer') ?>
