<?php

  $tmpl->set('title', 'Dashboards &middot; Tattle &middot; Charthouse');
  $tmpl->set('full_screen', $full_screen);
  $tmpl->set('refresh',$dashboard->getRefreshRate());
  $tmpl->place('header');
?>
<center> <!-- cssblasphemy but i need it look decent real quick --> 
    <h1><?php echo $dashboard->getName(); ?>&nbsp<small><?php echo $dashboard->getDescription(); ?></small></h1>
    <div>
	    <ul class="inline">
	    	<?php 
	    		foreach ($quick_times_desired as $print => $value) {
			?>
                <li class="inline">* <a href="<?php echo addOrReplaceInURL("?".fURL::getQueryString(), "from", $value)?>"><?php echo $print ?></a></li>
			<?php 	
				}
	    	?>
	    	<li class="inline">*</li>
	    </ul>
	</div>
    <div class="row">
	<?php
        $graph_count = 0;
        $columns = $dashboard->getColumns();
	foreach ($graphs as $graph) {
          $graph_row = ($graph_count % $columns);
          $url_graph = Graph::drawGraph($graph,$dashboard);
          $req = $_REQUEST;
          if (isset($ignored_values)) {
			$keys = array_keys($req);
			foreach ($ignored_values as $ignore_it) {
				if (in_array($ignore_it, $keys)) {
					unset($req[$ignore_it]);
				}
			}
		  }
          foreach ($req as $key => $value) {
			$url_graph = addOrReplaceInURL($url_graph,$key,$value);
		  }
        
		?>
        <span class=""><a href="<?php echo Graph::makeUrl('edit',$graph); ?>"><img src="<?php echo $url_graph ?>" rel=<?php echo ($graph_count >= $columns ? 'popover-above' : 'popover-below'); ?> title="<?php echo $graph->getName(); ?>" data-content="<?php echo $graph->getDescription(); ?>" /></a></span>
    <?php 
          $graph_count++;
           if ( $graph_count == $columns) {
             echo '</div><div class="row">';
           }
} ?>
</div>
</div>
</center>
<?php 
if (!$full_screen) {
echo '<a href="' . Dashboard::makeUrl('edit',$dashboard) . '">Edit Dashboard</a> | <a href="' . Graph::makeUrl('add',$dashboard) .'">Add Graph</a> | <a href="?' . fURL::getQueryString() . '&full_screen=true">Full Screen</a>';
$tmpl->set('show_bubbles',true);
$tmpl->place('footer') ;
}
?>
