=== MD Yet Another Metafield ===
Contributors: mustdigital
Tags: metabox, metafields, site options, options, fieldset
Requires at least: 4.3
Tested up to: 4.3
Stable tag: 0.6.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin can work with post meta fields (metaboxes), user meta and site options (options pages and admin dashboard widgets).

== Description ==
This plugin can work with post meta fields, user meta and site options. All-in-one solution. Post metaboxes, user meta fields, admin menu and submenu pages, dashboard widgets - MD YAM works with any of that. Taxonomy terms meta fields will be added soon.

== Installation ==
Install MD YAM as any other plugin. You can make new fieldsets with the function `md_yam_mf()`. Basic code looks like that:

`
function my_metabox() {

    $options = [
        'title' => 'Test metabox',
        'id' => 'unique_id'
    ];

    $fields = [
        [
            'title' => 'Textield',
            'type' => 'text',
            'id' => 'unique_meta_id',
        ]
    ];

    md_yam_mf( $options, $fields );

}
add_action('md_yam_init', 'my_metabox');
`
This code will create a basic metabox with one text field. It will be added to all post types. Note that the variable `$fields` is an array of arrays. If you are using `md_yam_mf()` inside another plugin, don't dorget to place it in a function, hooked to `'md_yam_init'`, to avoid plugin order issues.

See [GitHub repo](https://github.com/MUSTdigital/md-yam) for full readme and support.

== Frequently Asked Questions ==
= Another one? How come? =
1. Unlike other frameworks, MD YAM is all-in-one solution. Post metaboxes, user meta fields, admin menu and submenu pages, dashboard widgets - MD YAM works with any of that. Taxonomy terms meta fields will be added soon.
2. MD YAM is incredibly simple, so that almost any customization takes only couple of minutes.
3. New types of fields can be added easily.
4. MD YAM uses standart WP admin HTML markup. With default templates you can create options pages, that look absolutly like standart wordpress admin pages.
5. Tabs! Yep, creating tabs is as simple as that.
6. Custom templates. 

== Changelog ==
= 0.6.3 =
* Some rearrangement. 
* Added user meta fields support.

= 0.6.2 =
* Added admin page, which shows all fieldsets with corresponding fields.

= 0.6.1 =
* Moved the entire plugin to the subdirectory
* Added readme.txt.
* Various fixes.

= 0.6.0 =
* MD YAM is a plugin. Again.
* Full localization support.
* Restructure.
* Various fixes.
* Changed the way of creating a fieldset.

= 0.5.8 =
* Added the `'code-editor'` field type.
* Scripts and styles are enqueued on demand.
* Various fixes.

= 0.5.7 =
* Added the `'wp-image'` and `'wp-file'` field types.
* Added standart options to `'icon-picker'`.

= 0.5.6 =
* Added the `'icon-picker'` field type. Uses modified [Dashicons Picker](https://github.com/bradvin/dashicons-picker/) by bradvin.

= 0.5.5 =
* Added the posts dropdown.
* Select fix.
* Options checks fix.
* Other fixes.

= 0.5.4 =
* Added the default WordPress color-picker. The type is called `wp-color`, because I have another plans for `color`.

= 0.5.3 =
* Rearranged templates.
* Set the text field type as default.
* The tabs navigation appears right before the tab content.

= 0.5.2 =
* Added the `'default'` field option.
* Added the custom templates system.

= 0.5.1 =
* Added the `'post_id'` fieldset option.

= 0.5.0 =
* Initial release.