<?php
/******************************************************************************
 * SiteSkin: Easy Site Skinning Script
 * Script by Angela Sabas (http://scripts.indisguise.org)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * For more information please view the readme.txt file.
 ******************************************************************************/

namespace Robotess\SiteSkinEnhanced;

class SiteSkin
{
    private $defaultSettings = ['debug' => false];
    private $currentSkin;
    private $availableSkins;

    private $settings;

    /**
     * SiteSkin constructor.
     * @param $settingsFileName
     */
    public function __construct($settingsFileName)
    {
        $this->settings = array_merge($this->defaultSettings, $this->retrieveSettingsFromConfigFile($settingsFileName));

        // debug or not?
        if ($this->settings['debug']) {
            ERROR_REPORTING(E_ALL);
        } else {
            ERROR_REPORTING(0);
        }
    }

    /**
     * function to clean input strings for script
     *
     * @param $data
     * @return string
     */
    private function cleanString($data)
    {
        $data = trim(htmlentities(strip_tags($data), ENT_QUOTES));
        $data = addslashes($data);
        return $data;
    }

    private function showWarning($string)
    {
        if ($this->settings['debug']) {
            echo '<p style="font-weight: bold; color: #990000; font-size: 12px;">' . $string . '</p>';
        }
    }

    public function showHeader()
    {
        // check skins_dir format
        if (substr($this->settings['skins_dir'], -1) !== '/') {
            // if there is no trailing slash, add it
            $this->settings['skins_dir'] .= '/';
        }

        // read skins folder
        $skindir = opendir($this->settings['skins_dir']);
        $this->availableSkins = [];
        while (false !== ($file = readdir($skindir))) {
            if (is_dir($this->settings['skins_dir'] . $file) && $file !== '.' && $file !== '..') {
                $this->availableSkins[] = $file;
            }
        }

        // find out if this is a first visit
        // or verify if their skin cookie is valid
        $isFirstVisit = false;
        if (isset($_GET['skin']) && $_GET['skin'] !== '') {
            // check if the skin still exists, if not, treat it as a first visit
            if ($_GET['skin'] > count($this->availableSkins)) {
                $isFirstVisit = true;
            } else {
                // change skin
                $this->currentSkin = $this->cleanString($_GET['skin']) - 1;
                setcookie($this->settings['cookie_name'], $this->currentSkin, time() + 60 * 60 * 24 * 30);
            }
        } elseif (isset($_COOKIE[$this->settings['cookie_name']])) {
            // load skin from cookie
            $this->currentSkin = $this->cleanString($_COOKIE[$this->settings['cookie_name']]);
            // check if the skin still exists, if not, treat it as a first visit
            if ($this->currentSkin >= count($this->availableSkins)) {
                $isFirstVisit = true;
            } else {// refresh cookie
                setcookie($this->settings['cookie_name'], $this->currentSkin, time() + 60 * 60 * 24 * 30);
            }
        } else {
            $isFirstVisit = true;
        }

        // this is the first visit of the visitor
        // or the skin they previously set is missing
        // or their cookie has expired
        // so show him the default skin
        if ($isFirstVisit) {
            $this->currentSkin = 0;
            $isDefaultSkinInvalid = false;

            // initialize
            if (isset($this->settings['default_skin'])
                && $this->settings['default_skin'] > 0
                && $this->settings['default_skin'] <= count($this->availableSkins)) {
                $this->currentSkin = $this->settings['default_skin'] - 1;
            } else { // the default skin is invalid or there's nothing set, so get random
                $isDefaultSkinInvalid = true;
                $this->currentSkin = mt_rand(0, count($this->availableSkins) - 1);
            }
            setcookie($this->settings['cookie_name'], $this->currentSkin, time() + 60 * 60 * 24 * 30);

            if($isDefaultSkinInvalid) {
                $this->showWarning('WARNING: You have no correct default skin set. Setting you with a random one until you choose one yourself');
            }
        }

        // find out if the header file is there
        // php first, then html, then none
        if (is_file($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/header.php')) {
            require_once($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/header.php');
        } elseif (is_file($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/header.html')) {
            require_once($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/header.html');
        } elseif (is_file($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/header.htm')) {
            require_once($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/header.htm');
        } else {
            $this->showWarning('WARNING: No header file found. Check your skin directory setting and contents.');
        }
    }

    public function showSkinsSelector($showCurrent = true)
    {
        $ext = 'gif';
        if (isset($this->settings['thumb_extension'])) {
            $ext = $this->settings['thumb_extension'];
        }

        if ($showCurrent) {
            echo '<p class="skin">';
            echo 'Current skin:<br />';

            echo '<img src="' . $this->settings['web_skins_dir'] . $this->availableSkins[$this->currentSkin] . '/thumb.' .
                $ext . '" border="0" alt=" current skin" class="skin" />';
            echo '</p>';
            echo '<p class="skin">Select your skin:<br />';
        }

        // set up url
        $pageinfo = pathinfo($_SERVER['PHP_SELF']);
        $page = $pageinfo['basename'];
        $connector = '?';
        if (isset($_GET)) {
            foreach ($_GET as $get => $value) {
                if ($get !== 'skin') {
                    $page .= $connector . $get . '=' . $value;
                    $connector = '&amp;';
                }
            }
        }

        $i = 1;
        foreach ($this->availableSkins as $skin_select) {
            $alt_file = fopen($this->settings['skins_dir'] . $skin_select . '/alt.txt', 'rb');
            $alt_text = fgets($alt_file);
            fclose($alt_file);
            echo '<a href="' . $page . $connector . 'skin=' . $i . '">';
            echo '<img src="' . $this->settings['web_skins_dir'] . $skin_select . '/thumb.' . $ext .
                '" alt="' . $alt_text . '" title="' . $alt_text . '" class="skin" /></a> ';
            $i++;
        }

        if ($showCurrent) {
            echo '</p>';
        }

        // show link -- do not remove
        echo '<p style="text-align: center;">';
        echo '<a href="http://scripts.indisguise.org" target="_blank">';
        echo 'Powered by SiteSkin';
        echo '</a> &middot; <a href="http://scripts.robotess.net" title="PHP Scripts collections" target="_blank">';
        echo 'Version <b>3.4</b> for PHP >= 7';
        echo '</a></p>';
    }

    public function showFooter()
    {
        // find out if the header file is there
        // php first, then html, then none
        if (is_file($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/footer.php')) {
            require_once($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/footer.php');
        } elseif (is_file($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/footer.html')) {
            require_once($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/footer.html');
        } elseif (is_file($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/footer.htm')) {
            require_once($this->settings['skins_dir'] . $this->availableSkins[$this->currentSkin] . '/footer.htm');
        } else {
            $this->showWarning('WARNING: No footer file found. Check your skin directory setting and contents.');
        }
    }

    /**
     * @param $settingsFileName
     * @return array
     */
    private function retrieveSettingsFromConfigFile($settingsFileName)
    {
        $settings = [];

        require $settingsFileName;
        $availableParams = ['event', 'skins_dir', 'cookie_name', 'thumb_extension', 'web_skins_dir', 'default_skin', 'debug'];
        foreach ($availableParams as $paramName) {
            if(isset($$paramName)){
                $settings[$paramName] = $$paramName;
            }
        }

        return $settings;
    }
}