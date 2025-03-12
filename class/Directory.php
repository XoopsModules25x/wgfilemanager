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
 * Class Object Directory
 */
class Directory extends \XoopsObject
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
        $this->initVar('parent_id', \XOBJ_DTYPE_INT);
        $this->initVar('name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('description', \XOBJ_DTYPE_OTHER);
        $this->initVar('fullpath', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('weight', \XOBJ_DTYPE_INT);
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
        $helper = \XoopsModules\Wgfilemanager\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = \is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        // Title
        $title = $this->isNew() ? \_MA_WGFILEMANAGER_DIRECTORY_ADD : \_MA_WGFILEMANAGER_DIRECTORY_EDIT;
        // handler
        $directoryHandler = $helper->getHandler('Directory');
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table directory
        if ($this->getVar('id') > 1 || $this->isNew()) {
            $dirParentid = $this->getVar('parent_id');
            $dirParent_idSelect = new \XoopsFormSelect(\_MA_WGFILEMANAGER_DIRECTORY_PARENT_ID, 'parent_id', $dirParentid);
            $dirListSelect = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($directoryHandler->getDirListFormSelect(0)));
            foreach ($dirListSelect as $key => $value) {
                $dirParent_idSelect->addOption($key, $value);
            }
            $form->addElement($dirParent_idSelect);
            $form->addElement(new \XoopsFormHidden('parent_id_old', $dirParentid));
        } else {
            $form->addElement(new \XoopsFormHidden('parent_id', 0));
            $form->addElement(new \XoopsFormHidden('parent_id_old', 0));
        }
        // Form Text dirName
        $dirName = $this->getVar('name');
        $form->addElement(new \XoopsFormText(\_MA_WGFILEMANAGER_DIRECTORY_NAME, 'name', 50, 255, $dirName), true);
        $form->addElement(new \XoopsFormHidden('name_old', $dirName));
        // Form Editor DhtmlTextArea dirDescription
        $dirDescription = $this->getVar('description', 'e');
        $editorConfigs = [];
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        $editorConfigs['name'] = 'description';
        $editorConfigs['value'] = $dirDescription;
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '400px';
        $editorConfigs['editor'] = $editor;
        $form->addElement(new \XoopsFormEditor(\_MA_WGFILEMANAGER_DIRECTORY_DESCRIPTION, 'description', $editorConfigs));
        // Form Text dirFullpath
        $dirFullpath = $this->getVar('fullpath');
        if ($isAdmin) {
            $tbFullpath = new \XoopsFormLabel(\_MA_WGFILEMANAGER_DIRECTORY_FULLPATH, $dirFullpath);
            $tbFullpath->setDescription(sprintf(\_MA_WGFILEMANAGER_DIRECTORY_FULLPATH_DESCR, WGFILEMANAGER_UPLOAD_PATH . '/repository'));
            $form->addElement($tbFullpath);
            $form->addElement(new \XoopsFormHidden('fullpath', $dirFullpath));
            $form->addElement(new \XoopsFormHidden('fullpath_old', $dirFullpath));
        } else {
            $form->addElement(new \XoopsFormHidden('fullpath', $dirFullpath));
            $form->addElement(new \XoopsFormHidden('fullpath_old', $dirFullpath));
        }
        // Form Text dirWeight
        $dirWeight = $this->isNew() ? $directoryHandler->getCount() + 1 : $this->getVar('weight');
        //if ($isAdmin) {
            //$form->addElement(new \XoopsFormText(\_MA_WGFILEMANAGER_DIRECTORY_WEIGHT, 'weight', 50, 255, $dirWeight), true);
        //} else {
            $form->addElement(new \XoopsFormHidden('weight', $dirWeight));
        //}
        // Form Text Date Select dirDate_created
        $dirDate_created = $this->isNew() ? \time() : $this->getVar('date_created');
        $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGFILEMANAGER_DIRECTORY_DATE_CREATED, 'date_created', '', $dirDate_created));
        // Form Select User dirSubmitter
        $uidCurrent = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $dirSubmitter = $this->isNew() ? $uidCurrent : $this->getVar('submitter');
        $form->addElement(new \XoopsFormSelectUser(\_MA_WGFILEMANAGER_DIRECTORY_SUBMITTER, 'submitter', false, $dirSubmitter));
        // Permissions
        if ('directory' === $helper->getConfig('permission_type')) {
            $memberHandler = \xoops_getHandler('member');
            $groupList = $memberHandler->getGroupList();
            $grouppermHandler = \xoops_getHandler('groupperm');
            $fullList[] = \array_keys($groupList);
            if ($this->isNew()) {
                //$groupsCanApproveCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_DIR_APPROVE, 'groups_approve_directory[]', $fullList);
                $groupsCanSubmitDirCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_DIR_SUBMIT, 'groups_submit_directory[]', $fullList);
                $groupsCanViewDirCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_DIR_VIEW, 'groups_view_directory[]', $fullList);
                $groupsCanDownloadCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_FILE_DOWNLOAD_FROM_DIR, 'groups_download_directory[]', $fullList);
                $groupsCanUploadCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_FILE_UPLOAD_TO_DIR, 'groups_upload_directory[]', $fullList);
            } else {
                //$groupsIdsApprove = $grouppermHandler->getGroupIds('wgfilemanager_approve_directory', $this->getVar('id'), $GLOBALS['xoopsModule']->getVar('mid'));
                //$groupsIdsApprove[] = \array_values($groupsIdsApprove);
                //$groupsCanApproveCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_APPROVE, 'groups_approve_directory[]', $groupsIdsApprove);
                $groupsIdsSubmit = $grouppermHandler->getGroupIds('wgfilemanager_submit_directory', $this->getVar('id'), $GLOBALS['xoopsModule']->getVar('mid'));
                $groupsIdsSubmit[] = \array_values($groupsIdsSubmit);
                $groupsCanSubmitDirCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_DIR_SUBMIT, 'groups_submit_directory[]', $groupsIdsSubmit);
                $groupsIdsView = $grouppermHandler->getGroupIds('wgfilemanager_view_directory', $this->getVar('id'), $GLOBALS['xoopsModule']->getVar('mid'));
                $groupsIdsView[] = \array_values($groupsIdsView);
                $groupsCanViewDirCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_DIR_VIEW, 'groups_view_directory[]', $groupsIdsView);
                $groupsIdsDownload = $grouppermHandler->getGroupIds('wgfilemanager_download_directory', $this->getVar('id'), $GLOBALS['xoopsModule']->getVar('mid'));
                $groupsIdsDownload[] = \array_values($groupsIdsDownload);
                $groupsCanDownloadCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_FILE_DOWNLOAD_FROM_DIR, 'groups_download_directory[]', $groupsIdsDownload);
                $groupsIdsUpload = $grouppermHandler->getGroupIds('wgfilemanager_upload_directory', $this->getVar('id'), $GLOBALS['xoopsModule']->getVar('mid'));
                $groupsIdsUpload[] = \array_values($groupsIdsUpload);
                $groupsCanUploadCheckbox = new \XoopsFormCheckBox(\_MA_WGFILEMANAGER_PERM_FILE_UPLOAD_TO_DIR, 'groups_upload_directory[]', $groupsIdsUpload);
            }
            // To Approve
            //$groupsCanApproveCheckbox->addOptionArray($groupList);
            //$form->addElement($groupsCanApproveCheckbox);
            // To Submit
            $groupsCanSubmitDirCheckbox->addOptionArray($groupList);
            $groupsCanSubmitDirCheckbox->setDescription(\_MA_WGFILEMANAGER_PERM_DIR_SUBMIT_DESC);
            $form->addElement($groupsCanSubmitDirCheckbox);
            // To View
            $groupsCanViewDirCheckbox->addOptionArray($groupList);
            $groupsCanViewDirCheckbox->setDescription(\_MA_WGFILEMANAGER_PERM_DIR_VIEW_DESC);
            $form->addElement($groupsCanViewDirCheckbox);
            // To download
            $groupsCanDownloadCheckbox->addOptionArray($groupList);
            $groupsCanDownloadCheckbox->setDescription(\_MA_WGFILEMANAGER_PERM_FILE_DOWNLOAD_FROM_DIR_DESC);
            $form->addElement($groupsCanDownloadCheckbox);
            // To upload
            $groupsCanUploadCheckbox->addOptionArray($groupList);
            $groupsCanUploadCheckbox->setDescription(\_MA_WGFILEMANAGER_PERM_FILE_UPLOAD_TO_DIR_DESC);
            $form->addElement($groupsCanUploadCheckbox);
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
    public function getValuesDir($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wgfilemanager\Helper::getInstance();
        $utility = new \XoopsModules\Wgfilemanager\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $directoryHandler = $helper->getHandler('Directory');
        $directoryObj = $directoryHandler->get($this->getVar('parent_id'));
        if (\is_object($directoryObj)) {
            $ret['parent_text'] = $directoryObj->getVar('name');
        } else {
            $ret['parent_text'] = 'error get parent name';
        }
        //get current user
        $userUid = 0;
        if (isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser'])) {
            $userUid = $GLOBALS['xoopsUser']->uid();
        }
        $ret['favorite_id'] = 0;
        if ($userUid > 0) {
            $favoriteHandler = $helper->getHandler('Favorite');
            $crFavorite = new \CriteriaCompo();
            $crFavorite->add(new \Criteria('directory_id', $this->getVar('id')));
            $crFavorite->add(new \Criteria('submitter', $userUid));
            if ($favoriteHandler->getCount($crFavorite)) {
                $favoriteObj = $favoriteHandler->getObjects($crFavorite);
                $ret['favorite_id'] = $favoriteObj[0]->getVar('id');
            }
            unset($favoriteObj);
            unset($crFavorite);
        }
        $ret['count_subdirs']     = $directoryHandler->countSubDirs($this->getVar('id'));
        $ret['count_files']       = $directoryHandler->countFiles($this->getVar('fullpath'));
        $ret['description_text']  = $this->getVar('description', 'e');
        $ret['description_short'] = $utility::truncateHtml($ret['description'], $editorMaxchar);
        $ret['date_created_text'] = \formatTimestamp($this->getVar('date_created'), 's');
        $ret['submitter_text']    = \XoopsUser::getUnameFromId($this->getVar('submitter'));
        $ret['ctime_text']        = $ret['date_created_text'];
        $ret['directory_id']      = $this->getVar('id');
        return $ret;
    }
}
