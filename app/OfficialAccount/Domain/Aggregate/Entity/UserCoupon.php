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
 * 用户优惠券表
 *
 * @since 2.0
 *
 * @Entity(table="user_coupon")
 */
class UserCoupon extends Model
{
    /**
     * 优惠券名称
     *
     * @Column(name="coupon_name", prop="couponName")
     *
     * @var string
     */
    private $couponName;

    /**
     * 优惠券ID
     *
     * @Column(name="coupon_uuid", prop="couponUuid")
     *
     * @var int
     */
    private $couponUuid;

    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 过期时间
     *
     * @Column(name="expired_at", prop="expiredAt")
     *
     * @var string
     */
    private $expiredAt;

    /**
     * 优惠券数量
     *
     * @Column()
     *
     * @var int
     */
    private $num;

    /**
     * 用户ID
     *
     * @Column()
     *
     * @var string
     */
    private $openid;

    /**
     * 更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string
     */
    private $updatedAt;

    /**
     * UUID
     * @Id(incrementing=false)
     * @Column()
     *
     * @var string
     */
    private $uuid;

    /**
     * @param string $couponName
     *
     * @return self
     */
    public function setCouponName(string $couponName): self
    {
        $this->couponName = $couponName;

        return $this;
    }

    /**
     * @param int $couponUuid
     *
     * @return self
     */
    public function setCouponUuid(int $couponUuid): self
    {
        $this->couponUuid = $couponUuid;

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
     * @param string $expiredAt
     *
     * @return self
     */
    public function setExpiredAt(string $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * @param int $num
     *
     * @return self
     */
    public function setNum(int $num): self
    {
        $this->num = $num;

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
     * @param string $uuid
     *
     * @return self
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getCouponName(): ?string
    {
        return $this->couponName;
    }

    /**
     * @return int
     */
    public function getCouponUuid(): ?int
    {
        return $this->couponUuid;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getExpiredAt(): ?string
    {
        return $this->expiredAt;
    }

    /**
     * @return int
     */
    public function getNum(): ?int
    {
        return $this->num;
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
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
