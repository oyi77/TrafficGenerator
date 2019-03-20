<?php
    header("Access-Control-Allow-Origin: *");
    if(isset($_GET["id"])){       
            echo get_page($_GET['url'],$_GET["id"]);
        }
    else {
            echo get_page($_GET['url']);
        }
    //echo get_web_page($_GET['url']);
    function get_page($url, $id_file = ''){
        $user_agent=random_ua();
        $proxy = 'http://'.random_proxy();
        if($id_file != ''){
            require_once('config.php');
            $data = json_decode(readFileById($id_file, 'proxy'));
            $data = $data["proxy_list"];
            $proxy = 'http://'.$data[array_rand($data)];
            }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    function get_web_page( $url, $id = '')
    {
        $user_agent=random_ua();
        $proxy = 'http://'.random_proxy();
        if($id != ''){
            require_once('config.php');
            $data = json_decode(readFile($id, 'proxy'));
            $data = $data["proxy_list"];
            $proxy = 'http://'.$data[array_rand($data)];
            }
        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_PROXY          => $proxy,
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header['content'];
    }

    function random_proxy()
    {
        $f_contents = file("proxies.txt");
        $line = $f_contents[array_rand($f_contents)];
        return $line;
    }

    function random_ua()
    {
        $f_contents = file("useragents.txt");
        $line = $f_contents[array_rand($f_contents)];
        return $line;
    }
?>
