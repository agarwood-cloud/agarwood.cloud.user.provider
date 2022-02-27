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
class CreateDTO extends AbstractBaseDTO
{
    /**
     * 用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息。
     *
     * @var int
     */
    public int $subscribe = 0;

    /**
     * 用户的标识，对当前公众号唯一
     *
     * @var string
     */
    public string $openid = '';

    /**
     * 用户的昵称 (2021年12月27日之后不再输出)
     *
     * @var string
     */
    public string $nickname = '';

    /**
     * 用户的语言，简体中文为zh_CN
     *
     * @var string
     */
    public string $language = '';

    /**
     * 用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132 数值可选，0代表640*640正方形头像）
     * 用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。(2021年12月27日之后不再输出)
     *
     * @var string
     */
    public string $headimgurl = '';

    /**
     * 用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间
     *
     * @var int
     */
    public int $subscribe_time = 0;

    /**
     * 只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。
     *
     * @var string
     */
    public string $unionid = '';

    /**
     * 公众号运营者对粉丝的备注，公众号运营者可在微信公众平台用户管理界面对粉丝添加备注
     *
     * @var string
     */
    public string $remark = '';

    /**
     * 用户所在的分组ID（兼容旧的用户分组接口）
     *
     * @var int
     */
    public int $groupid = 0;

    /**
     * 用户被打上的标签ID列表
     *
     * @var array
     */
    public array $tagid_list = [];

    /**
     * 返回用户关注的渠道来源，
     *      ADD_SCENE_SEARCH 公众号搜索，
     *      ADD_SCENE_ACCOUNT_MIGRATION 公众号迁移，
     *      ADD_SCENE_PROFILE_CARD 名片分享，
     *      ADD_SCENE_QR_CODE 扫描二维码，
     *      ADD_SCENE_PROFILE_LINK 图文页内名称点击，
     *      ADD_SCENE_PROFILE_ITEM 图文页右上角菜单，
     *      ADD_SCENE_PAID 支付后关注，
     *      ADD_SCENE_WECHAT_ADVERTISEMENT 微信广告，
     *      ADD_SCENE_OTHERS 其他
     *
     * @var string
     */
    public string $subscribe_scene = 'VISITOR';

    /**
     * 二维码扫码场景（开发者自定义）
     *
     * @var int|string
     */
    public int|string $qr_scene = 0;

    /**
     * 二维码扫码场景描述（开发者自定义）
     *
     * @var string
     */
    public string $qr_scene_str = '';

    /**
     * @return int
     */
    public function getSubscribe(): int
    {
        return $this->subscribe;
    }

    /**
     * @param int $subscribe
     */
    public function setSubscribe(int $subscribe): void
    {
        $this->subscribe = $subscribe;
    }

    /**
     * @return string
     */
    public function getOpenid(): string
    {
        return $this->openid;
    }

    /**
     * @param string $openid
     */
    public function setOpenid(string $openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getHeadimgurl(): string
    {
        return $this->headimgurl;
    }

    /**
     * @param string $headimgurl
     */
    public function setHeadimgurl(string $headimgurl): void
    {
        $this->headimgurl = $headimgurl;
    }

    /**
     * @return int
     */
    public function getSubscribeTime(): int
    {
        return $this->subscribe_time;
    }

    /**
     * @param int $subscribe_time
     */
    public function setSubscribeTime(int $subscribe_time): void
    {
        $this->subscribe_time = $subscribe_time;
    }

    /**
     * @return string
     */
    public function getUnionid(): string
    {
        return $this->unionid;
    }

    /**
     * @param string $unionid
     */
    public function setUnionid(string $unionid): void
    {
        $this->unionid = $unionid;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark;
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark): void
    {
        $this->remark = $remark;
    }

    /**
     * @return int
     */
    public function getGroupid(): int
    {
        return $this->groupid;
    }

    /**
     * @param int $groupid
     */
    public function setGroupid(int $groupid): void
    {
        $this->groupid = $groupid;
    }

    /**
     * @return array
     */
    public function getTagidList(): array
    {
        return $this->tagid_list;
    }

    /**
     * @param array $tagid_list
     */
    public function setTagidList(array $tagid_list): void
    {
        $this->tagid_list = $tagid_list;
    }

    /**
     * @return string
     */
    public function getSubscribeScene(): string
    {
        return $this->subscribe_scene;
    }

    /**
     * @param string $subscribe_scene
     */
    public function setSubscribeScene(string $subscribe_scene): void
    {
        $this->subscribe_scene = $subscribe_scene;
    }

    /**
     * @return string|int
     */
    public function getQrScene(): string|int
    {
        return $this->qr_scene;
    }

    /**
     * @param int|string $qr_scene
     */
    public function setQrScene(int|string $qr_scene): void
    {
        $this->qr_scene = $qr_scene;
    }

    /**
     * @return string
     */
    public function getQrSceneStr(): string
    {
        return $this->qr_scene_str;
    }

    /**
     * @param string $qr_scene_str
     */
    public function setQrSceneStr(string $qr_scene_str): void
    {
        $this->qr_scene_str = $qr_scene_str;
    }
}
