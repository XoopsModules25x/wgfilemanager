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

use Xmf\Request;
use XoopsModules\Wgfilemanager;
use XoopsModules\Wgfilemanager\Constants;
use XoopsModules\Wgfilemanager\Common;

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgfilemanager_file.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';

$op     = Request::getCmd('op', 'list');
$fileId = Request::getInt('id');
$dirId  = Request::getInt('dir_id');
$start  = Request::getInt('start');
$limit  = Request::getInt('limit', $helper->getConfig('userpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgfilemanager_url', \WGFILEMANAGER_URL);
$GLOBALS['xoopsTpl']->assign('wgfilemanager_icon_bi_url', \WGFILEMANAGER_ICONS_URL . '/bootstrap/');
$GLOBALS['xoopsTpl']->assign('wgfilemanager_upload_url', \WGFILEMANAGER_UPLOAD_URL);
// Keywords
$keywords = [];
// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_INDEX, 'link' => 'index.php'];
// Permissions
$GLOBALS['xoopsTpl']->assign('showItem', $fileId > 0);

switch ($op) {
    case 'show':
    case 'list':
    default:

        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('file.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($fileId > 0) {
            $fileObj = $fileHandler->get($fileId);
        } else {
            $fileObj = $fileHandler->create();
        }
        $fileHandlename = (int)$helper->getConfig('file_handlename');
        // Set Vars
        $directoryId    = Request::getInt('directory_id');
        $directoryIdOld = Request::getInt('directory_id_old');
        $fileObj->setVar('directory_id', $directoryId);
        // get full path of current directory
        $dirBasePath = DS;
        if ($directoryId > 0) {
            $dirBasePath .= $directoryHandler->getFullPath($directoryId);
            $dirBasePath .= DS;
        }
        $repoPath = \WGFILEMANAGER_REPO_PATH . $dirBasePath;
        $uploaderErrors = '';
        if (0 == $fileId) {
            //upload new file
            require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
            $filename     = $_FILES['name']['name'];
            $fileMimetype = $_FILES['name']['type'];
            $fileSize     = $_FILES['name']['size'];
            $fileNewName  = substr($filename, 0, (strlen($filename)) - (strlen(strrchr($filename, '.'))));
            $extension    = \str_replace($fileNewName, '', $filename);
            if (Constants::FILE_HANDLENAME_UNIQUE === $fileHandlename) {
                $fileNewName = \preg_replace("/[^a-zA-Z0-9]+/", '', $fileNewName);
            }
            //check for new files, whether file already exists
            if (Constants::FILE_HANDLENAME_ORIGINAL === $fileHandlename && file_exists($repoPath . $fileNewName . $extension)) {
                \redirect_header('file.php?op=list', 5, \_MA_WGFILEMANAGER_FILE_ERROR_EXISTS);
            }
            $allowedMimeTypes = $mimetypeHandler->getMimetypeArray();
            $uploader = new \XoopsMediaUploader($repoPath, $allowedMimeTypes, $helper->getConfig('maxsize_file'), null, null);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                if (Constants::FILE_HANDLENAME_UNIQUE === $fileHandlename) {
                    $uploader->setPrefix($fileNewName . '_');
                }
                $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
                if ($uploader->upload()) {
                    $fileObj->setVar('name', $uploader->getSavedFileName());
                } else {
                    $uploaderErrors .= '<br>' . $uploader->getErrors();
                }
            } else {
                if ($filename > '') {
                    $uploaderErrors .= '<br>' . $uploader->getErrors();
                }
            }
            if ('' !== $uploaderErrors) {
                \redirect_header('file.php?op=edit&file_id=' . $fileId, 5, $uploaderErrors);
            }
        } else {
            //handle existing
            $fileName    = Request::getString('name');
            $fileNameOld = Request::getString('name_old');
            $movefile    = $directoryIdOld !== $directoryId;
            $renameFile  = $fileName !== $fileNameOld;
            if ($directoryIdOld !== $directoryId) {
                //move and rename file
                $dirBasePathOld = DS;
                $dirBasePathOld .= $directoryHandler->getFullPath($directoryIdOld);
                $dirBasePathOld .= DS;

                $fileHandler->renameFile($dirBasePathOld . $fileNameOld, $dirBasePath . $fileName);
            } else {
                if ($fileName !== $fileNameOld) {
                    //rename file
                    $fileHandler->renameFile($dirBasePath . $fileNameOld, $dirBasePath . $fileName);
                }
            }
            $fileObj->setVar('name', $fileName);
        }
        $fileObj->setVar('description', Request::getText('description'));
        $fileObj->setVar('ip', Request::getString('ip'));
        $fileObj->setVar('status', Request::getInt('status'));
        $fileDate_createdObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('date_created'));
        $fileObj->setVar('date_created', $fileDate_createdObj->getTimestamp());
        $fileObj->setVar('submitter', Request::getInt('submitter'));
        // Insert Data
        if ($fileHandler->insert($fileObj)) {
            $newFileId = $fileId > 0 ? $fileId : $fileObj->getNewInsertedId();
            unset($fileObj);
            $fileObj = $fileHandler->get($newFileId);
            $fileSaved = $repoPath . $fileObj->getVar('name');
            $fileObj->setVar('mimetype', \mime_content_type($fileSaved));
            $fileObj->setVar('mtime', \filemtime($fileSaved));
            $fileObj->setVar('ctime', \filectime($fileSaved));
            $fileObj->setVar('size', \filesize($fileSaved));
            $fileHandler->insert($fileObj);
            \redirect_header('index.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGFILEMANAGER_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $fileObj->getHtmlErrors());
        $form = $fileObj->getForm();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_FILE_ADD];
        // Form Create
        $fileObj = $fileHandler->create();
        $fileObj->start = $start;
        $fileObj->limit = $limit;
        $fileObj->setVar('directory_id', $dirId);
        $fileObj->setVar('directory_id_old', $dirId);
        $form = $fileObj->getForm();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_FILE_EDIT];
        // Check params
        if (0 == $fileId) {
            \redirect_header('index.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        // Get Form
        $fileObj = $fileHandler->get($fileId);
        $fileObj->start = $start;
        $fileObj->limit = $limit;
        $form = $fileObj->getForm();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_FILE_DELETE];
        // Check params
        if (0 == $fileId) {
            \redirect_header('index.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        $fileObj = $fileHandler->get($fileId);
        $fileName = $fileObj->getVar('name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('index.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($fileHandler->delete($fileObj)) {
                //get param list
                $params = '?op=list';
                $params .= '&amp;dir_id=' . $dirId;
                $params .= '&amp;start=' . $start;
                $params .= '&amp;limit=' . $limit;
                \redirect_header('index.php' . $params, 3, \_MA_WGFILEMANAGER_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $fileObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'id' => $fileId, 'start' => $start, 'limit' => $limit, 'dir_id' => $dirId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGFILEMANAGER_FORM_SURE_DELETE, $fileName));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'broken':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_BROKEN];
        // Check params
        if (0 == $fileId) {
            \redirect_header('file.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        $fileObj = $fileHandler->get($fileId);
        $fileCategory_id = $fileObj->getVar('directory_id');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('file.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $fileObj->setVar('status', Constants::STATUS_BROKEN);
            if ($fileHandler->insert($fileObj)) {
                \redirect_header('file.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_MA_WGFILEMANAGER_FORM_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $fileObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'id' => $fileId, 'start' => $start, 'limit' => $limit, 'op' => 'broken'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGFILEMANAGER_FORM_SURE_BROKEN, $fileCategory_id));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}

// Keywords
wgfilemanagerMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGFILEMANAGER_URL.'/file.php');

require __DIR__ . '/footer.php';