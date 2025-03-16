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

$dirname       = \basename(\dirname(__DIR__));
$moduleHandler = \xoops_getHandler('module');
$xoopsModule   = XoopsModule::getByDirname($dirname);
$moduleInfo    = $moduleHandler->get($xoopsModule->getVar('mid'));
$sysPathIcon32 = $moduleInfo->getInfo('sysicons32');
$helper = \XoopsModules\Wgfilemanager\Helper::getInstance();

$adminmenu[] = [
    'title' => \_MI_WGFILEMANAGER_ADMENU1,
    'link' => 'admin/index.php',
    'icon' => 'assets/icons/32/dashboard.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFILEMANAGER_ADMENU2,
    'link' => 'admin/directory.php',
    'icon' => 'assets/icons/32/directory.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFILEMANAGER_ADMENU3,
    'link' => 'admin/file.php',
    'icon' => 'assets/icons/32/file.png',
];
if ((bool)$helper->getConfig('use_broken')) {
    $adminmenu[] = [
        'title' => \_MI_WGFILEMANAGER_ADMENU4,
        'link' => 'admin/broken.php',
        'icon' => 'assets/icons/32/broken.png',
    ];
}
if ((bool)$helper->getConfig('use_favorites')) {
    $adminmenu[] = [
        'title' => \_MI_WGFILEMANAGER_ADMENU9,
        'link' => 'admin/favorite.php',
        'icon' => 'assets/icons/32/favorite.png',
    ];
}
$adminmenu[] = [
    'title' => \_MI_WGFILEMANAGER_ADMENU5,
    'link' => 'admin/mimetype.php',
    'icon' => 'assets/icons/32/mimetype.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFILEMANAGER_ADMENU6,
    'link' => 'admin/permissions.php',
    'icon' => 'assets/icons/32/permissions.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFILEMANAGER_ADMENU7,
    'link' => 'admin/clone.php',
    'icon' => 'assets/icons/32/clone.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFILEMANAGER_ADMENU8,
    'link' => 'admin/feedback.php',
    'icon' => 'assets/icons/32/feedback.png',
];
$adminmenu[] = [
    'title' => \_MI_WGFILEMANAGER_ABOUT,
    'link' => 'admin/about.php',
    'icon' => 'assets/icons/32/about.png',
];
