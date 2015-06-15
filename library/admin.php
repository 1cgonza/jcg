<?php
  function jcg_admin_js() {
    wp_enqueue_media();
    wp_enqueue_script( 'jcg_admin_js', get_template_directory_uri() . '/library/js/admin-scripts.js', array('jquery'), '', 'all' );
  }
  add_action( 'admin_enqueue_scripts', 'jcg_admin_js' );

  function disable_default_dashboard_widgets() {
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' ); // Comments Widget
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );  // Incoming Links Widget
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );         // Plugins Widget
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );   // Recent Drafts Widget
    remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );         //
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );       //
    // removing plugin dashboard boxes
    remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );         // Yoast's SEO Plugin Widget
  }

  /*====================================
  =            PROFILE MENU            =
  ====================================*/

  /*==========  TOP LEVEL MENU  ==========*/
  function jcg_add_profile_page() {
    add_menu_page(
      'Options',
      'Options',
      'manage_options',
      'jcg_options',
      'jcg_render_options',
      'dashicons-hammer',
      10
    );

    add_submenu_page(
      'jcg_options',
      'About',
      'About',
      'manage_options',
      'jcg_about',
      'jcg_render_options'
    );
  }
  add_action( 'admin_menu', 'jcg_add_profile_page' );

  /*==========  SECTIONS, SETTINGS AND FIELDS  ==========*/
  function jcg_init_profile_options() {
    disable_default_dashboard_widgets();
    /*==========  GENERAL  ==========*/
    add_settings_section(
      'general_section',    // ID for the section
      '',                   // Title which renders on the page
      '',                   // Callback function
      'jcg_options' // The page where this section is rendered
    );

    add_settings_field(
      'default_image',
      'Default Image',
      'jcg_render_default_image',
      'jcg_options',
      'general_section'
    );

    add_settings_field(
      'jcg_options_description',
      'Default description',
      'jcg_render_option_description',
      'jcg_options',
      'general_section'
    );

    register_setting(
      'general_section',
      'jcg_theme_options'
    );

    /*==========  ABOUT  ==========*/
    add_settings_section(
      'about_section',                      // ID for the section
      '',                                   // Title which renders on the page
      '',                                   // Callback function
      'jcg_about'                           // The page where this section is rendered
    );

    add_settings_field(
      'jcg_about_contact',
      'Contact',
      'jcg_render_contact',
      'jcg_about',
      'about_section'
    );

    add_settings_field(
      'jcg_about_social',
      'Social Links',
      'jcg_render_social',
      'jcg_about',
      'about_section'
    );

    add_settings_field(
      'jcg_about_bio',
      'Bio Academic',
      'jcg_render_bio',
      'jcg_about',
      'about_section'
    );

    add_settings_field(
      'jcg_about_bio_bio',
      'Bio Biographical',
      'jcg_render_bio_bio',
      'jcg_about',
      'about_section'
    );

    register_setting(
      'about_section',
      'jcg_about_options'
    );
  }
  add_action( 'admin_init', 'jcg_init_profile_options' );

  /*==========  CALLBACK FUNCTIONS  ==========*/
  function jcg_render_options() {
  ?>
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
        <a href="?page=jcg-profile-academic" class="nav-tab <?php echo $currentTab == 'jcg-profile-academic' ? 'nav-tab-active' : ''; ?>">Academic</a>
      </h2>

      <form action="options.php" method="post">
        <?php
        if ($currentTab == 'jcg_options') {
          settings_fields('general_section');
          do_settings_sections( 'jcg_options' );
        } elseif ($currentTab == 'jcg_about') {
          settings_fields('about_section');
          do_settings_sections( 'jcg_about' );
        } elseif ($currentTab == 'jcg-profile-academic') {
          settings_fields('academic_section');
          do_settings_sections( 'jcg-profile-academic' );
        }
        submit_button();
        ?>

      </form>
    </div>
  <?php
  }

  function jcg_render_option_description() {
    $options = (array)get_option('jcg_theme_options');
    $description = !empty($options['description']) ? $options['description'] : '';

    echo '<textarea name="jcg_theme_options[description]" cols="80" rows="10">' . $description . '</textarea>';
  }

  function jcg_render_default_image() {
    $options = (array)get_option('jcg_theme_options');
    $profileImage = !empty($options['image']) ? $options['image'] : '';
    ?>
      <div id="profile-image-container" class="hidden">
        <img id="profile-image" src="" alt="" title="" />
      </div>
      <input id="profile-image-input" type="hidden" name="jcg_theme_options[image]" id="jcg_theme_options_image" value="<?php echo $profileImage ?>" />
      <p class="hide-if-no-js">
        <a title="Set Default Image" href="javascript:;" id="assign-profile-image">Set Default Image</a>
      </p>
    <?php
  }

  function jcg_render_contact() {
    $options = (array)get_option('jcg_about_options');
    $email = !empty($options['email']) ? $options['email'] : '';
    $phone = !empty($options['phone']) ? $options['phone'] : '';

    $contact = '<label for="jcg_about_options_phone">Phone: </label>';
    $contact .= '<input id="jcg_about_options_phone" class="regular-text" type="tel" name="jcg_about_options[phone]" value="' . $phone . '">';
    $contact .= '<br /><br />';
    $contact .= '<label for="jcg_about_options_email">Email: </label>';
    $contact .= '<input id="jcg_about_options_email" class="regular-text" type="tel" name="jcg_about_options[email]" value="' . $email . '">';

    echo $contact;
  }

  function jcg_render_social() {
    $options = (array)get_option('jcg_about_options');
    $socialAccounts = array(
      'github'   => 'GitHub',
      'vimeo'    => 'Vimeo',
      'youtube'  => 'YouTube',
      'facebook' => 'Facebook',
      'twitter'  => 'Twitter',
      'flickr'   => 'Flickr',
      'linkedin' => 'LinkedIn',
      'imdb'     => 'IMDB'
    );

    $social = '';

    foreach ($socialAccounts as $slug => $name) {
      $value = !empty($options[$slug]) ? $options[$slug] : '';
      $social .= '<label for="jcg_about_options_' . $slug . '">' . $name . ': </label>';
      $social .= '<input id="jcg_about_options_' . $slug . '" class="regular-text" type="text" name="jcg_about_options[' . $slug . ']" value="' . $value . '">';
      $social .= '<br /><br />';
    }

    echo $social;
  }

  function jcg_render_bio() {
    $options = (array)get_option('jcg_about_options');
    $bio = !empty($options['bio']) ? $options['bio'] : '';

    $settings = array(
      'media_buttons' => false,
      'textarea_name' => 'jcg_about_options[bio]'
    );
    wp_editor($bio, 'jcg_about_options_bio', $settings);
  }

  function jcg_render_bio_bio() {
    $options = (array)get_option('jcg_about_options');
    $bio = !empty($options['bio_bio']) ? $options['bio_bio'] : '';

    $settings = array(
      'media_buttons' => false,
      'textarea_name' => 'jcg_about_options[bio_bio]'
    );
    wp_editor($bio, 'jcg_about_options_bio_bio', $settings);
  }

  /*====================================
  =            CUSTOM LOGIN            =
  ====================================*/
  add_action('login_enqueue_scripts', 'jcg_login_css', 10);
  add_filter('login_headerurl', 'jcg_login_url');
  add_filter('login_headertitle', 'jcg_login_title');

  function jcg_login_css() {
    wp_enqueue_style('jcg_login_css', get_template_directory_uri() . '/library/css/login.css', false);
  }

  function jcg_login_url() {
    return home_url();
  }
  function jcg_login_title() {
    return get_option('blogname');
  }
  /*-----  End of CUSTOM LOGIN  ------*/

  function jcg_custom_admin_footer() {
    echo '<span id="footer-thankyou">Developed by <a href="http://juancgonzalez.com" target="_blank">Juan Camilo Gonz&aacute;lez</a></span>.';
  }
  add_filter('admin_footer_text', 'jcg_custom_admin_footer');