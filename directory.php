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
$GLOBALS['xoopsOption']['template_main'] = 'wgfilemanager_directory.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';

$op       = Request::getCmd('op', 'list');
$dirId    = Request::getInt('id');
$parentId = Request::getInt('parent_id');
$start    = Request::getInt('start');
$limit    = Request::getInt('limit', $helper->getConfig('userpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

// Define Stylesheet
foreach ($styles as $style) {
    $GLOBALS['xoTheme']->addStylesheet($style, null);
}
$GLOBALS['xoTheme']->addStylesheet(\WGFILEMANAGER_URL . '/assets/css/default.css');
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgfilemanager_url', \WGFILEMANAGER_URL);
// Keywords
$keywords = [];
// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_INDEX, 'link' => 'index.php'];
// Permissions
$permCreate   = $permissionsHandler->getPermSubmitDirectory($parentId);
$permEdit     = $permissionsHandler->getPermSubmitDirectory($dirId);
$GLOBALS['xoopsTpl']->assign('permCreate', $permCreate);
$GLOBALS['xoopsTpl']->assign('permEdit', $permEdit);

$GLOBALS['xoopsTpl']->assign('showItem', $dirId > 0);

switch ($op) {
    case 'list':
    default:
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_DIRECTORY_LIST];
        $dirList = $directoryHandler->getDirList(0, $dirId);
        $GLOBALS['xoopsTpl']->assign('directoryCount', \count($dirList));
        $GLOBALS['xoopsTpl']->assign('directory_list', $dirList);
        $GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
        $GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
        $GLOBALS['xoopsTpl']->assign('wgfilemanager_icon_bi_url', \WGFILEMANAGER_ICONS_URL . '/bootstrap/');

        $directoryStyle = $helper->getConfig('directorystyle');
        if ('sortable' === $directoryStyle) {
            $GLOBALS['xoTheme']->addScript(\WGFILEMANAGER_URL . '/assets/js/jquery-ui.min.js');
            $GLOBALS['xoTheme']->addScript(\WGFILEMANAGER_URL . '/assets/js/sortable.js');
            $GLOBALS['xoTheme']->addScript(\WGFILEMANAGER_URL . '/assets/js/jquery.mjs.nestedSortable.js');
            $GLOBALS['xoTheme']->addStylesheet(\WGFILEMANAGER_URL . '/assets/css/nestedsortable.css');
            $GLOBALS['xoTheme']->addStylesheet(\WGFILEMANAGER_URL . '/assets/css/sortabledir.css');
        }
        $GLOBALS['xoopsTpl']->assign('directoryStyle', $directoryStyle);
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('directory.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if (!$permissionsHandler->getPermGlobalSubmit()) {
            \redirect_header('directory.php?op=list', 3, \_NOPERM);
        }
        if ($dirId > 0) {
            $directoryObj = $directoryHandler->get($dirId);
        } else {
            $directoryObj = $directoryHandler->create();
        }
        $dirParentId    = Request::getInt('parent_id');
        $dirParentIdOld = Request::getInt('parent_id_old');
        $dirName        = Request::getString('name');
        $dirNameOld     = Request::getString('name_old');
        $dirDescription = Request::getText('description');
        $dirWeight      = Request::getInt('weight');
        $moveDir        = false;
        $renameDir      = false;
        if ($dirId > 1) {
            $moveDir   = $dirParentId !== $dirParentIdOld;
            $renameDir = $dirName !== $dirNameOld;
        }
        // get full path
        $dirBasePath = '/';
        $dirFullPath = $dirBasePath;
        if ($dirParentId > 0) {
            $path = $directoryHandler->getFullPath($dirParentId);
            if ('' !== $path) {
                $dirBasePath .= $path . '/';
            }
            $dirFullPath = $dirBasePath . \mb_strtolower($dirName);
        }
        $dirFullPathOld = '';
        if ($moveDir) {
            $dirBasePathOld = '/';
            if ($dirParentIdOld > 1) {
                $dirBasePathOld .= $directoryHandler->getFullPath($dirParentIdOld);
                $dirBasePathOld .= '/';
            }
            $dirFullPathOld = $dirBasePathOld . \mb_strtolower($dirNameOld);
        }
        //check whether directory exist
        $dirExists = $directoryHandler->existDirectory($dirFullPath);
        //if new or move dir or rename dir then check that folder doesn't exist
        if ((0 === $dirId || $moveDir || $renameDir) && $dirExists) {
            $templateMain = 'wgfilemanager_admin_directory.tpl';
            $directoryObj->setVar('parent_id', $dirParentId);
            $directoryObj->setVar('name', $dirName);
            $directoryObj->setVar('description', $dirDescription);
            $directoryObj->setVar('weight', $dirWeight);
            $form = $directoryObj->getForm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGFILEMANAGER_DIRECTORY_ERROR_EXISTS);
        } else {
            // Set Vars
            $directoryObj->setVar('parent_id', $dirParentId);
            $directoryObj->setVar('name', $dirName);
            $directoryObj->setVar('description', $dirDescription);
            $directoryObj->setVar('fullpath', $dirFullPath);
            $directoryObj->setVar('weight', $dirWeight);
            $directoryDate_createdObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('date_created'));
            $directoryObj->setVar('date_created', $directoryDate_createdObj->getTimestamp());
            $directoryObj->setVar('submitter', Request::getInt('submitter'));
            // Insert Data
            if ($directoryHandler->insert($directoryObj)) {
                if ($moveDir) {
                    $directoryHandler->moveDirectory($dirFullPathOld, $dirFullPath);
                } else if ($renameDir) {
                    $directoryHandler->renameDirectory($dirBasePath . $dirNameOld, $dirFullPath);
                } else if (!$dirExists) {
                    $directoryHandler->createDirectory($dirFullPath);
                }
                if ('directory' === $helper->getConfig('permission_type')) {
                    $newDirId = $directoryObj->getNewInsertedId();
                    $permId = isset($_REQUEST['id']) ? $dirId : $newDirId;
                    $grouppermHandler = \xoops_getHandler('groupperm');
                    $mid = $GLOBALS['xoopsModule']->getVar('mid');
                    // Permission to view_directory
                    $grouppermHandler->deleteByModule($mid, 'wgfilemanager_view_directory', $permId);
                    if (isset($_POST['groups_view_directory'])) {
                        foreach ($_POST['groups_view_directory'] as $onegroupId) {
                            $grouppermHandler->addRight('wgfilemanager_view_directory', $permId, $onegroupId, $mid);
                        }
                    }
                    // Permission to submit_directory
                    $grouppermHandler->deleteByModule($mid, 'wgfilemanager_submit_directory', $permId);
                    if (isset($_POST['groups_submit_directory'])) {
                        foreach ($_POST['groups_submit_directory'] as $onegroupId) {
                            $grouppermHandler->addRight('wgfilemanager_submit_directory', $permId, $onegroupId, $mid);
                        }
                    }
                    // Permission to approve_directory
                    $grouppermHandler->deleteByModule($mid, 'wgfilemanager_approve_directory', $permId);
                    if (isset($_POST['groups_approve_directory'])) {
                        foreach ($_POST['groups_approve_directory'] as $onegroupId) {
                            $grouppermHandler->addRight('wgfilemanager_approve_directory', $permId, $onegroupId, $mid);
                        }
                    }
                }
                $directoryHandler->setDirWeight($dirParentId);
                \redirect_header('directory.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGFILEMANAGER_FORM_OK);
            }
            $GLOBALS['xoopsTpl']->assign('error', $directoryObj->getHtmlErrors());
        }
        break;
    case 'new':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_DIRECTORY_ADD];
        // Check permissions
        if (!$permissionsHandler->getPermGlobalSubmit()) {
            \redirect_header('directory.php?op=list', 3, \_NOPERM);
        }
        // Form Create
        $directoryObj = $directoryHandler->create();
        $directoryObj->setVar('parent_id', $parentId);
        $form = $directoryObj->getForm();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_DIRECTORY_EDIT];
        // Check permissions
        if (!$permissionsHandler->getPermGlobalSubmit()) {
            \redirect_header('directory.php?op=list', 3, \_NOPERM);
        }
        // Check params
        if (0 === $dirId) {
            \redirect_header('directory.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        // Get Form
        $directoryObj = $directoryHandler->get($dirId);
        $directoryObj->start = $start;
        $directoryObj->limit = $limit;
        $form = $directoryObj->getForm();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'clone':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_DIRECTORY_CLONE];
        // Check permissions
        if (!$permissionsHandler->getPermGlobalSubmit()) {
            \redirect_header('directory.php?op=list', 3, \_NOPERM);
        }
        // Request source
        $dirIdSource = Request::getInt('id_source');
        // Check params
        if (0 === $dirIdSource) {
            \redirect_header('directory.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        // Get Form
        $directoryObjSource = $directoryHandler->get($dirIdSource);
        $directoryObj = $directoryObjSource->xoopsClone();
        $form = $directoryObj->getForm();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_DIRECTORY_DELETE];
        // Check permissions
        if (!$permissionsHandler->getPermGlobalSubmit()) {
            \redirect_header('directory.php?op=list', 3, \_NOPERM);
        }
        // Check params
        if (0 === $dirId) {
            \redirect_header('directory.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        $directoryObj = $directoryHandler->get($dirId);
        $dirName = $directoryObj->getVar('name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('directory.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $dirFullPath = $directoryObj->getVar('fullpath');
            if ($directoryHandler->delete($directoryObj)) {
                if ($directoryHandler->deleteDirectory($dirFullPath)) {
                    if ($directoryHandler->deleteSubDirData($dirId)) {
                        \redirect_header('directory.php', 3, \_AM_WGFILEMANAGER_FORM_DELETE_OK);
                    } else {
                        \redirect_header('directory.php', 3, \_MA_WGFILEMANAGER_DIRECTORY_ERROR_DELETE_SUBDIRDATA);
                    }
                } else {
                    \redirect_header('directory.php', 3, \_MA_WGFILEMANAGER_DIRECTORY_ERROR_DELETE);
                }

            } else {
                $GLOBALS['xoopsTpl']->assign('error', $directoryObj->getHtmlErrors());
            }
        } else {
            $confirmText = \sprintf(\_MA_WGFILEMANAGER_DIRECTORY_DELETE_SINGLE, $dirName);
            if ($directoryHandler->dirIsParent($dirId)) {
                $confirmText .= \sprintf(\_MA_WGFILEMANAGER_DIRECTORY_DELETE_ISPARENT, $dirName);
            }
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'id' => $dirId, 'start' => $start, 'limit' => $limit, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                $confirmText);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'favorite_pin':
        //check perms
        if (!$permissionsHandler->getPermGlobalSubmit()) {
            \redirect_header('index.php?op=list', 3, \_NOPERM);
        }
        // Check params
        if (0 === $dirId) {
            \redirect_header('index.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        //get current user
        $userUid = 0;
        if (isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser'])) {
            $userUid = $GLOBALS['xoopsUser']->uid();
        }
        if (0 === $userUid) {
            \redirect_header('index.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        $favoriteObj = $favoriteHandler->create();
        $favoriteObj->setVar('directory_id', $dirId);
        $favoriteObj->setVar('date_created', \time());
        $favoriteObj->setVar('submitter', $userUid);
        if ($favoriteHandler->insert($favoriteObj)) {
            \redirect_header('index.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGFILEMANAGER_FORM_OK);
        } else {
            \redirect_header('index.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_MA_WGFILEMANAGER_FAVORITE_ERROR_SET);
        }
        break;
    case 'favorite_unpin':
        //check perms
        if (!$permissionsHandler->getPermGlobalSubmit()) {
            \redirect_header('index.php?op=list', 3, \_NOPERM);
        }
        // Check params
        if (0 === $dirId) {
            \redirect_header('index.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        $favoriteId = Request::getInt('favorite_id');
        if (0 === $favoriteId) {
            \redirect_header('index.php?op=list', 3, \_MA_WGFILEMANAGER_INVALID_PARAM);
        }
        $favoriteObj = $favoriteHandler->get($favoriteId);
        if ($favoriteHandler->delete($favoriteObj, true)) {
            \redirect_header('index.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_AM_WGFILEMANAGER_FORM_OK);
        } else {
            \redirect_header('index.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_MA_WGFILEMANAGER_FAVORITE_ERROR_SET);
        }
        break;
/*    case 'order':
        $aorder         = Request::getArray('menuItem');
        $i              = 0;
        $moveDir        = false;
        $moveDirId      = 0;
        $dirExists      = false;
        $dirFullPath    = '';
        $dirFullPathOld = '';
        //  first check folders
        foreach (\array_keys($aorder) as $key) {
            $dirParentId    = (int)$aorder[$key];
            $directoryObj   = $directoryHandler->get($key);
            $dirName        = $directoryObj->getVar('name');
            $dirParentIdOld = $directoryObj->getVar('parent_id');
            // check whether folder is moved to other parent
            $moveDir   = ($dirParentIdOld !== $dirParentId);
            if ($moveDir) {
                $moveDirId       = $key;
                $dirFullPathOld  = $directoryObj->getVar('fullpath');
                $directoryObjNew = $directoryHandler->get($dirParentId);
                $dirFullPath = '';
                if ($dirParentId > 0) {
                    $dirFullPath .= $directoryObjNew->getVar('fullpath');
                }
                if (!\str_ends_with($dirFullPath, '/')) {
                    $dirFullPath .= '/';
                }
                $dirFullPath .= \mb_strtolower($dirName);
                //check whether directory exist
                $dirExists = $directoryHandler->existDirectory($dirFullPath);
            }
            unset($directoryObj);
        }
        if ($dirExists) {
            XoopsLoad::load('xoopslogger');
            $xoopsLogger = XoopsLogger::getInstance();
            $xoopsLogger->activated = false;
            header('Content-Type: application/json');
            echo json_encode(['status'=>'error','message'=>\_MA_WGFILEMANAGER_DIRECTORY_ERROR_EXISTS_JS]);
            die;
        } else {
            // if no troubles save data and move folder if necessary
            foreach (\array_keys($aorder) as $key) {
                $dirParentId  = (int)$aorder[$key];
                $directoryObj = $directoryHandler->get($key);
                $dirName      = $directoryObj->getVar('name');
                $directoryObj->setVar('parent_id', $dirParentId);
                if ($moveDirId > 0 && $moveDirId == $key) {
                    $directoryObj->setVar('fullpath', $dirFullPath);
                    $directoryHandler->moveDirectory($dirFullPathOld, $dirFullPath);
                }
                $directoryObj->setVar('weight', $i + 1);
                $directoryHandler->insert($directoryObj);
                unset($directoryObj);
                $i++;
            }
        }

        break;*/
}

// Keywords
wgfilemanagerMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGFILEMANAGER_URL.'/directory.php');
$GLOBALS['xoopsTpl']->assign('wgfilemanager_upload_url', \WGFILEMANAGER_UPLOAD_URL);

require __DIR__ . '/footer.php';

