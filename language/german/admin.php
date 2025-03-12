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
require_once __DIR__ . '/main.php';

// ---------------- Admin Index ----------------
\define('_AM_WGFILEMANAGER_STATISTICS', 'Statistiken');
// There are
\define('_AM_WGFILEMANAGER_THEREARE_DIRECTORY', "Es gibt <span class='bold'>%s</span> Verzeichnisse in der Datenbank");
\define('_AM_WGFILEMANAGER_THEREARE_FILE', "Es gibt <span class='bold'>%s</span> Dateien in der Datenbank");
\define('_AM_WGFILEMANAGER_THEREARE_MIMETYPE', "Es gibt <span class='bold'>%s</span> Mimetypes in der Datenbank");
\define('_AM_WGFILEMANAGER_THEREARE_FILEBROKEN', "Es gibt <span class='bold'>%s</span> fehlerhafte Dateien in der Datenbank");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_WGFILEMANAGER_THEREARENT_DIRECTORY', 'Es gibt keine Verzeichnisse');
\define('_AM_WGFILEMANAGER_THEREARENT_FILE', 'Es gibt keine Dateien');
\define('_AM_WGFILEMANAGER_THEREARENT_MIMETYPE', 'Es gibt keine Mimetypes');
\define('_AM_WGFILEMANAGER_THEREARENT_FILEBROKEN', 'Es gibt keine fehlerhaften Dateien');
\define('_AM_WGFILEMANAGER_THEREARENT_FAVORITE', 'Es gibt keine Favoriten');
// Save/Delete
\define('_AM_WGFILEMANAGER_FORM_OK', 'Erfolgreich gespeichert');
\define('_AM_WGFILEMANAGER_FORM_DELETE_OK', 'Erfolgreich gelöscht');
\define('_AM_WGFILEMANAGER_FORM_SURE_DELETE', "Wollen Sie wirklich löschen: <b><span style='color : Red;'>%s </span></b>");
\define('_AM_WGFILEMANAGER_FORM_SURE_RENEW', "Wollen Sie wirklich aktualisieren: <b><span style='color : Red;'>%s </span></b>");
// Buttons
\define('_AM_WGFILEMANAGER_ADD_DIRECTORY', 'Neues Verzeichnis hinzufügen');
\define('_AM_WGFILEMANAGER_ADD_FILE', 'Neue Datei hinzufügen');
\define('_AM_WGFILEMANAGER_ADD_MIMETYPE', 'Neuen Mimetype hinzufügen');
\define('_AM_WGFILEMANAGER_LOAD_MIMETYPE', 'Standard Mimetype-Set laden');
\define('_AM_WGFILEMANAGER_LOAD_MIMETYPE_OK', 'Standard Mimetype-Set erfolgreich geladen');
// Lists
\define('_AM_WGFILEMANAGER_LIST_DIRECTORY', 'Liste der Verzeichnisse');
\define('_AM_WGFILEMANAGER_LIST_FILE', 'Liste der Dateien');
\define('_AM_WGFILEMANAGER_LIST_MIMETYPE', 'Liste der Mimetypes');
// ---------------- Admin Classes ----------------
// Mimetypes add/edit
\define('_AM_WGFILEMANAGER_MIMETYPE_ADD', 'Mimetype hinzufügen');
\define('_AM_WGFILEMANAGER_MIMETYPE_EDIT', 'Mimetype bearbeiten');
// Elements of Mimetypes
\define('_AM_WGFILEMANAGER_MIMETYPE_ID', 'Id');
\define('_AM_WGFILEMANAGER_MIMETYPE_EXTENSION', 'Extension');
\define('_AM_WGFILEMANAGER_MIMETYPE_MIMETYPE', 'Mimetype');
\define('_AM_WGFILEMANAGER_MIMETYPE_DESC', 'Beschreibung');
\define('_AM_WGFILEMANAGER_MIMETYPE_ADMIN', 'Administrator');
\define('_AM_WGFILEMANAGER_MIMETYPE_USER', 'Benutzer');
\define('_AM_WGFILEMANAGER_MIMETYPE_CAT', 'Kategorie');
\define('_AM_WGFILEMANAGER_MIMETYPE_CAT_NONE', 'Keine Kategorie');
\define('_AM_WGFILEMANAGER_MIMETYPE_CAT_IMAGE', 'Bild');
\define('_AM_WGFILEMANAGER_MIMETYPE_CAT_PDF', 'Pdf-Datei');
\define('_AM_WGFILEMANAGER_MIMETYPE_DATE_CREATED', 'Datum erstellt');
\define('_AM_WGFILEMANAGER_MIMETYPE_SUBMITTER', 'Einsender');
\define('_AM_WGFILEMANAGER_MIMETYPE_LOAD_DEFAULT', 'Wollen Sie das Standard Mimetype-Set wirklich laden?. Das aktuelle Set wird gelöscht!');
// Status
\define('_AM_WGFILEMANAGER_STATUS_NONE', 'Kein Status');
\define('_AM_WGFILEMANAGER_STATUS_OFFLINE', 'Offline');
\define('_AM_WGFILEMANAGER_STATUS_SUBMITTED', 'Eingesendet');
\define('_AM_WGFILEMANAGER_STATUS_APPROVED', 'Genehmigt');
\define('_AM_WGFILEMANAGER_STATUS_BROKEN', 'Fehlerhaft');
// Broken
\define('_AM_WGFILEMANAGER_BROKEN_RESULT', 'Fehlerhafte Einträge in Tabelle %s');
\define('_AM_WGFILEMANAGER_BROKEN_NODATA', 'Keine fehlerhaften Einträge in Tabelle %s');
\define('_AM_WGFILEMANAGER_BROKEN_TABLE', 'Tabelle');
\define('_AM_WGFILEMANAGER_BROKEN_KEY', 'Schlüsselfeld');
\define('_AM_WGFILEMANAGER_BROKEN_KEYVAL', 'Schlüsselwert');
\define('_AM_WGFILEMANAGER_BROKEN_MAIN', 'Hauptinfo');
// Clone feature
\define('_AM_WGFILEMANAGER_CLONE', 'Klonen');
\define('_AM_WGFILEMANAGER_CLONE_DSC', 'Ein Modul zu klonen war noch nie so einfach! Geben Sie einfach den Namen den Sie wollen und Knopf drücken!');
\define('_AM_WGFILEMANAGER_CLONE_TITLE', 'Klone %s');
\define('_AM_WGFILEMANAGER_CLONE_NAME', 'Wählen Sie einen Namen für das neue Modul');
\define('_AM_WGFILEMANAGER_CLONE_NAME_DSC', 'Verwenden Sie keine Sonderzeichen ! <br> Wählen Sie bitte kein vorhandenes Modul Modul Verzeichnisname  oder Datenbank-Tabellenname!');
\define('_AM_WGFILEMANAGER_CLONE_INVALIDNAME', 'FEHLER: Ungültige Modulnamen, bitte versuchen Sie einen anderen!');
\define('_AM_WGFILEMANAGER_CLONE_EXISTS', 'FEHLER: Modulnamen bereits benutzt, bitte versuchen Sie einen anderen!');
\define('_AM_WGFILEMANAGER_CLONE_CONGRAT', 'Herzliche Glückwünsche! %s wurde erfolgreich erstellt! <br /> Sie können Änderungen in Sprachdateien machen.');
\define('_AM_WGFILEMANAGER_CLONE_IMAGEFAIL', 'Achtung, wir haben es nicht geschafft, das neue Modul-Logo zu erstellen. Bitte beachten Sie assets / images / logo_module.png manuell zu modifizieren!');
\define('_AM_WGFILEMANAGER_CLONE_FAIL', "Leider konnten wir den neuen Klon nicht erstellen . Vielleicht müssen Sie die Schreibrechte von 'modules' Verzeichnis auf  (CHMOD 777) festlegen und neu versuchen.");
// ---------------- Admin Others ----------------
\define('_AM_WGFILEMANAGER_ABOUT_MAKE_DONATION', 'Einsenden');
\define('_AM_WGFILEMANAGER_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGFILEMANAGER_DONATION_AMOUNT', 'Spendenbetrag');
\define('_AM_WGFILEMANAGER_MAINTAINEDBY', ' wird unterstützt durch ');
// ---------------- End ----------------
\define('_AM_WGFILEMANAGER_FAVORITE_ID', 'ID');
\define('_AM_WGFILEMANAGER_FAVORITE_DATE_CREATED', 'Datum erstellt');
\define('_MA_WGFILEMANAGER_FAVORITE_SUBMITTER', 'Einsender');
