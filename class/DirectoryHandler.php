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

use Xmf\Request;
use XoopsModules\Wgfilemanager;
use XoopsModules\Wgfilemanager\Common\FilesManagement;


/**
 * Class Object Handler Directory
 */
class DirectoryHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgfilemanager_directory', Directory::class, 'id', 'name');
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
     * Get Count Directory in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountDirectory($start = 0, $limit = 0, $sort = 'id ASC, name', $order = 'ASC')
    {
        $crCountDirectory = new \CriteriaCompo();
        $crCountDirectory = $this->getDirectoryCriteria($crCountDirectory, $start, $limit, $sort, $order);
        return $this->getCount($crCountDirectory);
    }

    /**
     * Get All Directory in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllDirectory($start = 0, $limit = 0, $sort = 'id ASC, name', $order = 'ASC')
    {
        $crAllDirectory = new \CriteriaCompo();
        $crAllDirectory = $this->getDirectoryCriteria($crAllDirectory, $start, $limit, $sort, $order);
        return $this->getAll($crAllDirectory);
    }

    /**
     * Get Criteria Directory
     * @param        $crDirectory
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getDirectoryCriteria($crDirectory, $start, $limit, $sort, $order)
    {
        $crDirectory->setStart($start);
        $crDirectory->setLimit($limit);
        $crDirectory->setSort($sort);
        $crDirectory->setOrder($order);
        return $crDirectory;
    }

    /**
     * Get full path of given parent directory
     *
     * @param int $parent_id
     * @return string
     */
    public function getFullPath($parent_id) {

        $path = '';
        if ($parent_id > 0) {
            $path = $this->getFullPathRecursive($parent_id);
        }
        if ('' === $path) {
            return '';
        }
        $pathArray = \explode('/', $path);
        \krsort($pathArray);

        return \implode('/', \array_filter($pathArray));
    }

    /**
     * Get full path of given parent directory
     *
     * @param int $parent_id
     * @return string
     */
    public function getFullPathRecursive($parent_id) {
        $path = '';
        if ($parent_id > 1) {
            $directoryObj = $this->get($parent_id);
            $path .= mb_strtolower($directoryObj->getVar('name'));
            if ($directoryObj->getVar('parent_id') > 1) {
                $path .= '/' . $this->getFullPathRecursive($directoryObj->getVar('parent_id'));
            }
        }
        return $path;
    }

    /**
     * Check whether given path is a directory
     *
     * @param string $path
     * @return boolean
     */
    public function existDirectory ($path) {

        return \is_dir(\WGFILEMANAGER_REPO_PATH . $path);

    }

    /**
     * Create directory from given path
     *
     * @param string $path
     * @return boolean
     */
    public function createDirectory($path) {

        if (FilesManagement::createFolder(\WGFILEMANAGER_REPO_PATH . $path)) {
            return true;
        } else {
            throw new \Exception('New filename already exists.');
        }
    }

    /**
     * Rename directory
     *
     * @param string $oldDirname
     * @param string $newDirname
     * @return boolean
     */
    public function renameDirectory($oldDirname, $newDirname)
    {
        $oldFilePath = \WGFILEMANAGER_REPO_PATH . $oldDirname;
        $newFilePath = \WGFILEMANAGER_REPO_PATH . $newDirname;

        if (\file_exists($oldFilePath)) {
            if (!\file_exists($newFilePath)) {
                return \rename($oldFilePath, $newFilePath);
            } else {
                throw new \Exception('New filename already exists.');
            }
        } else {
            throw new \Exception('Old file does not exist.');
        }
    }

    /**
     * Delete directory from given path
     *
     * @param string $path
     * @return boolean
     */
    public function deleteDirectory($path)
    {
        $fullPath = \WGFILEMANAGER_REPO_PATH . $path;

        if (!FilesManagement::deleteDirectory($fullPath)) {
            return false;
        }

        return !$this->existDirectory($fullPath);

    }

    /**
     * Check whether given directory is used as parent
     *
     * @param int $dirId
     * @return boolean
     */
    public function dirIsParent ($dirId) {
        $crCountDirectory = new \CriteriaCompo();
        $crCountDirectory->add(new \Criteria('parent_id', $dirId));

        return $this->getCount($crCountDirectory) > 0;

    }

    /**
     * Count subdirectories from given directory
     *
     * @param int $dirId
     * @return integer
     */
    public function countSubDirs($dirId) {

        $crSubDir = new \CriteriaCompo();
        $crSubDir->add(new \Criteria('parent_id', $dirId));

        return $this->getCount($crSubDir) ;

    }

    /**
     * Count files in given directory
     *
     * @param string $fullpath
     * @return integer
     */
    public function countFiles($fullpath) {
        $file_new = [];
        $path = \WGFILEMANAGER_REPO_PATH . $fullpath;
        if (!\file_exists($path)) {
            return -1;
        }
        $files = scandir($path);
        for($i = 0 ; $i < count($files) ; $i++){
            if(\is_file($path .  '/' . $files[$i]) && $files[$i] !='.' && $files[$i] !='..'  && $files[$i] !='index.php'  && $files[$i] !='index.html') {
                $file_new[] = $files[$i];
            }
        }

        return count($file_new);
    }

    /**
     * Delete data from all subdirectories from given directory
     *
     * @param int $dirId
     * @return boolean
     */
    public function deleteSubDirData($dirId) {

        $crSubDir = new \CriteriaCompo();
        $crSubDir->add(new \Criteria('parent_id', $dirId));
        if ($this->getCount($crSubDir) > 0) {
            $directoryAll = $this->getAll($crSubDir);
            foreach (\array_keys($directoryAll) as $i) {
                if (!$this->deleteSubDirData($i)) {
                    return false;
                }
            }
        }
        $directoryObj = $this->get($dirId);
        if (\is_object($directoryObj) && !$this->delete($directoryObj)) {
            return false;
        }

        return true;

    }

    /**
     * Move directory
     *
     * @param string $pathSource
     * @param string $pathDest
     * @return boolean
     */
    public function moveDirectory($pathSource, $pathDest) {

        if(!FilesManagement::rcopy(\WGFILEMANAGER_REPO_PATH . $pathSource, \WGFILEMANAGER_REPO_PATH . $pathDest)){
            return false;
        }
        if (!FilesManagement::deleteDirectory(\WGFILEMANAGER_REPO_PATH . $pathSource)) {
            return false;
        }

        return true;
    }

    /**
     * Returns an array directories
     *
     * @param int $dirId
     * @param int $dirCurrent
     * @param int $levelCurrent
     * @return array
     */
    public function getDirList($dirId, $dirCurrent, $levelCurrent = 0) {

        $result = [];
/*        if (0 === $dirId) {
            $result[0]['id'] = 0;
            $result[0]['parent_id'] = 0;
            $result[0]['name'] = \_MA_WGFILEMANAGER_DIRECTORY_HOME;
            $result[0]['state'] = 0 === $dirCurrent ? 'open' : 'closed';
            $result[0]['class'] = 'home';
            $result[0]['level'] = 0;
            $crSubDir = new \CriteriaCompo();
            $crSubDir->add(new \Criteria('parent_id', $dirId));
            $result[0]['count_subdirs'] = $this->getCount($crSubDir);
            $result[0]['count_files'] = $this->countFiles('');
            $result[0]['subdirs'] = [];
        }*/
        $levelCurrent++;
        $crSubDir = new \CriteriaCompo();
        $crSubDir->add(new \Criteria('parent_id', $dirId));
        $crSubDir->setSort('weight ASC, id');
        $crSubDir->setOrder('ASC');
        if ($this->getCount($crSubDir) > 0) {
            $directoryAll = $this->getAll($crSubDir);
            foreach (\array_keys($directoryAll) as $i) {
                $directory = $directoryAll[$i]->getValuesDir();
                $result[$i]['id'] = $directory['id'];
                $result[$i]['parent_id'] = $directory['parent_id'];
                $result[$i]['name'] = $directory['name'];
                $result[$i]['state'] = $i === $dirCurrent ? 'open' : 'closed';
                $result[$i]['count_subdirs'] = $directory['count_subdirs'];
                $result[$i]['count_files'] = $directory['count_files'];
                $result[$i]['level'] = $levelCurrent;
                if ($directory['count_subdirs'] > 0) {
                                        $result[$i]['subdirs'] = $this->getDirList($i, $dirCurrent, $levelCurrent);
                }
            }
        }

        return $result;

    }

    /**
     * Returns an array directories for form select
     *
     * @param int $dirId
     * @return array
     */
    public function getDirListFormSelect($dirId) {

        $result = [];
        $crSubDir = new \CriteriaCompo();
        $crSubDir->add(new \Criteria('parent_id', $dirId));
        $crSubDir->setSort('weight ASC, id');
        $crSubDir->setOrder('ASC');
        if ($this->getCount($crSubDir) > 0) {
            $directoryAll = $this->getAll($crSubDir);
            foreach (\array_keys($directoryAll) as $i) {
                $directory = $directoryAll[$i]->getValuesDir();
                $name = $directory['name'];
                if ($dirId > 0) {
                    $level = \mb_substr_count($directory['fullpath'], '/');
                    $name = \str_repeat('- ', $level) . $name;
                }
                $result[$i] = [$directory['id'] => $name];
                if ($directory['count_subdirs'] > 0) {
                    $result[$i][]= $this->getDirListFormSelect($i);
                }
            }
        }

        return $result;
    }

    /**
     * Returns an array directories for breadcrumbs
     *
     * @param int $dirId
     * @return array
     */
    public function getDirListBreadcrumb($dirId) {

        $result = [];
        do {
            $dirObj = $this->get($dirId);
            if ($dirId > 1) {
                $result[$dirId] = $dirObj->getVar('name');
            }
            $dirId = $dirObj->getVar('parent_id');
        } while ($dirId > 0);

        return $result;
    }

}
