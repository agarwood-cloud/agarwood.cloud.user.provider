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
     * The name of the database for the message record
     *
     * @\Swoft\Config\Annotation\Mapping\Config("mongo.chat.database")
     *
     * @var string
     */
    public string $database;

    /**
     * Collection name of the message record
     *
     * @\Swoft\Config\Annotation\Mapping\Config("mongo.chat.collection")
     *
     * @var string
     */
    public string $collection;

    /**
     * Insert a message history
     *
     * @param string $openid     openid
     * @param string $customerId customer service id
     * @param string $sender     send by user
     * @param string $msgType    message type
     * @param array  $data       message
     * @param string $createdAt  create time
     * @param bool   $isRead     is read
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertOneMessage(string $openid, string $customerId, string $sender, string $msgType, array $data, string $createdAt, bool $isRead = false): InsertOneResult
    {
        return MongoClient::getInstance()->{$this->database}->{$this->collection}
            ->insertOne([
                'openid'      => $openid,
                'customer_id' => $customerId,
                'sender'      => $sender,
                'msg_type'    => $msgType,
                'data'        => $data,
                'created_at'  => $createdAt,
                'is_read'     => $isRead,
            ]);
    }

    /**
     * Insert multiple message records
     *
     * @param array $document message records
     * @param array $options mongodb insert options
     *
     * @return \MongoDB\InsertManyResult
     */
    public function insertManyMessage(array $document, array $options = []): InsertManyResult
    {
        return MongoClient::getInstance()->{$this->database}->{$this->collection}
            ->insertMany($document, $options);
    }

    /**
     * Update a message history
     *
     * @param string $openid  openid
     * @param bool   $isRead  is read
     * @param array  $options mongodb options
     *
     * @return \MongoDB\UpdateResult
     */
    public function updateOneMessageToReadByOpenid(string $openid, bool $isRead = true, array $options = []): UpdateResult
    {
        return MongoClient::getInstance()->{$this->database}->{$this->collection}
            ->updateOne(
                ['openid' => $openid],
                ['$set' => ['is_read' => $isRead]],
                $options
            );
    }

    /**
     * Update multiple message records
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
                ['$set' => ['is_read' => $isRead]],
                $options
            );
    }
}
