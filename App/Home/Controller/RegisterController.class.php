<?php
namespace Home\Controller;
use Think\Controller;
class RegisterController extends Controller{
    public function index(){
        $this->display();
    }
    public function add(){
        $date['name'] = I("post.username","","htmlspecialchars");
        $date['number'] = I("post.usernumber","","htmlspecialchars");
        $date['password'] = I("post.password","","htmlspecialchars");
        $date['phone'] = I("post.phone","","htmlspecialchars");
        $date['root'] = I("post.root");
        $ok = check($date);
        if($ok){
            $this->success('注册成功！');
        }else $this->error("注册失败！");
        $this->redirect("Index/index");
    }
}