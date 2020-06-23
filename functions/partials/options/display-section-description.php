<?php
$options = (array)get_option('jcg_theme_options');
$description = !empty($options['description']) ? $options['description'] : '';
?>

<textarea name="jcg_theme_options[description]" cols="80" rows="10"><?php echo $description; ?></textarea>
