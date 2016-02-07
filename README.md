# MD Yet Another Metafield
#### Table of contents
- [Description](#description)
- [Installation and usage](#installation-and-usage)
- [Frequently asked questions](#frequently-asked-questions)
- [Changelog](#changelog)
- [Roadmap](#roadmap)
- [Licence](#licence)

## Description
This plugin can work with post meta fields (metaboxes), user meta, term meta and site options (options pages and admin dashboard widgets). Theme customizer is not supported yet.
See full [documentation](https://github.com/MUSTdigital/md-yam/wiki).

## Installation and usage

Install MD YAM as any other plugin. You can make new fieldsets with the function `md_yam_mf()`. Basic code looks like that:

```php
    function my_metabox() {

        $options = [
            'title' => 'Test metabox',
            'id'    => 'unique_id'
        ];
        $fields = [
            [
                'title' => 'Textield',
                'type'  => 'text',
                'name'  => 'unique_meta_id'
            ]
        ];
        md_yam_mf( $options, $fields );

    }
    add_action('md_yam_init', 'my_metabox');
```
This code will create a basic metabox with one text field. It will be added to all post types. Note that the variable `$fields` is an array of arrays. If you are using `md_yam_mf()` inside another plugin, don't dorget to place it in a function, hooked to `'md_yam_init'`, to avoid plugin order issues.

## Frequently Asked Questions
#### Another one? How come?

This plugin was developed for internal use, but still it have some goodies to offer:

1. The main goal of this plugin is to provide a simple yet powerful interface to all kinds of metadata without messing with the database.
2. MD YAM is incredibly simple, so that almost any customization takes only couple of minutes.
3. New types of fields can be added easily.
4. MD YAM uses standart WP admin HTML markup. With default templates you can create options pages, that look absolutly like standart wordpress admin pages.
5. Tabs! Yep, creating tabs is as simple as that.
6. Custom templates.

## Changelog
##### 0.7.2
* Various fixes.

## Roadmap
### 1.0
* [ ] Repeatable fields support.
* [ ] Admin columns
* [x] Default WP color picker.
* [x] Localization support.
* [x] Helper function to get the values of fields.
* [x] HTML5 input tweaks and fixes.
* [x] Multicheck and multiselect
* [x] Taxonomy meta fields.

## Licence
[GPLv2](http://www.gnu.org/licenses/gpl-2.0.html)
