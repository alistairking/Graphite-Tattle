<?php
$tmpl->set('title', 'Threshold Checks &middot; Tattle &middot; Charthouse');
$active_tab_alerts = " class=active";
$tmpl->set('breadcrumbs',$breadcrumbs);
$tmpl->place('header');

try {
	$checks->tossIfEmpty();
	$affected = fMessaging::retrieve('affected', fURL::get());
	?>

<script type="text/javascript">
$(document).ready(function() {
  attachTooltips();
});
</script>

<a class="small btn primary" href="<?php echo Check::makeURL('add', $check_type);?>">Add Check</a>
<table class="zebra-striped">
          <thead>
		<tr>
    <th><?php echo fCRUD::printSortableColumn('name','Name'); ?></th>
    <th class="masterTooltip" title="Graph Target that will be checked in Graphite"><?php echo fCRUD::printSortableColumn('target','Target'); ?></th>
    <th class="masterTooltip" title="The threshold level at which a Warning will be triggered"><?php echo fCRUD::printSortableColumn('warn','Warn'); ?></th>
    <th class="masterTooltip" title="The threshold level at which an Error will be triggered"><?php echo fCRUD::printSortableColumn('error','Error'); ?></th>
    <th class="masterTooltip" title="Number of data points to use when calculating the moving average. Each data point spans one minute"><?php echo fCRUD::printSortableColumn('sample','Sample'); ?></th>
    <th><?php echo fCRUD::printSortableColumn('baseline','Baseline'); ?></th>
    <th class="masterTooltip" title="Over will trigger an alert when the value retrieved from Graphite is greater than the warning or error threshold. Under will trigger an alert when the value retrieved from Graphite is less than the warning or the error threshold"><?php echo fCRUD::printSortableColumn('over_under','Over/Under'); ?></th>
    <th class="masterTooltip" title="Public checks can be subscribed to by any user while private checks remain hidden from other users"><?php echo fCRUD::printSortableColumn('visiblity','Visibility'); ?></th>
    <th>Action</th>
       </tr></thead><tbody>    
	<?php
	$first = TRUE;
	foreach ($checks as $check) {
	?>
    	<tr>
        <td><?php echo $check->prepareName() . '<br/><a href="' . CheckResult::makeUrl('list',$check) . '">View';?></a> | <?php if (fSession::get('user_id') == $check->getUserId() || fAuthorization::checkAuthLevel('admin')) { 
                    echo '<a href="' . Check::makeURL('edit', $check_type, $check) . '"> Edit</a> |'; 
                  } ?>
        <a href="<?php echo Subscription::makeURL('add', $check); ?>">Subscribe</a></td>
        <td style="max-width:300px; overflow:scroll;"><?php echo $check->prepareTarget(); ?></td>
        <td><?php echo $check->prepareWarn(); ?></td>
        <td><?php echo $check->prepareError(); ?></td>
        <td><?php echo $check->prepareSample(); ?></td>
        <td><?php echo $check->prepareBaseline(); ?></td>
        <td><?php echo $over_under_array[$check->getOver_Under()]; ?></td>
        <td><?php echo $visibility_array[$check->getVisibility()]; ?></td>
        <td><?php echo $check->prepareName() . '<br/><a href="' . CheckResult::makeUrl('list',$check) . '">View';?></a> | <?php if (fSession::get('user_id') == $check->getUserId() || fAuthorization::checkAuthLevel('admin')) { 
                    echo '<a href="' . Check::makeURL('edit', $check_type, $check) . '">Edit</a> |'; 
                  } ?>
        <a href="<?php echo Subscription::makeURL('add', $check); ?>">Subscribe</a></td>
        </tr>
    <?php } ?>
    </tbody></table>
    <?php
    //check to see if paging is needed
    $total_pages = ceil($checks->count(TRUE) / $GLOBALS['PAGE_SIZE']);
    if ($total_pages > 1) {
      $prev_class = 'previous';
      $prev_link = fURL::replaceInQueryString('page', $page_num -1 );
      $next_class = 'next';
      $next_link = fURL::replaceInQueryString('page', $page_num + 1);
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
	<p class="info">There are currently no <?php echo $check_type?> based checks. <a href="<?php echo Check::makeURL('add', $check_type); ?>">Add one now</a></p>
	<?php
}
?>
</div>
<?php $tmpl->place('footer') ?>
