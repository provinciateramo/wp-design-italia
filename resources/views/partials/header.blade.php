<header id="header" class="" role="banner">

  <section class="branding-up">
    <div class="container">
      <div class="row">
        <div class="col">
        <!-- <img alt="" src="<?php header_image(); ?>" width="<?php echo absint( get_custom_header()->width ); ?>" height="<?php echo absint( get_custom_header()->height ); ?>"> -->
          <img alt="" src="<?php header_image(); ?>" width="200">
        </div>
        <div class="col text-right d-none d-sm-none d-md-block">
          <?php wp_nav_menu(array( 'theme_location' => 'menu-language', 'container' => 'ul', 'menu_class' => 'nav float-right' )); ?>
        </div>
      </div>
    </div>
  </section>
  <div id="fixed-top-section">
  <section class="branding">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-2 col-md-1">

          <?php $custom_logo_id = get_theme_mod( 'custom_logo' );
          $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
          if ( has_custom_logo() ) {
            echo '<img class="custom-logo transition" src="'. esc_url( $logo[0] ) .'">';
          } else {
            echo '<img class="custom-logo" src="'. \App\asset_path('images/custom-logo.png') .'">';
          } ?>

        </div>
        <div class="col">
          <div id="site-title">
            <h1><a class="p-0" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a></h1>
          </div>
          @if (get_theme_mod('tagline_visibility')=="")
          <div id="site-description" class="d-none d-lg-block mb-0 transition"><?php bloginfo("description") ?></div>
          @endif
        </div>
        <div class="col-md-5">

          <div class="container">
            <div class="row">
              <div class="col d-none d-sm-none d-md-block menu-social transition">
                <?php wp_nav_menu( array( 'theme_location' => 'menu-social', 'container' => 'ul', 'menu_class' => 'nav')); ?>
              </div>
              <div class="w-100 d-none d-md-block"></div>
              <div class="col search-form">
                <form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>">
                  <div><label class="screen-reader-text" for="s">Cerca:</label>
                    <input type="text" value="" name="s" id="s" />
                    <input type="submit" id="searchsubmit" value="Cerca" />
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <nav class="menu-main" id="menu-main-bar" role="navigation">
    <div class="container">
      <div class="row justify-content-center">
        <label for="show-menu-main" class="show-menu-main">Menu</label>
        <input type="checkbox" id="show-menu-main" role="button">
        <?php wp_nav_menu(array( 'theme_location' => 'menu-main', 'container' => 'ul', 'menu_class' => 'nav' )); ?>
      </div>
    </div>

  </nav>
  </div>

</header>
