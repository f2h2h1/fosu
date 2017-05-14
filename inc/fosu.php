<?php
class fosu extends database {
    function test03() {
    
        $username = "20150150113";
        $password = "ld19961006";
        
        //$cookie_file = dirname(__FILE__).'/cookie.txt';
        $cookie_file = tempnam("tmp","cookie");

        //先获取cookies并保存
        $url = "http://www.baidu.com";
        $ch = curl_init($url); //初始化
        curl_setopt($ch, CURLOPT_HEADER, 0); //不返回header部分
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //返回字符串，而非直接输出
        curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file); //存储cookies
        curl_exec($ch);
        curl_close($ch);

        //使用上面保存的cookies再次访问
        $url = "http://www.baidu.com";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面获取的cookies
        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;echo"<br>";
        echo $cookie_file;echo"<br>";
        $myfile = fopen($cookie_file, "r") or die("Unable to open file!");
        //echo fgets($myfile);echo"<br>";
        //echo fgets($myfile);echo"<br>";
        //echo fgets($myfile);echo"<br>";
        //echo fgets($myfile);echo"<br>";
        //echo fgets($myfile);echo"<br>";
        echo fread($myfile,filesize($cookie_file));
        fclose($myfile);
    }
    function test02() {
    
        $cookie_file = tempnam('./temp','cookie');//这是一个全局变量
        
        
        $line = "<br><br><br><br>###########################################################################################################################################<br><br><br><br>";
        
        $username = "20150150113";
        $password = "ld19961006";
        
        $host = FOSU_HOST."default2.aspx";
        echo"<br><br>".$host."<br><br>";
        $data = null;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',   
        );

        $result = self::httpRequest($host, $data, $headers);

        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        
        preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
		$cookie_SessionId=$results[0][0];
        printf("<pre>%s</pre>\n",var_export($cookie_SessionId, true));
        
        preg_match_all('/route=(.*?);/i', $str, $results);
		$cookie_route=$results[0][0];
        $cookie_route=substr($cookie_route, 0, -1);
        printf("<pre>%s</pre>\n",var_export($cookie_route, true));
        
        
        $cookie_file = $cookie_SessionId." ".$cookie_route;
        
        $pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
		preg_match($pattern, $str, $matches);
        $newview = urlencode($matches[1]);
        printf("<pre>%s</pre>\n",var_export($newview, true));
        
        printf("<pre>%s</pre>\n",var_export($str, true));
        
        echo $line;
        
        
        echo"<br><br>".$host."<br><br>";
        $data = "__VIEWSTATE=".$newview."&yh=".$username."&kl=".$password."&RadioButtonList1=%D1%A7%C9%FA&Button1=%B5%C7++%C2%BC&CheckBox1=on";
        
        $cookie = " ".$cookie_SessionId." ".$cookie_route;
        
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Origin' => 'http://100.fosu.edu.cn',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Referer' => 'http://100.fosu.edu.cn/',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'zh-CN,zh;q=0.8', 
        );
        
        $result = self::httpRequest($host, $data, $headers, $cookie);
        
        printf("<pre>%s</pre>\n",var_export($headers, true));
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));
               

        echo $line;       
               
        $host = FOSU_HOST."xsmainfs.aspx?xh=".$username;
        echo"<br><br>".$host."<br><br>";
        $data = null;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => 'http://100.fosu.edu.cn/',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8', 
        );
        $result = self::httpRequest($host, $data, $headers, $cookie);
        

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
        $refere = "xsmainfs.aspx?xh=".$username;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
        );
        $result = self::httpRequest($host, $data, $headers, $cookie);
        

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
        $refere = FOSU_HOST."xsmainfs.aspx?xh=".$username;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
        );
        $result = self::httpRequest($host, $data, $headers, $cookie);
        
        

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
        $refere = FOSU_HOST."xsmainfs.aspx?xh=".$username;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
        );
        $result = self::httpRequest($host, $data, $headers, $cookie);
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true)); 
        
        echo $line;        
        
       
        $host = FOSU_HOST."ggxxlb.aspx?xh=".$username."&qx=1&lx=%cd%a8%d6%aa%ce%c4%bc%fe&lxdm=1";
        echo"<br><br>".$host."<br><br>";
        $refere = FOSU_HOST."xsleft.aspx";
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
        );
        $result = self::httpRequest($host, $data, $headers, $cookie);
        
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
        $refere = FOSU_HOST."xstop.aspx";
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
        );
        $result = self::httpRequest($host, $data, $headers, $cookie);
        
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
        $refere = FOSU_HOST."xsleft_js.aspx?flag=xxcx";
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
        );
        $result = self::httpRequest($host, $data, $headers, $cookie);
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true)); 
        
        echo $line; 
        
        
        $host = FOSU_HOST."xscj.aspx?xh=".$username;
        echo"<br><br>".$host."<br><br>";
        $data = null;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => 'http://100.fosu.edu.cn/xsleft.aspx?flag=xxcx',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
        );
        $result = self::httpRequest($host, $data, $headers, $cookie);

        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));          
        
        
        
        $host = FOSU_HOST."xscj.aspx?xh=".$username;
        echo"<br><br>".$host."<br><br>";
        $data = "__VIEWSTATE=&xn=&xq=&Button1=%B3%C9%BC%A8%CA%E4%B3%F6&ddlKCLX=%B1%D8%D0%DE%BF%CE";
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => 'http://100.fosu.edu.cn/xsleft.aspx?flag=xxcx',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
        );
        $result = self::httpRequest($host, $data, $headers);

        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));
        
    
        return "is work";
    }
    function test01() {
        
        $line = "<br><br><br><br>###########################################################################################################################################<br><br><br><br>";
        
        $username = "20150150113";
        $password = "ld19961006";
        
        $host = FOSU_HOST."default2.aspx";
        echo"<br><br>".$host."<br><br>";
        $data = null;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',   
        );

        $result = parent::httpRequest($host, $data, $headers);

        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
		$cookie_SessionId=$results[0][0];
        printf("<pre>%s</pre>\n",var_export($cookie_SessionId, true));
        
        preg_match_all('/route=(.*?);/i', $str, $results);
		$cookie_route=$results[0][0];
        $cookie_route=substr($cookie_route, 0, -1);
        printf("<pre>%s</pre>\n",var_export($cookie_route, true));
        
        $pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
		preg_match($pattern, $str, $matches);
        $newview = urlencode($matches[1]);
        printf("<pre>%s</pre>\n",var_export($newview, true));
        
        printf("<pre>%s</pre>\n",var_export($str, true));
        
        echo $line;
        
        
        echo"<br><br>".$host."<br><br>";
        $data = "__VIEWSTATE=".$newview."&yh=".$username."&kl=".$password."&RadioButtonList1=%D1%A7%C9%FA&Button1=%B5%C7++%C2%BC&CheckBox1=on";
        
        $cookie = " ".$cookie_SessionId." ".$cookie_route;
        
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Origin' => 'http://100.fosu.edu.cn',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Referer' => 'http://100.fosu.edu.cn/',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        
        $result = parent::httpRequest($host, $data, $headers);
        
        printf("<pre>%s</pre>\n",var_export($headers, true));
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));
               

        echo $line;       
               
        $host = FOSU_HOST."xsmainfs.aspx?xh=".$username;
        echo"<br><br>".$host."<br><br>";
        $data = null;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => 'http://100.fosu.edu.cn/',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);
        

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
        $refere = "xsmainfs.aspx?xh=".$username;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);
        

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
        $refere = FOSU_HOST."xsmainfs.aspx?xh=".$username;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);
        
        

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
        $refere = FOSU_HOST."xsmainfs.aspx?xh=".$username;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true)); 
        
        echo $line;        
        
       
        $host = FOSU_HOST."ggxxlb.aspx?xh=".$username."&qx=1&lx=%cd%a8%d6%aa%ce%c4%bc%fe&lxdm=1";
        echo"<br><br>".$host."<br><br>";
        $refere = FOSU_HOST."xsleft.aspx";
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);
        
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
        $refere = FOSU_HOST."xstop.aspx";
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);
        
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
        $refere = FOSU_HOST."xsleft_js.aspx?flag=xxcx";
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => $refere,
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true)); 
        
        echo $line; 
        
        
        $host = FOSU_HOST."xscj.aspx?xh=".$username;
        echo"<br><br>".$host."<br><br>";
        $data = null;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => 'http://100.fosu.edu.cn/xsleft.aspx?flag=xxcx',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);

        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));          
        
        
        
        $host = FOSU_HOST."xscj.aspx?xh=".$username;
        echo"<br><br>".$host."<br><br>";
        $data = "__VIEWSTATE=&xn=&xq=&Button1=%B3%C9%BC%A8%CA%E4%B3%F6&ddlKCLX=%B1%D8%D0%DE%BF%CE";
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => 'http://100.fosu.edu.cn/xsleft.aspx?flag=xxcx',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);

        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));           
        
        
        
        return "is work";
    }
    function test00() {
    
        $username = "20150150113";
        $password = "ld19961006";
        
        $host = FOSU_HOST."default2.aspx";
        
        $data = null;
        
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',   
        );
        
        $result = parent::httpRequest($host, $data, $headers);
        
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        
        preg_match_all('/ASP.NET_SessionId=(.*?);/i', $str, $results);
		$cookie_SessionId=$results[0][0];
        printf("<pre>%s</pre>\n",var_export($cookie_SessionId, true));
        
        preg_match_all('/route=(.*?);/i', $str, $results);
		$cookie_route=$results[0][0];
        printf("<pre>%s</pre>\n",var_export($cookie_route, true));
        
        $pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/i';
		preg_match($pattern, $str, $matches);
        $newview = urlencode($matches[1]);
        printf("<pre>%s</pre>\n",var_export($newview, true));
        
        printf("<pre>%s</pre>\n",var_export($str, true));
        
        
        $data = "__VIEWSTATE=".$newview."&yh=".$username."&kl=".$password."&RadioButtonList1=%D1%A7%C9%FA&Button1=%B5%C7++%C2%BC&CheckBox1=on";
        
        $cookie = " ".$cookie_SessionId." ".$cookie_route;
        
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Origin' => 'http://100.fosu.edu.cn',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Referer' => 'http://100.fosu.edu.cn/',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        
        $result = parent::httpRequest($host, $data, $headers);
        
        printf("<pre>%s</pre>\n",var_export($result, true));
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));
        
        $host = FOSU_HOST."xsmainfs.aspx?xh=".$username;
        $data = null;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => 'http://100.fosu.edu.cn/',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);
        
        printf("<pre>%s</pre>\n",var_export($result, true));
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));  
        
        $host = FOSU_HOST."xscj.aspx?xh=".$username;
        $data = null;
        $headers = array (
            'Host' => '100.fosu.edu.cn',
            'Connection' => 'keep-alive',
            'Cache-Control' => 'max-age=0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36',
            'Referer' => 'http://100.fosu.edu.cn/xsleft.aspx?flag=xxcx',
            'Accept-Encoding' => 'gzip, deflate, sdch',
            'Accept-Language' => 'zh-CN,zh;q=0.8',
            'Cookie' => $cookie, 
        );
        $result = parent::httpRequest($host, $data, $headers);
        printf("<pre>%s</pre>\n",var_export($result, true));
        printf("<pre>%s</pre>\n",var_export($result['state'], true));
        if ($result['state'] == 1) {
            $str = mb_convert_encoding($result['msg'], 'UTF-8', 'gb2312');
        } else {
            $str = mb_convert_encoding($result['errmsg'], 'UTF-8', 'gb2312');
        }
        printf("<pre>%s</pre>\n",var_export($str, true));          
        
        
        return "is work";
    }
    function httpRequest($url, $data = null, $headers = null, $cookie = null) {
        global $cookie_file;
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
                if(!empty($cookie_file)) {
                    if(!empty($cookie)) {
                        curl_setopt($curl, CURLOPT_COOKIE, $cookie);//用于发送 cookie 变量
                    } else {
                        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);//用于保存 cookie 到文件
                    }
                } else {
                    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);//用于将保存的 cookie 文件发送出去
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
    function achievement() {
        return "this is a test farme";
    }
}