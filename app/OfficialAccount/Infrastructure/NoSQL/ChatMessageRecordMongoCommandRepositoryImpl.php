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
use Carbon\Carbon;
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
     * @param int    $customerId customer service id
     * @param string $sender     send by user
     * @param string $msgType    message type
     * @param array  $data       message
     * @param bool   $isRead     is read
     *
     * @return \MongoDB\InsertOneResult
     */
    public function insertOneMessage(string $openid, int $customerId, string $sender, string $msgType, array $data, bool $isRead = false): InsertOneResult
    {
        return MongoClient::getInstance()
            ->selectDatabase($this->database)
            ->selectCollection($this->collection)
            // ->{$this->database}->{$this->collection}
            ->insertOne([
                'openid'      => $openid,
                'customer_id' => $customerId,
                'sender'      => $sender,
                'msg_type'    => $msgType,
                'data'        => $data,
                'created_at'  => Carbon::now()->toDateTimeString(),
                'is_read'     => $isRead,
            ]);
    }

    /**
     * Insert multiple message records
     *
     * @param array $document message records
     * @param array $options  mongodb insert options
     *
     * @return \MongoDB\InsertManyResult
     */
    public function insertManyMessage(array $document, array $options = []): InsertManyResult
    {
        return MongoClient::getInstance()
            ->selectDatabase($this->database)
            ->selectCollection($this->collection)
            // ->{$this->database}->{$this->collection}
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
        return MongoClient::getInstance()
            ->selectDatabase($this->database)
            ->selectCollection($this->collection)
            // ->{$this->database}->{$this->collection}
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
        return MongoClient::getInstance()
            ->selectDatabase($this->database)
            ->selectCollection($this->collection)
            // ->{$this->database}->{$this->collection}
            ->updateMany(
                ['openid' => $openid],
                ['$set' => ['is_read' => $isRead]],
                $options
            );
    }

    /**
     * 获取粉丝的聊天记录
     *
     * @param string $openid
     * @param string $startAt
     * @param string $endAt
     * @param int    $page
     * @param int    $pageSize
     *
     * @return array
     */
    public function getMessageRecordByOpenid(string $openid, string $startAt, string $endAt, int $page = 1, int $pageSize = 20): array
    {
        $filter = [
            'openid'     => $openid,
            'created_at' => ['$gte' => $startAt, '$lte' => $endAt],
        ];

        $options = [
            'sort'  => ['created_at' => -1],
            'skip'  => ($page - 1) * $pageSize,
            'limit' => $pageSize,
            'count' => true,
        ];
        return [
            // 聊天记录
            'list'  => MongoClient::getInstance()
                ->selectDatabase($this->database)
                ->selectCollection($this->collection)
                ->find($filter, $options)
                ->toArray(),
            // 总数
            'total' => MongoClient::getInstance()
                ->selectDatabase($this->database)
                ->selectCollection($this->collection)
                ->countDocuments($filter),
        ];
    }

    /**
     * 获取最后一条聊天记录消息记录列表
     *
     * @param int    $customerId
     * @param string $startAt
     * @param string $endAt
     * @param int    $page
     * @param int    $pageSize
     *
     * @return array
     */
    public function getLastMessageChatList(int $customerId, string $startAt, string $endAt, int $page = 1, int $pageSize = 20): array
    {
        return MongoClient::getInstance()
            ->selectDatabase($this->database)
            ->selectCollection($this->collection)
            ->aggregate([
                [
                    '$match' => [
                        'customer_id' => $customerId,
                    ],
                ],
                [
                    '$group' => [
                        '_id'         => '$openid',
                        'openid'      => ['$last' => '$openid'],
                        'customer_id' => ['$last' => '$customer_id'],
                        'created_at'  => ['$last' => '$created_at'],
                        'sender'      => ['$last' => '$sender'],
                        'msg_type'    => ['$last' => '$msg_type'],
                        'is_read'     => ['$last' => '$is_read'],
                        'data'        => ['$last' => '$data'],
                    ]
                ],
                [
                    '$sort' => ['created_at' => -1],
                ],
                [
                    '$skip' => ($page - 1) * $pageSize,
                ],
                [
                    '$limit' => $pageSize,
                ]
            ])
            ->toArray();
    }

    /**
     * @param int    $customerId
     * @param string $startAt
     * @param string $endAt
     *
     * @return array
     */
    public function getLastMessageChatListCount(int $customerId, string $startAt, string $endAt): array
    {
        return MongoClient::getInstance()
            ->selectDatabase($this->database)
            ->selectCollection($this->collection)
            ->aggregate([
                [
                    '$match' => [
                        'customer_id' => $customerId,
                    ],
                ],
                [
                    '$group' => [
                        '_id'         => '$openid',
                        'openid'      => ['$last' => '$openid'],
                        'customer_id' => ['$last' => '$customer_id'],
                        'created_at'  => ['$last' => '$created_at'],
                        'sender'      => ['$last' => '$sender'],
                        'msg_type'    => ['$last' => '$msg_type'],
                        'is_read'     => ['$last' => '$is_read'],
                        'data'        => ['$last' => '$data'],
                    ]
                ],
                [
                    '$count' => 'total'
                ]
            ])
            ->toArray();
    }
}
