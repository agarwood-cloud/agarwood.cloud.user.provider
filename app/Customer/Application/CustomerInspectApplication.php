<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\Customer\Application;

use App\Customer\Interfaces\DTO\Customer\IndexDTO;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CustomerInspectApplication
{

    // TODO 暂时还没有开始写业务逻辑

    /**
     * 应用层
     *      客服列表服务接口
     *
     *
     * @param IndexDTO $DTO
     * @param bool     $isPagination
     *
     * @return array
     */
    public function indexProvider(IndexDTO $DTO, bool $isPagination = true): array;

    /**
     * 应用层
     *      查看列表服务接口
     *
     * @param string $uuid
     *
     * @return array
     */
    public function viewProvider(string $uuid): array;
}
