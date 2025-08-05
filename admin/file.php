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
// Get all request values
$op     = Request::getCmd('op', 'list');
$fileId = Request::getInt('id');
$start  = Request::getInt('start');
$limit  = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgfilemanager_admin_file.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('file.php'));
        $adminObject->addItemButton(\_AM_WGFILEMANAGER_ADD_FILE, 'file.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $fileCount = $fileHandler->getCountFile();
        $fileAll = $fileHandler->getAllFile($start, $limit);
        $GLOBALS['xoopsTpl']->assign('file_count', $fileCount);
        $GLOBALS['xoopsTpl']->assign('wgfilemanager_url', \WGFILEMANAGER_URL);
        $GLOBALS['xoopsTpl']->assign('wgfilemanager_upload_url', \WGFILEMANAGER_UPLOAD_URL);
        // Table view file
        if ($fileCount > 0) {
            foreach (\array_keys($fileAll) as $i) {
                $file = $fileAll[$i]->getValuesFile();
                $GLOBALS['xoopsTpl']->append('file_list', $file);
                unset($file);
            }
            // Display Navigation
            if ($fileCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($fileCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGFILEMANAGER_THEREARENT_FILE);
        }
        break;
    case 'new':
        $templateMain = 'wgfilemanager_admin_file.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('file.php'));
        $adminObject->addItemButton(\_AM_WGFILEMANAGER_LIST_FILE, 'file.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $fileObj = $fileHandler->create();
        $form = $fileObj->getForm();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
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
        $dirBasePath = '/';
        if ($directoryId > 0) {
            $dirBasePath .= $directoryHandler->getFullPath($directoryId);
            $dirBasePath .= '/';
        }
        $repoPath = \WGFILEMANAGER_REPO_PATH . $dirBasePath;
        $uploaderErrors = '';
        if (0 == $fileId) {
            //upload new file
            require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
            $filename     = $_FILES['fil_name']['name'];
            $fileMimetype = $_FILES['fil_name']['type'];
            $fileSize     = $_FILES['fil_name']['size'];
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
            $fileName    = Request::getString('fil_name');
            $fileNameOld = Request::getString('fil_name_old');
            $movefile    = $directoryIdOld !== $directoryId;
            $renameFile  = $fileName !== $fileNameOld;
            if ($directoryIdOld !== $directoryId) {
                //move and rename file
                $dirBasePathOld = '/';
                $dirBasePathOld .= $directoryHandler->getFullPath($directoryIdOld);
                $dirBasePathOld .= '/';

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
            \redirect_header('file.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGFILEMANAGER_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $fileObj->getHtmlErrors());
        $form = $fileObj->getForm();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgfilemanager_admin_file.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('file.php'));
        $adminObject->addItemButton(\_AM_WGFILEMANAGER_ADD_FILE, 'file.php?op=new');
        $adminObject->addItemButton(\_AM_WGFILEMANAGER_LIST_FILE, 'file.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $fileObj = $fileHandler->get($fileId);
        $fileObj->start = $start;
        $fileObj->limit = $limit;
        $form = $fileObj->getForm();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgfilemanager_admin_file.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('file.php'));
        $fileObj = $fileHandler->get($fileId);
        $fileName = $fileObj->getVar('name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('file.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($fileHandler->delete($fileObj)) {
                \redirect_header('file.php', 3, \_AM_WGFILEMANAGER_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $fileObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'id' => $fileId, 'start' => $start, 'limit' => $limit, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGFILEMANAGER_FORM_SURE_DELETE, $fileName));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
