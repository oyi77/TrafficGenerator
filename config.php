<?php
if(isset($_GET["func"])){
    $func = $_GET["func"];
}
if($func == "saveFile"){
    echo saveFileById();
    }
function saveFileById(){
        $namafile = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        $url = $_POST["url"];
        $iframe = $_POST["banyakiprame"];
        $refresh = $_POST["autorepresh"];
        $proxytext = $_POST["proxylist"];

        $proxy_list = explode("\n", $proxytext);

        $config = [
            'url' => $url,
            'iframe' => $iframe,
            'refresh' => $refresh,
            'proxy_list' => $proxy_list,
            'used' => 0
            ];

        file_put_contents('config/'.$namafile.'.conf', json_encode($config));

        return $namafile;
}
function readFileById($id_file,$type=''){
    if($id_file != null){
        $file_iki = file_get_contents("config/".$id_file.'.conf');
        $data = json_decode($file_iki,true);
        $to_return = "";
        if($type == 'proxy'){
                $to_return = json_encode($data["proxy_list"]);
            }
        else {
                $data["used"] = $data["used"] + 1;
                file_put_contents("config/".$id_file.'.conf', json_encode($data));
                unset($data["proxy_list"]);
                $to_return = json_encode($data);
            }

        return $to_return;
    }
    else {
        return 'haha';
    }
}

function cok(){
    echo "jancok";
    }
?>
