# UOD Custom CSS Class to Body
Custom CSS Class to body module is used to add custom class to <body> tag specific to
node.

Settings form will allow to add the CSS Class, select the existing nodes (article & page) (for which you want to add the css class).

## Dependencies
* [Select2 library](https://select2.org/) (>=4.0.x)

## Installation
Install this module like every other Drupal module. Also it's needed to download the select2 library.

### Composer (recommended)
In order to download the module and its dependencies, you need to add the following to your root composer.json file into the repositories section:

```json
    {
        "type": "composer",
        "url": "https://asset-packagist.org"
    },
    {
        "type": "vcs",
        "url": "git@github.com:pareshpate/uod_custom_css_class_to_body.git"
    }
```

It's also needed to extend the 'installer-path' section:

```json
    "web/libraries/{$name}": [
        "type:drupal-library",
        "type:bower-asset",
        "type:npm-asset"
    ],
```
And add a new 'installer-types' section next to the 'installer-path' in the 'extra' section:

```json
    "installer-types": ["bower-asset", "npm-asset", "drupal-library"],
```

After this you can download the custom module with required dependencies using "composer require pareshpate/uod_custom_css_class_to_body:dev-main". Custom module will be downloaded into the custom folder and the library will be downloaded into the libraries folder.
