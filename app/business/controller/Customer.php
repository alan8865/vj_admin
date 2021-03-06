<?php
/* +----------------------------------------------------------------------
 * 作	者: venus <venus-wxp@outlook.com>
 +----------------------------------------------------------------------
 * 创建日期: 2017-11-29 18:21
 +----------------------------------------------------------------------
 * 文件描述: 这是Customer类
 +----------------------------------------------------------------------
 * 升级记录: 
 +----------------------------------------------------------------------
 */

namespace app\business\controller;

/**
 * Class Customer 类
 * @package app\business\controller
 */
class Customer extends Common {

    // 这里配置是否分页
    protected $paginate = true;

    // 定义搜索字段（必须是数组）
    // 注意：如果你的搜索字段是2个或者两个以上，那么数组必须在最后面赘上一个元素“|”或者“&”
    // 用来表示这些模糊匹配的字段是或者关系还是且的关系
    protected $likeFields = [
        'name'
    ];

    // 这里是定义要查询所需要的表的字段，默认为 *
    protected $fields = [

    ];

    // 这里是定义详情页展示数据需要的字段，如果没有提供，默认会和$fields保持一致
    protected $detailFields = [

    ];

    /*public function index () {

    }*/

    protected function beforeAlter (&$data) {
        $data['content'] = htmlspecialchars($data['content']);
    }

    protected function afterDetail (&$data) {
        $data['content'] = htmlspecialchars_decode($data['content']);
    }

}