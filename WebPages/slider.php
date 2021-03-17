<?php
  $database_host = "localhost";
  $database_user = "root";
  $database_pass = "yy747488";
  $database_name = "usermood";
 $conn = mysqli_connect($database_host,$database_user,$database_pass,$database_name);
   
   if(!$conn)
{
     die("connection failed: " . mysqli_connect_error());
}
  echo "Connected successfully";
?>


<?php
include("s1.php");
$userid = $mvalue = $udate = $msg = "";
$sql = "SELECT * FROM usermood";
$rs = $link->query($sql);
if(!empty($_POST)) {
    $userid = $_POST["userid"];
    $mvalue = $_POST["mvalue"];
    $udate = $_POST["udate"];
    $sql = sprintf("INSERT INTO umoods (userid, mvalue,udate)) VALUES('%s','%d','%d')", $userid, $mvalue,$udate);
    $rs = $link->query($sql);
}  else {
    $msg = "Upload failed:" .$link->error;
}
?>

<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <title>slider</title>
        <style type="text/css">
            body{
              font-family: Arial
              font-size: 14px;
              color: orange;
            }
            .lineDiv {
                position: relative;
                height: 20px;      
                background:linear-gradient(80deg,blue,orange);
                width: 380px;
                margin: 60px auto;
            }
             
            .lineDiv .minBlock {
                position: absolute;
                top: -5px;
                left: 0;
                width: 17px;
                height: 20px;
                background: pink;
                cursor: pointer
            }
             
            .lineDiv .minBlock .vals {
                position: absolute;
                font-size: 20px;
                top: -45px;
                left: -10px;
                width: 35px;
                height: 35px;
                line-height: 35px;
                text-align: center;
                background: white;
            }
             
            .lineDiv .minBlock .vals:after {
                content: "";
                width: 0px;
                height: 0px;
                border-top: 6px solid blue;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-bottom: 6px solid transparent;
                display: block;
                margin-left: 11px;
            }
        </style>
    </head>
 
    <body>

        <center>
            <h3>Happy index <span id="msg">0</span>%</h3>
                value = "<?php echo $mvalue; ?>"
        </center>
        <div id="lineDiv" class="lineDiv">
            <div id="minBlock" class="minBlock">
                <div id="vals" class="vals">0</div>
            </div>
        </div>



        <script>
            window.onload = function() {
 
                var lineDiv = document.getElementById('lineDiv'); 
                var minDiv = document.getElementById('minBlock'); 
                var msg = document.getElementById("msg");
                var vals = document.getElementById("vals");
                var ifBool = false; 
                
                var start = function(e) {
                    e.stopPropagation();
                    ifBool = true;
                    console.log("mousedown")
                }
                var move = function(e) {
                    console.log("mousemove")
                    if(ifBool) {
                        if(!e.touches) {    
                            var x = e.clientX;
                        } else {    
                            var x = e.touches[0].pageX;
                        }
                        
                        var lineDiv_left = getPosition(lineDiv).left;
                        var minBlock_left = x - lineDiv_left; 
                        if(minBlock_left >= lineDiv.offsetWidth - 15) {
                            minBlock_left = lineDiv.offsetWidth - 15;
                        }
                        if(minBlock_left < 0) {
                            minDiv_left = 0;
                        }
                        
                        minBlock.style.left = minBlock_left + "px";
                        msg.innerText = parseInt((minBlock_left / (lineDiv.offsetWidth - 15)) * 100);
                        vals.innerText = parseInt((minBlock_left / (lineDiv.offsetWidth - 15)) * 100);
                    }
                }
                var end = function(e) {
                        console.log("mouseup")
                        ifBool = false;
                    }
                    
                minDiv.addEventListener("touchstart", start);
                minDiv.addEventListener("mousedown", start);
                
                window.addEventListener("touchmove", move);
                window.addEventListener("mousemove", move);
                
                window.addEventListener("touchend", end);
                window.addEventListener("mouseup", end);
                
                function getPosition(node) {
                    var left = node.offsetLeft; 
                    var top = node.offsetTop;
                    current = node.offsetParent; 
                    　 
                    　　
                    while(current != null) {　　
                        left += current.offsetLeft;　　
                        top += current.offsetTop;　　
                        current = current.offsetParent;　　
                    }
                    return {
                        "left": left,
                        "top": top
                    };
                }
            }
        </script>
    <tr>
        <td><input type="submit" value="sumbit"></td>
    </tr>
    </body>
</html>
