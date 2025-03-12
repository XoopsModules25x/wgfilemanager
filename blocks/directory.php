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
function b_wgfilemanager_directory_show($options)
{
    $block      = [];
    $typeBlock  = $options[0];
    $limit      = $options[1];
    $lengthName = $options[2];
    $helper     = Helper::getInstance();
    $directoryHandler = $helper->getHandler('Directory');
    $crDirectory = new \CriteriaCompo();
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);

    switch ($typeBlock) {
        case 'last':
        default:
            // For the block: directory last
            $crDirectory->setSort('date_created');
            $crDirectory->setOrder('DESC');
            break;
        case 'new':
            // For the block: directory new
            // new since last week: 7 * 24 * 60 * 60 = 604800
            $crDirectory->add(new \Criteria('date_created', \time() - 604800, '>='));
            $crDirectory->add(new \Criteria('date_created', \time(), '<='));
            $crDirectory->setSort('date_created');
            $crDirectory->setOrder('ASC');
            break;
    }

    $crDirectory->setLimit($limit);
    $directoryAll = $directoryHandler->getAll($crDirectory);
    unset($crDirectory);
    if (\count($directoryAll) > 0) {
        foreach (\array_keys($directoryAll) as $i) {
            $block[$i]['id'] = $directoryAll[$i]->getVar('id');
            $nameShort = \htmlspecialchars($directoryAll[$i]->getVar('name'), ENT_QUOTES | ENT_HTML5);
            if ($lengthName > 0) {
                $nameShort = \substr($nameShort, 0, (int)$lengthName);
            }
            $block[$i]['name'] =  $nameShort;
        }
    }
    $GLOBALS['xoopsTpl']->assign('wgfilemanager_url', \WGFILEMANAGER_URL);
    return $block;

}

/**
 * Function edit block
 * @param  $options
 * @return string
 */
function b_wgfilemanager_directory_edit($options)
{
    $GLOBALS['xoopsTpl']->assign('wgfilemanager_upload_url', \WGFILEMANAGER_UPLOAD_URL);
    $form = "<input type='hidden' name='options[0]' value='".$options[0]."' >";
    $form .= \_MB_WGFILEMANAGER_DISPLAY . " : <input type='text' name='options[1]' size='5' maxlength='255' value='" . $options[1] . "' >&nbsp;<br>";
    $form .= \_MB_WGFILEMANAGER_NAME_LENGTH . " : <input type='text' name='options[2]' size='5' maxlength='255' value='" . $options[2] . "' ><br><br>";

    return $form;

}
