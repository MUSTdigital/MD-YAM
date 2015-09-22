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

## Description
This plugin can work with meta fields (metaboxes) and site options (options pages and admin dashboard widgets).

Thanks to [Wordpress Plugin Boilerplate](https://github.com/devinvinson/WordPress-Plugin-Boilerplate/) for a starting point!

## Installation and usage

Install MD YAM as any other plugin. You can make new fieldsets with the function `md_yam_mf()`. Basic code looks like that:

```php
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
```
This code will create a basic metabox with one text field. It will be added to all post types. Note that the variable `$fields` is an array of arrays. If you are using `md_yam_mf()` inside another plugin, don't dorget to place it in a function, hooked to `'md_yam_init'`, to avoid plugin order issues.

See options below to customize the metabox output or to work with site options.


## Frequently Asked Questions
#### Another one? How come?

This plugin was developed for internal use, but still it have some goodies to offer:

1. Unlike other frameworks, MD YAM allows to work with both meta fields and site options.
2. MD YAM is incredibly simple, so that almost any customization takes only couple of minutes.
3. New types of fields can be added easily.
4. MD YAM uses standart WP admin HTML markup. With default templates you can create options pages, that look absolutly like standart wordpress admin pages.
5. Tabs! Yep, creating tabs is as simple as that.
6. Custom templates. 


## Supported display variants and their options 
### 0. Common options
* **title** *(string, required)*. Title of the metabox.
* **id** *(string, required)*. ID of the metabox. Should be unique, and I'm not kidding.
* **group** *(string|bool, optional, default `NULL`)*. You can group fields by setting this option. This will make everything to be saved in one postmeta (or site option) as an array. If `true`, will be equal to the `id`.
* **thin** *(bool, optional, default `'false`)*. If set to `true`, the metabox will use thin styles (derived from core @media rules).
* **type** *(string, optional, default `'metabox'`)*. Type of the fieldset. See options below.

### 1. Metabox: 'type' => 'metabox'
* **post_type** *(string, optional, default `NULL`)*. Post type slug. See the `$screen` parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_meta_box#Parameters).
* **post_id** *(int|array, optional, default `NULL`)*. Post id. Single integer or an array of integers. The metabox would be shown only on the matched edit screens.
* **context** *(string, optional, default `'advanced'`)*. See the `$context` parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_meta_box#Parameters).

### 2. Dashboard widget: 'type' => 'dashboard'
This type doesn't have any special options yet.

### 3. Admin menu page: 'type' => 'menu_page'
* **short_title** *(string, optional, default `title`)*. The on-screen name text for the menu. See the `$menu_title` parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **capability** *(string, optional, default `'manage_options'`)*. The capability required for this menu to be displayed to the user. See the `$capability` parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **icon** *(string, optional, default `''`)*. The icon for this menu. See `$icon_url` parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).
* **position** *(string, optional, default `NULL`)*. The position in the menu order this menu should appear. See the `$position` parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_menu_page#Parameters).

### 4. Admin submenu page: 'type' => 'submenu_page'
* **parent** *(string, required)*. The slug name for the parent menu. See the `$parent_slug` parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).
* **short_title** *(string, optional, default `title`)*. The on-screen name text for the menu. See the `$menu_title` parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).
* **capability** *(string, optional, default `'manage_options'`)*. The capability required for this menu to be displayed to the user. See the `$capability` parameter on the [Codex](https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters).


## Field types and their options
Each field definition comprises two parts. First part consists of [common options](#common-properties) and second part consists of [special options](#special-properties). Special options vary due to field type and should be stored in an `'options'` key of a field array.

#### Available field types (by default).
* Basic inputs:
  * `text`
  * `textarea`
  * `checkbox`
  * `radio`
  * `select`
* HTML5 inputs. Almost any input which uses `<input type="%type%">` syntax:
  * `time`, `date`, `datetime`, `datetime-local`, `month`, `week`
  * `number`, `range`
  * `email`, `url`, `tel`
  * `color`
* Special inputs:
  * `wp-color` - [wpColorPicker](https://make.wordpress.org/core/2012/11/30/new-color-picker-in-wp-3-5/).
  * `tinymce` - [wp_editor](https://codex.wordpress.org/Function_Reference/wp_editor).
  * `posts` - posts dropdown.
  * `icon-picker`
  * `'wp-image'`, `'wp-file'` - [WP media uploader](https://codex.wordpress.org/Javascript_Reference/wp.media).
  * `'code-editor'` - [ACE Editor](http://ace.c9.io/).
* Non-inputs:
  * `heading`
  * `tab`

#### Common properties
* **title** *(string, required)*. Field title.
* **id** *(string, required)*. Field id. Should be unique.
* **type** *(string, required)*. Field type.
* **descripion** *(string, optional, default `NULL`)*. Description for the field.
* **default** *(any, optional, default `NULL`)*. Default value for the field.
* **values** *(string|array, required for certain field types)*. Available values.

#### Special properties
There are some common special properties, which can be used almost in every field. Theese are the standart HTML and HTML5 input attributes. See w3.org for details. All special properties are optional.
* **disabled** *(string|bool, optional, default `false`)*. 
* **required** *(string|bool, optional, default `false`)*.
* **readonly** *(string|bool, optional, default `false`)*.
* **multiple** *(string|bool, optional, default `false`)*. NB: this doesn't make a field repeatable. See [w3.org](http://www.w3.org/TR/2012/WD-html5-20121025/common-input-element-attributes.html#attr-input-multiple).
* **placeholder** *(string, optional, default `''`)*.
* **maxlength** *(string, optional, default `''`)*.
* **size** *(string, optional, default `''`)*.
* **pattern** *(string, optional, default `''`)*.
* **min** *(int|string, optional, default `''`)*. Used in the date, time and number fields.
* **max** *(int|string, optional, default `''`)*. Used in the date, time and number fields.
* **step** *(int|string, optional, default `''`)*. Used in the date, time and number fields.
* **class** *(string, optional, default varies due to a field type)*. You can use this option to set special class to the input. Note, this will replace default class (though there are not many of them). E.g. default class for a text field is `'regular-text'`.

##### Textarea
* **cols** *(int, optional, default `40`)*.
* **rows** *(int, optional, default `5`)*.

##### Tinymce
Note: may not work properly if `'group'` option is set. Working on 'at, pals.
* **tinymce** *(array, optional, default `array()`)*. An array of tinymce options. Will be passed directly to the `wp_editor`. See the [Codex](https://codex.wordpress.org/Function_Reference/wp_editor).

##### Posts dropdown ('posts')
You can pass a prearranged array of post objects in `'values'` field OR use the `'post_type'` special property.
* **post_type** *(string, optional, default `page`)*. Post type slug.

##### Icons ('icon-picker')
You can pass a prearranged array of icons names in `'values'` field. Don't forget to enqueue appropriate styles for admin area. If nothing is provided, script will use default Wordpress Dashicons. Examples will be added soon.
* **button_class** *(string, optional, default `button button-secondary fonticon-picker-button`)*. Class of upload button.
* **prefix** *(string, optional, default `dashicons dashicons-`)*. Prefix to be used with each icon name.

##### Image and file fields ('wp-image', 'wp-file')
This field types use default wordpress media upload feature. The main difference between this two types is the special thumbnail container in the image template. In addition, `wp-image` displays the thumbnail on an image.
* **button_class** *(string, optional, default `button button-secondary md-imagepicker-button` for `'wp-image'` and `button button-secondary md-filepicker-button` for `'wp-file'`)*. Class of upload button.
* **value_type** *(string, optional, default `id` for `'wp-image'` and `url` for `'wp-file'`)*. Type of attachment metadata you want to see as a value of an input. Many options are available, but I can't see why you'd want to use something different from `id` or `url`. Seriously, why would you?

##### Code editor ('code-editor')
Very basic implementation of ACE editor. To add new themes or languages you have to manually upload them to `assets/js/ace/` folder. I didn't add many of them, 'cause I didn't need to. Sorry. See [full list](https://github.com/ajaxorg/ace-builds/tree/master/src-min-noconflict) of themes and supported languages.
* **height** *(string, optional, default `100px`)*. Height of the editor.
* **width** *(string, optional, default `100%`)*. Width of the editor.
* **language** *(string, optional, default `''`)*. Programming language mode. Available by default: `css`, `html`, `javascript` and `php`.
* **theme** *(string, optional, default `''`)*. Theme of the editor. Available by default: `chrome` (light theme) and `monokai` (dark theme).


## Custom templates
You can override old and/or create new templates easily. Of course, you can just edit template files in /templates/ folder, but this can cause some problems with updating your MD YAM installation. Prefered way of working with custom templates is described below.

1. Copy entire `/templates/` folder to your theme root. If you use child theme -- to the child theme root.
2. Rename that folder to `'md-yam'`.
3. Type templates: `%THEME-ROOT%/md-yam/types/%FIELDSET-TYPE%.php`.
4. Field templates: `%THEME-ROOT%/md-yam/fields/%FIELD-TYPE%.php`.
5. Other templates (tabs, blocks, headings): `%THEME-ROOT%/md-yam/helpers/%TEMPLATE%.php`.


## Tabs and headings
#### Tabs
To create a tab just use the special field type `'tab'`. Yeah, that simple. It has only two parameters: `'type'` itself and `'title'`. All further fields (up to another tab or the end of an array) will be parts of this tab.

#### Headings
Use the special field type `'heading'` to create a heading. In addition to the `'type'` and the `'title'` parameters, heading has one special parameter -- `'tag'`, which defaults to `'h2'`.


## Changelog
##### 0.6.1
* Moved the entire plugin to the subdirectory
* Added readme.txt.
* Various fixes.


## Roadmap
### 1.0
* Repeatable fields support.
*  ~~Default WP color picker~~.
*  ~~Localization support~~.
* HTML5 input tweaks and fixes.
* Multicheck and multiselect
* Taxonomy meta fields. Integration with [Tax Meta Class](https://github.com/bainternet/Tax-Meta-Class)? 

## Licence
[GPLv2](http://www.gnu.org/licenses/gpl-2.0.html)
