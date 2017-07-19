<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->assign("userdate",I("session.userdate",""));
        $this->assign("style",message());
        $this->display();
    }
    public function login(){
        $number = I("post.number","","htmlspecialchars");
        $password = I("post.password","","htmlspecialchars");
        if($number==''){
            fof("账号未填写！");
            exit;
        }else if($password==''){
            fof("密码未填写！");
            exit;
        }else{
            $from = M("user");
            $sql ="number=".$number;
            $result = $from->where($sql)->select();
            if($result){
                if($result[0]['password']==$password){
                    $_SESSION['userdate']=$result[0]['name'];
                    $_SESSION['userid']=$result[0]['id'];
                    $_SESSION['userroot']=$result[0]['root'];
                    $this->success("登陆成功！");
                }else $this->error("密码错误！");
            }else $this->error("不存在该账号！");
        }
    }
    public function logout(){
        unset($_SESSION['userdate']);
        unset($_SESSION['userid']);
        unset($_SESSiON['userroot']);
        session_destroy();
        $this->success("退出成功！");
    }
}