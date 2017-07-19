<?php
/**
 * Admin模块公共函数库
 */
//打印函数
function P($string){
    print_r($string);
}
//打印时间
function ptime(){
    $time = date("y年m月d日  H:m",time());
    echo $time;
}
//错误弹窗
function fof($string){
    echo "<script>alert('$string');history.back();</script>";
}
//读取数据库表、标题
function tblist($s){
        $user = array("ID","账号","用户名","密码","联系方式","身份");
        $car = array("ID","车牌号","车型","车主");
        $parking = array("ID","名字","价格","地址","车场主","数量","电话");
    if($s=='user')
        return $user;
    elseif($s=='car')
        return $car;
    elseif($s=='parking')
        return $parking;
    else 
        return "";
}
//打印字段名
function keyname($s){
    $user = array();
    $from = M($s);
    $result = $from->getDbFields();
    return $result;
}
//删除数据
function delete($list){
    $tb = I("session.tb","");
    $map['id'] = array('in',$list);
    $from = M($tb);
    $result=$from->where($map)->delete();
    return $result;
}
//打印信息
function readtb($s,$page){
    unset($_SESSION['message']);
    unset($_SESSION['key']);
    unset($_SESSION['tb']);
    if($s==""){
        $_SESSION['message']="";
        $_SESSION['key']="";
        $_SESSION['tb']="";
    }else{
        if(I("session.tb","")!=$s){
            unset($_SESSION['pagination']);
            unset($_SESSION['pagemap']);
        }
        $_SESSION['tb']=$s;
        $from = M($s);
        $string = tblist($s);
        if(I("session.pagination","")==""){
             $result = $from->select();  
             paging($result);
         }
        $page=$page+1;
        $value = $from->page($page,5)->select();
        $_SESSION['message'] = $value;
        $_SESSION['key'] = $string;  
        return "";
    if($result){
       }else{
           unset($_SESSION['message']);
           unset($_SESSION['key']);
           session_destroy();
       }  
    }
}
//查找数据
function findlist($key,$tb){
    switch($tb){
        case"user":
            $map['name|number|phone|root'] = array('like','%'.$key.'%');
            break;
        case"car":
            $map['num|owner'] = array('like','%'.$key.'%');
            break;
        case"parking":
            $map['name|price|parkplace|owner|num|phone'] = array('like','%'.$key.'%');
            break;
    }
    $from = M($tb);
    $result = $from->where($map)->select();
    return $result;
}
//分页函数
function paging($result){
    unset($_SESSION['pagination']);
    if($result){
        $num = 5;
        $record_count = count($result);
        if($record_count%$num!=0)
            $page = round($record_count/$num)+1;
        else $page = $record_count/$num;
        $list['count'] = $record_count;
        $list['page'] = $page;
        $list['num'] = $num;
        $list['type'] = "page";
    }else{
        $list['count'] = "";
        $list['page'] = "";
        $list['num'] = 0;
        $list['type'] = "didden";
    }
    $_SESSION['pagination'] = $list;
}
//分页内容
function pagevalue($page){
    unset($_SESSION['pvalue']);
    unset($_SESSION['pagemap']);
    $tb = I("session.tb","");
    $list = I("session.pagination","");
//     if(I("session.pagination","")){
//         $date = I("session.message","");
//         $count = $list['count'];
//         $i = 5*$page;        
//         for($s = 0;$i<$count;$i++,$s++){
//             $result[$s] = $date[$i];
//             if($s==4)
//                 break;
//         }
//         $_SESSION['message'] = $result;
//     }else $_SESSION['message'] = "null";
    
    $end = $list['page'];
    $map['front'] = U("Index/index?table=$tb");
    $map['back'] = U("Index/index?table=$tb&page=$end");
    
    if($page<=1){
        $map['firstv'] = 1;
        $map['first'] = U("Index/index?table=$tb&page=0"," ");
        $map['secondv'] = 2;
        $map['second'] = U("Index/index?table=$tb&page=1"," ");
        $map['thirdv'] = 3;
        $map['third'] = U("Index/index?table=$tb&page=2"," ");
    }else{
        $f = $page-2;
        $t = $page-1;
        $map['firstv'] = $page-1;
        $map['first'] = U("Index/index?table=$tb&page=$f"," ");
        $map['secondv'] = $page;
        $map['second'] = U("Index/index?table=$tb&page=$t"," ");
        $map['thirdv'] = $page+1;
        $map['third'] = U("Index/index?table=$tb&page=$page"," ");
    }
    if($end<2){
        $map['firsts'] = "active";
        $map['seconds'] = $map['thirds'] = "disabled";
    }elseif($end==2){
        $map['thirds'] = "disabled";
        if($page==0){
            $map['firsts'] ="active";
            $map['seconds'] = "";
        }else{
            $map['firsts'] = "";
            $map['seconds'] ="active";
        }
    }elseif($end>=2){
        if($page==0){
            $map['firsts'] ="active";
            $map['seconds'] = " ";
            $map['thirds'] = " ";
        }else{
            $map['firsts'] =" ";
            $map['seconds'] = "active";
            $map['thirds'] = " ";
        }
        if(($page+1)==$end){
            $map['firsts'] = "";
            $map['seconds'] ="active";
            $map['thirds'] = "disabled";
        }
    }
    $_SESSION['pagemap'] = $map;
}
?>