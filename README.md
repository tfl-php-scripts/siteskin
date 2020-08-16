# Siteskin for PHP 7 [Robotess Fork]

The main repository with issue tracking is at gitlab: https://gitlab.com/tfl-php-scripts/siteskin

Original author is [Angela Sabas](https://github.com/angelasabas/siteskin) / Original readme is [here](public/readme.txt).

#### I would highly recommend not to use this script for new installations. Although some modifications were made, this script is still pretty old, not very secure, and does not have any tests, that's why please only update it if you have already installed it before.

This version requires at least PHP 7.2.

## Upgrading instructions

I'm not providing support for those who have version lower than 3.3.x.

If you are using Siteskin [Robotess Fork] 1.* (previously - 3.4.* (my version)):
- **Back up all your current files first.**
- Download an [archive of this repository](https://gitlab.com/tfl-php-scripts/siteskin/-/archive/master/siteskin-master.zip?path=public). Extract the archive and go to "public" directory.
- Replace the following files with the ones from "public" directory:
  - skinnerhead.php
  - skinnerfoot.php
  - SiteSkin.php

If you are using Siteskin 3.3.x (old version by Angela), also do the following:
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

Please follow the instructions carefully. A lot of issues were caused by users having incorrect config files.

That's it! Should you encounter any problems, please create an issue (here: https://gitlab.com/tfl-php-scripts/siteskin/-/issues), and I will try and solve it if I can. You can also report an issue via contact form: http://contact.robotess.net?box=scripts&subject=Issue+with+SiteSkin . Please note that I don't support fresh installations, only those that were upgraded from old version.
