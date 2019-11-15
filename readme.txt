=== WP to Alexa Flash Briefing ===
Contributors: ko31
Donate link: https://go-sign.info
Tags: alexa,amazon,flash briefing,feed
Requires at least: 4.7
Tested up to: 5.3
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This is a plugin to create a feed of Alexa flash briefing skill in WordPress.

== Description ==

This is a plugin to create a feed of Alexa flash briefing skill in WordPress.

Please create `Briefing` posts just like the posts, and pages.

You can publish your feed by itself. It's easy!

### Features

* You can start using it immediately without initial setting.
* A custom post type 'Briefing' for creating feeds is provided
* Provide endpoint URL for registering Alexa flash briefing skill.
* It can check the endpoint URL from the setting screen.

### Endpoint URL

When your permalink structure setting is basic:

`https://example.com/index.php?rest_route=/w2afb/v1/briefings`

For other settings:

`https://example.com/wp-json/w2afb/v1/briefings`

If you want to provide multiple endpoints, you can create them using the categories as follows:

`/wp-json/w2afb/v1/briefings?category=yourcategoryslug`

== Related Links ==

* [Github](https://github.com/ko31/wp-to-alexa-flash-briefing)

== Installation ==

1. Upload the wp-to-alexa-flash-briefing directory to the plugins directory.
1. Activate the plugin through the ‘Plugins’ menu in WordPress.
1. 'Dashboard'->'Settings'->'WP to Alexa Flash Briefing'
1. You can get an 'Endpoint URL'.
1. Please register the URL in the Alexa Developer Console feed item.

== Frequently Asked Questions ==

= What is the output feed format? =

It is json format.

= Can I register audio contents? =

If you want to register audio content, please enter the URL of the MP3 stream at the beginning of the body.

= Can I use a block editor? =

Yes. Both block editor and code editor are available.

== Screenshots ==

1. A custom post type 'Briefing' for creating feeds is provided
2. Provide endpoint URL for registering Alexa flash briefing skill.

== Changelog ==

= 1.0 =

* Initial Release
