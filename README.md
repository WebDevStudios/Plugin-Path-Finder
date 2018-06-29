# Plugin Path Finder
A small WordPress utility to enhance the capabilities of `plugin_dir_path`
and `plugin_dir_url`.

The methods in this library will allow you to find the root path of your
plugin or the URL to any asset in that plugin without needing to set up
complex file or dependency injection structures.

## Installation
This package can be installed a couple of different ways. It was
originally developed as a small mu-plugin, so you could clone down
this directory and then add the `plugin-path-finder.php` file to
your mu-plugins directory.

Alternately, you can install it via Composer:
`composer require webdevstudios/plugin-path-finder`. It's registered
as a regular library, so you'll need to include the Composer
autoload.php file from somewhere within your WordPress installation.

## Usage
Once the library is installed, you can access the namespaced methods
by adding them to the top of your PHP file, or by calling the full
namespaced method:

```
use function WDS\Utils\PluginPathFinder\get_plugin_dir;
use function WDS\Utils\PluginPathFinder\get_plugin_url;

...

function some_function() {
    $dir = get_plugin_dir( __FILE__ );
    $url = get_plugin_url( $dir . '/assets/some-asset.css' );
}
```

*IMPORTANT: These methods must only be called after the `plugins_loaded`
action, or PHP will throw a fatal error.*