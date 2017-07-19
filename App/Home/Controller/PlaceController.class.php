<?php
namespace Home\Controller;
use Think\Controller;
class PlaceController extends Controller {
    public function index(){
        $userdate = userdate();
        $this->assign("user",$userdate);
        $this->assign("pdate",placedate($userdate['name']));
        $this->assign("place",buildpark($userdate['name']));
        $this->display();
    }
}