<div class="wrap">
	<h2>Theme Options</h2>

	<?php
		$currentTab = 'jcg_options';
		if (isset( $_GET['page']) ) {
		$currentTab = $_GET['page'];
		}
	?>

	<h2 class="nav-tab-wrapper">
		<a href="?page=jcg_options" class="nav-tab <?php echo  $currentTab == 'jcg_options' ? 'nav-tab-active' : ''; ?>">General</a>
		<a href="?page=jcg_about" class="nav-tab <?php echo $currentTab == 'jcg_about' ? 'nav-tab-active' : ''; ?>">About</a>
	</h2>

	<form action="options.php" method="post">
		<?php
		if ($currentTab == 'jcg_options') {
			settings_fields('general_section');
			do_settings_sections( 'jcg_options' );
		} elseif ($currentTab == 'jcg_about') {
			settings_fields('about_section');
			do_settings_sections( 'jcg_about' );
		}
		submit_button();
		?>

	</form>
</div>
