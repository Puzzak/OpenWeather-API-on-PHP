<?php
    function weather($geo){
        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "https://api.openweathermap.org/data/2.5/weather?appid=(APP%20ID)&units=metric&lang=ru&q=".$geo);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
        $data = curl_exec($ch);
        curl_close($ch);
        $raww=json_decode($data,true);
        $degs=$raww[wind][deg]/45;
        switch((int)$degs){
            case "0":$direction="South";break;
            case "1":$direction="South-West";break;
            case "2":$direction="West";break;
            case "3":$direction="North-West";break;
            case "4":$direction="North";break;
            case "5":$direction="North-East";break;
            case "6":$direction="East";
            case "7":$direction="South-East";break;
            case "8":$direction="South";break;
        }
        $weather=array();               
                $weather[data][icon]="http://openweathermap.org/img/wn/".$raww[weather][0][icon]."@2x.png";
                $weather[data][wind][direction]=$direction;
                $weather[data][wind][speed]=$raww[wind][speed];
                $weather[data][description]=$raww[weather][0][description];
                $weather[data][temperature]=(int)$raww[main][temp];         //will return 0 if error
                $weather[data][sunset]=date("H:i",$raww[sys][sunset]);
                $weather[data][sunrise]=date("H:i",$raww[sys][sunrise]);
                $weather[data][updated]=date("d.m.y, g:i a");
                $weather[data][raw]=$data;
              return($weather);
    }
    //echo json_encode(weather()); //debug
?>
