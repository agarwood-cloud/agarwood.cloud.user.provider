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
 * 用户详情表
 *
 * @since 2.0
 *
 * @Entity(table="user_info_temp")
 */
class UserInfoTemp extends Model
{
    /**
     * 生日
     *
     * @Column()
     *
     * @var string
     */
    private $birthday;

    /**
     * 用户所在城市
     *
     * @Column()
     *
     * @var string
     */
    private $city;

    /**
     * 用户所在国家
     *
     * @Column()
     *
     * @var string
     */
    private $country;

    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     *
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 用户的语言，简体中文为zh_CN
     *
     * @Column()
     *
     * @var string
     */
    private $language;

    /**
     * OPENID
     *
     * @Column()
     *
     * @var string
     */
    private $openid;

    /**
     * 手机号
     *
     * @Column()
     *
     * @var string
     */
    private $phone;

    /**
     * 用户所在省份
     *
     * @Column()
     *
     * @var string
     */
    private $province;

    /**
     * 备注
     *
     * @Column()
     *
     * @var string
     */
    private $remark;

    /**
     * 用户被打上的标签ID列表
     *
     * @Column(name="tag_id_list", prop="tagIdList")
     *
     * @var string
     */
    private $tagIdList;

    /**
     * @param string $birthday
     *
     * @return self
     */
    public function setBirthday(string $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @param string $city
     *
     * @return self
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param string $country
     *
     * @return self
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

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
     * @param string $language
     *
     * @return self
     */
    public function setLanguage(string $language): self
    {
        $this->language = $language;

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
     * @param string $phone
     *
     * @return self
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param string $province
     *
     * @return self
     */
    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @param string $remark
     *
     * @return self
     */
    public function setRemark(string $remark): self
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * @param string $tagIdList
     *
     * @return self
     */
    public function setTagIdList(string $tagIdList): self
    {
        $this->tagIdList = $tagIdList;

        return $this;
    }

    /**
     * @return string
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
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
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
    public function getLanguage(): ?string
    {
        return $this->language;
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
     * @return string
     */
    public function getTagIdList(): ?string
    {
        return $this->tagIdList;
    }
}
