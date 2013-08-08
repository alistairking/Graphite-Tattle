<?php
$page_title = $action == 'add' ? 'Add a Dashboard' : 'Edit Dashboard';
$tmpl->set('title', $page_title);
$breadcrumbs[] = array('name' => $page_title,'url' => '?'.fURL::getQueryString(),'active'=> true);
$tmpl->set('breadcrumbs',$breadcrumbs);
$tmpl->place('header');
if (isset($dashboard_id)) {
  $query_string = "&dashboard_id=$dashboard_id";
} else {
  $query_string = '';
}
?>
  <div class="row">
    <div class="span4">
      <form class="form-stacked" action="?action=<?php echo $action.$query_string; ?>" method="post">
        <div class="main" id="main">
          <fieldset>
                <div class="clearfix">
	      <label for="dashboard-name">Name<em>*</em></label>
              <div class="input">
	        <input id="dashboard-name" class="span3" type="text" size="30" name="name" value="<?php echo $dashboard->encodeName(); ?>" />
              </div>
            </div><!-- /clearfix -->
            <div class="clearfix">
              <label for="dashboard-description">Description<em>*</em></label>
              <div class="input">             
                 <textarea class="span3" id="dashboard-description" name="description" rows="3"><?php echo $dashboard->encodeDescription(); ?></textarea>
              </div>
            </div><!-- /clearfix -->
            <div class="clearfix">
              <label for="dashboard-columns">Columns<em>*</em></label>
              <div class="input">
                <select name="columns" class="span3">
                <?php
                 $columns = array('1' => '1', '2'   => '2', '3' => '3');
                 foreach ($columns as $value => $text) {
                   fHTML::printOption($text, $value, $dashboard->getColumns());
                 }
                ?>
                </select>            
              </div>
            </div><!-- /clearfix -->
        <div class="clearfix">
              <label for="dashboard-graph_width">Graph Width<em>*</em></label>
              <div class="input">             
                 <input id="dashboard-graph_width" class="span3" type="text" size="30" name="graph_width" value="<?php echo $dashboard->encodeGraphWidth(); ?>" />
              </div>
            </div><!-- /clearfix -->
        <div class="clearfix">
              <label for="dashboard-graph_height">Graph Height<em>*</em></label>
              <div class="input">             
                 <input id="dashboard-graph_height"  class="span3" type="text" size="30" name="graph_height" value="<?php echo $dashboard->encodeGraphHeight(); ?>" />
            </div><!-- /clearfix -->           
            </div>
            <div class="clearfix">
              <label for="dashboard-background_color">Background Color<em>*</em></label>
              <div class="input">             
                  <input id="dashboard-background_color" class="span3" type="text" size="30" name="background_color" value="<?php echo $dashboard->encodeBackgroundColor(); ?>" />
              </div>
            </div><!-- /clearfix -->            
	    <div class="clearfix">
             <label for="dashboard-refresh_rate">Refresh Rate<em>*</em> (in seconds)</label>
             <div class="input">
               <input id="dashboard-refresh_rate" class="span3" type="text" size="30" name="refresh_rate" value="<?php echo $dashboard->getRefreshRate(); ?>" />
             </div>
            </div>
            <div class="actions span4">
	      <input class="btn primary" type="submit" value="Save" />
              <input class="btn" type="submit" name="action::delete" value="Delete" />
              <a href="<?php echo Dashboard::makeUrl('view',$dashboard); ?>" class="btn">View</a>
              <div class="required"><em>*</em> Required field</div>
	      <input type="hidden" name="token" value="<?php echo fRequest::generateCSRFToken(); ?>" />
              <input type="hidden" name="user_id" value="<?php echo fSession::get('user_id'); ?>" />
            </div>
         </fieldset>
       </div>       
     </form>
    </div>
    <div class="span10">   
   <?php if ($action == 'edit') { ?>
   <p class="info"><a href="<?php echo Graph::makeURL('add',$dashboard); ?>">Add Graph</a></p>
 <?php
   try {
	$graphs->tossIfEmpty();
	$affected = fMessaging::retrieve('affected', fURL::get());
	?>
    <div>
	<table class="zebra-striped">
          <thead>
          <tr>
          <th>Weight</th>    
          <th>Name</th>
          <th>Description</th>
          <th>Vtitle</th>
          <th>Area</th>
          <th>Action</th>
          </tr>    
          </thead>
          <tbody>
	<?php
	$first = TRUE;
	foreach ($graphs as $graph) {
		?>
    	<tr>
        <td><?php echo $graph->prepareWeight(); ?></td>
        <td><?php echo $graph->prepareName(); ?></td>
        <td><?php echo $graph->prepareDescription(); ?></td>
        <td><?php echo $graph->prepareVtitle(); ?></td>
        <td><?php echo $graph->prepareArea(); ?></td>        
        <td><a href="<?php echo Graph::makeURL('edit', $graph); ?>">Edit</a> |
        <a href="<?php echo Graph::makeURL('delete', $graph); ?>">Delete</a> |
        <form id="form_clone_<?php echo (int)$graph->getGraphId(); ?>" method="post" action="<?php echo Graph::makeURL('clone', $graph); ?>" style="display: initial;">
        	<a href="#" onclick="$('#form_clone_<?php echo (int)$graph->getGraphId(); ?>').submit(); return false;">Clone</a>
        	<input type="hidden" name="token" value="<?php echo fRequest::generateCSRFToken("/graphs.php"); ?>" />
        </form></td>
        </tr>
    <?php } ?>
    </tbody></table>
    <?php
} catch (fEmptySetException $e) {
	?>
	<p class="info">There are currently no Tattle graph available for this Dashboard . <a href="<?php echo Graph::makeURL('add',$dashboard); ?>">Add one now</a></p>
	<?php
} }
?>
    </div>
  </div>
</div>
</div>
<?php
$tmpl->place('footer');        
