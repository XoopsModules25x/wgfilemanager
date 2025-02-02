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
 * @author       Goffy - Wedega - Email:webmaster@wedega.com - Website:https://xoops.wedega.com
 */

use XoopsModules\Wgfilemanager;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object File
 */
class File extends \XoopsObject
{
    /**
     * @var int
     */
    public $start = 0;

    /**
     * @var int
     */
    public $limit = 0;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->initVar('id', \XOBJ_DTYPE_INT);
        $this->initVar('directory_id', \XOBJ_DTYPE_INT);
        $this->initVar('name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('description', \XOBJ_DTYPE_OTHER);
        $this->initVar('mimetype', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('size', \XOBJ_DTYPE_INT);
        $this->initVar('ctime', \XOBJ_DTYPE_INT);
        $this->initVar('mtime', \XOBJ_DTYPE_INT);
        $this->initVar('ip', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('status', \XOBJ_DTYPE_INT);
        $this->initVar('favorite', \XOBJ_DTYPE_INT);
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
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getForm($action = false)
    {
        $helper             = \XoopsModules\Wgfilemanager\Helper::getInstance();
        $fileHandler        = $helper->getHandler('File');
        $permissionsHandler = $helper->getHandler('Permissions');
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = \is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        // Title
        $title = $this->isNew() ? \_MA_WGFILEMANAGER_FILE_ADD : \_MA_WGFILEMANAGER_FILE_EDIT;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        //$form->addElement(new \XoopsFormHidden('formtype', $formType));
        // Form Table directory
        $directoryId = (int)$this->getVar('directory_id');
        $directoryHandler = $helper->getHandler('Directory');
        $fileDirectory_idSelect = new \XoopsFormSelect(\_MA_WGFILEMANAGER_FILE_DIRECTORY_ID, 'directory_id', $directoryId);
        $dirListSelect = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($directoryHandler->getDirListFormSelect(0)));
        foreach ($dirListSelect as $key => $value) {
            $fileDirectory_idSelect->addOption($key, $value);
        }
        $form->addElement($fileDirectory_idSelect, true);
        $form->addElement(new \XoopsFormHidden('directory_id_old', $directoryId));
        // Form File: Upload fileName
        $fileName = $this->isNew() ? '' : $this->getVar('name');
        if ($this->isNew()) {
            if ($permissionsHandler->getPermUploadFileToDir($directoryId)) {
                $fileUploadTray = new \XoopsFormElementTray(\_MA_WGFILEMANAGER_FILE_NAME, '<br>');
                //$fileDirectory = '/uploads/wgfilemanager/files/file';
                //$fileUploadTray->addElement(new \XoopsFormLabel(\sprintf(\_MA_WGFILEMANAGER_FILE_NAME_UPLOADS, ".$fileDirectory/"), $fileName));
                $maxsize = $helper->getConfig('maxsize_file');
                $fileUploadTray->addElement(new \XoopsFormFile('', 'name', $maxsize));
                $fileUploadTray->addElement(new \XoopsFormLabel(\_MA_WGFILEMANAGER_FORM_UPLOAD_SIZE, ($maxsize / 1048576) . ' ' . \_MA_WGFILEMANAGER_FORM_UPLOAD_SIZE_MB));
                $form->addElement($fileUploadTray, true);
            } else {
                $form->addElement(new \XoopsFormHidden('name', $fileName));
            }
        } else {
            $form->addElement(new \XoopsFormText(\_MA_WGFILEMANAGER_FILE_NAME, 'name', 100, 150, $fileName));
            $form->addElement(new \XoopsFormHidden('name_old', $fileName));
        }
        // Form Editor DhtmlTextArea fileDescription
        $editorConfigs = [];
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        $editorConfigs['name'] = 'description';
        $editorConfigs['value'] = $this->getVar('description', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '400px';
        $editorConfigs['editor'] = $editor;
        $form->addElement(new \XoopsFormEditor(\_MA_WGFILEMANAGER_FILE_DESCRIPTION, 'description', $editorConfigs));
        // Form Text fileType
        $fileType = $this->isNew() ? '' : $this->getVar('mimetype');
        if (!$this->isNew()) {
            $form->addElement(new \XoopsFormLabel(\_MA_WGFILEMANAGER_FILE_MIMETYPE, $fileType));
        }
        //$form->addElement(new \XoopsFormHidden('mimetype', $fileType));
        // Form Text Date file modification date
        $fileSize = $this->isNew() ? \time() : $this->getVar('size');
        if (!$this->isNew()) {
            $form->addElement(new \XoopsFormLabel(\_MA_WGFILEMANAGER_FILE_SIZE, $fileHandler->FileSizeConvert($fileSize)));
        }
        // Form Text Date file modification date
        $fileMtime = $this->isNew() ? \time() : $this->getVar('mtime');
        if (!$this->isNew()) {
            $form->addElement(new \XoopsFormLabel(\_MA_WGFILEMANAGER_FILE_MTIME, \formatTimestamp($fileMtime, 's')));
        }
        // Form Text Date file creation date
        $fileCtime = $this->isNew() ? \time() : $this->getVar('ctime');
        if (!$this->isNew()) {
            $form->addElement(new \XoopsFormLabel(\_MA_WGFILEMANAGER_FILE_CTIME, \formatTimestamp($fileCtime, 's')));
        }
        //$form->addElement(new \XoopsFormHidden('mtime', $fileMtime));
        //$form->addElement(new \XoopsFormTextDateSelect(\_MA_WGFILEMANAGER_FILE_MTIME, 'mtime', '', $fileMtime));
        // Form Text IP fileIp
        $fileIp = $_SERVER['REMOTE_ADDR'];
        if ($isAdmin) {
            $form->addElement(new \XoopsFormText(\_MA_WGFILEMANAGER_FILE_IP, 'ip', 20, 150, $fileIp));
        } else {
            $form->addElement(new \XoopsFormHidden('ip', $fileIp));
        }
        // Form Select Status fileStatus
        $fileStatus = $this->isNew() ? Constants::STATUS_SUBMITTED : $this->getVar('status');
        if ($isAdmin) {
            $fileStatusSelect = new \XoopsFormSelect(\_MA_WGFILEMANAGER_FILE_STATUS, 'status', $fileStatus);
            $fileStatusSelect->addOption(Constants::STATUS_NONE, \_AM_WGFILEMANAGER_STATUS_NONE);
            //$fileStatusSelect->addOption(Constants::STATUS_OFFLINE, \_AM_WGFILEMANAGER_STATUS_OFFLINE);
            $fileStatusSelect->addOption(Constants::STATUS_SUBMITTED, \_AM_WGFILEMANAGER_STATUS_SUBMITTED);
            //$fileStatusSelect->addOption(Constants::STATUS_APPROVED, \_AM_WGFILEMANAGER_STATUS_APPROVED);
            $fileStatusSelect->addOption(Constants::STATUS_BROKEN, \_AM_WGFILEMANAGER_STATUS_BROKEN);
            $form->addElement($fileStatusSelect);
        } else {
            $form->addElement(new \XoopsFormHidden('status', $fileStatus));
        }

        // Form Text Date Select fileDate_created
        $fileDate_created = $this->isNew() ? \time() : $this->getVar('date_created');
        if ($isAdmin) {
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGFILEMANAGER_FILE_DATE_CREATED, 'date_created', '', $fileDate_created));
        } elseif (!$this->isNew()) {
            $form->addElement(new \XoopsFormLabel(\_MA_WGFILEMANAGER_FILE_DATE_CREATED, \formatTimestamp($fileDate_created, 's')));
        }

        // Form Select User fileSubmitter
        $uidCurrent = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $fileSubmitter = $this->isNew() ? $uidCurrent : $this->getVar('submitter');
        if ($isAdmin) {
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGFILEMANAGER_FILE_SUBMITTER, 'submitter', false, $fileSubmitter));
        } elseif (!$this->isNew()) {
            $form->addElement(new \XoopsFormLabel(\_MA_WGFILEMANAGER_FILE_SUBMITTER, \XoopsUser::getUnameFromId($fileSubmitter)));
            $form->addElement(new \XoopsFormHidden('submitter', $fileSubmitter));
        }
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormHidden('start', $this->start));
        $form->addElement(new \XoopsFormHidden('limit', $this->limit));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesFile($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wgfilemanager\Helper::getInstance();
        $utility = new \XoopsModules\Wgfilemanager\Utility();

        $directoryHandler = $helper->getHandler('Directory');
        $fileHandler      = $helper->getHandler('File');
        $editorMaxchar    = $helper->getConfig('editor_maxchar');
        $ret              = $this->getValues($keys, $format, $maxDepth);
        $fileName         = $this->getVar('name');
        $ret['dir_name']  = \_MA_WGFILEMANAGER_DIRECTORY_HOME;
        $ret['real_url']  = \WGFILEMANAGER_REPO_URL . '/' . $fileName;
        //$ret['real_path'] = \WGFILEMANAGER_REPO_PATH . '/' . $fileName;
        $directoryObj = $directoryHandler->get($this->getVar('directory_id'));
        if (\is_object($directoryObj) && '' !== $directoryObj->getVar('name')) {
            $ret['dir_name']     = $directoryObj->getVar('name');
            $ret['dir_fullpath'] = $directoryObj->getVar('fullpath');
            $ret['real_url']     = \WGFILEMANAGER_REPO_URL . $directoryObj->getVar('fullpath') . '/' . $fileName;
            $ret['real_path']    = \WGFILEMANAGER_REPO_PATH . $directoryObj->getVar('fullpath') . '/' . $fileName;
        }
        $ret['print_url']          = $ret['real_url'];
        $ret['description_text']   = $this->getVar('description', 'e');
        $ret['description_short']  = $utility::truncateHtml($ret['description'], $editorMaxchar);
        $status                    = $this->getVar('status');
        switch ($status) {
            case Constants::STATUS_NONE:
            default:
                $status_text = \_AM_WGFILEMANAGER_STATUS_NONE;
                break;
            /*case Constants::STATUS_OFFLINE:
                $status_text = \_AM_WGFILEMANAGER_STATUS_OFFLINE;
                break;
            case Constants::STATUS_APPROVED:
                $status_text = \_AM_WGFILEMANAGER_STATUS_APPROVED;
                break;*/
            case Constants::STATUS_SUBMITTED:
                $status_text = \_AM_WGFILEMANAGER_STATUS_SUBMITTED;
                break;
            case Constants::STATUS_BROKEN:
                $status_text = \_AM_WGFILEMANAGER_STATUS_BROKEN;
                break;
        }
        $ret['status_text']        = $status_text;
        $ret['mtime_text']         = \formatTimestamp($this->getVar('mtime'), 's');
        $ret['ctime_text']         = \formatTimestamp($this->getVar('ctime'), 's');
        $ret['size_text']          = $fileHandler->FileSizeConvert($this->getVar('size'));
        $ret['date_created_text']  = \formatTimestamp($this->getVar('date_created'), 's');
        $ret['submitter_text']     = \XoopsUser::getUnameFromId($this->getVar('submitter'));
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayFile()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }
        return $ret;
    }
}
