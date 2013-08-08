<?php
$tmpl->set('title', 'Tattle : Self Service Alerts based on Graphite metrics');
$tmpl->set('breadcrumbs',$breadcrumbs);
$tmpl->place('header');

try {
	$subscriptions->tossIfEmpty();
	$affected = fMessaging::retrieve('affected', fURL::get());
	?>
	<table class="zebra-striped">
          <thead>
          <tr>    
          <th>Check</th>
          <th>Alert State</th>
          <th>Method</th>
          <th>Status</th>
          <th>Action</th>
          </tr>    
          </thead>
          <tbody>
	<?php
	$first = TRUE;
	foreach ($subscriptions as $subscription) {
          $check = new Check($subscription->getCheckId());      
	?>
    	<tr>
        <td><?php echo $check->prepareName(); ?></td>
        <td><?php echo $status_array[$subscription->prepareThreshold()]; ?></td>
        <td><?php echo $subscription->prepareMethod(); ?></td>
        <td><?php echo ($subscription->getStatus() ? 'Disabled' : 'Enabled'); ?></td>
        <td><a href="<?php echo Subscription::makeURL('edit', $subscription); ?>">Edit</a> |
        <a href="<?php echo Subscription::makeURL('delete', $subscription); ?>">Delete</a></td>
        </tr>
    <?php } ?>
    </tbody></table>
    <?php
    //check to see if paging is needed
    $total_pages = ceil($subscriptions->count(TRUE) / $GLOBALS['PAGE_SIZE']);
    if ($total_pages > 1) {
      $prev_class = 'previous';
      $prev_link = fURL::get() . '?page=' . ($page_num - 1);
      $next_class = 'next';
      $next_link = fURL::get() . '?page=' . ($page_num + 1);
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
	<p class="info">There are currently no Tattle check subscriptions for your account. Add a <a href="<?php echo Check::makeURL('list', 'threshold'); ?>">threshold</a> based or a <a href="<?php echo Check::makeURL('list', 'predictive'); ?>">predictive</a> based subscription now.</p>
	<?php
}
?>
</div>
<?php $tmpl->place('footer') ?>
