<?php
$options = (array)get_option('jcg_about_options');
$email = !empty($options['email']) ? $options['email'] : '';
$phone = !empty($options['phone']) ? $options['phone'] : '';
?>

<label for="jcg_about_options_phone">Phone: </label>
<input
	id="jcg_about_options_phone"
	class="regular-text"
	type="tel"
	name="jcg_about_options[phone]"
	value="<?php echo $phone; ?>"
>

<br /><br />

<label for="jcg_about_options_email">Email: </label>
<input
	id="jcg_about_options_email"
	class="regular-text"
	type="tel"
	name="jcg_about_options[email]"
	value="<?php echo $email; ?>"
>
