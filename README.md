# MD Yet Another Metafield
#### Table of contents
- [Description](#description)
- [Installation and usage](#installation-and-usage)
- [Frequently asked questions](#frequently-asked-questions)
- [Supported display variants and their options](#supported-display-variants-and-their-options)
- [Field types and their options](#field-types-and-their-options)
- [Custom templates](#custom-templates)
- [Tabs and headings](#tabs-and-headings)
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
4. MD YAM uses standart WP admin HTML markup. With default templates you can create options pages, that look absolutly like standart wordpress admin pages.
5. Tabs! Yep, creating tabs is as simple as that.
6. Custom templates. 


## Supported display variants and their options 
### 0. Common options
* **title** *(string, required)*. Title of the metabox.
* **id** *(string, required)*. ID of the metabox. Should be unique, and i'm not kidding.
* **group** *(string|bool, optional, default NULL)*. You can group fields by setting this option. This will make everything to be saved in one postmeta (or site option) as an array. If *true*, will be equal to the id.
* **thin** *(bool, optional, default 'false')*. If set to true, metabox will use thin styles (derived from core @media rules).
* **type** *(string, optional, default 'metabox')*. Set type of the fieldset. See options below.

### 1. Metabox: 'type' => 'metabox'
* **post_type** *(string, optional, default NULL)*. Post type slug. See $screen parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_meta_box#Parameters).
* **post_id** *(int|array, optional, default NULL)*. Post id. Single integer or an array of integers. Metabox would be shown only on matched edit screens.
* **context** *(string, optional, default 'advanced')*. See $context parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_meta_box#Parameters).

### 2. Dashboard widget: 'type' => 'dashboard'
This type doesn't have any special options yet.

### 3. Admin menu page: 'type' => 'menu_page'
* **short_title** *(string, optional, default title)*. The on-screen name text for the menu. See $menu_title parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **capability** *(string, optional, default 'manage_options')*. The capability required for this menu to be displayed to the user. See $capability parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **icon** *(string, optional, default '')*. The icon for this menu. See $icon_url parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **position** *(string, optional, default NULL)*. The position in the menu order this menu should appear. See $position parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).

### 4. Admin submenu page: 'type' => 'submenu_page'
* **parent** *(string, required)*. The slug name for the parent menu. See $parent_slug parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).
* **short_title** *(string, required)*. The on-screen name text for the menu. See $menu_title parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).
* **capability** *(string, required)*. The capability required for this menu to be displayed to the user. See $capability parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).

## Field types and their options
Each field array consists of two parts. First part consists of [common options](#common-properties) and [special options](#special-properties). Special options vary due to field type and should be stored in an 'options' key of a field array.

#### Available field types (by default).
* 'text'
* 'textarea'
* 'tinymce' (wp_editor)
* 'checkbox'
* 'radio'
* 'select'
* HTML5 fields:
  * 'date'
  * 'time'
  * 'email'
  * 'url'
  * 'number'
  * 'color'
  * 'range'
* special types (non-fields):
  * 'heading'
  * 'tab'

#### Common properties
* **title** *(string, required)*. Field title.
* **id** *(string, required)*. Field id. Should be unique.
* **type** *(string, required)*. Field type.
* **descripion** *(string, optional, default NULL)*. Description for the field.
* **default** *(any, optional, default NULL)*. Default value for the field.
* **values** *(array, required for certain field types)*. Available values. Can be plain array (then an index will be used as a value) or 'value'=>'title' array. Titles are used for display puprose, and values will be, hmm, values themselves. Currently used by select and radio inputs.

#### Special properties
There are some common special properties, which can be used almost in every field. Theese are standart HTML and HTML5 input attributes. See w3.org for details. All of special properties are optional.
* **disabled** *(string|bool, optional, default false)*. 
* **required** *(string|bool, optional, default false)*.
* **readonly** *(string|bool, optional, default false)*.
* **multiple** *(string|bool, optional, default false)*. NB: this doesn't make field repeatable. See [w3.org](http://www.w3.org/TR/2012/WD-html5-20121025/common-input-element-attributes.html#attr-input-multiple).
* **placeholder** *(string, optional, default '')*.
* **maxlength** *(string, optional, default '')*.
* **size** *(string, optional, default '')*.
* **pattern** *(string, optional, default '')*.
* **min** *(int|string, optional, default '')*. Used in date, time and number fields.
* **max** *(int|string, optional, default '')*. Used in date, time and number fields.
* **step** *(int|string, optional, default '')*. Used in date, time and number fields.
* **class** *(string, optional, default varies due to field type)*. You can use this option to set special class to the input. Note, this will replace default class (though there are not many of them). E.g. default class for text field is 'regular-text'.

##### Textarea
* **cols** *(int, optional, default 40)*.
* **rows** *(int, optional, default 5)*.

##### Tinymce
* **tinymce** *(array, optional, default array())*. An array of tinymce options. Will be passed directly to wp_editor. See the [Codex](https://codex.wordpress.org/Function_Reference/wp_editor).

## Custom templates
You can override old and/or create new templates easily. Of course, you can just edit default templates, but this can cause some problems with updating your MD YAM installation. Prefered way of working with custom templates is described below.

1. Copy entire /templates/ folder to your theme root. If you use child theme -- to the child theme root.
2. Rename that folder to 'md-yam'.
3. Type templates: %THEME-ROOT%/md-yam/types/%FIELDSET-TYPE%.php
4. Field templates: %THEME-ROOT%/md-yam/fields/%FIELD-TYPE%.php

Type template can use prerendered HTML with all fields. Field template can use $meta variable, which contains all field options plus it's value.

## Tabs and headings
#### Tabs
To create a tab just use a special field type 'tab'. It has only to parameters: 'type' itself and 'title'. All further fields (up to another tab or the end of an array) will be part of this tab.

#### Headings
Use special field type 'heading' to create a heading. Yeah, that simple. In addition to 'type' and 'title' parameters, heading has one special parameter -- 'tag', which defaults to 'H2'.

## Changelog
##### 0.5.2
* Added *default* field option.
* Added custom templates system.

##### 0.5.1
* Added *post_id* fieldset option.

##### 0.5.0
* Initial release

## Roadmap
### 0.6
* [ ] Default WP color picker.
* [ ] Other HTML5 input tweaks.
* [ ] 'Required' fix.

### 0.7
* Multiply fields support.

### 0.8
* Taxonomy meta fields. Integration with [Tax Meta Class](https://github.com/bainternet/Tax-Meta-Class)? 

## Licence
[GPLv2](http://www.gnu.org/licenses/gpl-2.0.html)

## Meta information
* Contributors: mustdigital
* Tags: metabox, metafields, site options, options
* Requires at least: 4.3
* Tested up to: 4.3
* Stable tag: 0.5.21
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
