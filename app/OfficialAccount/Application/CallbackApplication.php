<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Application;

use Symfony\Component\HttpFoundation\Response;

/**
 * @\Swoft\Bean\Annotation\Mapping\Bean()
 */
interface CallbackApplication
{
    /**
     * 公众号回调
     *
     * @param int|string $platformId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function officialAccountProvider(int|string $platformId): Response;
}
