<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);

    $wp_customize->remove_control( 'display_header_text' );
    //TAGLINE: SHOW / HIDE SWITCH
    $wp_customize->add_setting("tagline_visibility", array(
        "default" => "",
        "transport" => "refresh",
    ));
    $wp_customize->add_control(new \WP_Customize_Control(
        $wp_customize,
        "tagline_visibility",
        array(
            "label" => __("Visibilità sottotitolo", "wppa_teramo"),
            "section" => "title_tagline",
            "settings" => "tagline_visibility",
            'type'     => 'select',
            'choices'  => array(
                ''  => 'Mostra',
                '0' => 'Nascondi',
            )
        )
    ));

    $wp_customize->add_setting( 'wppa_head_color', array(
        'default' => '#0066cc',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'wppa_custom_accent_color', array(
        'label'      => __( 'Colore della testata', 'wppa' ),
        'section'    => 'colors',
        'settings'   => 'wppa_head_color'
    ) ) );


    $wp_customize->add_setting( 'wppa_link_color' , array(
        'default'     => "#0066cc",
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'header_textcolor', array(
        'label'       => __( 'Colore dei link', 'wppa' ),
        'section'     => 'colors',
        'settings'     => 'wppa_link_color'
    ) ) );

    $wp_customize->add_setting( 'wppa_button_color' , array(
        'default'     => "#65dde0",
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'wppa_custom_button_color', array(
        'label'       => __( 'Colore dei pulsanti', 'wppa' ),
        'section'     => 'colors',
        'settings'     => 'wppa_button_color'
    ) ) );
    $wp_customize->add_setting( 'wppa_footer_color' , array(
        'default'     => "#00264d",
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'wppa_custom_footer_color', array(
        'label'       => __( 'Colore del footer', 'wppa' ),
        'section'     => 'colors',
        'settings'     => 'wppa_footer_color'
    ) ) );
    $wp_customize->add_setting( 'wppa_footer_link' , array(
        'default'     => "#65dcdf",
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'wppa_custom_footer_link', array(
        'label'       => __( 'Colore dei link nel footer', 'wppa' ),
        'section'     => 'colors',
        'settings'     => 'wppa_footer_link'
    ) ) );

    //ADD SECTION FOR STYILING
    $wp_customize->add_panel("single_post_settings", array(
        'title' => __("Impostazioni articolo", "wppa"),
        'capability' => 'edit_theme_options',
        'priority' => 100,
    ));

    //ADD SECTION FOR STYILING
    $wp_customize->add_section("blog", array(
        "title" => __("Metadati", "wppa"),
        "priority" => 1,
        'panel'    => 'single_post_settings'
    ));

    $wp_customize->add_section("featured_image", array(
        "title" => __("Immagine principale", "wppa"),
        "priority" => 2,
        'panel'    => 'single_post_settings'
    ));

    $wp_customize->add_setting(
        'single_post_show_author',
        array(
            'default'            => true,
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'single_post_show_author',
        array(
            'type'        => 'checkbox',
            'label'       => __( 'Mostra autore del contenuto', 'wppa' ),
            'description' => __( 'Se selezioni questa opzione, verrà mostrato l\'autore del singolo articolo.', 'wppa' ),
            'section'     => 'blog',
            'priority'    => 1,
        )
    );

    $wp_customize->add_setting(
        'single_post_hide_related_posts',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'single_post_hide_related_posts',
        array(
            'type'        => 'checkbox',
            'label'       => __( 'Nascondi articoli correlati?', 'wppa' ),
            'description' => __( 'Se selezioni questa opzione, gli articoli correlati non saranno visualizzati nel singolo articolo.', 'wppa' ),
            'section'     => 'blog',
            'priority'    => 2,
        )
    );


    //EXCERPT LENGTH
    $wp_customize->add_setting("custom_excerpt_length", array(
        "defachoicesult" => "30",
        "transport" => "refresh",
    ));

    $wp_customize->add_control(new \WP_Customize_Control(
        $wp_customize,
        "custom_excerpt_length",
        array(
            "label" => __("Numero di parole per anteprima", "wppa"),
            "section" => "blog",
            "settings" => "custom_excerpt_length",
            'type'     => 'select',
            'choices'  => array_combine(range(5,100,5),range(5,100,5)),
            'input_attrs' => array( 'min' => 0, 'max' => 100, 'step'  => 5 ),
            'priority' => 4,
        )
    ));

    $wp_customize->add_setting(
        'single_post_hide_thumbnail',
        array(
            'default'           => true,
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'single_post_hide_thumbnail',
        array(
            'type'        => 'checkbox',
            'label'       => __( 'Nascondi immagine in evidenza sul singolo articolo?', 'wppa' ),
            'description' => __( 'Se selezioni questa opzione, l\'immagine in evidenza non sarà visualizzata nel singolo articolo.', 'wppa' ),
            'section'     => 'featured_image',
            'priority'    => 1,
        )
    );

    $wp_customize->add_setting(
        'single_post_align_thumbnail',
        array(
            'default'           => 'alignright',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'single_post_align_thumbnail',
        array(
            'type'        => 'radio',
            'label'       => __( 'Allineamento immagine in evidenza', 'wppa' ),
            'section'     => 'featured_image',
            'priority'    => 2,
            'choices'     => array(
                "alignright"    => "Destra",
                "alignleft"     => "Sinistra",
                "aligncenter"   => "Centro",
                "alignnone"     => "Nessun allineamento"
            )
        )
    );

    //ADD SECTION FOR FOOTER
    $wp_customize->add_section("footer", array(
        "title" => __("Footer", "customizer_footer_sections"),
        "priority" => 100,
    ));

    //FOOTER COLUMNS SCHEMA
    $wp_customize->add_setting("footer_columns_schema", array(
        "default" => "4-8",
        "transport" => "refresh",
    ));
    $wp_customize->add_control(new \WP_Customize_Control(
        $wp_customize,
        "footer_columns_schema",
        array(
            "label" => __("Footer Columns Schema", "bbe"),
            "section" => "footer",
            "settings" => "footer_columns_schema",
            'type'     => 'select',
            'choices'  => array(
                '0' => 'Disable Footer Widgets',
                '12'  => '1 Column',
                '6-6'  => '2 Columns: Equal Sizes',
                '4-8'  => '2 Columns: 4-8',
                '8-4'  => '2 Columns: 8-4',
                '4-4-4'  => '3 Columns: Equal Sizes',
                '6-3-3'  => '3 Columns: 6-3-3',
                '3-3-6'  => '3 Columns: 3-3-6',
                '3-4-5'  => '3 Columns: 3-4-5',
                '5-4-3'  => '3 Columns: 5-4-3',
                '3-3-3-3'  => '4 Columns: Equal Sizes',

            )
        )
    ));

    //FOOTER TEXT
    $wp_customize->add_setting("footer_text", array(
        "default" => "",
        "transport" => "postMessage",
    ));
    $wp_customize->add_control(new \WP_Customize_Control(
        $wp_customize,
        "footer_text",
        array(
            "label" => __("Footer Text", "bbe"),
            "section" => "footer",
            "settings" => "footer_text",
            'type'     => 'textarea',

        )
    ));

});


/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

add_action( 'wp_head', function () { ?>
    <style type="text/css">
        .branding, .menu-main { background-color: <?php echo get_theme_mod( 'wppa_head_color', "#0066cc" ); ?>; }
        a, a:hover { color: <?php echo get_theme_mod('wppa_link_color', "#0066cc"); ?>; }
        button, input[type="submit"] { background-color: <?php echo get_theme_mod( 'wppa_button_color', "#65dde0" ); ?>; }
        html, #footer { background-color: <?php echo get_theme_mod( 'wppa_footer_color', '#00264d' ); ?>; }
        #footer a { color: <?php echo get_theme_mod('wppa_footer_link', "#65dcdf"); ?>; }
        .bg-footer {background-color: <?php echo get_theme_mod( 'wppa_footer_color', '#00264d' ); ?>; }
    </style>
    <?php
});
