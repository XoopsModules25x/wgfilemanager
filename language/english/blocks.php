<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgFileManager module for xoops
 *
 * @copyright    2021 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      wgfilemanager
 * @author       Goffy - Wedega - Email:webmaster@wedega.com - Website:https://xoops.wedega.com
 */

require_once __DIR__ . '/main.php';

// Admin Edit
\define('_MB_WGFILEMANAGER_DISPLAY', 'How Many Items to Display');
\define('_MB_WGFILEMANAGER_NAME_LENGTH', 'Name Length (0 = no length limit)');
// Directory
\define('_MB_WGFILEMANAGER_DIR_NAME', 'Name');
\define('_MB_WGFILEMANAGER_DIRECTORY_GOTO', 'Goto Directory');
\define('_MB_WGFILEMANAGER_DIRECTORY_HOME', 'Basic');
// File
\define('_MB_WGFILEMANAGER_FILE_DIRECTORY_ID', 'Directory');
\define('_MB_WGFILEMANAGER_FILE_NAME', 'Name');
\define('_MB_WGFILEMANAGER_FILE_GOTO', 'Goto File');
// Directory/Favorite list collapsable
\define('_MB_WGFILEMANAGER_DIRFAV_COL_TYPE', 'Anzeigetyp');
\define('_MB_WGFILEMANAGER_DIRFAV_COL_TYPE_0', 'Beide Listen aufklappbar');
\define('_MB_WGFILEMANAGER_DIRFAV_COL_TYPE_1', 'Nur Favoritenliste aufklappbar');
\define('_MB_WGFILEMANAGER_DIRFAV_COL_TYPE_2', 'Nur Verzeichnisliste aufklappbar');
