<?php
require CLASS_PATH.'operation.class.php';
class chengji extends operation {
    public $parameter;
    public function __construct($parameter) {
        $this->parameter = $parameter;
    }
    public function bangdingapi() {
        //判断用户是否已绑定
        $state = parent::wechatApi($this->parameter[2]);
        $postObj = $state['postObj'];
        $openid = $postObj->FromUserName;
        if ($state['state'] == 1) {//已绑定
            $content = "您已经绑定，无需再次绑定，直接输入“成绩”查看";
            $result = parent::transmitText($postObj, $content);
        } elseif ($state['state'] == 2) {//未绑定
            $url = parent::getUrl()."?/chengji/bangdingpage/".$openid;
            $content = "<a href=\"".$url."\">点此绑定教务系统</a>";
            $result = parent::transmitText($postObj, $content);
        } else {
            $result = $state['msg'];
        }
        return $result;
    }
    public function bangdingpage() {
        $url = parent::getUrl()."?/chengji/bangdingpanduan/".$openid."/";
        $_GET['id'] = $this->parameter[2];
        require APP_PATH.'bangding.php';
    }
    public function bangdingpanduan() {
        $openid = $_POST['openid'];
        $username = $_POST['xuehao'];
        $password = $_POST['password'];
        
        echo '<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />';
        echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';
        
        $state = parent::validate($openid, $username, $password);
        if ($state['state'] == 1) {
            //判断学号密码是否正确
            $state = parent::isLegal($username, $password);
            if ($state['state'] == 1) {//学号密码正确
                $lbxm = $state['lbxm'];
                //判断数据库连接是否成功
                $state = parent::init();
                if ($state['state'] == 1) {//数据库连接成功
                    $sqlParameter = array(
                        ":openid" => $openid,
                        ":username" => $username,
                        ":password" => $password,
                        ":lbxm" => $lbxm,
                    );
                    $sql = "insert `fosu`(`openid`,`username`,`password`,`lbxm`) values(:openid,:username,:password,:lbxm);";
                    $state = parent::sqlSelect($sql, $sqlParameter);
                    if ($state['state'] == 1) {//sql语句执行成功
                         echo '<h1 style="text-align:center;margin-top: 50">绑定成功</h1>'; 
                         echo '<h2 style="text-align:center;">点击<span style="color:red;">左</span>上角的X，关闭绑定页</h2>';
                         echo '<h2 style="text-align:center;">输入“<span style="color:red;">成绩</span>”即可查询成绩</h2>';
                         echo '<h2 style="text-align:center;">输入“<span style="color:red;">解绑</span>”即可解除绑定</h2>';
                         echo '<h3 style="text-align:center;">不过我一般不推荐解除绑定。</h3>';
                         echo '<h3 style="text-align:center;">因为挂科的人才会解除绑定。</h3>';
                    } else {//sql语句执行失败
                        echo '<h1 style="text-align:center;margin-top: 50">绑定失败</h1>';
                        echo '<h1 style="text-align:center;margin-top: 50">sql语句执行失败</h1>';
                    }
                } else {//数据库连接失败
                    echo '<h1 style="text-align:center;margin-top: 50">绑定失败</h1>';
                    echo '<h1 style="text-align:center;margin-top: 50">数据库连接失败</h1>';
                }
            } elseif ($state['state'] == -3) {//学号密码错误
                echo '<h1 style="text-align:center;margin-top: 50">绑定失败</h1>';
                echo '<h1 style="text-align:center;margin-top: 50">请检查下你写的学号密码是不是正确</h1>';
                echo '<h1 style="text-align:center;margin-top: 50">code:'.$state['errcode'].'</h1>';
            } elseif ($state['state'] == -5) {//学号密码错误
                echo '<h1 style="text-align:center;margin-top: 50">绑定失败</h1>';
                echo '<h1 style="text-align:center;margin-top: 50">可能是密码错误，亦有可能是教务系统未能打开</h1>';
                echo '<h1 style="text-align:center;margin-top: 50">请检查下你写的学号密码是不是正确</h1>';
                echo '<h1 style="text-align:center;margin-top: 50">code:'.$state['errcode'].'</h1>';
            } else {//教务系统未能打开
                echo '<h1 style="text-align:center;margin-top: 50">绑定失败</h1>'; 
                echo '<h1 style="text-align:center;margin-top: 50">教务系统未能打开</h1>';
                echo '<h1 style="text-align:center;margin-top: 50">code:'.$state['errcode'].'</h1>'; 
            }
        } else {
            echo '<h1 style="text-align:center;margin-top: 50">总有刁民想陷害朕！！！</h1>';
            echo '<h2 style="text-align:center;margin-top:30"> <img src="http://ww4.sinaimg.cn/large/6810001bgw1et2d11g70dj20a608rmxe.jpg" height="150" align="middle"></h2> ';
            echo '<h1 style="text-align:center;margin-top: 50">有话好好说，微信微博联系我：caserest</h1>';
        }
    }
    public function chaxun() {
        //判断用户是否已绑定
        $state = parent::wechatApi($this->parameter[2]);
        $postObj = $state['postObj'];
        $openid = $postObj->FromUserName;
        if ($state['state'] == 1) {//已绑定
            $username = $state['username'];
            $password = $state['password'];
            $state = parent::getGrade($username, $password);
            if ($state['state'] == 1) {//获取成绩数据成功
                $grade = $state['grade'];
                $content[] = array(
                    "Title" => "查询到的成绩如下",
                    "Description" => $grade,
                    "PicUrl" => "",
                    "Url" => "",  
                );
            } elseif ($state['state'] == -7 || $state['state'] == -6) {//获取成绩数据失败
                $content[] = array(
                    "Title" => "查询失败!",
                    "Description" => "原因:获取成绩数据失败\ncode:".$state['errcode'],
                    "PicUrl" => "",
                    "Url" => "",  
                );
            } elseif ($state['state'] == -6) {
                $content[] = array(
                    "Title" => "查询失败!",
                    "Description" => "原因:获取成绩数据失败\n解决办法：请多试几次\ncode:".$state['errcode'],
                    "PicUrl" => "",
                    "Url" => "",  
                );
            } elseif ($state['state'] == -5) {
                $content[] = array(
                    "Title" => "查询失败!",
                    "Description" => "原因:可能是密码错误，亦有可能是教务系统未能打开\n解决办法：请多试几次，多次失败后请回复“解绑”，随后回复“绑定”重新绑定\ncode:".$state['errcode'],
                    "PicUrl" => "",
                    "Url" => "",  
                );
            } elseif ($state['state'] == -3) {//学号密码错误
                $content[] = array(
                    "Title" => "查询失败!",
                    "Description" => "原因:绑定学号或者密码错误\n解决办法：请回复“解绑”，随后回复“绑定”重新绑定\ncode:".$state['errcode'],
                    "PicUrl" => "",
                    "Url" => "",  
                );
            } elseif ($state['state'] == -4 || $state['state'] == -2 || $state['state'] == -1) {//教务系统未能打开
                $content[] = array(
                    "Title" => "查询失败!",
                    "Description" => "原因:教务系统未能打开\n解决办法：请多试几次\ncode:".$state['errcode'],
                    "PicUrl" => "",
                    "Url" => "",  
                );
            } else {//教务系统未能打开
                $content[] = array(
                    "Title" => "查询失败!",
                    "Description" => "原因:教务系统未能打开\n解决办法：请多试几次\ncode:".$state['errcode'],
                    "PicUrl" => "",
                    "Url" => "",  
                );
            }
            $result = parent::transmitNews($postObj, $content);
        } elseif ($state['state'] == 2) {//未绑定
            $url = parent::getUrl()."?/chengji/bangdingpage/".$openid;
            $content = "<a href=\"".$url."\">点此绑定教务系统</a>";
            $result = parent::transmitText($postObj, $content);
        } else {
            $result = $state['msg'];
        }
        return $result;
    }
    public function jiebang() {
        //判断用户是否已绑定
        $state = parent::wechatApi($this->parameter[2]);
        $postObj = $state['postObj'];
        $openid = $postObj->FromUserName;
        if ($state['state'] == 1) {//已绑定
            $username = $state['username'];
            $sql = "delete from `fosu` where `openid`=?;";
            $state = parent::sqlSelect($sql, $openid);
            if ($state['state'] == 1) {//sql语句执行成功
                $content = "你已解除学号：{$username}的绑定！回复“绑定”进行重新绑定";
                $result = parent::transmitText($postObj, $content);
            } else {//sql语句执行失败
                $content = "数据库他妈炸了，所以解绑失败，请老爷您重新尝试！";
                $result = parent::transmitText($postObj, $content);
            }
        } elseif ($state['state'] == 2) {//未绑定
            $content = "你还没有绑定，恕无法解绑";
            $result = parent::transmitText($postObj, $content);
        } else {
            $result = $state['msg'];
        }
        return $result;
    }
}