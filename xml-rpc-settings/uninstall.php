<?php // exit if uninstall constant is not defined
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

// delete multiple options
$settings = array(
    // Disable GET access:
    'allow_disallow_get_access',
    // Disable system.multicall:
    'allow_disallow_multicall',
    // Disable system.listMethods:
    'allow_disallow_listmethods',
    // Disable authenticated methods:
    'allow_disallow_auth',
    // Disable pingbacks:
    'allow_disallow_pingbacks',
    // Remove X-Pingback header:
    'allow_disallow_header',
    // Hide WordPress version when verifying pingbacks:
    'allow_disallow_verify_agent',
    // Hide WordPress version when sending pingbacks:
    'allow_disallow_send_agent',
    // Disable Demo API:
    'allow_disallow_demo',
    // Disable Blogger API:
    'allow_disallow_blogger',
    // Disable MetaWeblog API:
    'allow_disallow_metaweblog',
    // Disable MovableType API:
    'allow_disallow_movabletype',
    // Allow XML-RPC only for:
    'allowed_ip',
    // Add message to XML-RPC methods:
    'methods_message',
);

foreach ($settings as $setting) {
    unregister_setting('xml-rpc-settings-group', $setting);
}