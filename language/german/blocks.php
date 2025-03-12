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
\define('_MB_WGFILEMANAGER_DISPLAY', 'Wie viele Einträge anzeigen');
\define('_MB_WGFILEMANAGER_NAME_LENGTH', 'Länge Namen (0 = keine Längenbeschränkung=');
// Directory
\define('_MB_WGFILEMANAGER_DIR_NAME', 'Name');
\define('_MB_WGFILEMANAGER_DIRECTORY_GOTO', 'Gehe zu Verzeichnis');
\define('_MB_WGFILEMANAGER_DIRECTORY_HOME', 'Standardverzeichnis');
// File
\define('_MB_WGFILEMANAGER_FILE_DIRECTORY_ID', 'Verzeichnis');
\define('_MB_WGFILEMANAGER_FILE_NAME', 'Name');
\define('_MB_WGFILEMANAGER_FILE_GOTO', 'Gehe zu Datei');
// Directory/Favorite list collapsable
\define('_MB_WGFILEMANAGER_DIRFAV_COL_TYPE', 'Display Type');
\define('_MB_WGFILEMANAGER_DIRFAV_COL_TYPE_0', 'Both lists collapsable');
\define('_MB_WGFILEMANAGER_DIRFAV_COL_TYPE_1', 'Only favorite list collapsable');
\define('_MB_WGFILEMANAGER_DIRFAV_COL_TYPE_2', 'Only directory list collapsable');
