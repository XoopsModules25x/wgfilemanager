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
\define('_MA_WGFILEMANAGER_INDEX', 'Overview wgFileManager');
\define('_MA_WGFILEMANAGER_TITLE', 'wgFileManager');
\define('_MA_WGFILEMANAGER_DETAILS', 'Show details');
\define('_MA_WGFILEMANAGER_BROKEN', 'Notify as broken');
\define('_MA_WGFILEMANAGER_INDEX_NOFILES', 'No files in this directory');
\define('_MA_WGFILEMANAGER_ACTION', 'Action');
\define('_MA_WGFILEMANAGER_INDEX_STYLELIST', 'Show in list style');
\define('_MA_WGFILEMANAGER_INDEX_STYLEGROUPED', 'Show in grouped style');
\define('_MA_WGFILEMANAGER_INDEX_STYLECARD', 'Show in card style');
\define('_MA_WGFILEMANAGER_INDEX_STYLECARDBIG', 'Show in big card style');
\define('_MA_WGFILEMANAGER_INVALID_PARAMS', 'Invalid parameters');
\define('_MA_WGFILEMANAGER_FAVORITE', 'Favorites');
\define('_MA_WGFILEMANAGER_FAVORITE_PIN', 'Show in favorites');
\define('_MA_WGFILEMANAGER_FAVORITE_UNPIN', 'Remove from favorites');
\define('_MA_WGFILEMANAGER_FAVORITE_ERROR_SET', 'ERROR: setting favorites failed');
//sorting
\define('_MA_WGFILEMANAGER_INDEX_SORTLIST', 'Sort List');
\define('_MA_WGFILEMANAGER_NAME', 'by name');
\define('_MA_WGFILEMANAGER_DATE_CREATE', 'by date submission');
\define('_MA_WGFILEMANAGER_CTIME', 'by file creation date');
// ---------------- Contents ----------------
// Directory
\define('_MA_WGFILEMANAGER_DIRECTORY', 'Directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_ADD', 'Add Directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_EDIT', 'Edit Directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_DELETE', 'Delete Directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_CLONE', 'Clone Directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_DETAILS', 'Details Directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_LIST', 'List of Directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_REFRESH', 'Refresh List');
\define('_MA_WGFILEMANAGER_DIRECTORY_TITLE', 'Directory title');
\define('_MA_WGFILEMANAGER_DIRECTORY_DESC', 'Directory description');
\define('_MA_WGFILEMANAGER_DIRECTORY_DELETE_SINGLE', "Do you really want to delete directory '%s' with all files?<br>");
\define('_MA_WGFILEMANAGER_DIRECTORY_DELETE_ISPARENT', "This directory '%s' is used also as parent directory for other directories. Do you really want to delete directory with all files and subdirectories?");
\define('_MA_WGFILEMANAGER_DIRECTORY_HOME', 'Basic Directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_GOTO', 'Goto Directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_SHOWHIDE', 'Show/hide Sub Directory');
//Errors
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_EXISTS', 'ERROR: Directory already exists');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_EXISTS_JS', "ERROR: Moving folder failed!\n\nReason: Directory already exist");
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_DONOTEXIST', 'ERROR: Directory does not exists');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_CREATE', 'ERROR: Creating directory failed');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_MOVE', 'ERROR: Moving file failed');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_DELETE', 'ERROR: Deleting directory failed');
\define('_MA_WGFILEMANAGER_DIRECTORY_ERROR_DELETE_SUBDIRDATA', 'ERROR: Deleting data of subdirectories failed');
// Count
\define('_MA_WGFILEMANAGER_COUNT_SUBDIRS', 'Number of subdirectories');
\define('_MA_WGFILEMANAGER_COUNT_FILES', 'Number of files');
\define('_MA_WGFILEMANAGER_COUNT_MIMETYPES', 'Number of mime types');
// Caption of Directory
\define('_MA_WGFILEMANAGER_DIRECTORY_ID', 'Id');
\define('_MA_WGFILEMANAGER_DIRECTORY_PARENT_ID', 'Parent directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_NAME', 'Name');
\define('_MA_WGFILEMANAGER_DIRECTORY_DESCRIPTION', 'Description');
\define('_MA_WGFILEMANAGER_DIRECTORY_FULLPATH_DESCR', 'Path starting from: %s');
\define('_MA_WGFILEMANAGER_DIRECTORY_FULLPATH', 'Fullpath');
\define('_MA_WGFILEMANAGER_DIRECTORY_WEIGHT', 'Weight');
\define('_MA_WGFILEMANAGER_DIRECTORY_DATE_CREATED', 'Date_created');
\define('_MA_WGFILEMANAGER_DIRECTORY_SUBMITTER', 'Submitter');
\define('_MA_WGFILEMANAGER_DIRECTORY_COUNT', 'Number of directories');
//basic directory
\define('_MA_WGFILEMANAGER_DIRECTORY_BASICNAME', 'Basic directory');
\define('_MA_WGFILEMANAGER_DIRECTORY_BASIC_FAILED', 'Creation of basic directory failed');
// File
\define('_MA_WGFILEMANAGER_FILE', 'File');
\define('_MA_WGFILEMANAGER_FILE_ADD', 'Add File');
\define('_MA_WGFILEMANAGER_FILE_EDIT', 'Edit File');
\define('_MA_WGFILEMANAGER_FILE_DELETE', 'Delete File');
\define('_MA_WGFILEMANAGER_FILE_CLONE', 'Clone File');
\define('_MA_WGFILEMANAGER_FILE_DETAILS', 'Details File');
\define('_MA_WGFILEMANAGER_FILE_LIST', 'List of File');
\define('_MA_WGFILEMANAGER_FILE_TITLE', 'File title');
\define('_MA_WGFILEMANAGER_FILE_DESC', 'File description');
// Caption of File
\define('_MA_WGFILEMANAGER_FILE_ID', 'Id');
\define('_MA_WGFILEMANAGER_FILE_DIRECTORY_ID', 'Directory');
\define('_MA_WGFILEMANAGER_FILE_NAME', 'Name');
\define('_MA_WGFILEMANAGER_FILE_DESCRIPTION', 'Description');
\define('_MA_WGFILEMANAGER_FILE_MIMETYPE', 'Type');
\define('_MA_WGFILEMANAGER_FILE_SIZE', 'Size');
\define('_MA_WGFILEMANAGER_FILE_MTIME', 'Modification date');
\define('_MA_WGFILEMANAGER_FILE_CTIME', 'Creation date');
\define('_MA_WGFILEMANAGER_FILE_IP', 'IP');
\define('_MA_WGFILEMANAGER_FILE_STATUS', 'Status');
\define('_MA_WGFILEMANAGER_FILE_DATE_CREATED', 'Date submitted');
\define('_MA_WGFILEMANAGER_FILE_SUBMITTER', 'Submitter');
\define('_MA_WGFILEMANAGER_FILE_NAME_UPLOADS', 'Uploaded files in: %s');
// File misc
\define('_MA_WGFILEMANAGER_INDEX_THEREARE', 'There are %s File');
\define('_MA_WGFILEMANAGER_INDEX_LATEST_LIST', 'Last items in wgFileManager');
\define('_MA_WGFILEMANAGER_FILE_ERROR_EXISTS', 'ERROR: file already exists in this directory');
\define('_MA_WGFILEMANAGER_FILE_ERROR_DONOTEXIST', 'ERROR: file does not exist');
\define('_MA_WGFILEMANAGER_FILE_DOWNLOAD', 'Download file');
\define('_MA_WGFILEMANAGER_FILE_UPLOAD', 'Upload file');
\define('_MA_WGFILEMANAGER_FILE_SHOWPREVIEW', 'Show preview');
// Buttons
\define('_MA_WGFILEMANAGER_SUBMIT', 'Submit');
\define('_MA_WGFILEMANAGER_SAVE', 'Save');
// Form
\define('_MA_WGFILEMANAGER_FORM_OK', 'Successfully saved');
\define('_MA_WGFILEMANAGER_FORM_DELETE_OK', 'Successfully deleted');
\define('_MA_WGFILEMANAGER_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGFILEMANAGER_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGFILEMANAGER_FORM_SURE_BROKEN', "Are you sure to notify as broken: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGFILEMANAGER_FORM_UPLOAD', 'Upload file');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_NEW', 'Upload new file: ');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_SIZE', 'Max file size: ');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_IMG_WIDTH', 'Max image width: ');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_IMG_HEIGHT', 'Max image height: ');
\define('_MA_WGFILEMANAGER_FORM_IMAGE_PATH', 'Files in %s :');
\define('_MA_WGFILEMANAGER_FORM_ACTION', 'Action');
\define('_MA_WGFILEMANAGER_FORM_EDIT', 'Modification');
\define('_MA_WGFILEMANAGER_FORM_DELETE', 'Clear');
\define('_MA_WGFILEMANAGER_INVALID_PARAM', 'Invalid parameter');
\define('_MA_WGFILEMANAGER_FORM_UPLOAD_MULTIDOTS', 'The file name contains multiple dots. This can cause problems during file upload');
// ---------------- Admin Permissions ----------------
// Permissions
\define('_MA_WGFILEMANAGER_PERM_GLOBAL', 'Permissions global');
\define('_MA_WGFILEMANAGER_PERM_GLOBAL_DESC', 'Permissions global to check type of.');
//\define('_MA_WGFILEMANAGER_PERM_GLOBAL_APPROVE', 'Permissions global to approve');
\define('_MA_WGFILEMANAGER_PERM_GLOBAL_SUBMIT', 'Permissions global to submit/upload');
\define('_MA_WGFILEMANAGER_PERM_GLOBAL_VIEW', 'Permissions global to view');
\define('_MA_WGFILEMANAGER_PERM_GLOBAL_DOWNLOAD', 'Permissions global to download');
//\define('_MA_WGFILEMANAGER_PERM_APPROVE', 'Permissions to approve');
//\define('_MA_WGFILEMANAGER_PERM_APPROVE_DESC', 'Permissions to approve');
//\define('_MA_WGFILEMANAGER_PERM_SUBMIT', 'Permissions to submit');
//\define('_MA_WGFILEMANAGER_PERM_SUBMIT_DESC', 'Permissions to submit');
\define('_MA_WGFILEMANAGER_PERM_DIR_SUBMIT', 'Permission directory submit');
\define('_MA_WGFILEMANAGER_PERM_DIR_SUBMIT_DESC', 'Permission to:<br>- edit this directory<br>- create subdirectories<br>- edit/delete files');
\define('_MA_WGFILEMANAGER_PERM_DIR_VIEW', 'Permission directory view');
\define('_MA_WGFILEMANAGER_PERM_DIR_VIEW_DESC', 'Permission to view directory with all files');
\define('_MA_WGFILEMANAGER_PERM_FILE_UPLOAD_TO_DIR', 'Permission directory upload');
\define('_MA_WGFILEMANAGER_PERM_FILE_UPLOAD_TO_DIR_DESC', 'Permission to upload files to this directory');
\define('_MA_WGFILEMANAGER_PERM_FILE_DOWNLOAD_FROM_DIR', 'Permission directory download');
\define('_MA_WGFILEMANAGER_PERM_FILE_DOWNLOAD_FROM_DIR_DESC', 'Permission to download files from this directory');
//\define('_MA_WGFILEMANAGER_PERM_VIEW', 'Permission to view');
//\define('_MA_WGFILEMANAGER_PERM_VIEW_DESC', 'Permission to view');
\define('_MA_WGFILEMANAGER_NO_PERMISSIONS_SET', 'No permission set');
\define('_MA_WGFILEMANAGER_NO_PERM_DIRECTORY_VIEW', 'No permission to view directory');
\define('_MA_WGFILEMANAGER_NO_PERM_DOWNLOAD', 'No permission to download');
// Admin link
\define('_MA_WGFILEMANAGER_ADMIN', 'Admin');
// ---------------- End ----------------
