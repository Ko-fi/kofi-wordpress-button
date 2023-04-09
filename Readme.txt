=== Ko-fi Button ===
Contributors: kofibutton, chrisodell, cameronjonesweb
Donate link: https://ko-fi.com/supportkofi
Tags: paypal, apple pay, paypal donate, donate plugin, members, membership, monetization, kofi_button, ko-fi, button
Requires at least: 4.6
Tested up to: 6.2
Stable tag: 1.3.0
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Receive donations on your Ko-fi page with a button on your WordPress site.

== Description ==

Ko-fi is a fast and friendly way to earn money from your blog, website or project. Over $200 million has been earned on Ko-fi so far and it's growing every month! 

The money goes directly to you with 0% fees from Ko-fi, it's completely free and a great alternative to ads!

Create your free page at ko-fi.com in just a few minutes and link your PayPal or Stripe account to start receiving donations. 

Use the Plugin to add a Ko-fi button or donation panel to any widget area, sidebar or use the shortcode [kofi] to add a button to any page or post.

== Installation ==

To install the plugin, please follow the following steps.

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

Yes, use Ko-fi to receive monthly subscriptions or create your own membership tiers. Use membership tiers to offer different benefits and price points to suit your audience.

= What does the WordPress Plugin do =

The WordPress plugin allows WordPress users to easily add a customisable 'Support me on Ko-fi' button to their blog or website. Simply add the plugin, enter your page details and place the widget in a sidebar or widget area.

Alternatively use the [kofi] shortcode in your page or in the shortcode block.

For more information see the help page at [ko-fi.com.](https://help.ko-fi.com/hc/en-us/articles/115004002614-Add-a-Ko-fi-button-to-your-WordPress-site)

= Help! The Default Code on my widget has changed =

With the release of 1.0.1 your Ko-fi code now comes from the settings page when using the shortcode or a widget. 

If you have not set your Ko-fi code in the settings page then simply update the Default Page Name/Id on the settings page, save the change and the widget will automatically pick it up.

= I'm getting errors with the widget after upgrading to the block widget editor =

In most instances there shouldn't be any issues upgrading to the block widget editor, but if you do encounter errors try removing the widget, saving, and adding the widget again.

= What options are available for the `[kofi]` shortcode? =

The following options are available:

* `type`: The type of Ko-fi widget to embed. Either `button` (default) or `panel`.
* `code`: Your Ko-fi username
* `text`: The button text (if using `button` type)
* `color`: The button background color (if using `button` type)

You don't need to provide any of the options unless required, the options will default to the settings from the plugin settings page if not specified.

= How can I control which pages the Floating Button displays on? =

By default, the floating button displays on every page when enabled. You can override it on individual posts and pages with the `Display floating button on this page` setting to hide on specific pages, or alternatively display only on specific pages when disabled globally.
For more advanced use cases, you can use the `kofi_display_floating_button` filter.

= Acknowledgements =

* Thanks to @mlchaves for his assistance with making the plugin php7.3 compliant.

== Screenshots ==

1. Ko-fi settings page, set the default settings of the button
2. Customise the button for a specific widget placement

== Changelog ==

= 1.3.0 =
* Intoduce new floating button options.

= 1.2.1 =
* Fix potential fatal error

= 1.2.0 =
* PHP 8 compatibility updates
* Replace third party color picker script with native color picker from WordPress core
* Improve reliability of default coffee code settings
* Code quality improvements

= 1.1.0 =
* Fix button alignment bug with themes that support full width aligned blocks
* Fix conflict with Elementor
* Add donation panel widget
* Expand shortcode capabilities to include changing the username and embed the donation panel
* Allow changing the username in the widget
* Additional security checks
* Code quality improvements

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
