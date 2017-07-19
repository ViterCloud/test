<?php
namespace Admin\Model;
use Think\Model;
class ParkingModel extends Model{
    protected $_validate = array(
        array('name','require','车场名必须填!'),
        array('name','','车场名已存在!',1,'unique',1),
        array('name','0,15','车场名长度不符合标准',1,'length'),
        array('price','require','价格必须填!'),
        array('parkplace','require','地址必须填!'),
        array('owner','require','场主必须填!'),
        array('num','require','电话必须填!')        
    );
}
?>