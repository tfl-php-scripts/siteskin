# Siteskin Enhanced (v 3.4)

####  I'm not the author of the script, original script is here: [Siteskin](https://github.com/angelasabas/siteskin)

[Siteskin](https://github.com/angelasabas/siteskin), but updated by me for PHP 7.4. Original readme by Angela is [here](public/readme.txt)

## Upgrading from 3.3.x

- **Back up all your current files first.**
- Download an [artifact with the script of this repository](https://gitlab.com/tfl-php-scripts/siteskin/builds/artifacts/master/download?job=downloader). Extract the archive.
- Update the following files:
  - skinnerhead.php
  - skinnerfoot.php
- Upload the following file:
  - SiteSkin.php
- Open up your skins.php page and replace this:
```php
<?php
show_skins( $skin, $skin_array );
require_once( 'skinnerfoot.php' );
?>
```
...with this:
```php
<?php
$siteSkin->showSkinsSelector();
require_once('skinnerfoot.php');
?>
```
    
That's it! In case of some problems and issues please create an issue here.
