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

require __DIR__ . '/header.php';
// Get all request values
$op    = Request::getCmd('op', 'list');
$dirId = Request::getInt('dir_id', 1);
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('userpager'));

$GLOBALS['xoopsOption']['template_main'] = 'wgfilemanager_index.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';
// Define Stylesheet
foreach ($styles as $style) {
    $GLOBALS['xoTheme']->addStylesheet($style, null);
}
$GLOBALS['xoTheme']->addStylesheet(\WGFILEMANAGER_URL . '/assets/css/default.css');

$GLOBALS['xoTheme']->addScript('browse.php?Frameworks/jquery/jquery.js');
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGFILEMANAGER_URL.'/index.php');
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgfilemanager_icon_bi_url', \WGFILEMANAGER_ICONS_URL . '/bootstrap/');
$GLOBALS['xoopsTpl']->assign('wgfilemanager_url', \WGFILEMANAGER_URL);
$GLOBALS['xoopsTpl']->assign('wgfilemanager_upload_url', \WGFILEMANAGER_UPLOAD_URL);
//preferences
$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
$indexDirPosition = (string)$helper->getConfig('indexdirposition');
$GLOBALS['xoopsTpl']->assign('indexDirPosLeft', 'left' === $indexDirPosition);
$GLOBALS['xoopsTpl']->assign('indexDirPosTop', 'top' === $indexDirPosition);
$GLOBALS['xoopsTpl']->assign('indexDirPosNone', 'none' === $indexDirPosition);
$GLOBALS['xoopsTpl']->assign('useBroken', (bool)$helper->getConfig('use_broken'));
$GLOBALS['xoopsTpl']->assign('useFavorites', (bool)$helper->getConfig('use_favorites'));
$iconSet = $helper->getConfig('iconset');
// Keywords
$keywords = [];
//get param list
$params = '&amp;dir_id=' . $dirId;
$params .= '&amp;start=' . $start;
$params .= '&amp;limit=' . $limit;
$GLOBALS['xoopsTpl']->assign('params', $params);

$cookieStyle   = $GLOBALS['xoopsConfig']['usercookie'] . '_wgf_indexstyle';
$cookiePreview = $GLOBALS['xoopsConfig']['usercookie'] . '_wgf_indexpreview';
$cookieSorting = $GLOBALS['xoopsConfig']['usercookie'] . '_wgf_indexsort';

switch ($op) {
    case 'list':
    default:
        $GLOBALS['xoTheme']->addScript('browse.php?Frameworks/jquery/jquery.js');
        // handle cookies
        // cookie style
        $cookieIndexstyle = Request::getString($cookieStyle, 'none', 'COOKIE');
        if ('none' === $cookieIndexstyle) {
            $cookieIndexstyle = Constants::COOKIE_STYLE_DEFAULT;
            xoops_setcookie($cookieStyle, $cookieIndexstyle, time() + 60 * 60 * 24 * 30);
        } else {
            $cookieIndexstyle = $_COOKIE[$cookieStyle];
        }
        $GLOBALS['xoopsTpl']->assign('wgfindexstyle', $cookieIndexstyle);
        $GLOBALS['xoopsTpl']->assign('styledefault', Constants::COOKIE_STYLE_DEFAULT);
        $GLOBALS['xoopsTpl']->assign('stylegrouped', Constants::COOKIE_STYLE_GROUPED);
        $GLOBALS['xoopsTpl']->assign('stylecard', Constants::COOKIE_STYLE_CARD);
        $GLOBALS['xoopsTpl']->assign('stylecardbig', Constants::COOKIE_STYLE_CARDBIG);

        // cookie preview
        $cookieIndexPreview = Request::getString($cookiePreview, 'none', 'COOKIE');
        if ('none' === $cookieIndexPreview) {
            $cookieIndexPreview = Constants::COOKIE_NOPREVIEW;
            xoops_setcookie($cookiePreview, $cookieIndexPreview, time() + 60 * 60 * 24 * 30);
        } else {
            $cookieIndexPreview = $_COOKIE[$cookiePreview];
        }
        $GLOBALS['xoopsTpl']->assign('wgfindexpreview', (int)$cookieIndexPreview);
        $GLOBALS['xoopsTpl']->assign('previewshow', Constants::COOKIE_PREVIEW);
        $GLOBALS['xoopsTpl']->assign('previewhide', Constants::COOKIE_NOPREVIEW);

        // cookie sorting
        $cookieIndexSort = Request::getString($cookieSorting, 'none', 'COOKIE');
        if ('none' === $cookieIndexSort) {
            $cookieIndexSort = Constants::COOKIE_SORT_NAME_ASC;
            xoops_setcookie($cookieSorting, $cookieIndexSort, time() + 60 * 60 * 24 * 30);
        } else {
            $cookieIndexSort = $_COOKIE[$cookieSorting];
        }
        $GLOBALS['xoopsTpl']->assign('wgfindexsort', $cookieIndexSort);
        $GLOBALS['xoopsTpl']->assign('sortnameasc', Constants::COOKIE_SORT_NAME_ASC);
        $GLOBALS['xoopsTpl']->assign('sortnamedesc', Constants::COOKIE_SORT_NAME_DESC);
        $GLOBALS['xoopsTpl']->assign('sortctimeasc', Constants::COOKIE_SORT_CTIME_ASC);
        $GLOBALS['xoopsTpl']->assign('sortctimedesc', Constants::COOKIE_SORT_CTIME_DESC);
        $GLOBALS['xoopsTpl']->assign('sortdatecreateasc', Constants::COOKIE_SORT_DATE_CREATE_ASC);
        $GLOBALS['xoopsTpl']->assign('sortdatecreatedesc', Constants::COOKIE_SORT_DATE_CREATE_DESC);
        switch ($cookieIndexSort) {
            case Constants::COOKIE_SORT_NAME_ASC:
            default:
                $sortby = 'name';
                $sortbyDir = 'name';
                $orderby = 'ASC';
                break;
            case Constants::COOKIE_SORT_NAME_DESC:
                $sortby = 'name';
                $sortbyDir = 'name';
                $orderby = 'DESC';
                break;
            case Constants::COOKIE_SORT_CTIME_ASC:
                $sortby = 'ctime';
                $sortbyDir = 'date_created';
                $orderby = 'ASC';
                break;
            case Constants::COOKIE_SORT_CTIME_DESC:
                $sortby = 'ctime';
                $sortbyDir = 'date_created';
                $orderby = 'DESC';
                break;
            case Constants::COOKIE_SORT_DATE_CREATE_ASC:
                $sortby = 'date_created';
                $sortbyDir = 'date_created';
                $orderby = 'ASC';
                break;
            case Constants::COOKIE_SORT_DATE_CREATE_DESC:
                $sortby = 'date_created';
                $sortbyDir = 'date_created';
                $orderby = 'DESC';
                break;
        }

        // Breadcrumbs
        if ($dirId > 1) {
            $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_INDEX, 'link' => 'index.php'];
            $dirArray = $directoryHandler->getDirListBreadcrumb($dirId);
            $dirListBreadcrumb = array_reverse($dirArray, true);
            foreach ($dirListBreadcrumb as $key => $value) {
                if ($key == array_key_last($dirListBreadcrumb)) {
                    $xoBreadcrumbs[] = ['title' => $value];
                } else {
                    $xoBreadcrumbs[] = ['title' => $value, 'link' => 'index.php?dir_id=' . $key];
                }
            }
        } else {
            $xoBreadcrumbs[] = ['title' => \_MA_WGFILEMANAGER_INDEX];
        }

        //get permissions
        $GLOBALS['xoopsTpl']->assign('permCreateDir', $permissionsHandler->getPermSubmitDirectory($dirId));
        $GLOBALS['xoopsTpl']->assign('permEditDir', $permissionsHandler->getPermSubmitDirectory($dirId));
        $GLOBALS['xoopsTpl']->assign('permEditFile', $permissionsHandler->getPermSubmitDirectory($dirId));
        $GLOBALS['xoopsTpl']->assign('permDownloadFileFromDir', $permissionsHandler->getPermDownloadFileFromDir($dirId));
        $GLOBALS['xoopsTpl']->assign('permUploadFileToDir', $permissionsHandler->getPermUploadFileToDir($dirId));
        $GLOBALS['xoopsTpl']->assign('permViewDirectory', $permissionsHandler->getPermViewDirectory($dirId));
        $GLOBALS['xoopsTpl']->assign('showBtnDetails', true);

        //get directory list
        $dirList = $directoryHandler->getDirList(0, $dirId);
        $GLOBALS['xoopsTpl']->assign('dir_list', $dirList);
        $GLOBALS['xoopsTpl']->assign('dirId', $dirId);
        $indexDirList = $directoryHandler->getSubDirList($dirId, $sortbyDir, $orderby);
        $GLOBALS['xoopsTpl']->assign('indexDirlist', $indexDirList);
        $GLOBALS['xoopsTpl']->assign('indexDirlistIcon', WGFILEMANAGER_ICONS_URL . '/foldericons/folder2.png');

        // get files
        $crFile = new \CriteriaCompo();
        $crFile->add(new \Criteria('directory_id', $dirId));
        $fileCount = $fileHandler->getCount($crFile);

        $fileList = [];
        $crFile->setStart($start);
        $crFile->setLimit($limit);
        $crFile->setSort($sortby);
        $crFile->setOrder($orderby);
        if ($fileCount > 0) {
            $fileIcons = [];
            if ('none' !== $iconSet) {
                $fileIcons = $fileHandler->getFileIconCollection($iconSet);
            }
            $fileAll = $fileHandler->getAll($crFile);
            foreach (\array_keys($fileAll) as $i) {
                $file = $fileAll[$i]->getValuesFile();
                $ext = '';
                if (strpos($file['name'],'.') > 0) {
                    $ext  = substr(strrchr($file['name'], '.'), 1);
                }
                $fileCategory = isset($fileIcons['files'][$ext]) ? (int)$fileIcons['files'][$ext]['category'] : 0;
                $file['category']  = $fileCategory;
                $file['icon_url']  = isset($fileIcons['files'][$ext]) ? $fileIcons['files'][$ext]['src'] : $fileIcons['default'];
                $file['image']     = false;
                $file['image_url'] = '';
                $file['pdf']       = false;
                $file['pdf_url']   = '';
                switch ($fileCategory) {
                    case 0:
                        break;
                    case Constants::MIMETYPE_CAT_IMAGE:
                        $file['image'] = true;
                        $file['image_url'] = $file['real_url'];
                        break;
                    case Constants::MIMETYPE_CAT_PDF:
                        $file['pdf'] = true;
                        $file['pdf_url'] = $file['real_url'];
                        break;
                }
                $fileList[$i]        = $file;
            }
        }
        $GLOBALS['xoopsTpl']->assign('indexFilelist', $fileList);

        $block['fav_list'] = [];
        if ((bool)$helper->getConfig('use_favorites')) {
            //get fav list
            $favList = [];
            //get directory fav list
            $favList['dirs'] = $directoryHandler->getFavDirList();
            //get directory fav list
            $favList['files'] = $fileHandler->getFavFileList();
            $GLOBALS['xoopsTpl']->assign('fav_list', $favList);
        }
        // Display Navigation
        if ($fileCount > $limit) {
            require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
            $pagenav = new \XoopsPageNav($fileCount, $limit, $start, 'start', 'op=list&amp;limit=' . $limit . '&amp;dir_id=' . $dirId);
            $GLOBALS['xoopsTpl']->assign('pagenavFile', $pagenav->renderNav());
        }

        //get current user
        $userUid = 0;
        if (isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser'])) {
            $userUid = $GLOBALS['xoopsUser']->uid();
        }
        $GLOBALS['xoopsTpl']->assign('userUid', $userUid);
        break;

    case 'setstyle':
        // set cookies and reload
        $styleType = Request::getString('style');
        xoops_setcookie($cookieStyle, $styleType, time() + 60 * 60 * 24 * 30);
        \redirect_header('index.php?op=list' . $params, 0);
        break;
    case 'setpreview':
        // set cookies and reload
        $previewType = Request::getInt('preview');
        xoops_setcookie($cookiePreview, $previewType, time() + 60 * 60 * 24 * 30);

        \redirect_header('index.php?op=list' . $params, 0);
        break;
    case 'setsort':
        // set cookies and reload
        $sortType = Request::getInt('sort');
        xoops_setcookie($cookieSorting, $sortType, time() + 60 * 60 * 24 * 30);

        \redirect_header('index.php?op=list' . $params, 0);
        break;
}

// Keywords
wgfilemanagerMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

require __DIR__ . '/footer.php';
