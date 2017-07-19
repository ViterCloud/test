<?php
namespace Admin\Controller;
use Think\Controller;
class AddController extends Controller {
    public function index(){
        $keyname = I("session.key","");
        array_shift($keyname);
        $this->assign("keyname",$keyname);
        $key = keyname(I("session.tb",""));
        array_shift($key);
        $this->assign("keyid",$key);
        $this->display();
    }
    public function add(){
        $tab = I("session.tb","");
        $date = I("post.");
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
            if(!$from->create($date)){
                fof($from->getError());
                exit;
            }else{
                if($from->add($date)){
                    $this->success("添加成功!");
                }else $this->error("添加失败!");
            }
        }
        $this->redirect("Index/index",'table=$tab',2,' ');
    }
}