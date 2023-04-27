<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Messages,
    Valid
};
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Cruder\Cruder;

/**
 * Cache class
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Cache {

    public $cache_name = FALSE;
    public $data = FALSE;
    public $cache_item = FALSE;
    public $cache_adapter = FALSE;
    public $cache_status = FALSE;
    public $caching_time = FALSE;
    public $db;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->db = new Cruder();
        $this->cacheStatus();
        $this->cachingTime();
    }

    /**
     * Cache init
     * 
     * @return mixed Cache data
     *
     */
    public function isHit(): mixed {

        if ($this->cache_status == '0') {
            return false;
        }

        $this->cache_adapter = new FilesystemAdapter();
        $this->cache_item = $this->cache_adapter->getItem($this->cache_name);

        if (!$this->cache_item->isHit()) {
            $data = false;
        } else {
            $data = $this->cache_item->get();
        }

        return $data;
    }

    /**
     * Cache save
     * 
     * @param mixed $data Cache data
     * @return mixed Data
     *
     */
    public function save(mixed $data): mixed {

        if ($this->cache_status == '0') {
            return $data;
        }

        $this->cache_item->expiresAfter((int) $this->caching_time);
        $this->cache_item->set($data);
        $this->cache_adapter->save($this->cache_item);

        return $data;
    }

    /**
     * Cache status
     *
     */
    private function cacheStatus(): void {

        $this->cache_status = $this->db
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('cache_status')
                ->save();

        if (Valid::inPOST('cache_status')) {
            $cache_status = 0;

            if (Valid::inPOST('cache_status') == 'on') {
                $cache_status = 1;
            }

            $this->db
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('cache_status', $cache_status)
                    ->save();

            $this->cache_status = $this->db
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('cache_status')
                    ->save();
        }
    }

    /**
     * Caching time
     *
     */
    private function cachingTime(): void {

        $this->caching_time = $this->db
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('caching_time')
                ->save();

        if (Valid::inPOST('caching_time')) {

            $this->db
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('caching_time', Valid::inPOST('caching_time'))
                    ->save();

            $this->caching_time = $this->db
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('caching_time')
                    ->save();

            $this->clear();

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Clear cache
     *
     */
    public function clear(): void {
        $Cache = new FilesystemAdapter();
        $Cache->clear();
    }

    /**
     * Delete item
     * 
     * @param string $item Cache item
     *
     */
    public function deleteItem(string $item): void {
        $Cache = new FilesystemAdapter();
        $Cache->deleteItem($item);
    }

}
