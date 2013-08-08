<?php
$tmpl->set('title', 'Alerts &middot; Tattle &middot; Charthouse');
$tmpl->set('breadcrumbs',$breadcrumbs);
$tmpl->place('header');

try {
        $results->tossIfNoRows();
	?>
<span class="span10">
  <table class="zebra-striped">
          <thead>
    <tr>    
    <th>Check</th>
    <th>Latest Status</th>
    <th>Alert Count</th>
    <th>Action</th>
       </tr></thead><tbody>    
	<?php
	$first = TRUE;
	foreach ($results as $row) {
          $check = new Check($row['check_id']);
		?>
    	<tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $status_array[$row['status']]; ?></td>
        <td><?php echo $row['count']; ?></td>
        <td><a href="<?php echo CheckResult::makeURL('list', $check); ?>">View</a>
        </td>
        </tr>
    <?php } ?>
    </tbody></table></span>
    <?php
} catch (fNoRowsException $e) {
	?>
	<p class="info">There are currently no Alerts based on your subscriptions. Smile, looks like everything is happy!</p>
	<?php
}
?>
</div>
<?php $tmpl->place('footer') ?>
