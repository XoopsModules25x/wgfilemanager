<?php

declare(strict_types=1);


namespace XoopsModules\Wgfilemanager;

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
 * @since        1.0
 * @min_xoops    2.5.9
 * @author       Goffy - Wedega - Email:webmaster@wedega.com - Website:https://xoops.wedega.com
 */

use XoopsModules\Wgfilemanager;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Mimetype
 */
class Favorite extends \XoopsObject
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->initVar('id', \XOBJ_DTYPE_INT);
        $this->initVar('directory_id', \XOBJ_DTYPE_INT);
        $this->initVar('file_id', \XOBJ_DTYPE_INT);
        $this->initVar('date_created', \XOBJ_DTYPE_INT);
        $this->initVar('submitter', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
     *
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     * @return integer
     */
    public function getNewInsertedId()
    {
        return $GLOBALS['xoopsDB']->getInsertId();
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesFavorite($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wgfilemanager\Helper::getInstance();

        $ret = $this->getValues($keys, $format, $maxDepth);
        $directoryHandler = $helper->getHandler('Directory');
        $directoryObj = $directoryHandler->get($this->getVar('directory_id'));
        $ret['dir_name'] = '';
        if (\is_object($directoryObj)) {
            $ret['dir_name'] = $directoryObj->getVar('name');
        } else {
            $ret['dir_name'] = 'error get dir name';
        }
        $fileHandler = $helper->getHandler('File');
        $fileObj = $fileHandler->get($this->getVar('file_id'));
        $ret['file_name'] = '';
        if (\is_object($fileObj)) {
            $ret['file_name'] = $fileObj->getVar('name');
        } else {
            $ret['file_name'] = 'error get file name';
        }
        $ret['date_created_text'] = \formatTimestamp($this->getVar('date_created'), 's');
        $ret['submitter_text']    = \XoopsUser::getUnameFromId($this->getVar('submitter'));
        return $ret;
    }
}
