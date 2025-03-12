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

require_once __DIR__ . '/common.php';

// ---------------- Admin Main ----------------
\define('_MI_WGFILEMANAGER_NAME', 'wgFileManager');
\define('_MI_WGFILEMANAGER_DESC', 'Dieses Modul verwaltet Dateien und Verzeichnisse');
// ---------------- Admin Menu ----------------
\define('_MI_WGFILEMANAGER_ADMENU1', 'Übersicht');
\define('_MI_WGFILEMANAGER_ADMENU2', 'Verzeichnisse');
\define('_MI_WGFILEMANAGER_ADMENU3', 'Dateien');
\define('_MI_WGFILEMANAGER_ADMENU4', 'Fehlerhafte Einträge');
\define('_MI_WGFILEMANAGER_ADMENU5', 'Mime Types');
\define('_MI_WGFILEMANAGER_ADMENU6', 'Berechtigungen');
\define('_MI_WGFILEMANAGER_ADMENU7', 'Klonen');
\define('_MI_WGFILEMANAGER_ADMENU8', 'Feedback');
\define('_MI_WGFILEMANAGER_ADMENU9', 'Favoriten');
\define('_MI_WGFILEMANAGER_ABOUT', 'Über');
// ---------------- Admin Nav ----------------
\define('_MI_WGFILEMANAGER_ADMIN_PAGER', 'Admin Bereich');
\define('_MI_WGFILEMANAGER_ADMIN_PAGER_DESC', 'Anzahl Einträge Listen im Admin Bereich');
// User
\define('_MI_WGFILEMANAGER_USER_PAGER', 'Benutzer Bereich');
\define('_MI_WGFILEMANAGER_USER_PAGER_DESC', 'Anzahl Einträge Listen im Benutzer Bereich');
// Submenu
\define('_MI_WGFILEMANAGER_SMNAME1', 'Index Seite');
\define('_MI_WGFILEMANAGER_SMNAME2', 'Verzeichnis');
\define('_MI_WGFILEMANAGER_SMNAME3', 'Datei einsenden');
//\define('_MI_WGFILEMANAGER_SMNAME6', 'Search');
// Blocks
\define('_MI_WGFILEMANAGER_DIRFAV_BLOCK_LIST', 'Block Liste Verzeichnisse Favoriten');
\define('_MI_WGFILEMANAGER_DIRFAV_BLOCK_LIST_DESC', 'Block Liste Verzeichnisse und Favoriten');
\define('_MI_WGFILEMANAGER_DIRECTORY_BLOCK_LAST', 'Block letzte Verzeichnisse');
\define('_MI_WGFILEMANAGER_DIRECTORY_BLOCK_LAST_DESC', 'Block letzte Verzeichnisse');
\define('_MI_WGFILEMANAGER_DIRECTORY_BLOCK_NEW', 'Block neue Verzeichnisse');
\define('_MI_WGFILEMANAGER_DIRECTORY_BLOCK_NEW_DESC', 'Block neue Verzeichnisse');
\define('_MI_WGFILEMANAGER_FILE_BLOCK_LAST', 'Block letzte Dateien');
\define('_MI_WGFILEMANAGER_FILE_BLOCK_LAST_DESC', 'Block letzte Dateien');
\define('_MI_WGFILEMANAGER_FILE_BLOCK_NEW', 'Block neue Dateien');
\define('_MI_WGFILEMANAGER_FILE_BLOCK_NEW_DESC', 'Block neue Dateien');
\define('_MI_WGFILEMANAGER_DIRFAV_BLOCK_LIST_COLLAPSABLE', 'Block Liste Verzeichnisse Favoriten aufklappbar');
\define('_MI_WGFILEMANAGER_DIRFAV_BLOCK_LIST_COLLAPSABLE_DESC', 'Block Liste Verzeichnisse und Favoriten aufklappbar');
// Config
\define('_MI_WGFILEMANAGER_EDITOR_ADMIN', 'Editor Admin');
\define('_MI_WGFILEMANAGER_EDITOR_ADMIN_DESC', 'Bitte den zu verwendenden Editor für den Admin-Bereich wählen');
\define('_MI_WGFILEMANAGER_EDITOR_USER', 'Editor User');
\define('_MI_WGFILEMANAGER_EDITOR_USER_DESC', 'Bitte den zu verwendenden Editor für den User-Bereich wählen');
\define('_MI_WGFILEMANAGER_EDITOR_MAXCHAR', 'Maximale Zeichen Text');
\define('_MI_WGFILEMANAGER_EDITOR_MAXCHAR_DESC', 'Maximale Anzahl an Zeichen für die Anzeige von Texten in Listen im Admin-Bereich');
\define('_MI_WGFILEMANAGER_KEYWORDS', 'Schlüsselworter');
\define('_MI_WGFILEMANAGER_KEYWORDS_DESC', 'Bitte Schlüsselwörter angeben (getrennt durch ein Komma)');
\define('_MI_WGFILEMANAGER_MDESC', 'Beschreibung Modul');
\define('_MI_WGFILEMANAGER_MDESC_DESC', 'Geben Sie hier die Modulbeschreibung für die Verwendung in den Metadaten ein');
\define('_MI_WGFILEMANAGER_MDESC_DEFAULT', 'XOOPS Dateimanager');
\define('_MI_WGFILEMANAGER_INDEX_PERMISSION_TYPE', 'Art der Berechtigungen');
\define('_MI_WGFILEMANAGER_INDEX_PERMISSION_TYPE_DESC', 'Definiere die Art der Verwaltung der Berechtigungen');
\define('_MI_WGFILEMANAGER_INDEX_PERMISSION_TYPE_GLOBAL', 'Verwende globale Berechtigungen');
\define('_MI_WGFILEMANAGER_INDEX_PERMISSION_TYPE_DIR', 'Berechtigungen je Verzeichnis setzen');
\define('_MI_WGFILEMANAGER_SIZE_MB', 'MB');
\define('_MI_WGFILEMANAGER_MAXSIZE_FILE', 'Maximale Dateigröße');
\define('_MI_WGFILEMANAGER_MAXSIZE_FILE_DESC', 'Bitte die für den Upload von Dateien maximal zulässige Dateigröße definieren');
\define('_MI_WGFILEMANAGER_FILE_HANDLENAME', 'Behandlung Dateinamen');
\define('_MI_WGFILEMANAGER_FILE_HANDLENAME_DESC', 'Definiere wie mit Dateinamen umgegangen werden soll');
\define('_MI_WGFILEMANAGER_FILE_HANDLENAME_ORIGINAL', 'Verwende den originalen Dateinamen');
\define('_MI_WGFILEMANAGER_FILE_HANDLENAME_UNIQUE', 'Erstelle eindeutigen Dateinamen auf Basis des originalen Dateinamen');
\define('_MI_WGFILEMANAGER_ICONSET', 'Icon-Set');
\define('_MI_WGFILEMANAGER_ICONSET_DESC', 'Definiere welches Icon-Set verwendet werden soll');
\define('_MI_WGFILEMANAGER_ICONSET_NONE', 'Kein Icon-Set verwenden');
\define('_MI_WGFILEMANAGER_INDEX_DIRPOSITION', 'Position Verzeichnisliste');
\define('_MI_WGFILEMANAGER_INDEX_DIRPOSITION_DESC', 'Wähle die Position der Verzeichnisliste auf der Index-Seite');
\define('_MI_WGFILEMANAGER_INDEX_DIRPOSITION_NONE', 'Keine Verzeichnisliste auf der Indexseite verwenden. Ich verwende einen Block stattdessen.');
\define('_MI_WGFILEMANAGER_INDEX_DIRPOSITION_LEFT', 'Linke Seite');
\define('_MI_WGFILEMANAGER_INDEX_DIRPOSITION_TOP', 'Oberhalb');
//\define('_MI_WGFILEMANAGER_DIRECTORYSTYLE', 'List Style Directory Page');
//\define('_MI_WGFILEMANAGER_DIRECTORYSTYLE_DESC', 'Select list style on directory page');
\define('_MI_WGFILEMANAGER_TABLE_TYPE', 'Tabellen Typ');
\define('_MI_WGFILEMANAGER_TABLE_TYPE_DESC', 'Bootstrap Tabellen Typ');
\define('_MI_WGFILEMANAGER_PANEL_TYPE', 'Panel Typ');
\define('_MI_WGFILEMANAGER_PANEL_TYPE_DESC', 'Bootstrap Panel Typ');
\define('_MI_WGFILEMANAGER_USE_BROKEN', 'Verwende Feature FEHLERHAFT');
\define('_MI_WGFILEMANAGER_USE_BROKEN_DESC', 'Entscheide ob das Feature FEHLERHAFT verwendet werden soll. Benutzer können dann die Administratoren über fehlerhafte Dateilinks informieren.');
\define('_MI_WGFILEMANAGER_USE_FAVORITES', 'Verwende Feature FAVORITEN');
\define('_MI_WGFILEMANAGER_USE_FAVORITES_DESC', 'Entscheide ob das Feature FAVORITEN verwendet werden soll. Benutzer können dann Verzeichnisse oder Dateien pinnen, damit diese unter Favoriten angezeigt werden.');
\define('_MI_WGFILEMANAGER_SHOW_BREADCRUMBS', 'Brotkrumen-Navigation (breadcrumbs) anzeigen');
\define('_MI_WGFILEMANAGER_SHOW_BREADCRUMBS_DESC', 'Eine Brotkrumen-Navigation zeigt den aktuellen Seitenstand innerhalb der Websitestruktur');
\define('_MI_WGFILEMANAGER_SHOW_COPYRIGHT', 'Copyright anzeigen');
\define('_MI_WGFILEMANAGER_SHOW_COPYRIGHT_DESC', 'Sie können das Copyright bei der wgSimpleAcc-Ansicht entfernen, jedoch wird ersucht, an einer beliebigen Stelle einen Backlink auf www.wedega.com anzubringen');
\define('_MI_WGFILEMANAGER_MAINTAINEDBY', 'Unterstützt dur');
\define('_MI_WGFILEMANAGER_MAINTAINEDBY_DESC', 'Url zur Support Seite oder Community');
