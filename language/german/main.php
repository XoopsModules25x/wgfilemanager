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

require_once __DIR__ . '/admin.php';

// ---------------- Main ----------------
\define('_MA_WGFILEMANAGER_INDEX', 'Übersicht wgFileManager');
\define('_MA_WGFILEMANAGER_TITLE', 'wgFileManager');
\define('_MA_WGFILEMANAGER_DETAILS', 'Zeige Details');
\define('_MA_WGFILEMANAGER_BROKEN', 'Als fehlerhaft melden');
\define('_MA_WGFILEMANAGER_INDEX_NOFILES', 'Es gibt keine Dateien in diesem Verzeichnis');
\define('_MA_WGFILEMANAGER_ACTION', 'Aktion');
\define('_MA_WGFILEMANAGER_INDEX_STYLELIST', 'Zeige als Listenansicht');
\define('_MA_WGFILEMANAGER_INDEX_STYLEGROUPED', 'Zeige als gruppierte Ansicht');
\define('_MA_WGFILEMANAGER_INDEX_STYLECARD', 'Zeige als Cards');
\define('_MA_WGFILEMANAGER_INDEX_STYLECARDBIG', 'Zeige als große Cards');
\define('_MA_WGFILEMANAGER_INVALID_PARAMS', 'Ungültiger Parameter');
\define('_MA_WGFILEMANAGER_FAVORITE', 'Favoriten');
\define('_MA_WGFILEMANAGER_FAVORITE_PIN', 'In Favoriten anzeigen');
\define('_MA_WGFILEMANAGER_FAVORITE_UNPIN', 'Aus Favoriten enfernen');
\define('_MA_WGFILEMANAGER_FAVORITE_ERROR_SET', 'FEHLER: Setzen Favoriten fehlgeschlagen');
//sorting
\define('_MA_WGFILEMANAGER_INDEX_SORTLIST', 'Sortierung Liste');
\define('_MA_WGFILEMANAGER_NAME', 'nach Name');
\define('_MA_WGFILEMANAGER_DATE_CREATE', 'nach Einsendedatum');
\define('_MA_WGFILEMANAGER_CTIME', 'nach Erstelldatum');
// ---------------- Contents ----------------
// Directory
\define('_MA_WGFILEMANAGER_DIRECTORY', 'Verzeichnis');
\define('_MA_WGFILEMANAGER_DIRECTORY_ADD', 'Verzeichnis hinzufügen');
\define('_MA_WGFILEMANAGER_DIRECTORY_EDIT', 'Verzeichnis bearbeiten');
\define('_MA_WGFILEMANAGER_DIRECTORY_DELETE', 'Verzeichnis löschen');
\define('_MA_WGFILEMANAGER_DIRECTORY_CLONE', 'Verzeichnis klonen');
\define('_MA_WGFILEMANAGER_DIRECTORY_DETAILS', 'Details Verzeichnis');
\define('_MA_WGFILEMANAGER_DIRECTORY_LIST', 'Liste der Verzeichnisse');
\define('_MA_WGFILEMANAGER_DIRECTORY_REFRESH', 'Liste aktualisieren');
\define('_MA_WGFILEMANAGER_DIRECTORY_TITLE', 'Titel Verzeichnis');
\define('_MA_WGFILEMANAGER_DIRECTORY_DESC', 'Beschreibung Verzeichnis');
\define('_MA_WGFILEMANAGER_DIRECTORY_DELETE_SINGLE', "Wollen Sie wirklich das Verzeichnis '%s' mit allen Dateien löschen?<br>");
\define('_MA_WGFILEMANAGER_DIRECTORY_DELETE_ISPARENT', "Dieses Verzeichnis '%s' dient auch als Überverzeichnis für darin enthaltene Unterverzeichnisse. Wollen Sie wirklich das Verzeichnis mit allen Unterverzeichnissen und Dateien löschen?");
\define('_MA_WGFILEMANAGER_DIRECTORY_HOME', 'Standard-Verzeichnis');
\define('_MA_WGFILEMANAGER_DIRECTORY_GOTO', 'Gehe zu Verzeichnis');
\define('_MA_WGFILEMANAGER_DIRECTORY_SHOWHIDE', 'Zeige/verstecke Unterverzeichnisse');
//Errors
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_EXISTS', 'FEHLER: Verzeichnis exisitiert bereits');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_EXISTS_JS', "FEHLER: Verschieben des Verzeichnisses fehlgeschlagen!\n\nGrund: Verzeichnis exisitiert bereits");
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_DONOTEXIST', 'FEHLER: Verzeichnis exisitiert nicht');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_CREATE', 'FEHLER: Erstellen des Verzeichnisses fehlgeschlagen');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_MOVE', 'FEHLER: Verschieben der Datei fehlgeschlage');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_DELETE', 'FEHLER: Löschen des Verzeichnisses fehlgeschlagen');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_DELETE_SUBDIRDATA', 'FEHLER: Löschen des Unterverzeichnisses fehlgeschlagen');
// Count
\define('_MA_WGFILEMANAGER_COUNT_SUBDIRS', 'Anzahl Unterverzeichnisse');
\define('_MA_WGFILEMANAGER_COUNT_FILES', 'Anzahl Dateien');
\define('_MA_WGFILEMANAGER_COUNT_MIMETYPES', 'Anzahl Mimetypes');
// Caption of Directory
\define('_MA_WGFILEMANAGER_DIRECTORY_ID', 'Id');
\define('_MA_WGFILEMANAGER_DIRECTORY_PARENT_ID', 'Übergeordnetes Verzeichnis');
\define('_MA_WGFILEMANAGER_DIRECTORY_NAME', 'Name');
\define('_MA_WGFILEMANAGER_DIRECTORY_DESCRIPTION', 'Beschreibung');
\define('_MA_WGFILEMANAGER_DIRECTORY_FULLPATH_DESCR', 'Pfad startet von: %s');
\define('_MA_WGFILEMANAGER_DIRECTORY_FULLPATH', 'Vollständiger Pfad');
\define('_MA_WGFILEMANAGER_DIRECTORY_WEIGHT', 'Reihung');
\define('_MA_WGFILEMANAGER_DIRECTORY_DATE_CREATED', 'Datum erstellt');
\define('_MA_WGFILEMANAGER_DIRECTORY_SUBMITTER', 'Einsender');
\define('_MA_WGFILEMANAGER_DIRECTORY_COUNT', 'Anzahl Verzeichnisse');
//basic directory
\define('_MA_WGFILEMANAGER_DIRECTORY_BASICNAME', 'Standard Verzeichnis');
\define('_MA_WGFILEMANAGER_DIRECTORY_BASIC_FAILED', 'Ertellen des Standard Verzeichnisses fehlgeschlagen');
// File
\define('_MA_WGFILEMANAGER_FILE', 'Datei');
\define('_MA_WGFILEMANAGER_FILE_ADD', 'Datei hinzufügen');
\define('_MA_WGFILEMANAGER_FILE_EDIT', 'Datei bearbeiten');
\define('_MA_WGFILEMANAGER_FILE_DELETE', 'Datei löschen');
\define('_MA_WGFILEMANAGER_FILE_CLONE', 'Datei klonen');
\define('_MA_WGFILEMANAGER_FILE_DETAILS', 'Details Datei');
\define('_MA_WGFILEMANAGER_FILE_LIST', 'Liste der Dateien');
\define('_MA_WGFILEMANAGER_FILE_TITLE', 'Dateititel');
\define('_MA_WGFILEMANAGER_FILE_DESC', 'Datei Beschreibung');
// Caption of File
\define('_MA_WGFILEMANAGER_FILE_ID', 'Id');
\define('_MA_WGFILEMANAGER_FILE_DIRECTORY_ID', 'Verzeichnis');
\define('_MA_WGFILEMANAGER_FILE_NAME', 'Name');
\define('_MA_WGFILEMANAGER_FILE_DESCRIPTION', 'Beschreibung');
\define('_MA_WGFILEMANAGER_FILE_MIMETYPE', 'Type');
\define('_MA_WGFILEMANAGER_FILE_SIZE', 'Größe');
\define('_MA_WGFILEMANAGER_FILE_MTIME', 'Änderungsdatum');
\define('_MA_WGFILEMANAGER_FILE_CTIME', 'Erstelldatum');
\define('_MA_WGFILEMANAGER_FILE_IP', 'IP');
\define('_MA_WGFILEMANAGER_FILE_STATUS', 'Status');
\define('_MA_WGFILEMANAGER_FILE_DATE_CREATED', 'Einsendedatum');
\define('_MA_WGFILEMANAGER_FILE_SUBMITTER', 'Einsender');
\define('_MA_WGFILEMANAGER_FILE_NAME_UPLOADS', 'Hochgeladene Dateien in: %s');
// File misc
\define('_MA_WGFILEMANAGER_INDEX_THEREARE', 'Es gibt %s Dateien');
\define('_MA_WGFILEMANAGER_INDEX_LATEST_LIST', 'Letzte Einträge in wgFileManager');
\define('_MA_WGFILEMANAGER_FILE_ERROR_EXISTS', 'FEHLER: Datei exisitiert bereits in diesem Verzeichnis');
\define('_MA_WGFILEMANAGER_FILE_ERROR_DONOTEXIST', 'FEHLER: Datei exisitiert nicht');
\define('_MA_WGFILEMANAGER_FILE_DOWNLOAD', 'Datei herunterladen');
\define('_MA_WGFILEMANAGER_FILE_UPLOAD', 'Datei hochladen');
\define('_MA_WGFILEMANAGER_FILE_SHOWPREVIEW', 'Vorschau anzeigen');
// Buttons
\define('_MA_WGFILEMANAGER_SUBMIT', 'Senden');
\define('_MA_WGFILEMANAGER_SAVE', 'Speichern');
// Form
\define('_MA_WGFILEMANAGER_FORM_OK', 'Erfolgreich gespeichert');
\define('_MA_WGFILEMANAGER_FORM_DELETE_OK', 'Erfolgreich gelöscht');
\define('_MA_WGFILEMANAGER_FORM_SURE_DELETE', "Wollen Sie wirklich löschen: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGFILEMANAGER_FORM_SURE_RENEW', "Wollen Sie wirklich aktualisieren: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGFILEMANAGER_FORM_SURE_BROKEN', "Wollen Sie wirklich als fehlerhaft melden: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGFILEMANAGER_FORM_UPLOAD', 'Datei hochladen');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_NEW', 'Neue Datei hochladen: ');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_SIZE', 'Maximale Dateigröße: ');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_IMG_WIDTH', 'Maximale Bildbreite: ');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_IMG_HEIGHT', 'Maximale Bildhöhe: ');
\define('_MA_WGFILEMANAGER_FORM_IMAGE_PATH', 'Dateien in %s :');
\define('_MA_WGFILEMANAGER_FORM_ACTION', 'Aktion');
\define('_MA_WGFILEMANAGER_FORM_EDIT', 'Ändern');
\define('_MA_WGFILEMANAGER_FORM_DELETE', 'Leeren');
\define('_MA_WGFILEMANAGER_INVALID_PARAM', 'Ungültiger Parameter');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_MULTIDOTS', 'Der Dateiname enthält mehrere Punkte. Dies kann zu Problemen beim Upload führen');
// ---------------- Admin Permissions ----------------
// Permissions
\define('_MA_WGFILEMANAGER_PERM_GLOBAL', 'Globale Berechtigungen');
\define('_MA_WGFILEMANAGER_PERM_GLOBAL_DESC', 'Globale Berechtigungen');
//\define('_MA_WGFILEMANAGER_PERM_GLOBAL_APPROVE', 'Permissions global to approve');
\define('_MA_WGFILEMANAGER_PERM_GLOBAL_SUBMIT', 'Globale Berechtigungen zum Senden/Hochladen');
\define('_MA_WGFILEMANAGER_PERM_GLOBAL_VIEW', 'Globale Berechtigungen zum Anzeigen');
\define('_MA_WGFILEMANAGER_PERM_GLOBAL_DOWNLOAD', 'Globale Berechtigungen zum Herunterladen');
//\define('_MA_WGFILEMANAGER_PERM_APPROVE', 'Permissions to approve');
//\define('_MA_WGFILEMANAGER_PERM_APPROVE_DESC', 'Permissions to approve');
//\define('_MA_WGFILEMANAGER_PERM_SUBMIT', 'Permissions to submit');
//\define('_MA_WGFILEMANAGER_PERM_SUBMIT_DESC', 'Permissions to submit');
\define('_MA_WGFILEMANAGER_PERM_DIR_SUBMIT', 'Berechtigungen Senden Verzeichnis');
\define('_MA_WGFILEMANAGER_PERM_DIR_SUBMIT_DESC', 'Berechtigungen zum:<br>- Bearbeiten von Verzeichnissen<br>- Erstellen von Unterverzeichnissen<br>- Bearbeiten/Löschen von Dateien');
\define('_MA_WGFILEMANAGER_PERM_DIR_VIEW', 'Berechtigungen Anzeigen Verzeichnis');
\define('_MA_WGFILEMANAGER_PERM_DIR_VIEW_DESC', 'Berechtigungen zum Anzeigen von Verzeichnissen mit allen Dateien');
\define('_MA_WGFILEMANAGER_PERM_FILE_UPLOAD_TO_DIR', 'Berechtigungen Hochladen Verzeichnis');
\define('_MA_WGFILEMANAGER_PERM_FILE_UPLOAD_TO_DIR_DESC', 'Berechtigungen zum Hochladen von Dateien in dieses Verzeichnis');
\define('_MA_WGFILEMANAGER_PERM_FILE_DOWNLOAD_FROM_DIR', 'Berechtigungen Herunterladen Verzeichnis');
\define('_MA_WGFILEMANAGER_PERM_FILE_DOWNLOAD_FROM_DIR_DESC', 'Berechtigungen zum Herunterladen von Dateien aus diesem Verzeichnis');
//\define('_MA_WGFILEMANAGER_PERM_VIEW', 'Permission to view');
//\define('_MA_WGFILEMANAGER_PERM_VIEW_DESC', 'Permission to view');
\define('_MA_WGFILEMANAGER_NO_PERMISSIONS_SET', 'Keine Berechtigungen gesetzt');
\define('_MA_WGFILEMANAGER_NO_PERM_DIRECTORY_VIEW', 'Keine Berechtigung zum Anzeigen des Verzeichnisses');
\define('_MA_WGFILEMANAGER_NO_PERM_DOWNLOAD', 'Keine Berechtigung zum Herunterladen');
// Admin link
\define('_MA_WGFILEMANAGER_ADMIN', 'Admin');
// ---------------- End ----------------
