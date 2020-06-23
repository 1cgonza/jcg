<?php
$options = (array)get_option('jcg_about_options');
$socialAccounts = jcg_get_social();

foreach ($socialAccounts as $slug => $name) :
	$value = !empty($options[$slug]) ? $options[$slug] : '';
	$id = 'jcg_about_options_' . $slug;
?>

	<label for="<?php echo $id; ?>"><?php echo $name; ?>: </label>
	<input
		id="<?php echo $id; ?>"
		class="regular-text"
		type="text"
		name="jcg_about_options[<?php echo $slug; ?>]"
		value="<?php echo $value; ?>"
	>

	<br /><br />
<?php endforeach;
