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
\define('_AM_WGFILEMANAGER_STATISTICS', 'Statistics');
// There are
\define('_AM_WGFILEMANAGER_THEREARE_DIRECTORY', "There are <span class='bold'>%s</span> directories in the database");
\define('_AM_WGFILEMANAGER_THEREARE_FILE', "There are <span class='bold'>%s</span> files in the database");
\define('_AM_WGFILEMANAGER_THEREARE_MIMETYPE', "There are <span class='bold'>%s</span> mime types in the database");
\define('_AM_WGFILEMANAGER_THEREARE_FILEBROKEN', "There are <span class='bold'>%s</span> broken files in the database");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_WGFILEMANAGER_THEREARENT_DIRECTORY', "There aren't directories");
\define('_AM_WGFILEMANAGER_THEREARENT_FILE', "There aren't files");
\define('_AM_WGFILEMANAGER_THEREARENT_MIMETYPE', "There aren't mime types");
\define('_AM_WGFILEMANAGER_THEREARENT_FILEBROKEN', "There aren't broken files");
\define('_AM_WGFILEMANAGER_THEREARENT_FAVORITE', "There aren't favorites");
// Save/Delete
\define('_AM_WGFILEMANAGER_FORM_OK', 'Successfully saved');
\define('_AM_WGFILEMANAGER_FORM_DELETE_OK', 'Successfully deleted');
\define('_AM_WGFILEMANAGER_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_AM_WGFILEMANAGER_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
// Buttons
\define('_AM_WGFILEMANAGER_ADD_DIRECTORY', 'Add New Directory');
\define('_AM_WGFILEMANAGER_ADD_FILE', 'Add New File');
\define('_AM_WGFILEMANAGER_ADD_MIMETYPE', 'Add New Mimetypes');
\define('_AM_WGFILEMANAGER_LOAD_MIMETYPE', 'Load default mimetype set');
\define('_AM_WGFILEMANAGER_LOAD_MIMETYPE_OK', 'Default mimetype set successfully loaded');
// Lists
\define('_AM_WGFILEMANAGER_LIST_DIRECTORY', 'List of Directory');
\define('_AM_WGFILEMANAGER_LIST_FILE', 'List of File');
\define('_AM_WGFILEMANAGER_LIST_MIMETYPE', 'List of Mimetype');
// ---------------- Admin Classes ----------------
// Mimetypes add/edit
\define('_AM_WGFILEMANAGER_MIMETYPE_ADD', 'Add Mimetypes');
\define('_AM_WGFILEMANAGER_MIMETYPE_EDIT', 'Edit Mimetype');
// Elements of Mimetypes
\define('_AM_WGFILEMANAGER_MIMETYPE_ID', 'Id');
\define('_AM_WGFILEMANAGER_MIMETYPE_EXTENSION', 'Extension');
\define('_AM_WGFILEMANAGER_MIMETYPE_MIMETYPE', 'Mimetype');
\define('_AM_WGFILEMANAGER_MIMETYPE_DESC', 'Desc');
\define('_AM_WGFILEMANAGER_MIMETYPE_ADMIN', 'Admin');
\define('_AM_WGFILEMANAGER_MIMETYPE_USER', 'User');
\define('_AM_WGFILEMANAGER_MIMETYPE_CAT', 'Category');
\define('_AM_WGFILEMANAGER_MIMETYPE_CAT_NONE', 'No category');
\define('_AM_WGFILEMANAGER_MIMETYPE_CAT_IMAGE', 'Image');
\define('_AM_WGFILEMANAGER_MIMETYPE_CAT_PDF', 'Pdf-file');
\define('_AM_WGFILEMANAGER_MIMETYPE_DATE_CREATED', 'Date created');
\define('_AM_WGFILEMANAGER_MIMETYPE_SUBMITTER', 'Submitter');
\define('_AM_WGFILEMANAGER_MIMETYPE_LOAD_DEFAULT', 'Do you really want to load default mimetype set? Existing set will be deleted!');
// Status
\define('_AM_WGFILEMANAGER_STATUS_NONE', 'No status');
\define('_AM_WGFILEMANAGER_STATUS_OFFLINE', 'Offline');
\define('_AM_WGFILEMANAGER_STATUS_SUBMITTED', 'Submitted');
\define('_AM_WGFILEMANAGER_STATUS_APPROVED', 'Approved');
\define('_AM_WGFILEMANAGER_STATUS_BROKEN', 'Broken');
// Broken
\define('_AM_WGFILEMANAGER_BROKEN_RESULT', 'Broken items in table %s');
\define('_AM_WGFILEMANAGER_BROKEN_NODATA', 'No broken items in table %s');
\define('_AM_WGFILEMANAGER_BROKEN_TABLE', 'Table');
\define('_AM_WGFILEMANAGER_BROKEN_KEY', 'Key field');
\define('_AM_WGFILEMANAGER_BROKEN_KEYVAL', 'Key value');
\define('_AM_WGFILEMANAGER_BROKEN_MAIN', 'Info main');
// Clone feature
\define('_AM_WGFILEMANAGER_CLONE', 'Clone');
\define('_AM_WGFILEMANAGER_CLONE_DSC', 'Cloning a module has never been this easy! Just type in the name you want for it and hit submit button!');
\define('_AM_WGFILEMANAGER_CLONE_TITLE', 'Clone %s');
\define('_AM_WGFILEMANAGER_CLONE_NAME', 'Choose a name for the new module');
\define('_AM_WGFILEMANAGER_CLONE_NAME_DSC', 'Do not use special characters! <br>Do not choose an existing module dirname or database table name!');
\define('_AM_WGFILEMANAGER_CLONE_INVALIDNAME', 'ERROR: Invalid module name, please try another one!');
\define('_AM_WGFILEMANAGER_CLONE_EXISTS', 'ERROR: Module name already taken, please try another one!');
\define('_AM_WGFILEMANAGER_CLONE_CONGRAT', 'Congratulations! %s was sucessfully created!<br>You may want to make changes in language files.');
\define('_AM_WGFILEMANAGER_CLONE_IMAGEFAIL', 'Attention, we failed creating the new module logo. Please consider modifying assets/images/logo_module.png manually!');
\define('_AM_WGFILEMANAGER_CLONE_FAIL', 'Sorry, we failed in creating the new clone. Maybe you need to temporally set write permissions (CHMOD 777) to modules folder and try again.');
// ---------------- Admin Others ----------------
\define('_AM_WGFILEMANAGER_ABOUT_MAKE_DONATION', 'Submit');
\define('_AM_WGFILEMANAGER_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGFILEMANAGER_DONATION_AMOUNT', 'Donation Amount');
\define('_AM_WGFILEMANAGER_MAINTAINEDBY', ' is maintained by ');
// ---------------- End ----------------
\define('_AM_WGFILEMANAGER_FAVORITE_ID', 'ID');
\define('_AM_WGFILEMANAGER_FAVORITE_DATE_CREATED', 'Date submitted');
\define('_MA_WGFILEMANAGER_FAVORITE_SUBMITTER', 'Submitter');
