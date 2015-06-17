<?php

/*--------------------------------------------------*/
/* Simple Sidebar Manager > settings page
/*--------------------------------------------------*/

function vuzzu_ssm_admin_settings_view() {

  $post_types = get_post_types( '', 'names' );
  unset($post_types['attachment']);
  unset($post_types['revision']);
  unset($post_types['nav_menu_item']);

  $ssm_support_types = get_option('simple_sidebar_manager_support_types',array('post','page'));

  ?>

    <div class="wrap ssm-settings">

      <form method="post" action="options.php">

        <?php settings_fields( 'ssm-settings-group' ); ?>
        <?php do_settings_sections( 'ssm-settings-group' ); ?>

        <h2> <?php _e('Simple Sidebar Manager supporting post types','ssm_terms'); ?> </h2>

        <p> <?php _e('Below you can extend support for more post types:','ssm_terms'); ?> </p>

        <?php foreach($post_types as $pt_name) : ?>
          <div>
            <label style="margin:10px;display:block">
              <?php echo ucfirst($pt_name); ?>
              <input type="checkbox" name="simple_sidebar_manager_support_types[]"
                   value="<?php echo $pt_name; ?>"
                   <?php if(is_array($ssm_support_types) && in_array($pt_name, $ssm_support_types) ) echo 'checked="checked"'; ?> />
            </label>
          </div>
        <?php endforeach; ?>

        <?php submit_button(); ?>

      </form>
    </div>

  <?php

}


/*--------------------------------------------------*/
/* Simple Sidebar Manager > sidebar management page
/*--------------------------------------------------*/

function vuzzu_ssm_admin_sidebar_management_view() {

  global $wp_registered_sidebars;
  $currentSidebars = get_option('ssm_dyn_sidebars', array());
  $sidebarList = array( ''=>__('None','ssm_terms') );
  foreach( $wp_registered_sidebars as $_sidebar) {
    $sidebarList[$_sidebar['id']] = $_sidebar['name'];
  }

  ?>

  <style>
    .uz_input { margin: 20px 10px; }
    .uz_input label { margin-left: 0; }
  </style>

  <div class="wrap ssm-sidebars">
    <h2> <?php _e("Manage sidebars",'ssm_terms'); ?> </h2>

    <form method="post" action="options.php">

        <?php settings_fields( 'ssm-sidebars-group' ); ?>
        <?php do_settings_sections( 'ssm-sidebars-group' ); ?>

        <h3> <?php _e("Set a default sidebar position",'ssm_terms'); ?> </h3>
        <?php $sidebarPositions = array(''=>__('None','ssm_terms'), 'left'=>__('Left','ssm_terms'), 'right'=>__('Right','ssm_terms'));
        uz_select_input(__('Default sidebar position','ssm_terms'),'ssm_default_sidebar_position',get_option('ssm_default_sidebar_position','none'),$sidebarPositions, true); ?>

        <h3 style="margin-top:40px"> <?php _e("Set a default sidebar",'ssm_terms'); ?> </h3>
         <?php uz_select_input(__('Default sidebar','ssm_terms'),'ssm_default_sidebar',get_option('ssm_default_sidebar',__('None','ssm_terms')), $sidebarList,true); ?>

        <h3 style="margin-top:40px"> <?php _e("Add/Modify/Remove dynamic sidebars",'ssm_terms'); ?> </h3>
        <?php uz_ajax_list_input(__('Current dynamic sidebars','ssm_terms'),'ssm_dyn_sidebars',$currentSidebars); ?>

        <?php submit_button(); ?>

    </form>

  </div>


  <?php

}


/*--------------------------------------------------*/
/* Simple Sidebar Manager > metabox view
/*--------------------------------------------------*/

function vuzzu_ssm_metabox_view() {

	global $post;

	$default_sidebar_position = get_option('ssm_default_sidebar_position',null);
	$default_sidebar = get_option('ssm_default_sidebar',null);

	$current_sidebar_position = get_post_meta($post->ID, 'ssm_sidebar_position', true);
	$current_sidebar = get_post_meta($post->ID, 'ssm_sidebar', true);

	?>

  <style>

    #ssm-sidebar-manager .inside { padding: 0; }
    #ssm-sidebar-manager .option { padding: 0 12px 0 10px; border-bottom: 1px solid #dfdfdf; }
    #ssm-sidebar-manager div.option:last-child { border-bottom: 0; }
    .ssm_sidebar_manager .options { float:left; width: 100%; }
    .ssm_sidebar_manager .options a { display: block; float: left; margin-right: 10px; width: 75px; height: 40px; color: #464646; border: 1px solid #dfdfdf; -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; background: #fff;	text-align: center; line-height: 40px; cursor: pointer; }
    .ssm_sidebar_manager .options a:last-of-type { margin-right: 0; }
    .ssm_sidebar_manager .options a:hover,
    .ssm_sidebar_manager .options a.current { background: #f2f2f2; color: #464646; }
    .ssm_sidebar_manager .options a:last-child { margin-right: 0; }
    .ssm_sidebar_manager .options a i { width: 35px; height: 40px; text-align: center; font-size: 10px; line-height: 40px; }
    .ssm_sidebar_manager .options a.left i,
    .ssm_sidebar_manager .options a.right i { float: left; border-left: 1px solid #dfdfdf; background-color: #fff; }
    .ssm_sidebar_manager .options a.right i { float: right; }
    .ssm_sidebar_manager .options select { margin-top: 15px; width: 90%; }

  </style>

  <script>
    jQuery(function() {
      jQuery(document).on('click', '.ssm_sidebar_manager a', function() {
        var position = jQuery(this);
        position.parent().find('.current').removeClass('current');
        position.nextAll('input[type=hidden]').val(position.attr('class'));

        var sidebars = position.parent().find('select');
        if (sidebars.css('display') === 'none' && position.attr('class') !== 'none') sidebars.slideToggle('fast');
        if (sidebars.css('display') !== 'none' && position.attr('class') === 'none') sidebars.slideToggle('fast');

        position.addClass('current');
      });
    });
  </script>

	<!-- SIDEBAR OPTIONS -->
	<div class="ssm_sidebar_manager">

		<div class="description">

			<p> <?php _e('Choose the side and the sidebar','ssm_terms'); ?> </p>

		</div>

		<div class="options uz_input">

			<?php

				$none_cur = (empty($default_sidebar_position)) ? ' current' : '' ;
				$left_cur = ($default_sidebar_position=='left') ? ' current' : '';
				$right_cur = ($default_sidebar_position=='right') ? ' current' : '';
				$sidebar_cur = ($default_sidebar_position=='none') ? '' : $default_sidebar_position;

				if( !empty($current_sidebar_position) && $current_sidebar_position != 'none' ) {
					$left_cur 	 = ($current_sidebar_position=='left') ? ' current' : '';
					$right_cur 	 = ($current_sidebar_position=='right') ? ' current' : '';
					$none_cur 	 = '';
				}

				if( $current_sidebar_position == 'none' ) {
					$none_cur = ' current';
					$left_cur = '';
					$right_cur = '';
				}

				$sidebarNone = ( empty($default_sidebar) && empty($current_sidebar) ) ? true : false;

			?>

			<a class="left<?php echo $left_cur; ?>"> <i class="fa fa-play fa-rotate-180"></i> <?php _e('Left','ssm_terms'); ?> </a>
			<a class="right<?php echo $right_cur; ?>"> <i class="fa fa-play"></i> <?php _e('Right','ssm_terms'); ?> </a>
			<a class="none<?php echo $none_cur; ?>"> <?php _e('None','ssm_terms'); ?> </a>

			<select name="ssm_sidebar" data-actual="<?php echo $current_sidebar; ?>" <?php if(!empty($none_cur)) echo 'style="display:none"'; ?>>

				<?php global $wp_registered_sidebars;

				foreach( $wp_registered_sidebars as $_sidebar ) :

					$selectedSidebar = '';

					if( !$sidebarNone ) {
						if( !empty($current_sidebar) && $current_sidebar==$_sidebar['id'] ) $selectedSidebar = 'selected="selected"';
						if( empty($current_sidebar) && $default_sidebar==$_sidebar['id'] ) $selectedSidebar = 'selected="selected"';
					}

					echo '<option value="'.$_sidebar['id'].'" '.$selectedSidebar.'>'.$_sidebar['name'] .'</option>';

				endforeach; ?>

			</select>

			<input type="hidden" name="ssm_sidebar_position" value="<?php echo (!empty($current_sidebar_position)) ? $current_sidebar_position : $default_sidebar_position; ?>" />

		</div>

		<div class="uz_clear"></div>

	</div>
	<!-- SIDEBAR OPTIONS END -->

	<?php

}
