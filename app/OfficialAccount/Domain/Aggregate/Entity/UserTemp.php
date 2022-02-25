<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Domain\Aggregate\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;

/**
 * 用户表
 *
 * @since 2.0
 *
 * @Entity(table="user_temp")
 */
class UserTemp extends Model
{
    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 客服
     *
     * @Column()
     *
     * @var string|null
     */
    private $customer;

    /**
     * 客服ID
     *
     * @Column(name="customer_uuid", prop="customerUuid")
     *
     * @var string
     */
    private $customerId;

    /**
     * 删除时间
     *
     * @Column(name="deleted_at", prop="deletedAt")
     *
     * @var string|null
     */
    private $deletedAt;

    /**
     * 分组
     *
     * @Column(name="group_uuid", prop="groupUuid")
     *
     * @var string|null
     */
    private $groupUuid;

    /**
     * 头像链接
     *
     * @Column(name="head_img_url", prop="headImgUrl")
     *
     * @var string
     */
    private $headImgUrl;

    /**
     *
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 昵称
     *
     * @Column()
     *
     * @var string
     */
    private $nickname;

    /**
     * OPENID
     *
     * @Column()
     *
     * @var string
     */
    private $openid;

    /**
     * 公众号uuid
     *
     * @Column(name="service_uuid", prop="serviceUuid")
     *
     * @var string
     */
    private $tencentId;

    /**
     * 是否关注
     *
     * @Column()
     *
     * @var string
     */
    private $subscribe;

    /**
     * 关注时间
     *
     * @Column(name="subscribe_at", prop="subscribeAt")
     *
     * @var string
     */
    private $subscribeAt;

    /**
     * 返回用户关注的渠道来源，ADD_SCENE_SEARCH 公众号搜索，ADD_SCENE_ACCOUNT_MIGRATION 公众号迁移，ADD_SCENE_PROFILE_CARD 名片分享，ADD_SCENE_QR_CODE 扫描二维码，ADD_SCENE_PROFILE_ LINK 图文页内名称点击，ADD_SCENE_PROFILE_ITEM 图文页右上角菜单，ADD_SCENE_PAID 支付后关注，ADD_SCENE_OTHERS 其他
     *
     * @Column(name="subscribe_scene", prop="subscribeScene")
     *
     * @var string
     */
    private $subscribeScene;

    /**
     * UNION_ID
     *
     * @Column(name="union_id", prop="unionId")
     *
     * @var string
     */
    private $unionId;

    /**
     * 取关时间
     *
     * @Column(name="unsubscribed_at", prop="unsubscribedAt")
     *
     * @var string
     */
    private $unsubscribedAt;

    /**
     * 更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string
     */
    private $updatedAt;

    /**
     * @param string $createdAt
     *
     * @return self
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param string|null $customer
     *
     * @return self
     */
    public function setCustomer(?string $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @param int $customerId
     *
     * @return self
     */
    public function setCustomerUuid(int $customerId): self
    {
        $this->customerUuid = $customerId;

        return $this;
    }

    /**
     * @param string|null $deletedAt
     *
     * @return self
     */
    public function setDeletedAt(?string $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @param string|null $groupUuid
     *
     * @return self
     */
    public function setGroupUuid(?string $groupUuid): self
    {
        $this->groupUuid = $groupUuid;

        return $this;
    }

    /**
     * @param string $headImgUrl
     *
     * @return self
     */
    public function setHeadImgUrl(string $headImgUrl): self
    {
        $this->headImgUrl = $headImgUrl;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $nickname
     *
     * @return self
     */
    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @param string $openid
     *
     * @return self
     */
    public function setOpenid(string $openid): self
    {
        $this->openid = $openid;

        return $this;
    }

    /**
     * @param int $tencentId
     *
     * @return self
     */
    public function setServiceUuid(int $tencentId): self
    {
        $this->serviceUuid = $tencentId;

        return $this;
    }

    /**
     * @param string $subscribe
     *
     * @return self
     */
    public function setSubscribe(string $subscribe): self
    {
        $this->subscribe = $subscribe;

        return $this;
    }

    /**
     * @param string $subscribeAt
     *
     * @return self
     */
    public function setSubscribeAt(string $subscribeAt): self
    {
        $this->subscribeAt = $subscribeAt;

        return $this;
    }

    /**
     * @param string $subscribeScene
     *
     * @return self
     */
    public function setSubscribeScene(string $subscribeScene): self
    {
        $this->subscribeScene = $subscribeScene;

        return $this;
    }

    /**
     * @param string $unionId
     *
     * @return self
     */
    public function setUnionId(string $unionId): self
    {
        $this->unionId = $unionId;

        return $this;
    }

    /**
     * @param string $unsubscribedAt
     *
     * @return self
     */
    public function setUnsubscribedAt(string $unsubscribedAt): self
    {
        $this->unsubscribedAt = $unsubscribedAt;

        return $this;
    }

    /**
     * @param string $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getCustomerUuid(): ?string
    {
        return $this->customerUuid;
    }

    /**
     * @return string|null
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @return string|null
     */
    public function getGroupUuid(): ?string
    {
        return $this->groupUuid;
    }

    /**
     * @return string
     */
    public function getHeadImgUrl(): ?string
    {
        return $this->headImgUrl;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getOpenid(): ?string
    {
        return $this->openid;
    }

    /**
     * @return string
     */
    public function getServiceUuid(): ?string
    {
        return $this->serviceUuid;
    }

    /**
     * @return string
     */
    public function getSubscribe(): ?string
    {
        return $this->subscribe;
    }

    /**
     * @return string
     */
    public function getSubscribeAt(): ?string
    {
        return $this->subscribeAt;
    }

    /**
     * @return string
     */
    public function getSubscribeScene(): ?string
    {
        return $this->subscribeScene;
    }

    /**
     * @return string
     */
    public function getUnionId(): ?string
    {
        return $this->unionId;
    }

    /**
     * @return string
     */
    public function getUnsubscribedAt(): ?string
    {
        return $this->unsubscribedAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }
}
