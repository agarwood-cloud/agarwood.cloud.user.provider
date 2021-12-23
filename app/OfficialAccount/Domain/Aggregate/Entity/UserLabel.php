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
 * 用户标签表
 *
 * @since 2.0
 *
 * @Entity(table="user_label")
 */
class UserLabel extends Model
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
     * 删除时间
     *
     * @Column(name="deleted_at", prop="deletedAt")
     *
     * @var string
     */
    private $deletedAt;

    /**
     * 标签
     *
     * @Column()
     *
     * @var string
     */
    private $label;

    /**
     * OPENID
     * @Id(incrementing=false)
     * @Column()
     *
     * @var string
     */
    private $openid;

    /**
     * 创建时间
     *
     * @Column(name="tag_id_list", prop="tagIdList")
     *
     * @var string
     */
    private $tagIdList;

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
     * @param string $deletedAt
     *
     * @return self
     */
    public function setDeletedAt(string $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @param string $label
     *
     * @return self
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

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
     * @return string
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
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
    public function getTagIdList(): ?string
    {
        return $this->tagIdList;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }
}
