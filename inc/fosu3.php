<?php
class fosu3 extends database {

    public $username = "20150150113";
    public $password = "ld19961006";
    
    function test00() {
        
        $cookie_file = tempnam(SAE_TMP_PATH, 'cookie');
        $ch=curl_init("http://100.fosu.edu.cn/default2.aspx");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        $str=curl_exec($ch);
        echo $str;
        $info=curl_getinfo($ch);
        curl_close($ch);
        $pattern = '/<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.*)" \/>/i';
        preg_match($pattern, $str, $matches);
        $viewstate = urlencode($matches[1]);
        
        $pattern = '/<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="(.*)" \/>/i';
        preg_match($pattern, $str, $matches);
        $viewstategenerator = urlencode($matches[1]);

        $pattern = '/<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="(.*)" \/>/i';
        preg_match($pattern, $str, $matches);
        $eventvalidation = urlencode($matches[1]);


        $yh=$this->username;
        $kl=$this->password;

        

        $login_url="http://100.fosu.edu.cn/default2.aspx";
        //$login="__VIEWSTATE={$viewstate}&__VIEWSTATEGENERATOR={$viewstategenerator}&__EVENTVALIDATION={$eventvalidation}&yh={$yh}&kl={$kl}&RadioButtonList1=%D1%A7%C9%FA&Button1=%B5%C7++%C2%BC&CheckBox1=on";
        $login = "__VIEWSTATE=%2FwEPDwULLTIxMjIzMDI0NjgPZBYCAgEPZBYCAgsPD2QWAh4Hb25jbGljawUPd2luZG93LmNsb3NlKCk7ZBgBBR5fX0NvbnRyb2xzUmVxdWlyZVBvc3RCYWNrS2V5X18WAQUJQ2hlY2tCb3gxAULK0%2BpMlImfVERO9luPI8bfGFw%3D&__VIEWSTATEGENERATOR=09394A33&__EVENTVALIDATION=%2FwEWCwLirej3CQLX78rvDALF77rvDALN7c0VAoCp6c0NAr%2FC6pAOAveMotMNAoznisYGAtaUz5sCArursYYIAoLk17sJDusm1l54nI%2Bf5XpQWcSgrPSEeic%3D&yh=".$this->username."&kl=".$this->password."&RadioButtonList1=%D1%A7%C9%FA&Button1=%B5%C7++%C2%BC&CheckBox1=on";

        
        //echo $login;
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$login_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $login);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        $str=curl_exec($ch);
        echo $str;
        curl_close($ch);
       
        $ch=curl_init("http://100.fosu.edu.cn/xscj.aspx?xh={$yh}");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_REFERER,"http://100.fosu.edu.cn/xsmainfs.aspx?xh={$yh}");
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        $str=curl_exec($ch);
        //echo $str;
        $info=curl_getinfo($ch);
        //print_r($info);
        curl_close($ch);
        echo $str;

        $pattern = '/<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.*)" \/>/i';
        preg_match($pattern, $str, $matches);
        $viewstate = urlencode($matches[1]);
        
        $pattern = '/<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="(.*)" \/>/i';
        preg_match($pattern, $str, $matches);
        $viewstategenerator = urlencode($matches[1]);

        $pattern = '/<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="(.*)" \/>/i';
        preg_match($pattern, $str, $matches);
        $eventvalidation = urlencode($matches[1]);
        //echo $view;
        //print_r($matches);



        $str= '学期成绩';
        $button=iconv('utf-8', 'gb2312', '$str');
        $score="__VIEWSTATE={$viewstate}&__VIEWSTATEGENERATOR={$viewstategenerator}&__EVENTVALIDATION={$eventvalidation}&xn=&xq=&&Button4=%C8%AB%B2%BF%D1%A7%C6%DA%B2%E9%D1%AF&ddlKCLX=%B1%D8%D0%DE%BF%CE";
        $ch=curl_init("http://100.fosu.edu.cn/xscj.aspx?xh={$yh}");

        //echo $score;
        curl_setopt($ch, CURLOPT_TIMEOUT,60); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $score);
        curl_setopt($ch,CURLOPT_REFERER,"http://100.fosu.edu.cn/xsmainfs.aspx?xh={$yh}");
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        $table=curl_exec($ch);
        curl_close($ch);
        
        echo $table;
        
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