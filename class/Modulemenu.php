<?php

namespace XoopsModules\Wgfilemanager;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Goffy - XOOPS Development Team
 */
//\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Modulemenu
 */
class Modulemenu
{

    /** function to create an array for XOOPS main menu
     *
     * @return array
     */
    public function getMenuitemsDefault()
    {

        $moduleDirName = \basename(\dirname(__DIR__));
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';

        require_once $pathname . 'include/common.php';
        $helper = \XoopsModules\Wgfilemanager\Helper::getInstance();

        //load necessary language files from this module
        $helper->loadLanguage('modinfo');

        $items = [];
        $items[] = [
            'name' => \_MI_WGFILEMANAGER_SMNAME1,
            'url'  =>  'index.php',
        ];
        $items[] = [
            'name' => \_MI_WGFILEMANAGER_SMNAME2,
            'url'  =>  'directory.php',
        ];
        $items[] = [
            'name' => \_MI_WGFILEMANAGER_SMNAME3,
            'url'  =>  'file.php?op=new',
        ];

        return $items;
    }


    /** function to create a list of sublinks
     *
     * @return array
     */
    public function getMenuitemsSbadmin5()
    {
        $moduleDirName = \basename(\dirname(__DIR__));
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';
        $urlModule     = \XOOPS_URL . '/modules/' . $moduleDirName . '/';

        require_once $pathname . 'include/common.php';
        $helper = \XoopsModules\Wgfilemanager\Helper::getInstance();

        //load necessary language files from this module
        /*        $helper->loadLanguage('common');
                $helper->loadLanguage('main');*/
        $helper->loadLanguage('modinfo');

        // start creation of link list as array

        $requestUri = $_SERVER['REQUEST_URI'];
        /*read navbar items related to perms of current user*/
        $items = [];
        $items[] = [
            'highlight' => \strpos($requestUri, $moduleDirName . '/index.php') > 0,
            'url' => $urlModule . 'index.php',
            'icon' => '<i class="fa fa-tachometer fa-fw fa-lg"></i>',
            'name' => \_MI_WGFILEMANAGER_SMNAME1,
            'sublinks' => []
        ];
        $items[] = [
            'highlight' => \strpos($requestUri, $moduleDirName . '/directory.php') > 0,
            'url' => $urlModule . 'directory.php',
            'icon' => '<i class="fa fa-folder fa-fw fa-lg"></i>',
            'name' => \_MI_WGFILEMANAGER_SMNAME2,
            'sublinks' => []
        ];
        $items[] = [
            'highlight' => \strpos($requestUri, $moduleDirName . '/file.php') > 0,
            'url' => $urlModule . 'file.php',
            'icon' => '<i class="fa fa-file fa-fw fa-lg"></i>',
            'name' => \_MI_WGFILEMANAGER_SMNAME3,
            'sublinks' => []
        ];

        return $items;
    }


}
