<?php

/**
 * Disable XML RPC for security.
 */
add_filter('xmlrpc_enabled', '__return_false');


/**
 * Désactive le pingback en plus du paramètre dans le backoffice wp-admin/options-discussion.php : "Tenter de notifier les sites liés depuis la publication"
 */
add_action('pre_ping', function (&$links) {
    $home = get_option('home');
    foreach ($links as $l => $link) {
        if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
});
// Remove pingback from head (link rel="pingback")
if (!is_admin()) {
    function link_rel_buffer_callback($buffer)
    {
        $buffer = preg_replace('/(<link.*?rel=("|\')pingback("|\').*?href=("|\')(.*?)("|\')(.*?)?\/?>|<link.*?href=("|\')(.*?)("|\').*?rel=("|\')pingback("|\')(.*?)?\/?>)/i', '', $buffer);
        return $buffer;
    }
    function link_rel_buffer_start()
    {
        ob_start("link_rel_buffer_callback");
    }
    function link_rel_buffer_end()
    {
        ob_flush();
    }
    add_action('template_redirect', 'link_rel_buffer_start', -1);
    add_action('get_header', 'link_rel_buffer_start');
    add_action('wp_head', 'link_rel_buffer_end', 999);
}
// Return pingback_url empty (<link rel="pingback" href>).
add_filter('bloginfo_url', function ($output, $property) {
    return ($property == 'pingback_url') ? null : $output;
}, 11, 2);
// Disable X-Pingback HTTP Header.
add_filter('wp_headers', function ($headers, $wp_query) {
    if (isset($headers['X-Pingback'])) {
        unset($headers['X-Pingback']);
    }
    return $headers;
}, 11, 2);


/**
 * Vérouille l'API (certain plugin l'utilise, donc il ne faut pas la désactiver)
 */
// Removes REST API link tag from header.
remove_action('wp_head', 'rest_output_link_wp_head', 10);
add_filter('rest_authentication_errors', function ($result) {
    if (! empty($result)) {
        return $result;
    }
    if (! is_user_logged_in()) {
        return new WP_Error('rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ));
    }
    return $result;
});
// Disable default users API endpoints for security. https://www.wp-tweaks.com/hackers-can-find-your-wordpress-username/
add_filter('rest_endpoints', function ($endpoints)
{
    if (!is_user_logged_in()) {
        if (isset($endpoints['/wp/v2/users'])) {
            unset($endpoints['/wp/v2/users']);
        }

        if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
            unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
        }
    }

    return $endpoints;
});


/**
 * Désactive Gutenberg avec le js et css asscoié
 */
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);
add_action('wp_enqueue_scripts', function () {
    // wp_deregister_style('wp-block-library'); // done by headache
    wp_deregister_style('wp-block-library-theme'); // Wordpress core
    wp_deregister_style('wc-block-style'); // WooCommerce
    wp_deregister_style('storefront-gutenberg-blocks'); // Storefront theme
}, 100);


/**
 * Désactive les commentaires et leur gestion
 */
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});
// Close comments on the front-end
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
add_filter('comments_array', '__return_empty_array', 10, 2); // Hide existing comments


/**
 * Désactive les émoticônes
 */
add_action('init', function () {
    remove_action('wp_head', 'wp_site_icon', 99);
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', function ($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, array( 'wpemoji' ));
        }
        return array();
    });
    add_filter('wp_resource_hints', function ($urls, $relation_type) {
        if ('dns-prefetch' == $relation_type) {
            // Strip out any URLs referencing the WordPress.org emoji location
            $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
            foreach ($urls as $key => $url) {
                if (strpos($url, $emoji_svg_url_bit) !== false) {
                    unset($urls[$key]);
                }
            }
        }
        return $urls;
    }, 10, 2);
});


/**
 * Désactiver oembed
 */
add_action('init', function () {
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('rest_api_init', 'wp_oembed_register_route');
    add_filter('embed_oembed_discover', '__return_false');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    add_filter('tiny_mce_plugins', function ($plugins) {
        return array_diff($plugins, array('wpembed'));
    });
    add_filter('rewrite_rules_array', function ($rules) {
        foreach ($rules as $rule => $rewrite) {
            if (false !== strpos($rewrite, 'embed=true')) {
                unset($rules[$rule]);
            }
        }
        return $rules;
    });
    remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
}, 9999);


/**
 * Désactiver feeds
 */
function disable_feeds()
{
    wp_redirect(site_url()); // Redirects all feeds to home page.
}
add_action('do_feed', 'disable_feeds', 1);
add_action('do_feed_rdf', 'disable_feeds', 1);
add_action('do_feed_rss', 'disable_feeds', 1);
add_action('do_feed_rss2', 'disable_feeds', 1);
add_action('do_feed_atom', 'disable_feeds', 1);
add_action('do_feed_rss2_comments', 'disable_feeds', 1);
add_action('do_feed_atom_comments', 'disable_feeds', 1);
remove_action('wp_head', 'wp_generator');                               // Removes WordPress version.
remove_action('wp_head', 'wp_shortlink_wp_head', 10);            // Removes shortlink.
remove_action('wp_head', 'rsd_link');                                   // Removes Really Simple Discovery link.
remove_action('wp_head', 'feed_links', 2);                       // Removes RSS feed links.
remove_action('wp_head', 'feed_links_extra', 3);                 // Removes all extra RSS feed links.
remove_action('wp_head', 'wlwmanifest_link');                           // Removes wlwmanifest.xml.
remove_action('wp_head', 'wp_resource_hints', 2);                // Removes meta rel=dns-prefetch href=//s.w.org
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10); // Removes relational links for the posts.


/**
 * Removes ?ver= query from styles and scripts.
 * @param string $src
 * @return string
 */
function remove_script_version(string $src): string
{
    return $src ? esc_url(remove_query_arg('ver', $src)) : $src;
}
add_filter('script_loader_src', 'remove_script_version', 15, 1);
add_filter('style_loader_src', 'remove_script_version', 15, 1);


/**
 * Remove contributor, subscriber and author roles.
 */
add_action('init', function(){
    remove_role('author');
    remove_role('contributor');
    remove_role('subscriber');
});
