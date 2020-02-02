# Siteskin Enhanced (v 3.4)

####  I'm not the author of the script, original script is here: [Siteskin](https://github.com/angelasabas/siteskin)

[Siteskin](https://github.com/angelasabas/siteskin), but updated by me for PHP 7. Original readme by Angela is [here](public/readme.txt)

## Upgrading from 3.3.x

- **Back up all your current files first.**
- Download an [archive of this repository](https://gitlab.com/tfl-php-scripts/siteskin/-/archive/master/siteskin-master.zip?path=public). Extract the archive and go to "public" directory.
- Replace the following files with the ones from "public" directory:
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
    
That's it! Should you encounter any problems, please create an issue here, and I will try and solve it if I can.
