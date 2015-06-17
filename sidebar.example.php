<!-- Use any block of code by picking which is more useful in your case -->


<!-- SIDEBAR.PHP EXAMPLE USING BOOTSTRAP -->

<?php

	$sidebar_settings = get_simple_sidebar();

?>

<?php if( isset($sidebar_settings['position']) && $sidebar_settings['position']!='none' ) : ?>

	<aside>

		<!-- SIDEBAR BEGIN -->
		<div class="col-sm-3 pull-<?php echo $sidebar_settings['position']; ?>">
			<?php dynamic_sidebar( $sidebar_settings['id'] ); ?>
		</div>
		<!-- SIDEBAR END -->

	</aside>

<?php endif; ?>

<!-- SIDEBAR.PHP EXAMPLE USING BOOTSTRAP END -->


<!-- SIDEBAR.PHP EXAMPLE AS ALTERNATIVE USING BOOTSTRAP -->

<aside>

  <?php

    if( is_front_page() ) {
      dynamic_sidebar('Home');
    } elseif ( is_page() ) {
      dynamic_sidebar('Page');
    } elseif( is_single() ) {
      dynamic_sidebar('Post');
    } elseif( is_404() ) {
      dynamic_sidebar('404');
    } else {

      $sidebar_settings = get_simple_sidebar();

      if( isset($sidebar_settings['position']) && $sidebar_settings['position']!='none' ) :

        ?>

        	<aside>

        		<!-- SIDEBAR BEGIN -->
        		<div class="col-sm-3 pull-<?php echo $sidebar_settings['position']; ?>">
        			<?php dynamic_sidebar( $sidebar_settings['id'] ); ?>
        		</div>
        		<!-- SIDEBAR END -->

        	</aside>

        <?php

      endif;

    }

  ?>

</aside>

<!-- SIDEBAR.PHP EXAMPLE AS ALTERNATIVE USING BOOTSTRAP END -->
