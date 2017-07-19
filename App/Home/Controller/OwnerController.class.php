<?php
namespace Home\Controller;
use Think\Controller;
class OwnerController extends Controller{
    public function index(){
        $result = checkcar(userdate());
        $value = pstate($result['num']);
        if($result){          
                $this->assign("date",$value);           
                $this->assign("car",$result);
                $this->assign("cs","hidden");
                if($value['state']=="空闲")
                    $this->assign("a_link"," ");
                elseif($value['state']=="停车中..."){
                    $string = "onclick=\"return false;\"";
                    $this->assign("a_link",$string);
                }                    
        }else{
            $this->assign("date",$value);
            $this->assign("car","");
            $this->assign("cs"," ");
            $string = "onclick=\"return false;\"";
            $this->assign("a_link",$string);
        }      
        $this->assign("park",placelist());
        $this->assign("user",userdate());
        $this->display();
    }
    public function find(){
        $result = checkcar(userdate());
        $value = pstate($result['num']);
        if($result){
            $this->assign("date",$value);
            $this->assign("car",$result);
            $this->assign("cs","hidden");
            if($value['state']=="空闲")
                $this->assign("a_link"," ");
            elseif($value['state']=="停车中..."){
                $string = "onclick=\"return false;\"";
                $this->assign("a_link",$string);
            }
        }else{
            $this->assign("date",$value);
            $this->assign("car","");
            $this->assign("cs"," ");
            $string = "onclick=\"return false;\"";
            $this->assign("a_link",$string);
        }
        $key = I("post.find","");
        $from = M("parking");
        $map['name'] = array('like','%'.$key.'%');
        $res = $from->where($map)->select();
        $this->assign("user",userdate());
        $this->assign("park",$res);
        $this->display();
    }
    public function park($id){
        $from = M('parking');
        $map['id'] = array('eq',$id);
        $result = $from->where($map)->select();
        $car = checkcar(userdate());
        if($car){
            $this->assign("car",$car);
        }
        $this->assign("park",$result[0]);
        $this->assign("user",userdate());
        $this->assign("id",$id);
        $this->display();
    }
    public function carid(){
        $record['num'] = I("post.carid","","htmlspecialchars");
        $record['style'] = I("post.style","C4","htmlspecialchars");
        $record['owner'] = I("post.username","","htmlspecialchars");
        if($record['num']){
            $result = logincar($record);
        if($result)
            $this->success("登记成功!");
        else 
            $this->error("登记失败！");
        }
    }
    public function addrecord(){
        $time = I("post.time","","htmlspecialchars");
        $list['carnum'] = I("post.carnum","","htmlspecialchars");
        $list['parkid'] = I("post.parkid","","htmlspecialchars");
        $list['start'] = time();
        $list['end'] = time()+3600*(int)$time;
        $result = addrecord($list);
        if($result)
            $this->success("停车成功!");
        else $this->error("停车失败!");
        $this->redirect("Owner/index");
    }
}
?>