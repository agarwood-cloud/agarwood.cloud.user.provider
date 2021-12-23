<?php declare(strict_types=1);
/**
 * This file is part of Agarwood Cloud.
 *
 * @link     https://www.agarwood-cloud.com
 * @document https://www.agarwood-cloud.com/docs
 * @contact  676786620@qq.com
 * @author   agarwood
 */

namespace App\OfficialAccount\Interfaces\DTO\Callback;

use Agarwood\Core\Support\Impl\AbstractBaseDTO;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 *
 * @Validator()
 */
class MessageSendEventDTO extends AbstractBaseDTO
{
    /**
     * @var string $ToUserName 接收方帐号（该公众号 ID）
     */
    protected string $ToUserName = '';

    /**
     * @var string $FromUserName 发送方帐号（OpenID, 代表用户的唯一标识）
     */
    protected string $FromUserName = '';

    /**
     * @var int $CreateTime 消息创建时间（时间戳）
     */
    protected int $CreateTime = 0;

    /**
     * @var int $MsgId 消息 ID（64位整型）
     */
    protected int $MsgId = 0;

    /**
     * @var string $MsgType
     */
    protected string $MsgType = 'event';

    /**
     * @var string $Event 事件类型 推送发送成功的回调事件
     */
    protected string $Event = 'MASSSENDJOBFINISH';

    /**
     * @var string $Status
     *
     */
    protected string $Status = 'send success';

    protected int $TotalCount = 0; //	tag_id下粉丝数；或者openid_list中的粉丝数

    protected int $FilterCount = 0; //	过滤（过滤是指特定地区、性别的过滤、用户设置拒收的过滤，用户接收已超4条的过滤）后，准备发送的粉丝数，原则上，FilterCount 约等于 SentCount + ErrorCount

    protected int $SentCount = 0; //	发送成功的粉丝数

    protected int $ErrorCount = 0; //	发送失败的粉丝数

    // ["CopyrightCheckResult"]=>
    //  array(3) {
    //    ["Count"]=>
    //    string(1) "0"
    //    ["ResultList"]=>
    //    NULL
    //    ["CheckState"]=>
    //    string(1) "1"
    //  }
    //  ["ArticleUrlResult"]=>
    //  array(2) {
    //    ["Count"]=>
    //    string(1) "1"
    //    ["ResultList"]=>
    //    array(1) {
    //      ["item"]=>
    //      array(2) {
    //        ["ArticleIdx"]=>
    //        string(1) "1"
    //        ["ArticleUrl"]=>
    //        string(48) "http://mp.weixin.qq.com/s/Q5DlF_LR_o3ceUGoj67Jcw"
    //      }
    //    }

    // $CopyrightCheckResult = [ 'Count' => 0, 'ResultList' => null, 'CheckState' = 1 ]

    // $ArticleUrlResult = [ 'Count' => 0, 'ResultList' => [ 'item' => [ 'ArticleIdx' => 1 , 'ArticleUrl' => 'http://mp.weixin.qq.com/s/Q5DlF_LR_o3ceUGoj67Jcw'] ]

    // 版权检查
    protected array $CopyrightCheckResult = [];

    // 以下为数组的key
    // protected string $ResultList = ''; //	各个单图文校验结果
    // protected string $ArticleIdx = ''; //	群发文章的序号，从1开始
    // protected string $CheckState = ''; //	整体校验结果： 1-未被判为转载，可以群发，2-被判为转载，可以群发，3-被判为转载，不能群发

    // 文件链接
    protected array $ArticleUrlResult = [];

    // 以下为数组的key
    //  protected string $ArticleUrl = ''; //	群发文章的url

    protected string $UserDeclareState = ''; //	用户声明文章的状态

    protected string $AuditState = ''; //	系统校验的状态

    protected string $OriginalArticleUrl = ''; //	相似原创文的url

    protected string $OriginalArticleType = ''; //	相似原创文的类型

    protected string $CanReprint = ''; //	是否能转载

    protected string $NeedReplaceContent = ''; //	是否需要替换成原创文内容

    protected string $NeedShowReprintSource = '';  //	是否需要注明转载来源

    /**
     * @return string
     */
    public function getToUserName(): string
    {
        return $this->ToUserName;
    }

    /**
     * @param string $ToUserName
     */
    public function setToUserName(string $ToUserName): void
    {
        $this->ToUserName = $ToUserName;
    }

    /**
     * @return string
     */
    public function getFromUserName(): string
    {
        return $this->FromUserName;
    }

    /**
     * @param string $FromUserName
     */
    public function setFromUserName(string $FromUserName): void
    {
        $this->FromUserName = $FromUserName;
    }

    /**
     * @return int
     */
    public function getCreateTime(): int
    {
        return $this->CreateTime;
    }

    /**
     * @param int $CreateTime
     */
    public function setCreateTime(int $CreateTime): void
    {
        $this->CreateTime = $CreateTime;
    }

    /**
     * @return int
     */
    public function getMsgId(): int
    {
        return $this->MsgId;
    }

    /**
     * @param int $MsgId
     */
    public function setMsgId(int $MsgId): void
    {
        $this->MsgId = $MsgId;
    }

    /**
     * @return string
     */
    public function getMsgType(): string
    {
        return $this->MsgType;
    }

    /**
     * @param string $MsgType
     */
    public function setMsgType(string $MsgType): void
    {
        $this->MsgType = $MsgType;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->Event;
    }

    /**
     * @param string $Event
     */
    public function setEvent(string $Event): void
    {
        $this->Event = $Event;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     */
    public function setStatus(string $Status): void
    {
        $this->Status = $Status;
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->TotalCount;
    }

    /**
     * @param int $TotalCount
     */
    public function setTotalCount(int $TotalCount): void
    {
        $this->TotalCount = $TotalCount;
    }

    /**
     * @return int
     */
    public function getFilterCount(): int
    {
        return $this->FilterCount;
    }

    /**
     * @param int $FilterCount
     */
    public function setFilterCount(int $FilterCount): void
    {
        $this->FilterCount = $FilterCount;
    }

    /**
     * @return int
     */
    public function getSentCount(): int
    {
        return $this->SentCount;
    }

    /**
     * @param int $SentCount
     */
    public function setSentCount(int $SentCount): void
    {
        $this->SentCount = $SentCount;
    }

    /**
     * @return int
     */
    public function getErrorCount(): int
    {
        return $this->ErrorCount;
    }

    /**
     * @param int $ErrorCount
     */
    public function setErrorCount(int $ErrorCount): void
    {
        $this->ErrorCount = $ErrorCount;
    }

    /**
     * @return array
     */
    public function getCopyrightCheckResult(): array
    {
        return $this->CopyrightCheckResult;
    }

    /**
     * @param array $CopyrightCheckResult
     */
    public function setCopyrightCheckResult(array $CopyrightCheckResult): void
    {
        $this->CopyrightCheckResult = $CopyrightCheckResult;
    }

    /**
     * @return array
     */
    public function getArticleUrlResult(): array
    {
        return $this->ArticleUrlResult;
    }

    /**
     * @param array $ArticleUrlResult
     */
    public function setArticleUrlResult(array $ArticleUrlResult): void
    {
        $this->ArticleUrlResult = $ArticleUrlResult;
    }

    /**
     * @return string
     */
    public function getUserDeclareState(): string
    {
        return $this->UserDeclareState;
    }

    /**
     * @param string $UserDeclareState
     */
    public function setUserDeclareState(string $UserDeclareState): void
    {
        $this->UserDeclareState = $UserDeclareState;
    }

    /**
     * @return string
     */
    public function getAuditState(): string
    {
        return $this->AuditState;
    }

    /**
     * @param string $AuditState
     */
    public function setAuditState(string $AuditState): void
    {
        $this->AuditState = $AuditState;
    }

    /**
     * @return string
     */
    public function getOriginalArticleUrl(): string
    {
        return $this->OriginalArticleUrl;
    }

    /**
     * @param string $OriginalArticleUrl
     */
    public function setOriginalArticleUrl(string $OriginalArticleUrl): void
    {
        $this->OriginalArticleUrl = $OriginalArticleUrl;
    }

    /**
     * @return string
     */
    public function getOriginalArticleType(): string
    {
        return $this->OriginalArticleType;
    }

    /**
     * @param string $OriginalArticleType
     */
    public function setOriginalArticleType(string $OriginalArticleType): void
    {
        $this->OriginalArticleType = $OriginalArticleType;
    }

    /**
     * @return string
     */
    public function getCanReprint(): string
    {
        return $this->CanReprint;
    }

    /**
     * @param string $CanReprint
     */
    public function setCanReprint(string $CanReprint): void
    {
        $this->CanReprint = $CanReprint;
    }

    /**
     * @return string
     */
    public function getNeedReplaceContent(): string
    {
        return $this->NeedReplaceContent;
    }

    /**
     * @param string $NeedReplaceContent
     */
    public function setNeedReplaceContent(string $NeedReplaceContent): void
    {
        $this->NeedReplaceContent = $NeedReplaceContent;
    }

    /**
     * @return string
     */
    public function getNeedShowReprintSource(): string
    {
        return $this->NeedShowReprintSource;
    }

    /**
     * @param string $NeedShowReprintSource
     */
    public function setNeedShowReprintSource(string $NeedShowReprintSource): void
    {
        $this->NeedShowReprintSource = $NeedShowReprintSource;
    }
}
