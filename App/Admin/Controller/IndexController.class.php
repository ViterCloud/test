<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index($table="",$page=0){
        $r = readtb($table,$page);
        if(I("session.pagination","")=="")
            paging(I("session.message",""));
        if(I("session.find","")){
           $_SESSION['message'] = I("session.find");
           unset($_SESSION['find']);
        }
        pagevalue($page);
        $this->assign("page",I("session.pagination",""));
        $this->assign("message",I("session.message",""));
        $this->assign("map",I("session.pagemap",""));      
        $this->assign("key",I("session.key",""));
        $this->assign("tb",I("session.tb",""));
        $this->display();
    }
    public function handle(){
        $hand = I("post.bt","");
        switch($hand){
            case "delete":
                $list = I("post.item","");
                $result = delete($list);
                if($result){
                    $this->success("删除成功!");
                }else $this->error("删除失败！");
                break;
            case "find":
                $date = I("post.f_name");
                $tb = I("session.tb","");
                $result = findlist($date,$tb);
                if($result){
                    unset($_SESSION['find']);
                    $_SESSION['find'] = $result;
                    $this->success("查询成功!");
                }else $this->error("没有记录!");
                break;
        }
    }
    public function update($id){
        $tb = I("session.tb","");
        $from = M($tb);
        $map['id'] = array('eq',$id);
        $result = $from->where($map)->select();
        $result = $result[0];
        array_shift($result);
        $this->assign("date",$result);
         $keyname = I("session.key","");
        array_shift($keyname);
        $this->assign("id",$id);
        $this->assign("keyname",$keyname);
        $this->display();
    }
    public function add($id){
        $tab = I("session.tb","");
        $date = I("post.");
        $map['id'] = array('eq',$id);
        switch($tab){
            case"user":
                $tb="User";
                break;
            case"packing":
                $tb="Parking";
                break;
            case"car":
                $tb="Car";
                break;
        }
        if($tb){
            $from = D($tb);           
            if($from->where($map)->save($date)){
                $this->success("修改成功!");
            }else $this->error("修改失败!");            
        }
        $this->redirect("Index/index",'table=$tab',2,' ');
    }
}