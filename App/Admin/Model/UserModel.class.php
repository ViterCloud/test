<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model{
    protected $_validate = array(
        array('number','require','账号必须填!'),
        array('number','','账号已存在!',1,'unique',1),
        array('number','3,10','账号长度不符合标准',1,'length'),
        array('name','require','用户名必须填!'),
        array('password','require','密码必须填!'),
        array('phone','require','电话必须填!'),
        array('root',array("car","place"),'身份不符合标准!',1,'in')
    );
}
?>