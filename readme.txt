=== Strong Testimonials ===
Contributors: cdillon27
Donate link: http://www.wpmission.com/donate
Tags: testimonials
Requires at least: 3.5
Tested up to: 3.9.2
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A simple yet robust testimonial manager.

== Description ==

Strong Testimonials by [WP Mission](http://www.wpmission.com) makes testimonials simple.

* **Show** with a variety of shortcodes or in a widget with transition effects.
* **Collect** through a customizable form with anti-spam options.
* **Manage** in the post editor including Featured Images and Categories.

> **This is a work in progress.** If you cannot tolerate occasional bugs and frequent updates, then please consider another plugin. 

> On the other hand, if you want: 
> * to participate in this plugin's development by offering ideas and feedback,
> * the prompt, personal attention of its developer (who will move mountains to resolve issues), 
> * popular features that other plugins offer at a price,
> then welcome aboard! You have been warned :)

= Coming soon: Get involved by voting on feature requests. =

**We are moving towards a vastly improved version 2.0 with flexible display components!**

= What's New in Version 1.8 =

Improved **cycle shortcode** options including: showing an **excerpt** of a testimonial, the entire content, or up to a certain length; a "Read more" link to the full testimonial or another page; and options to show the title, the featured image, and the client information or not.

Post Excerpt and Custom Fields now available in testimonial editor.

Skip loading the included stylesheets if you want to style it from the ground up.

Improved CSS including solving the long-standing width and float conflicts with some themes (YMMV). Tested in many popular themes including the [problematic](http://chrislema.com/wordpress-obesity/) [Avada](http://www.fklein.info/2013/05/overloaded-theme-problems/).

Improved i18n. Ready for translations.

= What's New in Version 1.7 =

Finally! [Custom fields](http://www.wpmission.com/tutorials/customize-the-form-in-strong-testimonials/). Change the testimonial submission form to meet your needs. Change which client fields appear underneath each testimonial.

= What's New in Version 1.6 =

Added support for the [Really Simple Captcha](http://wordpress.org/plugins/really-simple-captcha/) plugin which you may know from [Contact Form 7](http://wordpress.org/plugins/contact-form-7/). Nice!
Fixed a conflict with other plugins or themes also using the Cycle jQuery plugin.

= What's New in Version 1.5 =

A frequently requested feature, a **shortcode for rotating testimonials** on a page just like the widget.

= Primary Features =

* A customizable testimonial submission **form**.
* **Anti-spam** options.
* Administrator **notification** upon new testimonial submission.
* Multiple **shortcode** options including Cycle, All, Random, and Single.
* Multiple **widget** options including word limit, category selection, and random order.
* Use the WordPress post editor to **add and edit** testimonial content, including **thumbnail support** and **categories**.
* A developer dedicated to making it work.

*[Check out the screenshots for a better overview](http://wordpress.org/plugins/strong-testimonials/screenshots/).*

= Inspiration =

This is based on the popular [GC Testimonials](http://wordpress.org/plugins/gc-testimonials/). I have been very active in that plugin's support forum because I like its simplicity, I have used it on many sites, and I love to fix things.

Strong Testimonials aims to pick up where GC Testimonials left off while maintaining its simplicity.

= Future =

This plugin is under active development and all [ideas and feedback are welcome](http://www.wpmission.com/contact).

= Recommended =

[Simple Custom CSS](https://wordpress.org/plugins/simple-custom-css/) (100% compatible)

= Notes =

The administrator notification email function may not work with [WP Mail SMTP](https://wordpress.org/plugins/wp-mail-smtp/). I am working on this.

= Translations =

Can you help? [Contact me](http://www.wpmission.com/contact/).

== Installation ==

Option A: 

1. Go to `Plugins > Add New`.
1. Search for "strong testimonials".
1. Click "Install Now".

Option B: 

1. Download the zip file.
1. Unzip it on your hard drive.
1. Upload the `strong-testimonials` folder to the `/wp-content/plugins/` directory.

Option C:

1. Download the zip file.
1. Upload the zip file via `Plugins > Add New > Upload`.

Finally, activate the plugin.

I apologize for the lack of documentation. Adding features has taken precedence recently.

The default settings are designed to help you hit the ground running. Add the submission form shortcode to a page to start collecting testimonials. You can change the fields on the form in the fields editor. Other shortcodes and widgets allow you to display testimonials in various ways. 

If you have any questions or need help, use the [support forum](http://wordpress.org/support/plugin/strong-testimonials) or [contact me](http://www.wpmission.com/contact/).

== Anti-spam ==

Instead of reinventing the anti-spam wheel, Strong integrates other plugins to do the heavy lifting. Because spam is heavy. And modular is better.

To add CAPTCHA to the testimonial submission form:

1. install one of these supported plugins,
1. select that plugin on the `Testimonials > Settings` page.

Currently supported CAPTCHA plugins:

* [Captcha](http://wordpress.org/plugins/captcha/) by BestWebSoft
* [Simple reCAPTCHA](http://wordpress.org/plugins/simple-recaptcha) by WP Mission (that's me!)
* [Really Simple Captcha](http://wordpress.org/plugins/really-simple-captcha/) by Takayuki Miyoshi

Notes

* If the currently selected CAPTCHA plugin is deactivated, the setting will revert to "None".
* I plan to add an option for Akismet soon.
* [Contact me](http://www.wpmission.com/contact) if you have a plugin recommendation.


== Compared to GC Testimonials ==

= New Features and Fixes =

General

* Numerous code optimizations and PHP notice & error fixes.
* Using native WordPress functions and style, a best practice that makes it faster and futureproof and helps it play well with others.
* Multisite compatible with [Proper Network Activation](http://wordpress.org/plugins/proper-network-activation/) plugin. See FAQ below.
* A unique custom post type name of "wpm-testimonial" to prevent conflicts with other testimonial plugins (an infrequent but possible occurrence).

Display

* Simplified CSS.
* Process shortcodes in content (i.e. nested shortcodes).
* Thumbnail support specifically for testimonials, not all posts.

Admin

* Settings retained upon plugin deactivation.
* More efficient options storage means it's faster & easier to upgrade.
* Improved settings & shortcodes pages.
* Added category counts.

Submission form

* Updated [jQuery validation plugin](http://jqueryvalidation.org/), conditionally loaded.
* Client-side validation *plus* server-side validation, a best practice.
* CAPTCHA options (more info below).

Widget

* Updated [jQuery cycle plugin](http://jquery.malsup.com/cycle2/), conditionally loaded.
* Break on word boundary, not mid-word.
    * e.g. *"John is an asset . . ."* not *"John is an ass . . ."*
* Improved widget options.
* Order by: Random, Newest first, Oldest first.

== Frequently Asked Questions ==

= Why is "Fade" the only transition effect? =
See this [support thread](http://wordpress.org/support/topic/settings-bug-1).

= How can I change the fields on the form? =
On the `Testimonials > Fields` page, there is a field editor where you can add or remove fields, change field details, and drag-n-drop to reorder them. You can also restore the default fields. 

If you have ever used the Advanced Custom Fields or Custom Field Suite plugins, the editor will be very familiar.

Here is a [tutorial](http://www.wpmission.com/tutorials/customize-the-form-in-strong-testimonials/) - more to follow. Use the [support forum](http://wordpress.org/support/plugin/strong-testimonials) if you need help.

= How can I change which client information appears below the testimonial? =
On the `Testimonials > Settings` page, there is a Client Template. Follow the example to build shortcodes based on your custom fields. There is a shortcode for text fields (like a client's name) and a shortcode for links (like a client's website). A default template is included.

I admit it can greatly improved but I needed to build something quickly to include in version 1.7 with custom fields. The next major version will have a much better tool.

Use the [support forum](http://wordpress.org/support/plugin/strong-testimonials) if you need help.

= Is this multisite compatible? =
Yes, but I highly recommend first installing the [Proper Network Activation](http://wordpress.org/plugins/proper-network-activation/) plugin when adding Strong Testimonials to a multisite installation. That plugin will deftly handle the plugin activation process, thus ensuring each site has the default settings.

= Will it import my existing testimonials? =
Not yet, but the next major version will have an import function. If you have a ton of testimonials, you may want to wait.

= What about Akismet for the submission form? =
I plan to integrate Akismet soon.

= I modified my copy of GC Testimonials and I want to keep my features. =
I will gladly help add your modifications to a custom version of Strong Testimonials. In reality, I will likely steal your features and add them to a new version. You have been warned.

= I spent a lot of time adjusting the CSS to get GC Testimonials to work with my theme. Can I expect to do the same with this version? =
1. I simplifed the CSS so it will inherit as much from your theme as your other content and widgets, so you can probably trim down any custom CSS.
1. I will gladly help you sort it out.


== Screenshots ==

1. A sample page of three testimonials including photos.
2. The widget with a character limit of 200.
3. The widget without a character limit.
4. The testimonial submission form without CAPTCHA.
5. The math CAPTCHA option at the end of the form.
6. The reCAPTCHA option at the end of the form.
7. The settings page.
8. All the shortcode options.
9. The testimonials admin page.
10. Adding or editing a testimonial.
11. Adding or editing categories.
12. The widget settings in Cycle mode.
13. The same widget in Static mode.


== Changelog ==

= 1.8.1 =
* Fixed trailing comma error in JavaScript for IE 7 and 8.

= 1.8 =

* New features in cycle shortcode: Excerpt and "Read more" link.
* Solved CSS width and float conflicts with some themes.
* Ready for translations.

= 1.7.3 = 
* Fixed shortcode processing in widget content.

= 1.7.2 = 
* Fixed the update process.

= 1.7.1 =
* Fix for `Warning: Invalid argument supplied in foreach()` bugs.

= 1.7 =
* Custom fields on the testimonial submission form.
* Client fields underneath each testimonial via shortcodes.
* Improved activation/update process.
* Removed "Agree" checkbox from form.

= 1.6.2 =
* Fix conflict if jQuery Cycle plugin is enqueued by another plugin or theme.
* Fix conflict if using cycle shortcode and cycle widget on same page.
* All scripts local instead of via CDN.

= 1.6.1 =
* Bug fix where photo was not uploading with form submission.

= 1.6 =
* Added support for Really Simple Captcha plugin.

= 1.5.2 =
* Improved compatibility with earlier versions of PHP.

= 1.5.1 =
* Another bug fix for themes that set a width on the `content` class.

= 1.5 =
* Testimonial cycle shortcode.
* Improved reCAPTCHA error handling.
* Corrected text domain use.
* Fixed bug in widget character limit function.
* Fix for widget text that flows outside of sidebar.
* Fix bug in script registered/queued check.
* Improved plugin update procedure.
* Finally settled on a commenting style :)
	
= 1.4.7 =
* Removed line breaks on long input elements.
* Consistent self-closing input tags.

= 1.4.6 =
* Fixed bug: Copy-n-pasting shortcodes onto a page in Visual mode included `<code>` tags which fubar'd the page.

= 1.4.5 =
* Fixed bug: The form shortcode was being rendered before any accompanying page content.

= 1.4.4 =
* New minimum WordPress version: 3.5.
* Added shims for `has_shortcode` and `shortcode_exists` for WordPress version 3.5.
* Changed `save_post_{post-type}` to `save_post` for WordPress version 3.6.

= 1.4.3 =
* Improved compatibility with earlier versions of PHP.

= 1.4.2 =
* Fixed bug: missing categories in admin testimonials table.

= 1.4.1 =
* Fixed bug in category filter in the widget.

= 1.4 =
* Initial version, a fork of GC Testimonials 1.3.2.


== Upgrade Notice ==

= 1.8.1 =
Fixed a minor bug in Internet Explorer 7 or 8.

= 1.8 =
New features in cycle shortcode: Excerpt and "Read more" link. Solved CSS width and float conflicts with some themes. Ready for translations.

= 1.7.3 =
Fixed shortcode processing in widget content.

= 1.7.2 =
Fixed the update process.

= 1.7.1 =
Bugfix for `Warning: Invalid argument supplied in foreach()`.

= 1.7 =
Custom fields. Finally!

= 1.6.2 =
Fix conflicts with multiple uses of jQuery Cycle plugin.

= 1.6.1 =
Bug fix where photo was not uploading with form submission.

= 1.6 =
Added support for Really Simple Captcha plugin.

= 1.5.2 = 
Improved compatibility with earlier versions of PHP.

= 1.5.1 =
Another bug fix for themes that set a width on the `content` class.

= 1.5 =
New cycle shortcode. Bug fixes.

= 1.4.7 =
Improved code formatting to prevent a low-probability rendering problem.

= 1.4.6 =
Fixed a bug when copy-n-pasting a shortcode.

= 1.4.5 =
Fixed a bug where the form shortcode pushed other page content below.

= 1.4.4 =
Definitely update if you are running WordPress 3.5 or 3.6.

= 1.4.3 = 
Improved compatibility with earlier versions of PHP.

= 1.4.2 =
Fixed a minor bug that did not show multiple categories in the admin testimonials list.

= 1.4.1 =
Fixed a minor bug if a category was selected in the widget settings.
