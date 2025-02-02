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


/**
 * Class Object Handler File
 */
class FileHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgfilemanager_file', File::class, 'id', 'directory_id');
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $id field id
     * @param null $fields fields
     * @return \XoopsObject|null reference to the {@link Get} object
     */
    public function get($id = null, $fields = null)
    {
        return parent::get($id, $fields);
    }

    /**
     * get inserted id
     *
     * @return int reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count File in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountFile($start = 0, $limit = 0, $sort = 'id ASC, directory_id', $order = 'ASC')
    {
        $crCountFile = new \CriteriaCompo();
        $crCountFile = $this->getFileCriteria($crCountFile, $start, $limit, $sort, $order);
        return $this->getCount($crCountFile);
    }

    /**
     * Get All File in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllFile($start = 0, $limit = 0, $sort = 'id ASC, directory_id', $order = 'ASC')
    {
        $crAllFile = new \CriteriaCompo();
        $crAllFile = $this->getFileCriteria($crAllFile, $start, $limit, $sort, $order);
        return $this->getAll($crAllFile);
    }

    /**
     * Get Criteria File
     * @param        $crFile
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getFileCriteria($crFile, $start, $limit, $sort, $order)
    {
        $crFile->setStart($start);
        $crFile->setLimit($limit);
        $crFile->setSort($sort);
        $crFile->setOrder($order);
        return $crFile;
    }

    /**
     * Returns an array of files in directory
     *
     * @return array
     */
    public function getFileList($dirId, $start = 0, $limit = 0, $sort = 'name', $order = 'ASC') {

        $result = [];
        $crFile = new \CriteriaCompo();
        $crFile->add(new \Criteria('directory_id', $dirId));
        $crFile->setStart($start);
        $crFile->setLimit($limit);
        $crFile->setSort($sort);
        $crFile->setOrder($order);
        if ($this->getCount($crFile) > 0) {
            $fileAll = $this->getAll($crFile);
            foreach (\array_keys($fileAll) as $i) {
                $result[$i] = $fileAll[$i]->getValuesFile();
            }
        }

        return $result;

    }


    /**
     * Converts bytes into human readable file size.
     *
     * @param string $bytes
     * @return string human readable file size (2,87 Мб)
     */
    public function FileSizeConvert($bytes)
    {
        $bytes = (float)$bytes;
        $arBytes = [
            0 => [
                "UNIT" => "TB",
                "VALUE" => \pow(1024, 4)
            ],
            1 => [
                "UNIT" => "GB",
                "VALUE" => \pow(1024, 3)
            ],
            2 => [
                "UNIT" => "MB",
                "VALUE" => \pow(1024, 2)
            ],
            3 => [
                "UNIT" => "KB",
                "VALUE" => 1024
            ],
            4 => [
                "UNIT" => "B",
                "VALUE" => 1
            ],
        ];

        $result = '';
        foreach($arBytes as $arItem) {
            if($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = \str_replace(".", "," , (string)\round($result, 2))." ".$arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

    /**
     * Returns an array of files in directory
     *
     * @return bool
     * @throws \Exception
     * @throws \Exception
     */
    public function renameFile($oldFilename, $newFilename) {

        $oldFilePath = \WGFILEMANAGER_REPO_PATH . $oldFilename;
        $newFilePath = \WGFILEMANAGER_REPO_PATH . $newFilename;

        if (file_exists($oldFilePath)) {
            if (!file_exists($newFilePath)) {
                return rename($oldFilePath, $newFilePath);
            } else {
                throw new \Exception('New filename already exists.');
            }
        } else {
            throw new \Exception('Old file does not exist.');
        }

    }

    /**
     * Returns an array of files icons
     *
     * @return array
     * @throws \Exception
     * @throws \Exception
     */
    public function getFileIconCollection($iconSet) {

        $fileIcons = [];
        
        //get all allowed mime types
        $helper  = \XoopsModules\Wgfilemanager\Helper::getInstance();
        $mimetypeHandler   = $helper->getHandler('Mimetype');
        $allowedExtensions = $mimetypeHandler->getExtensionArray();

        $folderPath   = '';
        $folderUrl    = '';
        $fileTrailing = '';
        $fileDefault  = '';
        $fileIcons['type'] = '';

        switch ($iconSet) {
            case 'classic':
                $folderPath   = \WGFILEMANAGER_ICONS_PATH . '/fileicons/file-icon-vectors-master/dist/icons/classic/';
                $folderUrl    = \WGFILEMANAGER_ICONS_URL . '/fileicons/file-icon-vectors-master/dist/icons/classic/';
                $fileTrailing = '.svg';
                $fileDefault  = 'default.svg';
                $fileIcons['type'] = 'svg';
                break;
            case 'high-contrast':
                $folderPath   = \WGFILEMANAGER_ICONS_PATH . '/fileicons/file-icon-vectors-master/dist/icons/high-contrast/';
                $folderUrl    = \WGFILEMANAGER_ICONS_URL . '/fileicons/file-icon-vectors-master/dist/icons/high-contrast/';
                $fileTrailing = '.svg';
                $fileDefault  = 'default.svg';
                $fileIcons['type'] = 'svg';
                break;
            case 'square-o':
                $folderPath   = \WGFILEMANAGER_ICONS_PATH . '/fileicons/file-icon-vectors-master/dist/icons/square-o/';
                $folderUrl    = \WGFILEMANAGER_ICONS_URL . '/fileicons/file-icon-vectors-master/dist/icons/square-o/';
                $fileTrailing = '.svg';
                $fileDefault  = 'default.svg';
                $fileIcons['type'] = 'svg';
                break;
            case 'vivid':
                $folderPath   = \WGFILEMANAGER_ICONS_PATH . '/fileicons/file-icon-vectors-master/dist/icons/vivid/';
                $folderUrl    = \WGFILEMANAGER_ICONS_URL . '/fileicons/file-icon-vectors-master/dist/icons/vivid/';
                $fileTrailing = '.svg';
                $fileDefault  = 'default.svg';
                $fileIcons['type'] = 'svg';
                break;
            case 'teambox':
                $folderPath   = \WGFILEMANAGER_ICONS_PATH . '/fileicons/free-file-icons-master/512px/';
                $folderUrl    = \WGFILEMANAGER_ICONS_URL . '/fileicons/free-file-icons-master/512px/';
                $fileTrailing = '.png';
                $fileDefault  = '_blank.png';
                $fileIcons['type'] = 'png';
                break;
            case 'eagerterrier':
                $folderPath   = \WGFILEMANAGER_ICONS_PATH . '/fileicons/mimetypes-link-icons-master/images/';
                $folderUrl    = \WGFILEMANAGER_ICONS_URL . '/fileicons/mimetypes-link-icons-master/images/';
                $fileTrailing = '-icon-128x128.png';
                $fileDefault  = 'default-128x128.png';
                $fileIcons['type'] = 'png';
                break;
            case 'none':
                break;
            case '':
            default:
                throw new \Exception('Invalid iconset!');
        }

        if ($iconSet == 'none') {
            foreach ($allowedExtensions as $allowedExt) {
                $fileIcons['files'][$allowedExt['extension']]['src'] = '';
                $fileIcons['files'][$allowedExt['extension']]['category'] = $allowedExt['category'];
            }
        } else {
            if (file_exists($folderPath)) {
                foreach ($allowedExtensions as $allowedExt) {
                    $filePath = $folderPath . $allowedExt['extension'] . $fileTrailing;
                    if (file_exists($filePath)) {
                        $fileIcons['files'][$allowedExt['extension']]['src'] = $folderUrl . $allowedExt['extension'] . $fileTrailing;
                        $fileIcons['files'][$allowedExt['extension']]['category'] = $allowedExt['category'];
                    } else {
                        $fileIcons['default'] = $fileDefault;
                    }
                }
            } else {
                throw new \Exception('Folder ' . $folderPath . ' does not exist!');
            }
        }

        return $fileIcons;

    }

    /**
     * Returns an array of favorite files
     *
     * @return array
     */
    public function getFavFileList() {
        $result = [];
        $crFile = new \CriteriaCompo();
        $crFile->add(new \Criteria('favorite', '1'));
        $fileCount = $this->getCount($crFile);
        if ($fileCount > 0) {
            $crFile->setSort('name');
            $crFile->setOrder('asc');
            $fileAll = $this->getAll($crFile);
            foreach (\array_keys($fileAll) as $i) {
                $result[] = $fileAll[$i]->getValuesFile();
            }
        }

        return $result;
    }

}
