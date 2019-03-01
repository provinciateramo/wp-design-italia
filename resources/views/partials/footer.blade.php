<footer id="footer" role="contentinfo" class="it-footer mb-5 mb-sm-5 mb-lg-0 mb-xl-0">
  <div class="it-footer-main">
    <div class="container">
      <section>
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="it-brand-wrapper">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home">
                {!! App::wpdi_the_custom_logo() !!}
                <div class="it-brand-text">
                  <h2 class="no_toc"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h2>
                  @if (get_theme_mod('tagline_visibility')=="")
                    <h3 class="no_toc d-none d-md-block">{{ bloginfo("description") }}</h3>
                  @endif
                </div>
              </a>
            </div>
          </div>
        </div>
      </section>
      <section class="lista-sezioni">
        <div class="row">
          <?php App::create_footer_menu('menu-main'); ?>
        </div>
      </section>
      <section class="py-5 border-white border-top lista-sezioni">
        <?php $footer_columns_schema = get_theme_mod('footer_columns_schema', '4-8');
        if($footer_columns_schema!="0" && (!is_numeric($post->ID) or get_post_meta($post->ID,'bbe_hide_footer',TRUE)!=1)):
        ?>
        <div class="widget-area">
          <div class="row">
            <?php
            $number_of_footer_columns=substr_count($footer_columns_schema,'-')+1;
            $array_column_sizes=explode('-',$footer_columns_schema);
            for ($count=1; $count<=$number_of_footer_columns; $count++):
            ?>
            <div id="footer-column-<?php echo $count ?>" class="col-footer col-lg-<?php echo $array_column_sizes[$count-1] ?> widget-container widget_archive">
              <?php dynamic_sidebar('footer-'.$count);   ?>
            </div> <!-- /footer-column  -->
            <?php
            endfor;
            ?>
          </div>
        </div> <!-- /row -->
        <?php endif ?>

      </section>
    </div>
  </div>
  <div class="it-footer-small-prints clearfix">
    <div class="container">
      <div class="row align-items-start">
      <h3 class="sr-only">Sezione Link Utili</h3>
      <div class="col-md-auto">
        <?php wp_nav_menu(array( 'theme_location' => 'menu-footer', 'container' => 'ul', 'menu_class' => 'nav' )); ?>
      </div>
      <div class="col copyright">
        <p class="text-right">
          {!! App\wp_footer_colophon() !!}
        </p>
      </div>
      </div>
    </div>
  </div>
  </div>


</footer>
<a href="#" aria-hidden="true" data-attribute="back-to-top" class="back-to-top" id="toTop">
  <svg class="icon icon-light"><use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-arrow-up"></use></svg>
</a>
