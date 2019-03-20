<?php
if(isset($_GET["link"])){
    $i = $_GET["iprame"];
    $link = $_GET["link"];
    $tikang = $_GET["represh"];
    }
else if(isset($_GET["id"])) {
        require_once("config.php");
        $id_file = $_GET["id"];
    }
else {
        $config = parse_ini_file('app_config.ini.php');
    }
?>
<html>
    <head>
  <meta charset="UTF-8">
  <title>Giling Generator</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">


      <link rel="stylesheet" href="css/style.css">


</head>
    <body>
    <?php if($link != null) {
                                if($i > 1){
                                    for($a = 1; $a <= $i; $a++){ ?>
                                            <iframe class="frame" src=""></iframe>
                                      <?php  }
                                  }
                                else {  ?>
                                    <iframe class="frame" src=""></iframe>
                                 <?php   }
                            }
            else if($id_file != null) {
                $data = json_decode(readFileById($id_file),true);
                $link = $data["url"];
                $i = $data["iframe"];
                $tikang = $data["refresh"];
                 if($i > 1){
                                    for($a = 1; $a <= $i; $a++){ ?>
                                            <iframe class="frame" src=""></iframe>
                                      <?php  }
                                  }
                                else {  ?>
                                    <iframe class="frame" src=""></iframe>
                                 <?php   }
                 }
            else { ?>
                                <h1>Giling Generator</h1>
                                <form class="cf" id="form-giling">
                                  <div class="full left cf">
                                    <input type="text" name="link" id="link" placeholder="Link (ex: http://google.com)" required>
                                    <input type="text" name="banyakiprame" id="banyakiprame" placeholder="Jumlah Iframe (ex: 10)" required>
                                    <input type="text" name="autorepresh" id="autorepresh" placeholder="Jeda Refresh (ex: 5)">
                                    <br />
                                    <select class="round full" id="proxyOption" name="proxyoption">
                                      <option value="auto" selected>Auto Proxy</option>
                                      <option value="manual">Manual Proxy</option>
                                    </select>
                                    <textarea name="proxylist" type="text" name="proxylist" id="proxylist" placeholder="Proxy List : (ex: 62.210.149.33:30175)" style="display:none;"></textarea>
                                  </div>
                                  <input type="submit" value="Submit" id="input-submit">
                                  <div class="full cf">
                                    <textarea type="text" id="input-message" placeholder="Message" style="display:none;"></textarea>
                                  </div>
                                </form>
    <?php } ?>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        <?php if($link != null) {?>
            $(document).ready(function(){
                function getURL(url){
                    <?php if($link != null && $id_file != null) {?>
                            $('.frame').attr('src','proxy.php?url='+encodeURIComponent(url)+'&id=<?= $id_file ?>');
                    <?php } else {?>
                            $('.frame').attr('src','proxy.php?url='+encodeURIComponent(url));
                    <?php } ?>
                }
                function AutoRefresh( t ) {
                   setTimeout("location.reload(true);", t);
                }
                AutoRefresh(<?= $tikang ?>*100);
                getURL('<?= $link ?>');
                });
        <?php } else { ?>
        $('#proxyOption').on('change', function() {
          if($(this).val() == "auto"){
                $('#proxylist').hide();
              }
          else {
                $('#proxylist').show();
              }
        });
        $('#input-submit').click(function(event){
            event.preventDefault();
            if($('#link').val()){
                if($('#proxyOption').val() == "auto"){
                        $('#input-message').text('<?= $config["app_url"] ?>/index.php?link='+encodeURIComponent($('#link').val())+'&iprame='+$('#banyakiprame').val()+'&represh='+$('#autorepresh').val());
                        $('#input-message').show();
                    }
                else {
                        $.ajax({
                                url: 'config.php?func=saveFile',
                                type: 'post',
                                data: $('#form-giling').serialize(),
                                success: function( data, textStatus, jQxhr ){
                                    console.log(data);
                                    $('#input-message').text('<?= $config["app_url"] ?>/index.php?id='+data);
                                    $('#input-message').show();
                                },
                                error: function( jqXhr, textStatus, errorThrown ){
                                    console.log( errorThrown );
                                }
                            });
                    }
                }
            else {
                alert('ISIEN SEK TALAH BEB!');
                }
            });
        <?php } ?>
    </script>
</html>


