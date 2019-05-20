<?php
// GeoDirectory Plugin compatibility functions.


// Actions to fire if GeoDirectory installed.
if (defined('GEODIRECTORY_VERSION')) {
    // Add mobile account menu
    add_action('dt_before_site_logo', 'dt_add_mobile_gd_account_menu');
}

// Change avatar size
function dt_comment_avatar_size()
{
    return 60;
}

add_filter('geodir_comment_avatar_size', 'dt_comment_avatar_size');

// Change bp integration avatar size
function dt_bp_comment_avatar_size()
{
    return 60;
}

add_filter('gdbuddypress_comment_avatar_size', 'dt_bp_comment_avatar_size');

// Change avatar size
function dt_geodir_buddypress_reviews_before_content()
{
    return '<div id="reviewsTab">';
}

add_filter('geodir_buddypress_reviews_before_content', 'dt_geodir_buddypress_reviews_before_content');

// Change avatar size
function dt_geodir_buddypress_reviews_after_content()
{
    return '</div>';
}

add_filter('geodir_buddypress_reviews_after_content', 'dt_geodir_buddypress_reviews_after_content');

function dt_geodir_reviews_g_size()
{
    return 60;
}

add_filter('geodir_recent_reviews_g_size', 'dt_geodir_reviews_g_size');

//Custom Field Functions
function dt_geodir_check_custom_field_exists($htmlvar_name, $post_type)
{
    global $wpdb;
    $check_html_variable = $wpdb->get_var(
        $wpdb->prepare(
            "select htmlvar_name from " . GEODIR_CUSTOM_FIELDS_TABLE . " where htmlvar_name = %s and post_type = %s ",
            array($htmlvar_name, $post_type)
        )
    );
    return $check_html_variable;
}

function dt_geodir_check_fieldset_exists($site_title, $post_type)
{
    global $wpdb;
    $check_field_set = $wpdb->get_var(
        $wpdb->prepare(
            "select site_title from " . GEODIR_CUSTOM_FIELDS_TABLE . " where site_title = %s and post_type = %s ",
            array($site_title, $post_type)
        )
    );
    return $check_field_set;
}

function dt_geodir_delete_custom_field($htmlvar_name, $post_type)
{
    global $wpdb;
    $id = $wpdb->get_var(
        $wpdb->prepare(
            "select id from " . GEODIR_CUSTOM_FIELDS_TABLE . " where htmlvar_name = %s and post_type = %s ",
            array($htmlvar_name, $post_type)
        )
    );
    if ($id) {
        geodir_custom_field_delete($id);
    }
}

function dt_geodir_add_cpt_dummy_column($post_type)
{
    global $plugin_prefix;
    $detail_table = $plugin_prefix . $post_type . '_detail';
    geodir_add_column_if_not_exist($detail_table, 'post_dummy', "enum( '1', '0' ) NULL DEFAULT '0'");
}

function dt_geodir_add_custom_fields($fieldsets = array(), $fields = array(), $filters = array(), $fields_to_remove = array())
{

    // Field Set
    if (!empty($fieldsets)) {
        foreach ($fieldsets as $fieldset_index => $fieldset) {
            $check_geodir_field_set = dt_geodir_check_fieldset_exists($fieldset['site_title'], $fieldset['listing_type']);
            if (!$check_geodir_field_set) {
                geodir_custom_field_save($fieldset);
            }
        }
    }

    // Custom Fields
    if (!empty($fields)) {
        foreach ($fields as $field_index => $field) {
            $check_cf_exists = dt_geodir_check_custom_field_exists($field['htmlvar_name'], $field['listing_type']);
            if (!$check_cf_exists) {
                geodir_custom_field_save($field);
            }
        }
    }

    // Advance Search Filters
    if (!empty($filters) && function_exists('geodir_load_translation_geodiradvancesearch')) {
        foreach ($filters as $filter_index => $filter) {
            geodir_custom_advance_search_field_save($filter);
        }
    }

    // Fields to delete
    if (!empty($fields_to_remove)) {
        foreach ($fields_to_remove as $field_key => $field_names) {
            foreach ($field_names as $field_name) {
                dt_geodir_delete_custom_field($field_name, $field_key);
            }
        }
    }
}

// If GeoDirectory Installed add account mobile menu

function dt_add_mobile_gd_account_menu()
{ ?>
    <div class="dt-mobile-account-wrap"><a href="#gd-account-nav"><i class="fa fa-user"></i></a></div>
    <div id="gd-account-nav" >
        <div >
            <?php if (class_exists('geodir_loginwidget')) {
                the_widget('geodir_loginwidget', 'mobile-login-widget', array('before_title'=>'<strong class="mobile-login-widget-title">','after_title'=>'</strong>'));
            }?>
        </div>
    </div>
<?php
}

function sd_gdbp_display_listing_link($comment) {
    printf( '<br/><a class="gdbp_display_listing_link" style="display: inline-block;margin-top: 12px;" href="%1$s">%2$s</a>', esc_url( get_comment_link( $comment->comment_ID )), get_the_title($comment->comment_post_ID));
}
add_action('gdbp_comment_meta_after', 'sd_gdbp_display_listing_link');