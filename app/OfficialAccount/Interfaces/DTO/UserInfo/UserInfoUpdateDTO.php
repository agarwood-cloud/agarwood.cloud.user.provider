<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\UserInfo;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 *
 * @Validator()
 */
class UserInfoUpdateDTO extends AbstractBaseDTO
{
    /**
     * 生日
     *
     * @var ?string
     */
    public ?string $birthday = null;

    /**
     * 用户所在城市
     *
     * @var ?string
     */
    public ?string $city = null;

    /**
     * 用户所在国家
     *
     * @var ?string
     */
    public ?string $country = null;

    /**
     * 用户的语言，简体中文为zh_CN
     *
     * @var ?string
     */
    public ?string $language = null;

    /**
     * 手机号
     *
     * @var ?string
     */
    public ?string $phone = null;

    /**
     * 用户所在省份
     *
     * @var ?string
     */
    public ?string $province = null;

    /**
     * 备注
     *
     * @var ?string
     */
    public ?string $remark = null;

    /**
     * 用户被打上的标签ID列表
     *
     *
     * @var array
     */
    public array $tagIdList = [];

    /**
     * @param ?string $birthday
     *
     * @return self
     */
    public function setBirthday(?string $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @param ?string $city
     *
     * @return self
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param ?string $country
     *
     * @return self
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param ?string $language
     *
     * @return self
     */
    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param ?string $phone
     *
     * @return self
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param ?string $province
     *
     * @return self
     */
    public function setProvince(?string $province): self
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @param ?string $remark
     *
     * @return self
     */
    public function setRemark(?string $remark): self
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * @param array $tagIdList
     *
     * @return self
     */
    public function setTagIdList(array $tagIdList): self
    {
        $this->tagIdList = $tagIdList;

        return $this;
    }

    /**
     * @return ?string
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * @return string
     */
    public function getRemark(): ?string
    {
        return $this->remark;
    }

    /**
     * @return ?string
     */
    public function getTagIdList(): ?string
    {
        return implode(',', $this->tagIdList);
    }

    /**
     *
     * @param $attributes
     *
     * @return array
     */
    public function setBefore($attributes): array
    {
        //将时间修改为日期格式
        $attributes['tagIdList'] = $attributes['tagid_list'];
        unset(
            $attributes['tagid_list'],
        );
        return $attributes;
    }
}
