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

use App\OfficialAccount\Domain\Aggregate\Repository\ChatMessageRecordMongoCommandRepository;
use MongoDB\InsertManyResult;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
class ChatMessageRecordMongoCommandRepositoryImpl implements ChatMessageRecordMongoCommandRepository
{
    /**
     * 消息记录的数据库名称
     *
     * @\Swoft\Config\Annotation\Mapping\Config("mongo.chat.database")
     *
     * @var string
     */
    public string $database;

    /**
     * 消息记录的集合名称
     *
     * @\Swoft\Config\Annotation\Mapping\Config("mongo.chat.collection")
     *
     * @var string
     */
    public string $collection;

    /**
     * 插入一条聊天记录
     *
     * @param string $openid     微信用户openid
     * @param string $customerId 客服id
     * @param string $sender     发送者
     * @param string $msgType    消息类型
     * @param array  $data       消息内容
     * @param string $createdAt  创建时间
     * @param bool   $isRead     是否已读
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertOneMessage(string $openid, string $customerId, string $sender, string $msgType, array $data, string $createdAt, bool $isRead = false): InsertOneResult
    {
        return MongoClient::getInstance()->{$this->database}->{$this->collection}
            ->insertOne([
                'openid'     => $openid,
                'customerId' => $customerId,
                'sender'     => $sender,
                'msgType'    => $msgType,
                'data'       => $data,
                'createdAt'  => $createdAt,
                'isRead'     => $isRead,
            ]);
    }

    /**
     * 插入多条聊天记录
     *
     * @param array $document 消息内容
     * @param array $options
     *
     * @return \MongoDB\InsertManyResult
     */
    public function insertManyMessage(array $document, array $options = []): InsertManyResult
    {
        return MongoClient::getInstance()->{$this->database}->{$this->collection}
            ->insertMany($document, $options);
    }

    /**
     * 更新一条聊天记录
     *
     * @param string $openid  微信用户openid
     * @param bool   $isRead  是否已读
     * @param array  $options 选项
     *
     * @return \MongoDB\UpdateResult
     */
    public function updateOneMessageToReadByOpenid(string $openid, bool $isRead = true, array $options = []): UpdateResult
    {
        return MongoClient::getInstance()->{$this->database}->{$this->collection}
            ->updateOne(
                ['openid' => $openid],
                ['$set' => ['isRead' => $isRead]],
                $options
            );
    }

    /**
     * 更新多条聊天记录
     *
     * @param string $openid
     * @param bool   $isRead
     * @param array  $options
     *
     * @return \MongoDB\UpdateResult
     */
    public function updateManyToReadByOpenid(string $openid, bool $isRead = true, array $options = []): UpdateResult
    {
        return MongoClient::getInstance()->{$this->database}->{$this->collection}
            ->updateMany(
                ['openid' => $openid],
                ['$set' => ['isRead' => $isRead]],
                $options
            );
    }
}
