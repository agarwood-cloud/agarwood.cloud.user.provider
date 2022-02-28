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
     * @\Swoft\Validator\Annotation\Mapping\IsInt()
     *
     * @var int|null
     */
    public ?int $customerId = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $customer = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $headimgurl = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $nickname = null;

    /**
     *@\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $openid = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var int|null
     */
    public ?int $subscribe = null;

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
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var string|null
     */
    public ?string $subscribeScene = null;

    /**
     * @\Swoft\Validator\Annotation\Mapping\IsString()
     *
     * @var ?string
     */
    public ?string $unionid = null;

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
    public function getHeadimgurl(): ?string
    {
        return $this->headimgurl;
    }

    /**
     * @param string|null $headimgurl
     */
    public function setHeadimgurl(?string $headimgurl): void
    {
        $this->headimgurl = $headimgurl;
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
     * @return string|null
     */
    public function getUnionid(): ?string
    {
        return $this->unionid;
    }

    /**
     * @param string|null $unionid
     */
    public function setUnionid(?string $unionid): void
    {
        $this->unionid = $unionid;
    }
}
