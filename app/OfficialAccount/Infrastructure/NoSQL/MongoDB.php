<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\NoSQL;

use MongoDB\Collection;
use MongoDB\InsertOneResult;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface MongoDB
{
    /**
     * 获取需要插入的集合
     *
     * @return Collection
     */
    public function getCollection(): Collection;

    /**
     * 记录信息到mongodb
     *
     * @param array $document
     *
     * @return InsertOneResult
     */
    public function save(array $document): InsertOneResult;
}
