<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Infrastructure\NoSQL\Impl;

use App\OfficialAccount\Infrastructure\NoSQL\Enum\MongoDBEnum;
use App\OfficialAccount\Infrastructure\NoSQL\MongoClient;
use App\OfficialAccount\Infrastructure\NoSQL\MongoDB;
use MongoDB\Collection;
use MongoDB\InsertOneResult;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class MongoDBImpl implements MongoDB
{
    /**
     * mongodb collection
     *
     * @var Collection|null
     */
    protected ?Collection $collection = null;

    /**
     * 获取需要插入的集合
     *
     * @return Collection
     */
    public function getCollection(): Collection
    {
        // 集合名称
        $collectionName = MongoDBEnum::MONGODB_COLLECTION_PREFIX . date('m');
        if ($this->collection) {
            $name = $this->collection->getCollectionName();
            if ($collectionName === $name) {
                return $this->collection;
            }
        }

        // 数据库
        $dataBase = MongoDBEnum::MONGODB_DOCUMENT_PREFIX . date('Y');

        // 集合
        $collect = MongoClient::getInstance()->{$dataBase}->{$collectionName};

        // 判断是否存在索引
        $index = $collect->listIndexes();
        if (empty((array)$index)) {
            $collect->createIndex(['openid' => 1, 'created_time' => -1]);
            $collect->createIndex(['custom_uuid' => 1]);
        }

        $this->collection = $collect;

        return $collect;
    }

    /**
     * 记录信息到mongodb
     *
     * @param array $document
     *
     * @return InsertOneResult
     */
    public function save(array $document): InsertOneResult
    {
        // 获取集合
        // 保存记录
        return $this->getCollection()->insertOne($document);
    }
}
