<?php
/**
 * Home模块公共函数库
 */
//打印函数
function P($string){
    print_r($string);
}
//打印时间
function ptime(){
    $time = date("y年m月d日  H:i",time());
    echo $time;
}
//打印身份
function proot($s){
    if($s=="car")
        return "车主";
    elseif ($s=="place")
        return "场主";
}
//检查函数
function check($date){
    $s=0;
    $from = M("user");
    $result = $from->select();
    foreach ($result as $value){
        if($value['number']==$date['number']){
            fof("账号已存在！");
            exit;
        }
    }
    if($date['name']==''){
        fof("用户名未填写！");
        exit;
    }else $s++;
   if($date['password']==''){
       fof("密码未填写！");
        exit;
    }else $s++;
    if($date['phone']==''){
        fof("联系方式未填写！");
        exit;
    }else $s++;
    if(strlen($date['number'])<2||strlen($date['number'])>10){
        fof("账号不符合标准!");
        exit;
    }else $s++;;
    if($s==4){
        $result=$from->add($date);
        if($result>0)
            return 1;
        else
            return 0;
    }
}
//错误弹窗
function fof($string){
    echo "<script>alert('$string');history.back();</script>";
}
//检查是否有用户登录
function message(){
    $m = I("session.userdate","");
    if($m==''){
        $style['act'] = "hidden";
        $style['img'] = "dimg";
    }else{
        $style['act'] = 'act';
        $style['img'] = 'sta';
    }
    return $style;
}
//打印地址
function purl($u){
    if(I("session.userdate","")==""){
        $url = U("Home/Index/index");
        return $url;
    }else{
    if($u=="register")
        return $url['register'] = U("Home/Register/index");
    if ($u=="index")
        return $url['index'] = U("Home/Index/index");
    if ($u=="owner")
        return $url['owner'] = U("Home/Owner/index");
    if ($u=="place"){
        if(I("session.userroot","")=="place")
            return $url['place'] = U("Home/Place/index");
        else return $url['place'] = "";
    }
    if ($u=="about")
        return $url['about'] = U("Home/About/index");
    }
}
//打印场地信息
function placelist(){
    $from = M('parking');
    $result = $from->select();
    return $result;
}
//查找用户信息
function userdate(){
    $from = M('user');
    $sql = "id=".I("session.userid","");
    $result = $from->where($sql)->select();
    return $result[0];
}
//重组车位状态数组
function buildpark($key){
    $from = M('parking');
    $sql['owner'] = $key;
    $result = $from->where($sql)->select();
    $num = $result[0]['num'];
    $ing = rcr($result[0]['id']);
    $place = array();
    for($i=0;$i<$num;$i++){
        if($i<$ing)
            $place[$i]='ing';
        else
            $place[$i]='no';
    }
    return $place;
} 
//查询停车记录数
function rcr($place_id){
    $from = M('record');
    $map['parkid'] = array("eq",(int)$place_id);
    $result = $from->where($map)->select();
    $num = count($result);
    foreach ($result as $value){
        if(((int)$value['end']+600)<time())
            $num--;
    }
    return $num;
}
//查询车场主场地信息
function placedate($key){
    $from = M('parking');
    $sql['owner'] = $key;
    $result = $from->where($sql)->select();
    $value = $result[0];
    return $value;
}
//登记车辆
function logincar($record){
    $from = M('car');
    $result = $from->select();
    foreach($result as $value){
        if($value['num']==$record['num']){
            fof("同一车牌号码不能重复注册!");
            $result = 0;
            return $result;
        }
    }
    $result = $from->add($record);
    return $result;    
}
//检查车辆
function checkcar($list){
    $map['owner'] = array('eq',$list['name']);
    $from = M('car');
    $result = $from->where($map)->select(); 
    if($result){
        return $result[0];
    }
    else return 0;
}
//添加停车记录
function addrecord($list){
    $from = M('record');
    $result = $from->add($list);
    return $result;
}
//打印车辆状态
function pstate($id){
    $from = M('record');
    $date['state'] = "空闲";
    $date['stbox'] = "hidden";
    $date['end'] = "";
    $date['park'] = "";
    $map['carnum'] = array('eq',$id);
    $result = $from->where($map)->select();
    foreach ($result as $value){
        if(((int)$value['end']+600)>time()){
            $date['state'] = "停车中...";
            $date['stbox'] = "state";
            $date['end'] = date(" H:m",$value['end']);
            $str = findplace($value['parkid']);
            $date['park'] = mb_substr($str['name'], 0,2);
        }
    }
    return $date;
}
//查找场地信息
function findplace($key){
    $from = M('parking');
    $map['id'] = array('eq',$key);
    $result = $from->where($map)->select();
    return $result[0];
}
?>