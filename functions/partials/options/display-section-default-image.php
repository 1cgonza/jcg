<?php
$options = (array)get_option('jcg_theme_options');
$profileImage = !empty($options['image']) ? $options['image'] : '';
?>

<div id="jcg-profile-image-container" class="hidden">
	<img id="profile-image" src="" alt="" title="" />
</div>

<input
	id="profile-image-input"
	type="hidden"
	name="jcg_theme_options[image]"
	value="<?php echo $profileImage ?>"
/>

<p class="hide-if-no-js">
	<a title="Set Default Image" href="javascript:;" id="assign-profile-image">Set Default Image</a>
</p>
