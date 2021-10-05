<?php

/**
 * Plugin Name:       XML-RPC Settings
 * Plugin URI:        https://github.com/vavkamil/xml-rpc-settings
 * Description:       Configure XML-RPC methods to increase the security of your website.
 * Version:           1.2.1
 * Author:            @vavkamil
 * Author URI:        https://vavkamil.cz
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       xml-rpc-settings
 */

// ^ Header Requirements
// https://developer.wordpress.org/plugins/plugin-basics/header-requirements/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// create custom plugin settings menu
add_action( 'admin_menu', 'xmlrpc_settings_options_page' );

function xmlrpc_settings_options_page() {

    //create new top-level menu
    add_options_page('XML-RPC Settings', 'XML-RPC Settings', 'manage_options', 'xml-rpc-settings', 'xmlrpc_settings_options_page_html');

    //call register settings function
    add_action( 'admin_init', 'xmlrpc_settings_register_settings' );
}

// Add link to settings from plugins page
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'xmlrpc_settings_add_plugin_page_settings_link');
function xmlrpc_settings_add_plugin_page_settings_link( $links ) {
    $links[] = '<a href="' .
        admin_url( 'options-general.php?page=xml-rpc-settings' ) .
        '">' . __('Settings') . '</a>';
    return $links;
}

function xmlrpc_settings_register_settings() {
    //register our settings

    // Disable GET access:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_get_access' );

    // Disable system.multicall:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_multicall' );

    // Disable system.listMethods:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_listmethods' );

    // Disable authenticated methods:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_auth' );

    // Disable pingbacks:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_pingbacks' );

    // Remove X-Pingback header:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_header' );

    // Hide WordPress version when verifying pingbacks:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_verify_agent' );

    // Hide WordPress version when sending pingbacks:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_send_agent' );

    // Disable Demo API:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_demo' );

    // Disable Blogger API:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_blogger' );

    // Disable MetaWeblog API:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_metaweblog' );

    // Disable MovableType API:
    register_setting( 'xml-rpc-settings-group', 'allow_disallow_movabletype' );

    // Allow XML-RPC only for:
    register_setting( 'xml-rpc-settings-group', 'allowed_ip' );

    // Add message to XML-RPC methods:
    register_setting( 'xml-rpc-settings-group', 'methods_message' );
}

// XML-RPC Settings : Options HTML page
function xmlrpc_settings_options_page_html() {

    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    ?>
    <div class="wrap">
        <h1>XML-RPC Settings</h1>
        <h2>Configure XML-RPC methods to increase the security of your website.</h2>
        <form method="post" action="options.php">

            <?php settings_fields( 'xml-rpc-settings-group' ); ?>
            <table class="form-table">
                <tr><td colspan="100%"><hr><strong>Build-in features could be used for malicious purposes and cannot be disabled by default.</strong></td></tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Disable GET access:
                -->
                <tr valign="top">
                    <th scope="row">Disable GET access:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_get_access" value="disallow" <?php echo esc_attr( get_option('allow_disallow_get_access') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* XML-RPC API only responds to POST requests. Direct GET access is not needed and can be used to fingerprint websites and use them as XML-RPC zombies in later attacks.</span>
                    </td>
                </tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Disable system.multicall:
                -->
                <tr valign="top">
                    <th scope="row">Disable system.multicall:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_multicall" value="disallow" <?php echo esc_attr( get_option('allow_disallow_multicall') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* system.multicall method can be misused for amplification attacks.</span>
                    </td>
                </tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Disable system.listMethods:
                -->
                <tr valign="top">
                    <th scope="row">Disable system.listMethods:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_listmethods" value="disallow" <?php echo esc_attr( get_option('allow_disallow_listmethods') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* system.listMethods method can be used for verifying attack scope.</span>
                    </td>
                </tr>
                <tr><td colspan="100%"><hr><strong>Prevent malicious actors from enumerating usernames and credentials.</strong></td></tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Disable authenticated methods:
                -->
                <tr valign="top">
                    <th scope="row">Disable authenticated methods:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_auth" value="disallow" <?php echo esc_attr( get_option('allow_disallow_auth') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* Methods requiring authentication, such as <strong><em>wp.getUsersBlogs</em></strong>, are often used to brute-force your passwords.</span>
                    </td>
                </tr>
                <tr><td colspan="100%"><hr><strong>Pingbacks are a useful feature to discover back-links to your posts but can be misused for DDoS attacks or to fingerprint your WP version.</strong></td></tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Disable pingbacks:
                -->
                <tr valign="top">
                    <th scope="row">Disable pingbacks:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_pingbacks" value="disallow" <?php echo esc_attr( get_option('allow_disallow_pingbacks') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* Pingbacks are generally safe, but are often used for DDoS attacks via <strong><em>system.multicall</em></strong>.</span>
                    </td>
                </tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Remove X-Pingback header:
                -->
                <tr valign="top">
                    <th scope="row">Remove X-Pingback header:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_header" value="disallow" <?php echo esc_attr( get_option('allow_disallow_header') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* If you decide to disable pingbacks, it's a good practice to remove the X-Pingback header return by your posts.</span>
                    </td>
                </tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Hide WordPress version when verifying pingbacks:
                -->
                <tr valign="top">
                    <th scope="row">Hide WordPress version when verifying pingbacks:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_verify_agent" value="disallow" <?php echo esc_attr( get_option('allow_disallow_verify_agent') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* Pingbacks' user-agent can reveal your exact WordPress version, even when hidden by other plugins.</span>
                    </td>
                </tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Hide WordPress version when sending pingbacks:
                -->
                <tr valign="top">
                    <th scope="row">Hide WordPress version when sending pingbacks:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_send_agent" value="disallow" <?php echo esc_attr( get_option('allow_disallow_send_agent') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* Pingbacks' user-agent can reveal your exact WordPress version, even when hidden by other plugins.</span>
                    </td>
                </tr>
                <tr><td colspan="100%"><hr><strong>Unnecessary XML-RPC API, leave enabled if you are not sure.</strong></td></tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Disable Demo API:
                -->
                <tr valign="top">
                    <th scope="row">Disable Demo API:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_demo" value="disallow" <?php echo esc_attr( get_option('allow_disallow_demo') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* Remove demo.sayHello and demo.addTwoNumbers methods, as they are not needed.</span>
                    </td>
                </tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Disable Blogger API:
                -->
                <tr valign="top">
                    <th scope="row">Disable Blogger API:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_blogger" value="disallow" <?php echo esc_attr( get_option('allow_disallow_blogger') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* WordPress supports the Blogger XML-RPC API methods.</span>
                    </td>
                </tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Disable MetaWeblog API:
                -->
                <tr valign="top">
                    <th scope="row">Disable MetaWeblog API:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_metaweblog" value="disallow" <?php echo esc_attr( get_option('allow_disallow_metaweblog') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* WordPress supports the metaWeblog XML-RPC API.</span>
                    </td>
                </tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Disable MovableType API:
                -->
                <tr valign="top">
                    <th scope="row">Disable MovableType API:</th>
                    <td>
                        <input type="checkbox" name="allow_disallow_movabletype" value="disallow" <?php echo esc_attr( get_option('allow_disallow_movabletype') ) == 'disallow' ? 'checked' : '' ; ?> />
                        <span class="description">* WordPress supports the MovableType XML-RPC API.</span>
                    </td>
                </tr>
                <tr><td colspan="100%"><hr><strong>If you are using some integrations or WP mobile applications, it might be a good idea to allow XML-RPC only to specific IPs.</strong></td></tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Allow XML-RPC only for:
                -->
                <tr valign="top">
                    <th scope="row">Allow XML-RPC only for: </th>
                    <td>
                        <textarea name="allowed_ip" rows="4" cols="60" placeholder="IP comma separated eg. 192.168.10.242, 192.168.10.241"><?php echo esc_attr( get_option('allowed_ip') ); ?></textarea>
                    </td>
                </tr>
                <tr><td colspan="100%"><hr><strong>It is possible to hide a message between the allowed methods when system.listMethods is called (not recommended).</strong></td></tr>
                <!--
                ////////////////////////////////////////////////////////////////////////////////////////////////////
                // Add message to XML-RPC methods:
                -->
                <tr valign="top">
                    <th scope="row">Add message to XML-RPC methods:</th>
                    <td>
                        <textarea name="methods_message" rows="4" cols="60" placeholder="We are hiring! Check jobs.yourdomains.com"><?php echo esc_attr( get_option('methods_message') ); ?></textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable GET access:

function xmlrpc_settings_disable_get_access( $methods ) {
    global $pagenow; // get current page

    // Block GET requests
    if (!empty($pagenow) && $pagenow === "xmlrpc.php" && $_SERVER['REQUEST_METHOD'] === 'GET') {
        die();
    }
    return $methods;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable system.multicall:

function xmlrpc_settings_disable_xmlrpc_multicall( $methods ) {
    global $pagenow; // get current page

    // Block POST request that matches system.multicall
    if (!empty($pagenow) && $pagenow === "xmlrpc.php" && count(preg_grep('/system.multicall/', array_keys($_POST))) > 0) {
        die();
    }
    return $methods;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable system.listMethods:

function xmlrpc_settings_disable_xmlrpc_listmethods( $methods ) {
    return [];
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable authenticated methods:

function xmlrpc_settings_disable_xmlrpc_auth( $methods ) {
    // add_filter( 'xmlrpc_enabled', '__return_false' );

    foreach ($methods as $method) {
        if(substr( $method, 0, 8 ) === "this:wp_") {
            $method2 = substr($method, 5);
            $method2 = str_replace("wp_", "wp.", $method2);
            unset( $methods[$method2] );
        }
    }
    
    unset( $methods["wp.deleteFile"]);
    unset( $methods["wp.uploadFile"]);
    unset( $methods["wp.getCategories"]);

    return $methods;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable pingbacks:

function xmlrpc_settings_disable_xmlrpc_pingbacks( $methods ) {
    unset( $methods["pingback.extensions.getPingbacks"]);
    unset( $methods["pingback.ping"]);

    return $methods;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Remove X-Pingback header:

function xmlrpc_settings_disable_xmlrpc_header( $headers ) {
   unset( $headers['X-Pingback'] );

   return $headers;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Hide WordPress version when verifying pingbacks:

function xmlrpc_settings_disable_xmlrpc_verify_agent( $http_request ) {
    if(preg_match('/verifying pingback from/', $http_request['user-agent'])) {
                $http_request['user-agent'] = preg_replace("/WordPress\/(.*?);/", "WordPress/0.0.0;", $http_request['user-agent']);
    }

    return $http_request;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Hide WordPress version when sending pingbacks:

function xmlrpc_settings_disable_xmlrpc_send_agent( $methods ) {
    # TODO
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable Demo API:

function xmlrpc_settings_disable_xmlrpc_demo( $methods ) {
    unset( $methods["demo.addTwoNumbers"] );
    unset( $methods["demo.sayHello"] );

    return $methods;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable Blogger API:

function xmlrpc_settings_disable_xmlrpc_blogger( $methods ) {
    foreach ($methods as $method) {
        if(substr( $method, 0, 13 ) === "this:blogger_") {
            $method2 = substr($method, 5);
            $method2 = str_replace("blogger_", "blogger.", $method2);
            unset( $methods[$method2] );
        }
    }

    return $methods;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable MetaWeblog API:

function xmlrpc_settings_disable_xmlrpc_metaweblog( $methods ) {
    foreach ($methods as $method) {
        if(substr( $method, 0, 8 ) === "this:mw_") {
            $method2 = substr($method, 5);
            $method2 = str_replace("mw_", "metaWeblog.", $method2);
            unset( $methods[$method2] );
        }
        
        unset( $methods["metaWeblog.getUsersBlogs"]);
        unset( $methods["metaWeblog.deletePost"]);
    }

    return $methods;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable MovableType API:

function xmlrpc_settings_disable_xmlrpc_movabletype( $methods ) {
    foreach ($methods as $method) {
        if(substr( $method, 0, 8 ) === "this:mt_") {
            $method2 = substr($method, 5);
            $method2 = str_replace("mt_", "mt.", $method2);
            unset( $methods[$method2] );
        }
    }

    return $methods;
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Allow XML-RPC only for:

function xmlrpc_settings_xmlrpc_allowed_ip( $methods ) {
    $addresses = get_option('allowed_ip');
}

////////////////////////////////////////////////////////////////////////////////////////////////////
// Add message to XML-RPC methods:

function xmlrpc_settings_xmlrpc_methods_message( $methods ) {
    $message = get_option('methods_message');
    array_push($methods[$message]);
    $methods[$message] = $message;

    return $methods;
}

////////////////////////////////////////////////////////////////////////////////////////////////////

function xmlrpc_settings_disable_xmlrpc_onpage_load(){
    // Disable GET access:
    if(esc_attr(get_option('allow_disallow_get_access')) == 'disallow') {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_disable_get_access');
    }
    // Disable system.multicall:
    if(esc_attr(get_option('allow_disallow_multicall')) == 'disallow') {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_disable_xmlrpc_multicall');
    }

    // Disable system.listMethods:
    if(esc_attr(get_option('allow_disallow_listmethods')) == 'disallow') {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_disable_xmlrpc_listmethods');
    }

    // Disable authenticated methods:
    if(esc_attr( get_option('allow_disallow_auth')) == 'disallow') {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_disable_xmlrpc_auth');
    }

    // Disable pingbacks:
    if(esc_attr( get_option('allow_disallow_pingbacks')) == 'disallow') {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_disable_xmlrpc_pingbacks');
    }

    // Remove X-Pingback header:
    if(esc_attr( get_option('allow_disallow_header')) == 'disallow') {
        add_filter('wp_headers', 'xmlrpc_settings_disable_xmlrpc_header');
    }

    // Hide WordPress version when verifying pingbacks:
    if(esc_attr( get_option('allow_disallow_verify_agent')) == 'disallow') {
        add_filter('http_request_args', 'xmlrpc_settings_disable_xmlrpc_verify_agent');
    }

    // Hide WordPress version when sending pingbacks:
    if(esc_attr( get_option('allow_disallow_send_agent')) == 'disallow') {
        add_filter('http_request_args', 'xmlrpc_settings_disable_xmlrpc_send_agent');
    }

    // Disable Demo API:
    if(esc_attr( get_option('allow_disallow_demo')) == 'disallow' ) {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_disable_xmlrpc_demo');
    }

    // Disable Blogger API:
    if(esc_attr( get_option('allow_disallow_blogger')) == 'disallow' ) {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_disable_xmlrpc_blogger');
    }

    // Disable MetaWeblog API:
    if(esc_attr( get_option('allow_disallow_metaweblog')) == 'disallow' ) {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_disable_xmlrpc_metaweblog');
    }

    // Disable MovableType API:
    if(esc_attr( get_option('allow_disallow_movabletype')) == 'disallow' ) {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_disable_xmlrpc_movabletype');
    }

    // Allow XML-RPC only for:
    if(esc_attr( get_option('allowed_ip')) !== '' ) {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_xmlrpc_allowed_ip');
    }

    // Add message to XML-RPC methods:
    if(esc_attr( get_option('methods_message')) !== '' ) {
        add_filter('xmlrpc_methods', 'xmlrpc_settings_xmlrpc_methods_message');
    }


}

add_action('init', 'xmlrpc_settings_disable_xmlrpc_onpage_load');