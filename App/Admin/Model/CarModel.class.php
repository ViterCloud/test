<?php
namespace Admin\Model;
use Think\Model;
class CarModel extends Model{
    protected $_validate = array(
        array('num','require','车牌号必须填!',1),
        array('num','','车牌已被注册!',1,'unique',1),
        array('num','6','车牌号码不符合标准!',1,'length',1),
        array('owner','require','车主必须填',1),
        array('owner','','一个用户只能注册一个车牌',1,'unique',1)
    );
    protected $_auto = array(
        array('style','C4')
    );
}
?>