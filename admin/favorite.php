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
$op    = Request::getCmd('op', 'list');
$favId = Request::getInt('id');
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgfilemanager_admin_favorite.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('favorite.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $GLOBALS['xoopsTpl']->assign('wgfilemanager_url', \WGFILEMANAGER_URL);
        $GLOBALS['xoopsTpl']->assign('wgfilemanager_upload_url', \WGFILEMANAGER_UPLOAD_URL);
        $favoriteCount = $favoriteHandler->getCount();
        $GLOBALS['xoopsTpl']->assign('favorite_count', $favoriteCount);
        // Table view favorite
        if ($favoriteCount > 0) {
            $favoriteAll = $favoriteHandler->getAllFavorite($start, $limit);
            foreach (\array_keys($favoriteAll) as $i) {
                $favorite = $favoriteAll[$i]->getValuesFavorite();
                $GLOBALS['xoopsTpl']->append('favorite_list', $favorite);
                unset($favorite);
            }
            // Display Navigation
            if ($favoriteCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($favoriteCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGFILEMANAGER_THEREARENT_FAVORITE);
        }
        break;
    case 'delete':
        $templateMain = 'wgfilemanager_admin_favorite.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('favorite.php'));
        $favoriteObj = $favoriteHandler->get($favId);
        $dirName = $favoriteObj->getVar('name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('favorite.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $dirFullPath = $favoriteObj->getVar('fullpath');
            if ($favoriteHandler->delete($favoriteObj)) {
                \redirect_header('favorite.php', 3, \_AM_WGFILEMANAGER_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $favoriteObj->getHtmlErrors());
            }
        } else {
            $confirmText = _AM_WGFILEMANAGER_FORM_SURE_DELETE;
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'id' => $favId, 'start' => $start, 'limit' => $limit, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_AM_WGFILEMANAGER_FORM_SURE_DELETE, $favId));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
