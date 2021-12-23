<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\User;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;

/**
 * @\Swoft\Validator\Annotation\Mapping\Validator()
 */
class UpdateDTO extends AbstractBaseDTO
{
    /**
     * 客服ID
     *
     * @var ?int
     */
    protected ?int $customerId = null;

    /**
     * 客服
     *
     * @var ?string
     */
    protected ?string $customer = null;

    /**
     * 头像链接
     *
     * @var ?string
     */
    protected ?string $headImgUrl = null;

    /**
     * 昵称
     *
     * @var ?string
     */
    protected ?string $nickname = null;

    /**
     *
     * @var ?string
     */
    protected ?string $openid = null;

    /**
     * 是否关注
     *
     * @var ?int
     */
    protected ?int $subscribe = null;

    /**
     * 返回用户关注的渠道来源，
     *
     * ADD_SCENE_SEARCH 公众号搜索，
     * ADD_SCENE_ACCOUNT_MIGRATION 公众号迁移，
     * ADD_SCENE_PROFILE_CARD 名片分享，
     * ADD_SCENE_QR_CODE 扫描二维码，
     * ADD_SCENE_PROFILE_ LINK 图文页内名称点击，
     * ADD_SCENE_PROFILE_ITEM 图文页右上角菜单，
     * ADD_SCENE_PAID 支付后关注，
     * ADD_SCENE_OTHERS 其他
     * VISITOR 游客
     *
     * @var ?string
     */
    protected ?string $subscribeScene = null;

    /**
     * 关注时间
     *
     * @var ?int
     */
    protected ?int $subscribeTime = null;

    /**
     * UNION_ID
     *
     * @var ?string
     */
    protected ?string $unionId = null;

    /**
     * 取关时间
     *
     * @var ?string
     */
    protected ?string $unsubscribedAt = null;

    /**
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int|null $customerId
     */
    public function setCustomerId(?int $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return string|null
     */
    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    /**
     * @param string|null $customer
     */
    public function setCustomer(?string $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string|null
     */
    public function getHeadImgUrl(): ?string
    {
        return $this->headImgUrl;
    }

    /**
     * @param string|null $headImgUrl
     */
    public function setHeadImgUrl(?string $headImgUrl): void
    {
        $this->headImgUrl = $headImgUrl;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string|null $nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string|null
     */
    public function getOpenid(): ?string
    {
        return $this->openid;
    }

    /**
     * @param string|null $openid
     */
    public function setOpenid(?string $openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return int|null
     */
    public function getSubscribe(): ?int
    {
        return $this->subscribe;
    }

    /**
     * @param int|null $subscribe
     */
    public function setSubscribe(?int $subscribe): void
    {
        $this->subscribe = $subscribe;
    }

    /**
     * @return string|null
     */
    public function getSubscribeScene(): ?string
    {
        return $this->subscribeScene;
    }

    /**
     * @param string|null $subscribeScene
     */
    public function setSubscribeScene(?string $subscribeScene): void
    {
        $this->subscribeScene = $subscribeScene;
    }

    /**
     * @return int|null
     */
    public function getSubscribeTime(): ?int
    {
        return $this->subscribeTime;
    }

    /**
     * @param int|null $subscribeTime
     */
    public function setSubscribeTime(?int $subscribeTime): void
    {
        $this->subscribeTime = $subscribeTime;
    }

    /**
     * @return string|null
     */
    public function getUnionId(): ?string
    {
        return $this->unionId;
    }

    /**
     * @param string|null $unionId
     */
    public function setUnionId(?string $unionId): void
    {
        $this->unionId = $unionId;
    }

    /**
     * @return string|null
     */
    public function getUnsubscribedAt(): ?string
    {
        return $this->unsubscribedAt;
    }

    /**
     * @param string|null $unsubscribedAt
     */
    public function setUnsubscribedAt(?string $unsubscribedAt): void
    {
        $this->unsubscribedAt = $unsubscribedAt;
    }
}
