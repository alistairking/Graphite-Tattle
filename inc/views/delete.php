<?php

if (!isset($class_name)) {
  $class_name = 'Check';
}

if ($class_name == 'Setting') {
   if ($setting_type == 'user') {
     $form_url = $class_name::makeURL('delete',$setting_type,$setting_name,$owner_id);
     $list_url = $class_name::makeURL('list',$setting_type,NULL,$owner_id);
   } else {
     $form_url = $class_name::makeURL('delete',$setting_type,$setting_name,$owner_id);
     $list_url = $class_name::makeURL('list',$setting_type,NULL,$owner_id);
   }
} elseif ($class_name == 'Check') {
  $form_url = $class_name::makeURL('delete',$obj->prepareType(),$obj); 
  $list_url = $class_name::makeURL('list',$obj->prepareType());

} else {
  $form_url = $class_name::makeURL('delete',$obj); 
  $list_url = $class_name::makeURL('list');
}
$tmpl->set('title', 'Delete ' . $class_name);
$tmpl->place('header');
?>
<h1><?php echo $tmpl->prepare('title'); ?></h1>

<form action="<?php echo $form_url; ?>" method="post">
	<p class="warning"><?php echo $delete_text; ?></p>
	<p>
		<input class="btn danger" type="submit" value="Yes, delete this <?php echo $class_name;?>" />
		<a href="<?php echo $list_url; ?>">No, please keep it</a>
		<input type="hidden" name="token" value="<?php echo fRequest::generateCSRFToken(); ?>" />
	</p>
</form>
<?php
$tmpl->place('footer');
