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

require \dirname(__DIR__, 3) . '/include/cp_header.php';
require_once \dirname(__DIR__) . '/include/common.php';

$sysPathIcon16   = '../' . $GLOBALS['xoopsModule']->getInfo('sysicons16');
$sysPathIcon32   = '../' . $GLOBALS['xoopsModule']->getInfo('sysicons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');
$modPathIcon16   = \WGFILEMANAGER_URL . '/' . $GLOBALS['xoopsModule']->getInfo('modicons16') . '/';
$modPathIcon32   = \WGFILEMANAGER_URL . '/' . $GLOBALS['xoopsModule']->getInfo('modicons32') . '/';

// Get instance of module
$helper = \XoopsModules\Wgfilemanager\Helper::getInstance();
$directoryHandler = $helper->getHandler('Directory');
$fileHandler = $helper->getHandler('File');
$mimetypeHandler = $helper->getHandler('Mimetype');
if ((bool)$helper->getConfig('use_favorites')) {
    $favoriteHandler = $helper->getHandler('Favorite');
}
$myts = MyTextSanitizer::getInstance();

// 
if (!isset($xoopsTpl) || !\is_object($xoopsTpl)) {
    require_once \XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new \XoopsTpl();
}

// Load languages
\xoops_loadLanguage('admin', 'wgfilemanager');
\xoops_loadLanguage('modinfo', 'wgfilemanager');
// \xoops_loadLanguage('main', 'wgfilemanager');


// Local admin menu class
if (\file_exists($GLOBALS['xoops']->path($pathModuleAdmin.'/moduleadmin.php'))) {
    require_once $GLOBALS['xoops']->path($pathModuleAdmin.'/moduleadmin.php');
} else {
    \redirect_header('../../../admin.php', 5, \_AM_MODULEADMIN_MISSING);
}

xoops_cp_header();

// System icons path
$GLOBALS['xoopsTpl']->assign('sysPathIcon16', $sysPathIcon16);
$GLOBALS['xoopsTpl']->assign('sysPathIcon32', $sysPathIcon32);
$GLOBALS['xoopsTpl']->assign('modPathIcon16', $modPathIcon16);
$GLOBALS['xoopsTpl']->assign('modPathIcon32', $modPathIcon32);

$adminObject = \Xmf\Module\Admin::getInstance();
$style = \WGFILEMANAGER_URL . '/assets/css/admin/style.css';
