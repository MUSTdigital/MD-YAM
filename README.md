# MD Yet Another Metafield
* Contributors: mustdigital
* Tags: metabox, metafields, site options, options
* Requires at least: 4.3
* Tested up to: 4.3
* Stable tag: 0.5.0
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Description
This project is intended to be used as a part of any Wordpress plugin or theme.
It can work with meta fields (metaboxes) and site options (options pages
and admin dashboard widgets).

Thanks to [Wordpress Plugin Boilerplate](https://github.com/devinvinson/WordPress-Plugin-Boilerplate/) for a starting point!

## Installation and usage

Include MD YAM into your plugin or theme and require md-yam.php.

Setup new instance of MD_YAM_Fieldset class and add new fields. Basic code looks like that:

```
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
This will create a basic metabox with one text field. It will be added to all post types by default. Note that $fields variable is an array of arrays.

See options below to customize metabox output or to work with site options.


## Frequently Asked Questionse
#### Another one? How come?

This project was developed for internal use, in fact. But still it have some goodies to offer.
1. Unlike other frameworks, it can work with both meta fields and site options.
2. MD YAM is incredibly simple, so that any customization takes only couple of minutes.
3. New types of fields can be added easily.
4. MD YAM uses standart WP admin HTML markup. With default templates you can create options pages, that look absolutly like standart wordpress pages.
5. Tabs!


## Supported display variants and their options 
### 0. Common options
* **title**: string, required. Title of the metabox.
* **id**: string, required. ID of the metabox. Should be unique, and i'm not kidding.
* **group**: string, optional, default ''. You can group fields by setting this option. This will make everything to be saved in one postmeta (or site option) as an array.
* **thin**: bool, optional, default 'false'. With 'thin' set to true, metabox will use thin styles (derived from core @media rules).
* **type**: string, optional, default 'metabox'.

### 1. Metabox: 'type' => 'metabox'
* **post_type**: string, optional, default NULL. Post type slug. See $screen parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_meta_box#Parameters).
* **context**: string, optional, default 'advanced'. See $context parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_meta_box#Parameters).

### 2. Dashboard widget: 'type' => 'dashboard'
This type doesn't have any special options yet.

### 3. Admin menu page: 'type' => 'menu_page'
* **short_title**: string, required. The on-screen name text for the menu. See $menu_title parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **capability**: string, required. The capability required for this menu to be displayed to the user. See $capability parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **icon**: string, optional, default ''. The icon for this menu. See $icon_url parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **psition**: string, optional, default NULL. The position in the menu order this menu should appear. See $position parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).

### 4. Admin submenu page: 'type' => 'submenu_page'
* **parent**: string, required. The slug name for the parent menu. See $parent_slug parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).
* **short_title**: string, required. The on-screen name text for the menu. See $menu_title parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).
* **capability**: string, required. The capability required for this menu to be displayed to the user. See $capability parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).

## Field types and their options
Will be added soon.  

## Changelog
### 0.5.0
* Initial release

## Roadmap