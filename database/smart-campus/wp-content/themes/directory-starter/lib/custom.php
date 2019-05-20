<?php
function ds_add_top_header() {
    $enable_header_top = esc_attr(get_theme_mod('dt_enable_header_top', DT_ENABLE_HEADER_TOP));
    if ($enable_header_top != '1') {
        return;
    }
    ?>
    <div class="ds-top-header">
        <div class="container">
            <div class="ds-top-header-inner">
                <div class="ds-top-head-left">
                    <?php
                        if ( display_header_text() )  {
                            echo get_bloginfo( 'description', 'display' );
                        }
                     ?>
                </div>
                <div class="ds-top-head-right">
                    <?php wp_nav_menu( array(
                        'theme_location' => 'header-top',
                        'container_class' => 'header_top_menu',
                        'menu_class' => 'ds-top-menu-ul'
                    ) ); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
add_action('dt_before_header', 'ds_add_top_header');