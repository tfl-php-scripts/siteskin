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

if($siteSkin === null || !$siteSkin instanceof Robotess\SiteSkinEnhanced\SiteSkin) {
    echo 'WARNING: $siteSkin is null or of wrong type. Please make sure you included skinnerhead.php first';
    return;
}

$siteSkin->showFooter();