# MD Yet Another Metafield
#### Table of contents
- [Description](#description)
- [Installation and usage](#installation-and-usage)
- [Frequently asked questions](#frequently-asked-questions)
- [Supported display variants and their options](#supported-display-variants-and-their-options)
- [Field types and their options](#field-types-and-their-options)
- [Changelog](#changelog)
- [Roadmap](#roadmap)
- [Licence](#licence)
- [Meta information](#meta-information)

## Description
This project is intended to be used as a part of any Wordpress plugin or theme.
It can work with meta fields (metaboxes) and site options (options pages
and admin dashboard widgets).

Thanks to [Wordpress Plugin Boilerplate](https://github.com/devinvinson/WordPress-Plugin-Boilerplate/) for a starting point!

## Installation and usage

Include MD YAM into your plugin or theme and require md-yam.php.

Setup new instance of MD_YAM_Fieldset class and add new fields. Basic code looks like that:

```php
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
$meta = new MD_YAM_Fieldset();
$meta->setup($options);
$meta->add_fields($fields);
$meta->run();
```
This code will create a basic metabox with one text field. It will be added to all post types by default. Note that variable $fields is an array of arrays.

See options below to customize metabox output or to work with site options.


## Frequently Asked Questions
#### Another one? How come?

This project was developed for internal use, in fact. But still it have some goodies to offer.

1. Unlike other frameworks, it can work with both meta fields and site options.
2. MD YAM is incredibly simple, so that any customization takes only couple of minutes.
3. New types of fields can be added easily.
4. MD YAM uses standart WP admin HTML markup. With default templates you can create options pages, that look absolutly like standart wordpress pages.
5. Tabs! Yep, creating tabs is as simple as that.


## Supported display variants and their options 
### 0. Common options
* **title** *(string, required)*. Title of the metabox.
* **id** *(string, required)*. ID of the metabox. Should be unique, and i'm not kidding.
* **group** *(string|bool, optional, default NULL)*. You can group fields by setting this option. This will make everything to be saved in one postmeta (or site option) as an array. If *true*, will be equal to the id.
* **thin** *(bool, optional, default 'false')*. If set to true, metabox will use thin styles (derived from core @media rules).
* **type** *(string, optional, default 'metabox')*. Set type of the fieldset. See options below.

### 1. Metabox: 'type' => 'metabox'
* **post_type** *(string, optional, default NULL)*. Post type slug. See $screen parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_meta_box#Parameters).
* **context** *(string, optional, default 'advanced')*. See $context parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_meta_box#Parameters).

### 2. Dashboard widget: 'type' => 'dashboard'
This type doesn't have any special options yet.

### 3. Admin menu page: 'type' => 'menu_page'
* **short_title** *(string, optional, default **title**)*. The on-screen name text for the menu. See $menu_title parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **capability** *(string, optional, default 'manage_options')*. The capability required for this menu to be displayed to the user. See $capability parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **icon** *(string, optional, default '')*. The icon for this menu. See $icon_url parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **position** *(string, optional, default NULL)*. The position in the menu order this menu should appear. See $position parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).

### 4. Admin submenu page: 'type' => 'submenu_page'
* **parent** *(string, required)*. The slug name for the parent menu. See $parent_slug parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).
* **short_title** *(string, required)*. The on-screen name text for the menu. See $menu_title parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).
* **capability** *(string, required)*. The capability required for this menu to be displayed to the user. See $capability parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).

## Field types and their options
Will be added soon.  

## Changelog
### 0.5.0
* Initial release

## Roadmap
### 0.7
* Multiply fields support.

### 1.0
* Taxonomy meta fields. Integration with [Tax Meta Class](https://github.com/bainternet/Tax-Meta-Class)? 

## Licence
[GPLv2](http://www.gnu.org/licenses/gpl-2.0.html)

## Meta information
* Contributors: mustdigital
* Tags: metabox, metafields, site options, options
* Requires at least: 4.3
* Tested up to: 4.3
* Stable tag: 0.5.0
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
