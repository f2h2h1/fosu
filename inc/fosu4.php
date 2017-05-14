<?php
class fosu4 extends database {

    public $username = "20150150113";
    public $password = "ld19961006";
    
    function test00() {
        
        $line = "<br><br><br><br>###########################################################################################################################################<br><br><br><br>";
        
        
        $host = FOSU_HOST."default2.aspx";
        echo"<br><br>".$host."<br><br>";
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

        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if (empty($result['errmsg'])) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        
        preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
		$cookie_SessionId=$results[0][0];
        printf("<pre>%s</pre>\n",var_export($cookie_SessionId, true));
        
        
        $pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
		preg_match($pattern, $str, $matches);
        $VIEWSTATE = urlencode($matches[1]);
        printf("<pre>%s</pre>\n",var_export($VIEWSTATE, true));
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
        printf("<pre>%s</pre>\n",var_export($str, true));
        
        echo $line;

        echo"<br><br>".$host."<br><br>";
        $data = "__VIEWSTATE=".$VIEWSTATE."&yh=".$this->username."&kl=".$this->password."&RadioButtonList1=%D1%A7%C9%FA&Button1=%B5%C7++%C2%BC&CheckBox1=on";
        $data_size = strlen($data);
        $cookie = $cookie_SessionId;
        
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
        echo"<br><br>".$data."<br><br>";
        $result = self::httpRequest($host, $data, $headers);
        
        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        //printf("<pre>%s</pre>\n",var_export($headers, true));
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));
               

        echo $line;
        
        $host = FOSU_HOST."xsmainfs.aspx?xh=".$this->username;
        echo"<br><br>".$host."<br><br>";
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
        
        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));  

        echo $line;

        $host = FOSU_HOST."xstop.aspx";
        echo"<br><br>".$host."<br><br>";
        $data = null;
        $headers = array (
            'Host: 100.fosu.edu.cn',
            'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate',
            'Referer: '.FOSU_HOST."xsmainfs.aspx?xh=".$this->username,
            'Cookie: '.$cookie, 
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1', 
        );
        $result = self::httpRequest($host, $data, $headers);
        
        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));  

        echo $line;

        $host = FOSU_HOST."xsleft.aspx";
        echo"<br><br>".$host."<br><br>";
        $data = null;
        $headers = array (
            'Host: 100.fosu.edu.cn',
            'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate',
            'Referer: '.FOSU_HOST."xsmainfs.aspx?xh=".$this->username,
            'Cookie: '.$cookie,
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1',
        );
        $result = self::httpRequest($host, $data, $headers);
        
        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));  

        echo $line;
        
        $host = FOSU_HOST."xsbzwj.aspx";
        echo"<br><br>".$host."<br><br>";
        $data = null;
        $headers = array (
            'Host: 100.fosu.edu.cn',
            'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate',
            'Referer: '.FOSU_HOST."xsmainfs.aspx?xh=".$this->username,
            'Cookie: '.$cookie,
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1',
        );
        $result = self::httpRequest($host, $data, $headers);
        
        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));  

        echo $line;
        
        
        $host = FOSU_HOST."ggxxlb.aspx?xh=".$this->username."&qx=1&lx=%cd%a8%d6%aa%ce%c4%bc%fe&lxdm=1";
        echo"<br><br>".$host."<br><br>";
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
        
        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));  

        echo $line;        
        
        $host = FOSU_HOST."xsleft_js.aspx?flag=xxcx";
        echo"<br><br>".$host."<br><br>";
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
        
        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));  

        echo $line;  
 
        $host = FOSU_HOST."xsleft.aspx?flag=xxcx";
        echo"<br><br>".$host."<br><br>";
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
        
        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));  

        echo $line;  
 
        $host = FOSU_HOST."xscj.aspx?xh=".$this->username;
        echo"<br><br>".$host."<br><br>";
        //$data = "__VIEWSTATE=%2FwEPDwULLTIxMjIzMDI0NjgPZBYCAgEPZBYCAgsPD2QWAh4Hb25jbGljawUPd2luZG93LmNsb3NlKCk7ZBgBBR5fX0NvbnRyb2xzUmVxdWlyZVBvc3RCYWNrS2V5X18WAQUJQ2hlY2tCb3gxAULK0%2BpMlImfVERO9luPI8bfGFw%3D&__VIEWSTATEGENERATOR=09394A33&__EVENTVALIDATION=%2FwEWCwLirej3CQLX78rvDALF77rvDALN7c0VAoCp6c0NAr%2FC6pAOAveMotMNAoznisYGAtaUz5sCArursYYIAoLk17sJDusm1l54nI%2Bf5XpQWcSgrPSEeic%3D&yh=".$this->username."&kl=".$this->password."&RadioButtonList1=%D1%A7%C9%FA&Button1=%B5%C7++%C2%BC&CheckBox1=on";
        //$data_size = strlen($data);
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
        
        //$testresult = self::httpRequest("http://239.ameiity.sinaapp.com/fosu/?/fosu2/testresponse", $data, $headers, $cookie);
        //printf("<pre>%s</pre>\n",var_export($testresult, true)); 
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));  

        echo $line;
        
        return "is work";
    }
    function httpRequest($url, $data = null, $headers = null, $cookie = null) {
        global $cookie_file;
        printf("<pre>%s</pre>\n",var_export($headers, true));
        $result = array();
        if (!empty($url)) {
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                if (!empty($headers)) {
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                }
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                /*
                if(!empty($cookie_file)) {
                    if(!empty($cookie)) {
                        curl_setopt($curl, CURLOPT_COOKIE, $cookie);//用于发送 cookie 变量
                    } else {
                        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);//用于保存 cookie 到文件
                    }
                } else {
                    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);//用于将保存的 cookie 文件发送出去
                }
                */
                if(!empty($cookie)) {
                    curl_setopt($curl, CURLOPT_COOKIE, $cookie);//用于发送 cookie 变量
                }
                curl_setopt($curl, CURLOPT_HEADER, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($curl);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                if ($http_status == 200) {
                    $result = array(
                        "state" => 1,
                        "msg" => $output,
                    );
                } else {
                    $result = array(
                        "state" => -1,
                        "msg" => "http_status != 200",
                        "errmsg" => $output,
                    );
                }
            } catch(PDOException $e) {
                $result = array(
                    "state" => -2,
                    "msg" => $e,
                    "errmsg" => $output,
                );
            }
        } else {
            $result = array(
                "state" => -3,
                "msg" => "url is empty",
            );
        }
        return $result;
    }
    function testresponse() {
        printf("<p>\$_SERVER输出数据为：</p><pre>%s</pre>\n",var_export($_SERVER, true));
        $post = file_get_contents("php://input");
        printf("<pre>%s</pre>\n",var_export($post, true));
    }
}