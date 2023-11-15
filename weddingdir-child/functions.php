<?php

/**
 *  ------------------------
 *  WeddingDir - Child Theme
 *  -------------------------------------
 *  Child-Theme functions and definitions
 *  -------------------------------------
 *  @credit - https://codex.wordpress.org/Child_Themes
 *  --------------------------------------------------
 */
if (!class_exists('WeddingDir_Child_Theme')) {

    /**
     *  WeddingDir - Child Theme
     *  ------------------------
     */
    class WeddingDir_Child_Theme
    {

        /**
         *  Member Variable
         *  ---------------
         *  @var instance
         *  -------------
         */
        private static $instance;

        /**
         *  Initiator
         *  ---------
         */
        public static function get_instance()
        {

            if (!isset(self::$instance)) {

                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         *  Construct
         *  ---------
         */
        public function __construct()
        {

            /**
             *  1. Load Enqueue Script
             *  ----------------------
             */
            add_action('wp_enqueue_scripts', [$this, 'weddingdir_child_styles']);
        }

        /**
         *  1. Load Enqueue Script
         *  ----------------------
         */
        public static function weddingdir_child_styles()
        {

            /**
             *  WeddingDir - Child Theme ( style.css ) Loaded After parent style
             *  ----------------------------------------------------------------
             */
            wp_enqueue_style(

                /**
                 *  File Name
                 *  ---------
                 */
                esc_attr('weddingdir-child-style'),

                /**
                 *  File Path
                 *  ---------
                 */
                esc_url(get_stylesheet_directory_uri() . '/style.css'),

                /**
                 *  Load WeddingDir - Style After Bootsrap Library
                 *  ----------------------------------------------
                 */
                array('weddingdir-parent-style'),

                /**
                 *  WeddingDir - Theme Version
                 *  --------------------------
                 */
                esc_attr(wp_get_theme()->get('Version')),

                /**
                 *  Load Media in All
                 *  -----------------
                 */
                esc_attr('all')
            );
        }
    }

    /**
     *  WeddingDir - Child Theme
     *  ------------------------
     */
    WeddingDir_Child_Theme::get_instance();
}

function action_header_right_side()
{
    if (!is_user_logged_in()) {
?>
        <div class="button-box">
            <a class="btn btn-secondary" href="javascript:" role="button" data-bs-toggle="modal" data-bs-target="#weddingdir_couple_login_model_popup"><i class="fa fa-user-o d-xs-block d-lg-none d-xl-none d-sm-none"></i>
                <span class="d-none d-sm-block">
                    <strong>User login</strong>
                </span>
            </a>
            <a class="btn btn-primary" href="javascript:" role="button" data-bs-toggle="modal" data-bs-target="#weddingdir_vendor_login_model_popup"><i class="fa fa-user-o d-xs-block d-lg-none d-xl-none d-sm-none"></i>
                <span class="d-none d-sm-block">
                    <strong>Business login</strong>
                </span>
            </a>
        </div>
    <?php
    }
}


add_filter('nav_menu_link_attributes', 'action_nav_menu_link_attributes', 10, 3);
function action_nav_menu_link_attributes($atts, $item, $args)
{
    // The ID of the target menu item
    if ($item->ID == 4642) {
        $atts['href'] = 'javascript:';
        $atts['data-bs-toggle'] = 'modal';
        $atts['data-bs-target'] = '#weddingdir_couple_registration_model_popup';
    }

    if ($item->ID == 4741) {
        $atts['href'] = 'javascript:';
        $atts['data-bs-toggle'] = 'modal';
        $atts['data-bs-target'] = '#weddingdir_vendor_login_model_popup';
    } {
        if ($item->ID == 4643) {
            $atts['href'] = 'javascript:';
            $atts['data-bs-toggle'] = 'modal';
            $atts['data-bs-target'] = '#weddingdir_vendor_registration_model_popup';
        }
    }
    return $atts;
}

add_action('header_right_side', 'action_header_right_side');


add_filter('gettext', 'translate_text');
add_filter('ngettext', 'translate_text');

add_filter('gettext', 'translate_my_wishlish');
add_filter('ngettext', 'translate_my_wishlish');
function translate_text($translated)
{
    $translated = str_ireplace('Value of money', 'Value for money', $translated);
    return $translated;
}
function translate_my_wishlish($translated)
{
    $translated = str_ireplace('My Wishlist', 'Vendor list', $translated);
    return $translated;
}

function action_wp_footer()
{
    if (is_front_page()) {
    ?>
        <script>
            jQuery(document).ready(function() {
                $search_term = jQuery('<div class="col-12 col-md-3 fake-input"> <div class="weddingdir-dropdown-handler "> <div class="input-group"> <span class="d-flex align-items-center px-3 before-input-box"> <i class="fa fa-search"></i> </span> <input autocomplete="off" type="text" placeholder="Search by term.." id="search-term" data-page-template="1" name="search-term" class="form-control form-light search-term search-by-term" data-value-id="297"> </div> </div> </div>')

                $search_term.prependTo('.slider-form > .row');

                jQuery('input[name="listing-category-fake"]:not(.search-by-term)').attr('placeholder', 'Choose a category')

                jQuery('.slider-content .slider-form > .row > div').removeClass('col-md-5').addClass('col-md-3');
            });
        </script>
    <?php
    }
    ?>
    <script>
        jQuery(document).ready(function() {
            listings();
            <?php if (get_page_template_slug() == 'user-template/couple-dashboard.php') { ?>
                dashboard();
            <?php } ?>
        });

        function listings() {
            $filter_backdrop = jQuery('<div class="filter-backdrop"></div>');
            $filter_backdrop.appendTo('body');
            $map_button = jQuery('<li class="nav-item nav-map"> <a class="nav-link" id="listing-map" data-bs-toggle="pill" href="#" role="tab" aria-selected="false"> <i class="fa fa-map-marker"></i> Map </a> </li>');
            $map_button.appendTo('.map-tabbing');
            $map_close = jQuery('<svg class="close-map" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16"> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path> </svg>');

            $map_close.prependTo('#weddingdir_find_listing_section');

            jQuery('button[data-bs-target=".find-listing-widget"]').click(function(e) {
                jQuery('#weddingdir_find_listing_form .collapse').removeClass('show');
                setTimeout(function() {
                    jQuery('#weddingdir_find_listing_form .row:nth-child(2)').toggleClass('show-filter');
                    jQuery('.filter-backdrop').toggleClass('filter-backdrop-active');
                }, 300);
                e.preventDefault();
            });

            jQuery('.close-filter').click(function(e) {
                jQuery('#weddingdir_find_listing_form .row:nth-child(2)').toggleClass('show-filter');
                jQuery('.filter-backdrop').toggleClass('filter-backdrop-active');
                e.preventDefault();
            });

            jQuery('.filter-backdrop').click(function(e) {
                jQuery('#weddingdir_find_listing_form .row:nth-child(2)').removeClass('show-filter');
                jQuery('#map_handler').removeClass('show-map');
                jQuery('body').removeClass('body-show-map');
                jQuery('.filter-backdrop').removeClass('filter-backdrop-active');
                e.preventDefault();
            });
            jQuery('#listing-map').click(function(e) {
                jQuery('#map_handler').toggleClass('show-map');
                jQuery('body').toggleClass('body-show-map');
                jQuery('.filter-backdrop').toggleClass('filter-backdrop-active');
                e.preventDefault();
                return false;
            });
            jQuery('.close-map').click(function(e) {
                jQuery('#map_handler').toggleClass('show-map');
                jQuery('body').toggleClass('body-show-map');
                jQuery('.filter-backdrop').toggleClass('filter-backdrop-active');
                return false;
            });

        }
        <?php if (get_page_template_slug() == 'user-template/couple-dashboard.php') { ?>

            function dashboard() {
                jQuery('.dashboard-body .card-shadow').each(function(index, element) {
                    $section_name = jQuery(this).find('h3').text();
                    jQuery(this).addClass($section_name);
                });

                $top = jQuery('<div class="container"><div class="top row"><div class="col-lg-6 col-task"></div><div class="col-lg-6 col-budget"></div><div class="col-lg-12 col-guest"></div></div>');

                $top.prependTo('.col-xl-8');

                jQuery('.Upcoming.tasks').appendTo('.col-task');
                jQuery('.Budget').appendTo('.col-budget');
                jQuery('.Guest.List.Overview').appendTo('.col-guest');
                
            }
        <?php } ?>
    </script>
<?php
}


add_action('wp_footer', 'action_wp_footer');

function action_admin_head()
{
?>
    <style>
        #weddingdir-name,
        #weddingdir-child-name {
            font-size: 0;
        }

        #weddingdir-name:after {
            content: 'Bandhun';
            font-size: 15px;
        }

        #weddingdir-child-name:after {
            content: 'Bandhun Child';
            font-size: 15px;
        }

        #weddingdir-name span,
        #weddingdir-child-name span {
            font-size: 15px;
        }
    </style>
    <?php
    if (get_current_user_id() != 1) {
    ?>
        <style>
            #toplevel_page_weddingdir {
                display: none !important;
            }
        </style>
    <?php
    }
}

add_action('admin_head', 'action_admin_head');

/**
 * Change text strings
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 */
function my_text_strings($translated_text, $text, $domain)
{
    switch ($translated_text) {
        case 'WeddingDir':
            $translated_text = __('Bandhun', 'bandhun');
            break;
    }
    return $translated_text;
}
add_filter('gettext', 'my_text_strings', 20, 3);


function import_vendors()
{
    add_submenu_page(
        'edit.php?post_type=vendor',
        __('Import Vendors', 'textdomain'),
        __('Import Vendors', 'textdomain'),
        'manage_options',
        'import-vendors',
        'import_vendors_contents'
    );
}

add_action('admin_menu', 'import_vendors');


function import_vendors_contents()
{
    ?>
    <style>
        .import-form {
            max-width: 500px;
        }

        .import-form .form-control:not(:last-child) {
            margin-bottom: 1.5rem;
        }

        .import-form input {
            width: 100%;
        }

        .import-form .submit {
            font-weight: bold;
            font-size: 16px;
        }

        .import-table {
            overflow: auto;
        }

        .import-table th,
        .import-table td {
            padding: 5px 5px;
        }

        .import-table>table>tbody {
            display: flex;
            flex-wrap: wrap;

        }

        .import-table table {
            width: 100%;
        }

        .import-table>table>tbody>tr {
            padding: 5px;
            flex: 0 0 auto;
            width: 28%;
            border: 1px solid #ececec;
            background-color: #ececec;
        }

        .import-table>table>tbody>tr:nth-child(even) {
            background-color: #fff;
        }

        .login-details {
            background-color: #adf5ad;
            padding: 10px;
            border-radius: 10px;
            border: 1px dashed;
        }
    </style>
    <h1>
        <?php esc_html_e('Import vendors', 'my-plugin-textdomain'); ?>
    </h1>

    <?php if (!$_GET['csv']) { ?>
        <form action="/wp-admin/edit.php" method="GET" class="import-form">
            <div class="form-control">
                <label for="">
                    <h4>Please upload csv in media library and put csv link below.</h4>
                    <input type="hidden" name="post_type" value="vendor">
                    <input type="hidden" name="page" value="import-vendors">
                    <input type="text" name="csv" placeholder="CSV URL" required>
                </label>
            </div>
            <div class="form-control">
                <input type="submit" value="SUBMIT" class="submit button button-primary">
            </div>
        </form>
    <?php } else { ?>
        <h3>CSV URL: <?= $_GET['csv'] ?></h3>
    <?php } ?>
    <?php

    if ($_GET['csv']) {
        $CSVfp = fopen($_GET['csv'], "r");
        if ($CSVfp !== FALSE) {
    ?>
            <div class="import-table">
                <table>
                    <?php
                    $row = 0;
                    $meta_name = array();
                    $meta_input = array();

                    while (!feof($CSVfp)) {
                        $data = fgetcsv($CSVfp, 1000, ",");
                        if (!empty($data)) {
                            if ($row == 0) {
                                foreach ($data as $key => $d) {
                                    $meta_name[] = $d;
                                }
                            } else {
                                foreach ($data as $key => $d) {
                                    if ($d != 'categories') {
                                        $meta_input[$meta_name[$key]] = $d;
                                    }
                                }
                                $fname = preg_replace('/[^a-zA-Z0-9_.]/', '_', $meta_input['first_name']);
                                $lname = preg_replace('/[^a-zA-Z0-9_.]/', '_', $meta_input['last_name']);
                                $username = strtolower($meta_input['author_username']);
                                $password = $username;
                                $email = $meta_input['user_email'];
                                $user_id = create_new_vedor_user($username, $password, $email);
                                $meta_input['user_id'] = $user_id;
                                $post_exist = post_exists($meta_input['company_name']);
                                if ($post_exist) {
                                    $status = 'VENDOR EXIST ALREADY';
                                    $new_post_id = $post_exist;
                                } else {
                                    $new_post_id = create_new_vendor_post($meta_input);
                                    if ($new_post_id) {
                                        $status = 'IMPORTED';
                                    } else {
                                        $status = 'FAILED';
                                    }
                                }



                    ?>
                                <tr>
                                    <td>
                                        <h2 style="margin-top: 0; margin-bottom: 15px"><?= $meta_input['company_name'] ?> [<?= $status ?>]</h2>
                                        <table style="text-align: left">
                                            <tr>
                                                <th>
                                                    post_id
                                                </th>
                                                <td>
                                                    <?= $new_post_id ?>
                                                    <a href="<?= get_edit_post_link($new_post_id) ?>">[EDIT]</a>
                                                    <a href="<?= get_permalink($new_post_id) ?>">[VIEW]</a>
                                                </td>
                                            </tr>
                                            <?php foreach ($meta_input as $key => $d) { ?>
                                                <?php if ($key != '') { ?>
                                                    <tr>
                                                        <th>
                                                            <?= $key ?>
                                                        </th>
                                                        <td>
                                                            <?= $d ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                            <tr>
                                                <th>
                                                    categories
                                                </th>
                                                <td>
                                                    <?= $data[11] ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <div class="login-details">
                                                        <div>
                                                            <strong>username:</strong> <?= $username ?>
                                                        </div>
                                                        <div>
                                                            <strong>password:</strong> <?= $password ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        <?php $row++; ?>
                    <?php
                    }
                    ?>
                </table>
            </div>
    <?php
        }
        fclose($CSVfp);
    }
}



function create_new_vendor_post($meta_input)
{
    $category = get_term_by('name', trim($meta_input['categories']), 'vendor-category');

    if ($category) {
        $term = $category->term_id;
    } else {
        $term_id = wp_create_term(trim($meta_input['categories']), 'vendor-category');
        $category = get_term_by('name', trim($meta_input['categories']), 'vendor-category');
        $term = $category->term_id;
    }

    $wordpress_post = array(
        'post_title'  => $meta_input['company_name'],
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type'   => 'vendor',
        'tax_input'   => array(
            "vendor-category" => array($term)
        ),
        'meta_input'  => $meta_input
    );
    return wp_insert_post($wordpress_post);
}


function create_new_vedor_user($username, $password, $email)
{

    if (username_exists($username) || email_exists($email)) {
        $id_by_username = get_user_by('login', $username)->ID;
        $id_by_email = get_user_by('email', $email)->ID;
        $user_id = $id_by_username ? $id_by_username : $id_by_email;
        return $user_id;
    } else {
        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {

            die($user_id->get_error_message());
        }
        $user = get_user_by('id', $user_id);
        $user->remove_role('subscriber');
        $user->add_role('vendor');
        return $user_id;
    }
}



function import_listing()
{
    add_submenu_page(
        'edit.php?post_type=listing',
        __('Import listing', 'textdomain'),
        __('Import listing', 'textdomain'),
        'manage_options',
        'import-listing',
        'import_listing_contents'
    );
}

add_action('admin_menu', 'import_listing');


function import_listing_contents()
{
    ?>
    <style>
        .import-form {
            max-width: 500px;
        }

        .import-form .form-control:not(:last-child) {
            margin-bottom: 1.5rem;
        }

        .import-form input {
            width: 100%;
        }

        .import-form .submit {
            font-weight: bold;
            font-size: 16px;
        }

        .import-table {
            overflow: auto;
        }

        .import-table th,
        .import-table td {
            padding: 5px 5px;
        }

        .import-table>table>tbody {
            display: flex;
            flex-wrap: wrap;

        }

        .import-table table {
            width: 100%;
        }

        .import-table>table>tbody>tr {
            padding: 5px;
            flex: 0 0 auto;
            width: 28%;
            border: 1px solid #ececec;
            background-color: #ececec;
        }

        .import-table>table>tbody>tr:nth-child(even) {
            background-color: #fff;
        }

        .login-details {
            background-color: #adf5ad;
            padding: 10px;
            border-radius: 10px;
            border: 1px dashed;
        }
    </style>
    <h1>
        <?php esc_html_e('Import listing', 'my-plugin-textdomain'); ?>
    </h1>



    <?php if (!$_GET['csv']) { ?>
        <form action="/wp-admin/edit.php" method="GET" class="import-form">
            <div class="form-control">
                <label for="">
                    <h4>Please upload csv in media library and put csv link below.</h4>
                    <input type="hidden" name="post_type" value="listing">
                    <input type="hidden" name="page" value="import-listing">
                    <input type="text" name="csv" placeholder="CSV URL" required>
                </label>
            </div>
            <div class="form-control">
                <input type="submit" value="SUBMIT" class="submit button button-primary">
            </div>
        </form>
    <?php } else { ?>
        <h3>CSV URL: <?= $_GET['csv'] ?></h3>
    <?php } ?>
    <?php

    if ($_GET['csv']) {
        $CSVfp = fopen($_GET['csv'], "r");
        if ($CSVfp !== FALSE) {
    ?>
            <div class="import-table">
                <table>
                    <?php
                    $row = 0;
                    $meta_name = array();
                    $meta_input = array();

                    while (!feof($CSVfp)) {
                        $data = fgetcsv($CSVfp, 1000, ",");
                        if (!empty($data)) {
                            if ($row == 0) {
                                foreach ($data as $key => $d) {
                                    $meta_name[] = $d;
                                }
                            } else {
                                foreach ($data as $key => $d) {
                                    $meta_input[$meta_name[$key]] = $d;
                                }
                                $new_post_id = create_new_listing_post($meta_input);
                                if ($new_post_id) {
                                    $status = 'IMPORTED';
                                } else {
                                    $status = 'FAILED';
                                }

                    ?>
                                <tr>
                                    <td>
                                        <h2 style="margin-top: 0; margin-bottom: 15px"><?= $meta_input['company_name'] ?> [<?= $status ?>]</h2>
                                        <table style="text-align: left">
                                            <tr>
                                                <th>
                                                    post_id
                                                </th>
                                                <td>
                                                    <?= $new_post_id ?>
                                                    <a href="<?= get_edit_post_link($new_post_id) ?>">[EDIT]</a>
                                                    <a href="<?= get_permalink($new_post_id) ?>">[VIEW]</a>
                                                </td>
                                            </tr>
                                            <?php foreach ($meta_input as $key => $d) { ?>
                                                <?php if ($key != '') { ?>
                                                    <tr>
                                                        <th>
                                                            <?= $key ?>
                                                        </th>
                                                        <td>
                                                            <?= $d ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </table>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        <?php $row++; ?>
                    <?php
                    }
                    ?>
                </table>
            </div>
<?php
        }
        fclose($CSVfp);
    }
}



function create_new_listing_post($meta_input)
{
    $categories = explode(",", $meta_input['category']);
    $category = array();
    foreach ($categories as $categ) {
        if (term_exists($categ, 'listing-category')) {
            $category[] = get_term_by('name', $categ, 'listing-category')->term_id;
        } else {
            $new_term = wp_insert_term($categ, 'listing-category');
            $category[] = $new_term->term_id;
        }
    }

    $user_id = get_user_by('login', $meta_input['author_username'])->ID;

    $found_post = post_exists($meta_input['listing_name']);

    $wordpress_post = array(
        'post_title'  => $meta_input['listing_name'],
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type'   => 'listing',
        'tax_input'   => array(
            "listing-category" => $category
        ),
        'meta_input'  => $meta_input,
        'post_author' => $user_id
    );
    if ($found_post) {
        $wordpress_post['ID'] = $found_post;
        return wp_update_post($wordpress_post);
    } else {

        return wp_insert_post($wordpress_post);
    }
}

//check if user is logged in
add_filter('body_class', 'custom_class');
function custom_class($classes)
{
    if (is_user_logged_in()) {
        $classes[] = 'user-is-logged-in';
    } else {
        $classes[] = 'user-is-not-logged-in';
    }
    return $classes;
}



function action_hidden_inputs_fields($args = [])
{

    $_hidden_input  =   [
        'search_term'           =>      'search_terms',
    ];
    $_collection        =       [];

    foreach ($_hidden_input as $key => $value) {

        /**
         *  Update Value
         *  ------------
         */
        $_collection[$key]    =   isset($_GET[$key]) && !empty($_GET[$key])

            ?   $_GET[$key]

            :   '';
    }

    return array_merge($args, $_collection);
}

add_filter('weddingdir/find-listing/hidden-inputs', 'action_hidden_inputs_fields');

function custom_query_vars_filter($vars)
{
    $vars[] = 'search_term';

    return $vars;
}
add_filter('query_vars', 'custom_query_vars_filter');

function PLUGIN_modify_query($query)
{
    $search_term = get_query_var('search_term');
    if ($query->query['post_type'] == 'listing') {
        //Apply the order by options
        $query->set('s', $search_term);
    }
}

add_action('pre_get_posts', 'PLUGIN_modify_query');
