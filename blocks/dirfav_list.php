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

//use XoopsModules\Wgfilemanager;
use XoopsModules\Wgfilemanager\Helper;
//use XoopsModules\Wgfilemanager\Constants;
use Xmf\Request;

require_once \XOOPS_ROOT_PATH . '/modules/wgfilemanager/include/common.php';

/**
 * Function show block
 * @param  $options
 * @return array
 */
function b_wgfilemanager_dirfavlist_show($options)
{
    global $xoopsModule;

    $helper           = Helper::getInstance();
    $directoryHandler = $helper->getHandler('Directory');
    $fileHandler      = $helper->getHandler('File');

    $typeBlock  = $options[0];
    $lengthName = (int)$options[1];
    $typeList   = 0;
    if (isset($options[2])) {
        $typeList = (int)$options[2];
    }
    $GLOBALS['xoopsTpl']->assign('wgfilemanager_typeblock', $typeBlock);
    $GLOBALS['xoTheme']->addStylesheet(\WGFILEMANAGER_URL . '/assets/css/default.css');

    $block = [];

    $dirId = Request::getInt('dir_id', 0);
    if ((!empty($xoopsModule))) {
        $moduleDirName = \basename(\dirname(__DIR__));
/*        echo "<br>xoopsModule:".$moduleDirName. " " . $xoopsModule->getByDirname($moduleDirName)->getVar('mid');
        echo "<br>xoopsModule:".$xoopsModule->getVar('mid');*/
        if ($xoopsModule->getByDirname($moduleDirName)->getVar('mid') === $xoopsModule->getVar('mid')) {
            $dirId = Request::getInt('dir_id', 1);
        }
    }
    $collapseFav = false;
    $collapseDir = false;
    if ('collapsable' === (string)$options[0]) {
        switch ($typeList) {
            case 1:
                $collapseFav = true;
                $collapseDir = false;
                break;
            case 2:
                $collapseFav = false;
                $collapseDir = true;
                break;
            case 0:
            default:
                $collapseFav = true;
                $collapseDir = true;
                break;
        }
    }
    $GLOBALS['xoopsTpl']->assign('collapseFav', $collapseFav);
    $GLOBALS['xoopsTpl']->assign('collapseDir', $collapseDir);
    if (0 === $lengthName) {
        $lengthName = 1000;
    }
    $GLOBALS['xoopsTpl']->assign('lengthName', $lengthName);

    //get directory list
    $block['dir_list'] = $directoryHandler->getDirList(0, $dirId);

    $block['fav_list'] = [];
    if ((bool)$helper->getConfig('use_favorites')) {
        //get fav list
        $favList = [];
        //get directory fav list
        $favList['dirs'] = $directoryHandler->getFavDirList();
        //get directory fav list
        $favList['files'] = $fileHandler->getFavFileList();
        $block['fav_list'] = $favList;
        $GLOBALS['xoopsTpl']->assign('countFavlist', count($favList['dirs']) + count($favList['files']));
    }

    $GLOBALS['xoopsTpl']->assign('wgfilemanager_url', \WGFILEMANAGER_URL);
    $GLOBALS['xoopsTpl']->assign('wgfilemanager_icon_bi_url', \WGFILEMANAGER_ICONS_URL . '/bootstrap/');
    return $block;

}

/**
 * Function edit block
 * @param  $options
 * @return string
 */
function b_wgfilemanager_dirfavlist_edit($options)
{
    $GLOBALS['xoopsTpl']->assign('wgfilemanager_upload_url', \WGFILEMANAGER_UPLOAD_URL);
    $form = "<input type='hidden' name='options[0]' value='".$options[0]."' >";
    $form .= \_MB_WGFILEMANAGER_NAME_LENGTH . " : <input type='text' name='options[1]' size='5' maxlength='255' value='" . $options[1] . "' ><br><br>";
    if ('collapsable' === (string)$options[0]) {
        $form .= \_MB_WGFILEMANAGER_DIRFAV_COL_TYPE . ": <select name='options[2]' size='3'>";
        $form .= "<option value='0' " . (0 === (int)$options[2] ? "selected='selected'" : '') . '>' . \_MB_WGFILEMANAGER_DIRFAV_COL_TYPE_0 . '</option>';
        $form .= "<option value='1' " . (1 === (int)$options[2] ? "selected='selected'" : '') . '>' . \_MB_WGFILEMANAGER_DIRFAV_COL_TYPE_1 . '</option>';
        $form .= "<option value='2' " . (2 === (int)$options[2] ? "selected='selected'" : '') . '>' . \_MB_WGFILEMANAGER_DIRFAV_COL_TYPE_2 . '</option>';
        $form .= '</select><br>';
    }

    return $form;

}
