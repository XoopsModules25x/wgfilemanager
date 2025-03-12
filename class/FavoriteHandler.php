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


/**
 * Class Object Handler Favorite
 */
class FavoriteHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgfilemanager_favorite', Favorite::class, 'id', 'extension');
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
     * Get Count File in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountFavorite($start = 0, $limit = 0, $sort = 'id', $order = 'ASC')
    {
        $crCountFavorite = new \CriteriaCompo();
        $crCountFavorite = $this->getFavoriteCriteria($crCountFavorite, $start, $limit, $sort, $order);
        return $this->getCount($crCountFavorite);
    }

    /**
     * Get All Favorite in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllFavorite($start = 0, $limit = 0, $sort = 'id', $order = 'ASC')
    {
        $crAllFavorite = new \CriteriaCompo();
        $crAllFavorite = $this->getFavoriteCriteria($crAllFavorite, $start, $limit, $sort, $order);
        return $this->getAll($crAllFavorite);
    }

    /**
     * Get Criteria Favorite
     * @param        $crFavorite
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getFavoriteCriteria($crFavorite, $start, $limit, $sort, $order)
    {
        $crFavorite->setStart($start);
        $crFavorite->setLimit($limit);
        $crFavorite->setSort($sort);
        $crFavorite->setOrder($order);
        return $crFavorite;
    }
}
