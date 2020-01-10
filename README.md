# Siteskin Enhanced (v 3.4)

####  I'm not the author of the script, initial one is here: [Siteskin](https://github.com/angelasabas/siteskin)

[Siteskin](https://github.com/angelasabas/siteskin), but updated by me for PHP 7.4. Original readme by Angela is [here](public/readme.txt)

## Upgrading from 3.3.x

- **Back up all your current files first.**
- Download an [archive of this repository](https://gitlab.com/tfl-php-scripts/siteskin/-/archive/master/siteskin-master.zip). Extract the archive and go to "public" directory.
-   1. Update the following files with the ones from "public" directory:
          skinnerhead.php
          skinnerfoot.php
    2. Upload the following file:
          SiteSkin.php
    3. Open up your skins.php page and replace this:
          <?php
          show_skins( $skin, $skin_array );
          require_once( 'skinnerfoot.php' );
          ?>
       ...with this:
          <?php
          $siteSkin->showSkinsSelector();
          require_once('skinnerfoot.php');
          ?>
    
That's it! In case of some problems and issues please create an issue here.