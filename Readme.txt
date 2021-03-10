=== Plugin Name ===
Contributors: kofibutton
Donate link: https://ko-fi.com/supportkofi
Tags: paypal, apple pay, paypal donate, donate plugin, members, membership, monetization, kofi_button, ko-fi, button
Requires at least: 4.6
Tested up to: 5.7
Stable tag: 1.0.3
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Receive donations on your Ko-fi page with a button on your wordpress site.

== Description ==

Ko-fi is a fast and friendly way to earn money from your blog, website or project. Over $30 million has been earned on Ko-fi so far and it's growing every month! 

The money goes directly to you with 0% fees from Ko-fi, it's completely Free and a great alternative to ads!

Create your free page at ko-fi.com in just a few minutes and link your PayPal or Stripe account to start receiving donations. 

Use the Plugin to add a Ko-fi button to any widget area, sidebar or use the shortcode [kofi] to add a button to any page or post.

== Installation ==

To install the plugin, please follow the following steps.

Installation To install the plugin, please follow the following steps.

1. Go to ‘Plugins’and click Add New, search for Ko-fi and install the plugin or upload the plugin files to the /wp-content/plugins/Ko-fi-plugin directory. 
2. Activate the plugin through the ‘Plugins’ screen in WordPress.
3. Use the Settings > Ko-fi Settings screen to link to your Ko-fi page and configure the default settings.  
4. Go to Appearance > Widgets and add a ‘Ko-fi button’ widget to any Sidebar or Widget area. 
5. Override any default settings in the widget.
6. You can also add your Ko-fi button to any Page or Post using Shortcode [kofi].

== Frequently Asked Questions ==

= What is Ko-fi =

Ko-fi is a donation service allowing creators to receive small payments (roughly the price of a coffee) from supporters of their work. Used as an alternative to advertising, Ko-fi helps all types of artists, cosplayers, bloggers, coders and podcasters to fund their passions. 

= Do Ko-fi take a fee =

Nope, we don't take a fee from your donations. The payment processor will take a small fee for processing the transaction, but Ko-fi is a free service. 

= What about monthly memberships =

Ko-fi offer Ko-fi Gold, a totally optional upgrade which allows creators to receive recurring monthly donations, create supporter only content and build a monthly membership service. 

= What does the Wordpress Plugin do =

The Wordpress plugin allows wordpress users to easily add a customisable 'Support me on Ko-fi' button to their blog or website. Simply add the plugin, enter your page details and place the widget in a sidebar or widget area.

Alternatively use the [kofi] shortcode in your page or in the shortcode block.

For more information see the help page at [ko-fi.com.](https://help.ko-fi.com/hc/en-us/articles/115004002614-Add-a-Ko-fi-button-to-your-WordPress-site)

= Help! The Default Code on my widget has changed =

With the release of 1.0.1 your Ko-fi code now comes from the settings page when using the shortcode or a widget. 

If you have not set your Ko-fi code in the settings page then simply update the Default Page Name/Id on the settings page, save the change and the widget will automatically pick it up.

= Acknowledgements =

* Thanks to @mlchaves for his assistance with making the plugin php7.3 compliant.

== Screenshots ==

1. Ko-fi settings page, set the default settings of the button
2. Customise the button for a specific widget placement

== Changelog ==

= 1.0.3 =
* Handle the case with an apostrophe in the button text.
* Remove double quotation marks when rendering widget javascript to browser.
* Tested for button text handling extended characters.

= 1.0.2 =
* Align 'Default Code' field name in the Widget with the field name 'Page Name Or ID' on the settings.
* Set the default value in 'Page Name or ID' on the settings to being empty and set the placeholder to 'supportkofi'.
* When adding a new widget take the default values from the current Ko-fi settings.
* Re-arrange settings into a more logical order on the settings page.

= 1.0.1 =
* Minor Updates to the wording used withhin the plugin and to the use of 'Ko-fi'.
* Addition of ability to change button alignment within containing element.
* Bring plugin version in-line with readme.
* Fix hyperlink functionlity.
* Make the 'Default Code' widget field readonly and always the same value as on the settings page.

= 1.0.0 =
* Initial release