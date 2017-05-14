<?php
class operation extends database {
    //获取微信token参数
    public function getWechatParameter($str) {
        $parameter = explode("&", $str);
        for ($i = 1; $i < count($parameter); $i++) {
            $tempGET = explode("=", $parameter[$i]);
            $_GET[$tempGET[0]] = $tempGET[1];
        }
    }

    public function wechatApi($str) {
        //获取微信token参数
        self::getWechatParameter($str);
        //设置token
        define("TOKEN", "chengji");
        //接收来自微信的消息
        $postObj = self::receiveMessage();
        //token验证
        if (!isTOKEN or self::checkSignature()) {//通过token验证
            $openid = $postObj->FromUserName;//获取openid
            //判断openid是否为空
            if (!empty($openid)) {//openid不为空
                //判断数据库连接是否成功
                $state = parent::init();
                if ($state['state'] == 1) {//数据库连接成功
                    //判断该openid是否已绑定
                    $sql = "SELECT username,password FROM `fosu` where `openid` = ?;";
                    $state = parent::sqlSelect($sql, $openid);
                    if ($state['state'] == 1) {//sql语句执行成功
                        if ($state['msg'] == false) {//该openid未绑定
                            $result = array(
                                "state" => 2,
                                "msg" => "The user is not bound",
                            );
                        } else {////该openid已绑定
                            $result = array(
                                "state" => 1,
                                "msg" => "The user is bound",
                                "username" => $state['msg']['username'],
                                "password" => $state['msg']['password'],
                            );
                        }
                    } else {//sql语句执行失败
                        $content = "sql语句执行失败";
                        $result = array(
                            "state" => -1,
                            "msg" => self::transmitText($postObj, $content),
                            "errormsg" => $state,
                            "errorcode" => "501",
                        );
                    }
                } else {//数据库连接失败
                    $content = "数据库连接失败";
                    $result = array(
                        "state" => -2,
                        "msg" => self::transmitText($postObj, $content),
                        "errormsg" => $state,
                        "errorcode" => "502",
                    );
                }
            } else {//openid为空
                $content = "openid为空";
                $result = array(
                    "state" => -3,
                    "msg" => self::transmitText($postObj, $content),
                    "errormsg" => "",
                    "errorcode" => "503",
                );
            }
        } else {//未通过token验证
            $content = "token验证失败";
            $result = array(
                "state" => -4,
                "msg" => self::transmitText($postObj, $content),
                "errormsg" => "Not verified by token",
                "errorcode" => "504",
            );
        }
        $result["postObj"] = $postObj;
        return $result;
    }
    
    //判断用户密码是否正确
    public function isLegal($username, $password) {
        $host = FOSU_HOST."default2.aspx";
        $data = null;
        $headers = array (
            'Host: 100.fosu.edu.cn',
            'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate',
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1',   
        );
        $result = parent::httpRequest($host, $data, $headers);


        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
            
            preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
            $cookie_SessionId=$results[0][0];

            $pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
            preg_match($pattern, $str, $matches);
            $VIEWSTATE = urlencode($matches[1]);

            /*
            $pattern = '/<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="(.*)" \/>/i';
            preg_match($pattern, $str, $matches);
            $VIEWSTATEGENERATOR = urlencode($matches[1]);
            printf("<pre>%s</pre>\n",var_export($VIEWSTATEGENERATOR, true));

            $pattern = '/<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="(.*)" \/>/i';
            preg_match($pattern, $str, $matches);
            $EVENTVALIDATION = urlencode($matches[1]);
            printf("<pre>%s</pre>\n",var_export($EVENTVALIDATION, true));
            */

            $data = "__VIEWSTATE=".$VIEWSTATE."&yh=".$username."&kl=".$password."&RadioButtonList1=%D1%A7%C9%FA&Button1=%B5%C7++%C2%BC&CheckBox1=on";
            //$data_size = strlen($data);
            $cookie = $cookie_SessionId;
            
            // $headers = array (
                // 'Host: 100.fosu.edu.cn',
                // 'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
                // 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                // 'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
                // 'Accept-Encoding: gzip, deflate',
                // 'Referer: http://100.fosu.edu.cn/',
                // 'Cookie: '.$cookie,
                // 'Connection: keep-alive',
                // 'Upgrade-Insecure-Requests: 1',
            // );
$headers = array ('Cookie: '.$cookie,);
            $result = self::httpRequest($host, $data, $headers);
            
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
            preg_match('/密码错，请重新输入！/', $str, $matches);
            if (empty($matches)) {//登录成功
                $host = FOSU_HOST."xsmainfs.aspx?xh=".$username;
                $data = null;
                $headers = array (
                    'Host: 100.fosu.edu.cn',
                    'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
                    'Accept-Encoding: gzip, deflate',
                    'Referer: http://100.fosu.edu.cn/',
                    'Cookie: '.$cookie,
                    'Connection: keep-alive',
                    'Upgrade-Insecure-Requests: 1',
                );
                $result = self::httpRequest($host, $data, $headers);
                

                $host = FOSU_HOST."xstop.aspx";
                $data = null;
                $headers = array (
                    'Host: 100.fosu.edu.cn',
                    'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
                    'Accept-Encoding: gzip, deflate',
                    'Referer: '.FOSU_HOST."xsmainfs.aspx?xh=".$username,
                    'Cookie: '.$cookie, 
                    'Connection: keep-alive',
                    'Upgrade-Insecure-Requests: 1', 
                );
                $result = self::httpRequest($host, $data, $headers);
                
                if ($result['state'] == 1) {
                    $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');

                    //抓取姓名
                    preg_match('/<span id="lbXM">(?<lbxm>.*?)<\/span>/i', $str, $matches);
                    $lbxm = $matches['lbxm'];

                    //抓取学号
                    preg_match('/<span id="lbXH">(?<lbxh>.*?)<\/span>/i', $str, $matches);
                    $lbxh = $matches['lbxh'];
                    
                    if (!empty($lbxh)) {
                        $result = array(
                            "state" => 1,
                            "msg" => "Login success",
                            "cookie" => $cookie,
                            "lbxm" => $lbxm,
                        );
                    } else {
                        $result = array(
                            "state" => -5,
                            "msg" => "Login failed",
                            "errmsg" => "lbxh is empty",
                            "errcode" => "605",
                        );
                    } 
                } else {
                    $result = array(
                        "state" => -4,
                        "msg" => "Login failed",
                        "errmsg" => "xstop.aspx open failed",
                        "errcode" => "604",
                    );            
                }
            } else {//登录失败
                $result = array(
                    "state" => -3,
                    "msg" => "Login failed",
                    "errmsg" => "lbxh is empty.password is not correct",
                    "errcode" => "603",
                );
            }
        } else {
            $result = array(
                "state" => -1,
                "msg" => "Login failed",
                "errmsg" => "default2.aspx open failed",
                "errcode" => "601",
            );
        }
        return $result;
    }
    //获取成绩数据
    public function getGrade($username, $password) {
        $state = self::isLegal($username, $password);
        if ($state['state'] == 1) {
            $cookie = $state['cookie'];
            $host = FOSU_HOST."xsleft.aspx";
            $data = null;
            $headers = array (
                'Host: 100.fosu.edu.cn',
                'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Referer: '.FOSU_HOST."xsmainfs.aspx?xh=".$username,
                'Cookie: '.$cookie,
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
            );
            $result = self::httpRequest($host, $data, $headers);
            

            $host = FOSU_HOST."xsbzwj.aspx";
            $data = null;
            $headers = array (
                'Host: 100.fosu.edu.cn',
                'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Referer: '.FOSU_HOST."xsmainfs.aspx?xh=".$username,
                'Cookie: '.$cookie,
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
            );
            $result = self::httpRequest($host, $data, $headers);
            

            $host = FOSU_HOST."ggxxlb.aspx?xh=".$username."&qx=1&lx=%cd%a8%d6%aa%ce%c4%bc%fe&lxdm=1";
            $data = null;
            $headers = array (
                'Host: 100.fosu.edu.cn',
                'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Referer: http://100.fosu.edu.cn/xsleft.aspx',
                'Cookie: '.$cookie,
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
            );
            $result = self::httpRequest($host, $data, $headers);
            

            $host = FOSU_HOST."xsleft_js.aspx?flag=xxcx";
            $data = null;
            $headers = array (
                'Host: 100.fosu.edu.cn',
                'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Referer: http://100.fosu.edu.cn/xstop.aspx',
                'Cookie: '.$cookie,
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
            );
            $result = self::httpRequest($host, $data, $headers);
            
     
            $host = FOSU_HOST."xsleft.aspx?flag=xxcx";
            $data = null;
            $headers = array (
                'Host: 100.fosu.edu.cn',
                'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Referer: http://100.fosu.edu.cn/xsleft_js.aspx?flag=xxcx',
                'Cookie: '.$cookie,
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
            );
            $result = self::httpRequest($host, $data, $headers);

            
            $host = FOSU_HOST."xscj.aspx?xh=".$username;
            $data = null;
            $headers = array (
                'Host: 100.fosu.edu.cn',
                'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'http://100.fosu.edu.cn/xsleft.aspx?flag=xxcx',
                'Cookie: '.$cookie,
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
            );
            $result = self::httpRequest($host, $data, $headers);
            
            if ($result['state'] == 1) {
                $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
                $pattern = '/<span id="jqpjf">(?<jqpjf>.*?)<\/span>/i';
                preg_match($pattern, $str, $matches);	
                $zongjidian = $matches['jqpjf'];
                
                
                $pattern = '/<table cellspacing="0" cellpadding="3" rules="rows" bordercolor="#ADCEEF" border="1" id="DataGrid1" width="100%">[\s\S]*?<\/table>/i';
                preg_match($pattern, $str, $matches);	    
                $td_array = self::get_td_array($matches[0]);
                if (is_array($td_array)) {
                    $grade = "{$td_array[0][2]} ---{$td_array[0][9]}---{$td_array[0][10]}---{$td_array[0][14]}\n";
                    $grade2 = "{$td_array[0][2]} ---{$td_array[0][9]}---{$td_array[0][10]}---{$td_array[0][11]}---{$td_array[0][14]}\n";//挂科
                    for ($i = 1; $i < count($td_array); $i++) {
                        $grade .= "{$td_array[$i][2]} ---{$td_array[$i][9]}---{$td_array[$i][10]}---{$td_array[$i][14]}\n";
                        if ($td_array[$i][10] < 60) {
                            $grade2 .= "{$td_array[$i][2]} ---{$td_array[$i][9]}---{$td_array[$i][10]}---{$td_array[$i][11]}---{$td_array[$i][14]}\n";
                        }
                    }
                    $grade .= $grade2;
                    /*
                    foreach($td_array as $v){
                        if($v[10]){
                         $grade .="{$v[2]} ---{$v[9]}---{$v[10]}---{$v[14]}\n";
                           
                        }
                    }
                    */
                    $grade .= "\n".$zongjidian;
                    
                    $result = array(
                        "state" => 1,
                        "msg" => "success",
                        "grade" => $grade,
                    ); 
                } else {
                    $result = array(
                        "state" => -7,
                        "msg" => "get grade failed",
                        "errmsg" => "grade is emtpy",
                        "errcode" => "607",
                    );
                }
            } else {
                $result = array(
                    "state" => -6,
                    "msg" => "get grade failed",
                    "errmsg" => "xscj.aspx open failed",
                    "errcode" => "606",
                );
            }
        } else {
            $result = $state;
        }
        return $result;
    }


    //验证post参数
    public function validate($openid, $username, $password) {
    
        $result = array(
            "state" => 1,
            "msg" => "passed validation",
        );
    
        return $result;
    }
    
    //当前网页的URL
    public function getUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol.$_SERVER[HTTP_HOST].$_SERVER[SCRIPT_NAME];// 当前网页的URL
        $url = substr($url, 0, -9);
        return $url;
    }
    
    //把表格转换成数组的函数
	public function get_td_array($table) {
		
		$table = preg_replace("'<table[^>]*?>'si", "", $table);
		$table = preg_replace("'<tr[^>]*?>'si", "", $table);
		$table = preg_replace("'<td[^>]*?>'si", "", $table);
		$table = str_replace("</tr>", "{tr}", $table);
		$table = str_replace("</td>", "{td}", $table);
		
		$table = preg_replace("'<[\/\!]*?[^<>]*?>'si", "", $table);
		
		$table = preg_replace("'([\r\n])[\s]+'", "", $table);
		$table = str_replace(" ", "", $table);
		$table = str_replace(" ", "", $table);
		
		$table = explode('{tr}', $table);
		array_pop($table);
		foreach ($table as $key => $tr) {
			$td = explode('{td}', $tr);
			array_pop($td);
			$td_array[] = $td;
		} 
		return $td_array;
	}
    
    //验证签名
    public function checkSignature()
    {
        $signature = $_GET["signature"];//微信加密签名
        $timestamp = $_GET["timestamp"];//时间戳
        $nonce = $_GET["nonce"];//随机数	
        $echoStr = $_GET["echostr"];//随机字符串
        
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if ($tmpStr == $signature) {
            if (!isset($echoStr)) {
                return true;
            } else {
                echo $echoStr;
                exit;
            }
        } else {
            //die("token验证失败");
            return false;
        }
    }
    
    //接收来自微信的消息
    public function receiveMessageStr()
    {
        return file_get_contents("php://input");
    }	
    public function receiveMessage()
    {
        $postStr = $this->receiveMessageStr();
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $postObj;
    }
    
    //回复文本消息
    public function transmitText($object, $content)
    {
        if (!isset($content) || empty($content)) {
            return "";
        }
        
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        
        return $result;
    }
    
    //回复图文消息
    public function transmitNews($object, $newsArray)
    {
        if (!is_array($newsArray)) {
            return "";
        }
        $itemTpl = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($newsArray as $item) {
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
$item_str    </Articles>
</xml>";
        
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

}