=== XML-RPC Settings ===
Contributors: vavkamil
Tags: security, xmlrpc, ddos, brute-force
Requires at least: 3.9
Requires PHP: 5.3
Tested up to: 5.8
Stable tag: 1.2.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Secure your website with the most comprehensive XML-RPC Settings plugin.

== Description ==

### XML-RPC Settings

Configure XML-RPC methods to increase the security of your website:

#### Build-in features could be used for malicious purposes and cannot be disabled by default.

- Disable GET access
  - XML-RPC API only responds to POST requests. Direct GET access is not needed and can be used to fingerprint websites and use them as XML-RPC zombies in later attacks.
- Disable system.multicall
  - system.multicall method can be misused for amplification attacks.
- Disable system.listMethods
  - system.listMethods method can be used for verifying attack scope.

#### Prevent malicious actors from enumerating usernames and credentials.

- Disable authenticated methods
  - Methods requiring authentication, such as wp.getUsersBlogs, are often used to brute-force your passwords.

#### Pingbacks are a helpful feature to discover back-links to your posts but can be misused for DDoS attacks or allow fingerprinting your WP version.

- Disable pingbacks
  - Pingbacks are generally safe, but are often used for DDoS attacks via system.multicall.
- Remove X-Pingback header
  - If you decide to disable pingbacks, it's a good practice to remove the X-Pingback header return by your posts.
- Hide WordPress version when verifying pingbacks
  - Pingbacks' user-agent can reveal your exact WordPress version, even when hidden by other plugins.
- Hide WordPress version when sending pingbacks
  - Pingbacks' user-agent can reveal your exact WordPress version, even when hidden by other plugins.

#### Unnecessary XML-RPC API, leave enabled if you are not sure.

- Disable Demo API
  - Remove demo.sayHello and demo.addTwoNumbers methods, as they are not needed.
- Disable Blogger API
  - WordPress supports the Blogger XML-RPC API methods.
- Disable MetaWeblog API
  - WordPress supports the metaWeblog XML-RPC API.
- Disable MovableType API
  - WordPress supports the MovableType XML-RPC API.

#### If you are using some integrations or WP mobile applications, it might be a good idea to allow XML-RPC only to specific IPs.

- Allow XML-RPC only for
  - IP comma separated eg. 192.168.10.242, 192.168.10.241

#### It is possible to hide a message between the allowed methods when system.listMethods is called (not recommended).

- Add message to XML-RPC methods
  - We are hiring! Check jobs.yourdomains.com

== Installation ==

Secure your website using the following steps to install XML-RPC Settings:

1. Install XML-RPC Settings automatically or by uploading the ZIP file. 
2. Activate the XML-RPC Settings through the 'Plugins' menu in WordPress. XML-RPC Settings is now activated.
3. Go to the Settings >> XML-RPC Settings and configure the plugin based on your needs.

== Frequently Asked Questions ==

= How does XML-RPC Settings protect sites from attackers? =

The XML-RPC Settings plugin allows you to configure XML-RPC methods to increase the security of your website. For example, you can easily disable Pingback methods, which might be misused by attacks to launch DDoS attacks.

== Screenshots ==

XML-RPC Settings

1. The settings page is highly configurable, with a deep set of options available for each feature.

== Changelog ==

= 1.2.1 - October 05, 2021 =
- Fix callback function to register settings

= 1.2 - October 05, 2021 =
- Add `xmlrpc_settings_` prefix to function names to be unique

= 1.1 - October 03, 2021 =
- Updated readme.txt and fixed grammar

= 1.0 =
- An initial release
