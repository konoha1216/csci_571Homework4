<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    // echo $_POST['currentPlace'].'<br>';
    $_POST['currentStatus'] = 'fail';
    if ($_POST['currentPlace'] != ''){
        // echo 'current'.'<br>';
        // $ch=curl_init();
        // $timeout=5;
        // $geocodeUrl="http://ip-api.com/json";
        // curl_setopt($ch, CURLOPT_URL, $geocodeUrl);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        // $geocode_contents = curl_exec($ch);
        // $geocode_contents = json_decode($geocode_contents, true);
        // curl_close($ch);
        $myLat=$_POST['hidden_latitude'];
        $myLng=$_POST['hidden_longitude'];
        $_POST['streetToShow']='street';
        $_POST['cityToshow'] = $_POST['hidden_city'];
        // echo $myLng;
        // echo $myLat;
        // echo $_POST['cityToshow'];
        // $_POST['myState']=$geocode_contents['regionName'];
        $_POST['currentStatus']='success';
        echo '<div id="current_status" style="display:none;">'.success.'</div>';
        // echo $myLat.', '.$myLng.', '.$geocode_contents['as'].'<br>';
    }else{
        $myStreet=$_POST['myStreet'];
        $_POST['cityToshow'] = $_POST['myCity'];
        $_POST['streetToShow'] = $_POST['myStreet'];
        // $myCity=$_POST['myCity'];
        $myState=$_POST['myState'];
        $currentPlace=$_POST['currentPlace'];
        $myLocation = $myStreet.','.$myCity.','.$myState;
        
        // echo 'myLocation: '.$myLocation.'<br>';
        // echo 'myStreet: '.$myStreet.'<br>';
        // echo 'myCity: '.$myCity.'<br>';
        // echo 'myState: '.$myState.'<br>';
        // echo 'currentPlace: '.$currentPlace.'<br>';
        // 给定街道城市州返回坐标
        $ch=curl_init();
        $timeout=5;
        $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($myLocation) . "&key=AIzaSyCUbX3thvUqn4ul82mYU9guuASGixoH-SI";
        curl_setopt($ch, CURLOPT_URL, $geocodeUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $geocode_contents = curl_exec($ch);
        // echo $geocode_contents.'<br>';
        $geocode_contents = json_decode($geocode_contents, true);
        curl_close($ch);
        // print_r($geocode_contents);
        // echo '<br>';
        // echo $geocode_contents.'<br>';
        $myLat = $geocode_contents['results'][0]['geometry']['location']['lat'];
        $myLng = $geocode_contents['results'][0]['geometry']['location']['lng'];
    }

    echo '<div id="checkStreet" style="display:none;">'.$_POST['streetToShow'].'</div>';
    echo '<div id="checkCity" style="display:none;">'.$_POST['cityToshow'].'</div>';

    // echo 'myLat: '.$myLat.'<br>';
    // echo 'myLng: '.$myLng.'<br>';
    // echo '<br>';

    $myCoordinate = $myLat.','.$myLng;
    // echo 'myCoordinate: '.$myCoordinate.'<br>';
    // 给定坐标返回第一个天气部分
    $ch=curl_init();
    $timeout=5;
    $weathercodeUrl = "https://api.forecast.io/forecast/b4ab8a86fdb8c045bb2c056963dba9b9/".$myCoordinate."/?exclude=minutely,hourly,alerts,flags";
    curl_setopt($ch, CURLOPT_URL, $weathercodeUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $weathercode_contents = curl_exec($ch);
    // $weathercode_contents = json_decode($weathercode_contents, true);

    curl_close($ch);
    echo '<div id="weathercode_contents" style="display:none;">'.$weathercode_contents.'</div>';
    // echo $weathercode_contents;
    echo "<br>";

    //给定坐标日期返回详细天气状况
    if($_POST['detail_date']!=''){
        $detail_date=$_POST['detail_date'];
        $ch=curl_init();
        $timeout=5;
        $detailcode_url = "https://api.darksky.net/forecast/b4ab8a86fdb8c045bb2c056963dba9b9/".$myLat.','.$myLng.','.$detail_date."?exclude=minutely";
        // echo "detailcode_url: ".$detailcode_url; 
        curl_setopt($ch, CURLOPT_URL, $detailcode_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $detail_contents = curl_exec($ch);
        curl_close($ch);
        echo "<div id='detail_contents' style='display:none;'>".$detail_contents.'</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="referrer" content="no-referrer" />
    <title>hw4</title>
<style type="text/css">
*{
    padding: 0;
    margin: 0;
    font-family: 'Libre Baskerville', serif;
}
.content1{
    background-color: rgb(1,166,28);
    margin: 20px auto 20px;
    height: 240px;
    width: 740px;
    border-radius: 25px;
}
.title{
    margin: 10px 0 0 0;
    height: 50px;
    width: 740px;
    text-align: center;
    /*font-family: 'Playfair Display', serif;*/
    font-style: italic;;
    font-size: 36px;
    color: white;
}

#leftForm{
    float: left;
    width:330px;
    height: 120px;
    margin: 0 0 0 70px;
}

#whiteMiddle{
    float: left;
    background-color: white;
    width: 6px;
    height:120px;
    border-radius: 2px;
    color: white;
}
#current{
    float: left;
    width: 180px;
    height: 120px;
    margin: 0 0 0 120px;
    color: white;
}
.formItem{
    margin: 5px 0 5px 0;
}
#myState{
    width: 220px;
}
#myForm{
    color: white;
}
#btn{
    margin: 110px 0 0 -240px;
}
#mySearch{
    margin: 10px 0 0 0;
    height: 20px;
    width: 50px;
    font-size: 14px;
    vertical-align: middle;
}
#myClear{
    margin: 10px 0 0 -3px;
    height: 20px;
    width: 50px;
    font-size: 14px;
    vertical-align: middle;
}

#checkValid{
    background-color: rgb(239,239,239);
    border: solid 3px rgb(155,155,155);
    margin: 0 auto;
    height: 20px;
    width: 400px;
    text-align: center;
    vertical-align: middle;
}

#content2{
    height: 330;
    width: 500px;
    background-color: rgb(33,190,247);
    margin: 30px auto 0;
    border-radius: 25px;
    display: none;
}

#city1{
    font-size: 32px;
    font-weight: bold;
    margin: 37px 0 0 18px;
    color: white;
    padding: 15px 0 0 0;
}
#timezone1{
    margin: 0 0 0 18px;
    color: white;
}      
#temp1{
    margin: 10 0 0 18px;
    height: 125px;
}
#temp1num{
    color: white;
    font-size: 96px;
    height: 125px;
    font-weight: bold;
    float: left;
    margin: 0;
    line-height: 125px;
}
#temp1char1{
    float: left;
}
#temp1char1 img{
    float: left;
    height: 16px;
    width: 16px;
    margin: 10 0 0 5px;
}
#temp1char2{
    float: left;
    font-size: 36px;
    margin: 55px 0 0 5px;
    color: white;
}
#clear{
    clear: both;
    height: 0;
    line-height: 0;
    font-size: 0;
}
#summary1{
    width: 300px;
    height: 45px;
    font-size: 32px;
    font-weight: bold;
    margin: 0 0 0 18px;
    color: white;
    text-align: left;
}
#icon1{
    margin: 0 auto 0;
}
#icon1 img{
    width: 30px;
    height: 30px;
    margin: 0 auto;
}
#icon1 .img1{
    text-align: center;
}
#icon1 .text1{
    text-align: center;
}
#icon1 .icons{
    color: white;
    font-size: 22px;
    margin: 10px 12px 0 12px;
}
#humidity1{
    float: left;
}
#presure1{
    float: left;
}
#windspeed1{
    float: left;
}
#visibility1{
    float: left;
}
#cloudcover1{
    float: left;
}
#ozone1{
    float: left;
}

#content3{
    width: 880px;
    margin: 30px auto 0;
    display: none;
}
#daily_weather{
    width: 880px;
    background-color: rgb(138,195,239);
    color: white;
    border: 1px solid rgb(72,168,215);
    text-align: center;
    font-weight: bold;
    font-size:14px;
}
#daily_weather tr td{
    border: 1px solid rgb(72,168,215);
}
#daily_weather tr{
    height: 50px;
}
#daily_weather #table_header{
    height: 22px;
}
#daily_weather img{
    height: 50px;
    width: 50px;
}
#daily_weather .detail{
    cursor: pointer;
}

/*#content3{
    background-color: rgb(138,195,239);
}*/

#content4{
    margin: 30px 0 0;
    display: none;
}
#weather_detail{
    font-weight: bold;;
    font-size: 32px;
    margin: 0 auto;
    text-align: center;
}
#detail_card{
    width: 600px;
    height: 480px;
    margin: 20px auto 0;
    background-color: rgb(147,203,215);
    border-radius: 25px;
    color: white;
}
#info td{
    color: white;
    font-weight: bold;
    font-size: 20px;
}
#summary2{
    font-size: 38px;
    margin: 0 0 0 25px;
    padding-top: 80px;
    font-weight: bold;
}
#temp2{
    margin: 8px 0 0 25px;
    width: 350px;
}
#temp2num{
    font-size: 110px;
    float: left;
}
#temp2char1{
    float: left;
    margin: 0;
}
#temp2char2{
    float: left;
    font-size: 88px;
    margin: 21px 0 0 0;
}
#icon2{
    width: 300px;
    height: 300px;
    margin: -300px 0 0 300px;
    position: relative;
}
#icon2 img{
    top: 30px;
    width: 280px;
    height: 280px;
    margin: auto;
    position: absolute;

}
#info{
    margin:0 0 0 220px;
}
#info tr{
    line-height: 28px;
}
#info .first_col{
    text-align: right;;
}

#hourly_detail{
    font-weight: bold;;
    font-size: 32px;
    margin: 20px auto 5px;
    text-align: center;
}
#hidden_icon{
    margin: 0 auto;
    text-align: center;
}
#hidden_icon img{
    margin: 0 auto;
    width: 50px;
}
#hourly_line{
    margin: 0 auto;
    width: 750px;
}

</style>

<script type="text/javascript">
    function checkCurrent(){
        var request = new XMLHttpRequest()

        // Open a new connection, using the GET request on the URL endpoint
        request.open('GET', 'http://ip-api.com/json', true)

        request.onload = function() {
            var data = JSON.parse(this.response);
            document.getElementById("hidden_longitude").value = data['lon'];
            document.getElementById("hidden_latitude").value = data['lat'];
            document.getElementById("hidden_city").value = data['city'];
        }

        // Send request
        request.send();
        if(document.getElementById('current_status') != null){
            document.getElementById("myStreet").value='';
            document.getElementById("myCity").value='';
            document.getElementById('myState').options[0].selected='true';
            document.getElementById("currentPlace").checked = 'true';
            document.getElementById("myStreet").disabled='disabled';
            document.getElementById("myCity").disabled='disabled';
            document.getElementById('myState').disabled='disabled';
            document.getElementById("myStreet").style.opacity='0.5';
            document.getElementById("myCity").style.opacity='0.5';
            document.getElementById('myState').disabled='disabled';
        }

    }
    function clearForm(){
        console.log('script');
        document.getElementById("myStreet").value='';
        document.getElementById("myCity").value='';
        document.getElementById('myState').options[0].selected='true';
        document.getElementById('currentPlace').checked='';
        document.getElementById("myStreet").disabled='';
        document.getElementById("myCity").disabled='';
        document.getElementById('myState').disabled='';
        document.getElementById("myStreet").style.opacity='1';
        document.getElementById("myCity").style.opacity='1';

        document.getElementById('content2').style.display='none';
        document.getElementById('content3').style.display='none';
        document.getElementById('content4').style.display='none';
    }

    // function showresult1(){
    //     console.log('shouwresult1');
    //     document.getElementById('content2').style.display='block';
    //     document.getElementById('content3').style.display='block';
    // }   
    function getDate(n){
        // console.log('shouresult2');
        // document.getElementById('content2').style.display='none';
        // document.getElementById('content3').style.display='none';
        // document.getElementById('content4').style.display='block';
        weathercode_contents = JSON.parse(document.getElementById('weathercode_contents').innerText);
        document.getElementById('detail_date').value = weathercode_contents['daily']['data'][parseInt(n)]['time'];
        document.getElementById('myForm').submit();
    }
    function statusIcon(status){
        var source = '';
        if(status=='clear-day' || status=='clear-night'){
            source='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-12-512.png';
        }else if(status=='rain'){
            source='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-04-512.png';
        }else if(status=='snow'){
            source='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-19-512.png';
        }else if(status=='sleet'){
            source='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-07-512.png';
        }else if(status=='wind'){
            source='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-27-512.png';
        }else if(status=='fog'){
            source='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-28-512.png';
        }else if(status=='cloudy'){
            source='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-01-512.png';
        }else if(status=='partly-cloudy-day' || status=='partly-cloudy-night'){
            source='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-02-512.png';
        }
        return source;
    }

    // function summary2(summary2_text){
    //     if(summary2_text.length>15){
    //         return 'summary2_text[:15]'+'<br>'+'day';
    //     }else{
    //         return summary2_text;
    //     }
    // }
    function detailIcon(status){
        var source = '';
        if(status=='clear-day' || status=='clear-night'){
            source='https://cdn3.iconfinder.com/data/icons/weather-344/142/sun-512.png';
        }else if(status=='rain'){
            source='https://cdn3.iconfinder.com/data/icons/weather-344/142/rain-512.png';
        }else if(status=='snow'){
            source='https://cdn3.iconfinder.com/data/icons/weather-344/142/snow-512.png';
        }else if(status=='sleet'){
            source='https://cdn3.iconfinder.com/data/icons/weather-344/142/lightning-512.png';
        }else if(status=='wind'){
            source='https://cdn4.iconfinder.com/data/icons/the-weather-is-nice-today/64/weather_10-512.png';
        }else if(status=='fog'){
            source='https://cdn3.iconfinder.com/data/icons/weather-344/142/cloudy-512.png';
        }else if(status=='cloudy'){
            source='https://cdn3.iconfinder.com/data/icons/weather-344/142/cloudy-512.png';
        }else if(status=='partly-cloudy-day' || status=='partly-cloudy-night'){
            source='https://cdn3.iconfinder.com/data/icons/weather-344/142/sunny-512.png';
        }
        return source;
    }
    function preciption(precip){
        precip=parseFloat(precip);
        var result='';
        if(precip<=0.001){
            result='None';
        }else if(precip<=0.015){
            result='Very Light';
        }else if(precip<=0.05){
            result='Light';
        }else if(precip<=0.1){
            result='Moderate';
        }else{
            result='heavy';
        }
        return result;
    }
    function sunTime(sunTimestamp,timezone){
        var sunTimestamp=parseInt(sunTimestamp*1000);
        var sunTime=new Date(sunTimestamp);
        console.log(timezone);
        sunTime = sunTime.toLocaleString('en-US',{"timeZone":timezone});
        var newSunTime = new Date(sunTime);
        var h = newSunTime.getHours();
        if(h>12){
            return (h-12);
        }else{
            return h;
        }
    }

    //timestamp->date
    function timeStamp2date(mytimeStamp,timezone){
        var myTS = parseInt(mytimeStamp*1000);
        var date = new Date(myTS);
        console.log(timezone);
        date = date.toLocaleString('en-US',{"timeZone":timezone});
        var newDate = new Date(date);
        year = newDate.getFullYear();
        month = newDate.getMonth()+1 < 10 ? '0'+(newDate.getMonth()+1) : newDate.getMonth()+1;
        day = newDate.getDate();
        return year+'-'+month+'-'+day;
    }

    function lockOthers(){
        if (document.getElementById("currentPlace").checked){
            document.getElementById("myStreet").value='';
            document.getElementById("myCity").value='';
            document.getElementById('myState').options[0].selected='true';
            document.getElementById("myStreet").disabled='disabled';
            document.getElementById("myCity").disabled='disabled';
            document.getElementById('myState').disabled='disabled';
            document.getElementById("myStreet").style.opacity='0.5';
            document.getElementById("myCity").style.opacity='0.5';
            document.getElementById('myState').disabled='disabled';
        }else{
            document.getElementById("myStreet").disabled='';
            document.getElementById("myCity").disabled='';
            document.getElementById('myState').disabled='';
            document.getElementById("myStreet").style.opacity='1';
            document.getElementById("myCity").style.opacity='1';
        }
    }
    
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body onload="checkCurrent()">
<div class="main">
    <div class="content1">
        <div class="title">
            Weather Search
        </div>
        <form id="myForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div id="leftForm">
            Street<input type="text" id = "myStreet" name="myStreet" class="formItem" value="<?php if(isset($_POST['myStreet'])){echo $_POST['myStreet'];}?>" style="margin-left:5px;"><br>
            City<input type="text" id="myCity" name="myCity" class="formItem" value="<?php if(isset($_POST['myCity'])){echo $_POST['myCity'];}?>" style="margin-left: 15px;"><br>
            State
            <?php $select_value = isset($_POST['myState']) ? $_POST['myState'] : ''; ?>
            <select id="myState" id="myState" name="myState" class="formItem" value="<?php if(isset($_POST['myState'])){echo $_POST['myState'];}?>">
                <option value="State" selected>State</option>
                <option disabled="true" id="default_select" style="color: black">---------------------------------------------</option>
                <option value="Alabama" <?php echo $select_value == 'Alabama' ? 'selected' : '' ?>>Alabama</option>
                <option value="Alaska" <?php echo $select_value == 'Alaska' ? 'selected' : '' ?>>Alaska</option>
                <option value="Arizona" <?php echo $select_value == 'Arizona' ? 'selected' : '' ?>>Arizona</option>
                <option value="Arkansas" <?php echo $select_value == 'Arkansas' ? 'selected' : '' ?>>Arkansas</option>
                <option value="California" <?php echo $select_value == 'California' ? 'selected' : '' ?>>California</option>
                <option value="Colorado" <?php echo $select_value == 'Colorado' ? 'selected' : '' ?>>Colorado</option>
                <option value="Connecticut" <?php echo $select_value == 'Connecticut' ? 'selected' : '' ?>>Connecticut</option>
                <option value="Delaware" <?php echo $select_value == 'Delaware' ? 'selected' : '' ?>>Delaware</option>
                <option value="District Of Columbia" <?php echo $select_value == 'Music' ? 'selected' : '' ?>>District Of Columbia</option>
                <option value="Florida" <?php echo $select_value == 'Florida' ? 'selected' : '' ?>>Florida</option>
                <option value="Georgia" <?php echo $select_value == 'Georgia' ? 'selected' : '' ?>>Georgia</option>
                <option value="Hawaii" <?php echo $select_value == 'Hawaii' ? 'selected' : '' ?>>Hawaii</option>
                <option value="Idaho" <?php echo $select_value == 'Idaho' ? 'selected' : '' ?>>Idaho</option>
                <option value="Illinois" <?php echo $select_value == 'Illinois' ? 'selected' : '' ?>>Illinois</option>
                <option value="Indiana" <?php echo $select_value == 'Indiana' ? 'selected' : '' ?>>AlIndianaaska</option>
                <option value="Iowa" <?php echo $select_value == 'Iowa' ? 'selected' : '' ?>>Iowa</option>
                <option value="Kansas" <?php echo $select_value == 'Kansas' ? 'selected' : '' ?>>Kansas</option>
                <option value="Kentucky" <?php echo $select_value == 'Kentucky' ? 'selected' : '' ?>>Kentucky</option>
                <option value="Louisiana" <?php echo $select_value == 'Louisiana' ? 'selected' : '' ?>>Louisiana</option>
                <option value="Maine" <?php echo $select_value == 'Maine' ? 'selected' : '' ?>>Maine</option>
                <option value="Maryland" <?php echo $select_value == 'Maryland' ? 'selected' : '' ?>>Maryland</option>
                <option value="Massachusetts" <?php echo $select_value == 'Massachusetts' ? 'selected' : '' ?>>Massachusetts</option>
                <option value="Michigan" <?php echo $select_value == 'Michigan' ? 'selected' : '' ?>>Michigan</option>
                <option value="Minnesota" <?php echo $select_value == 'Minnesota' ? 'selected' : '' ?>>Minnesota</option>
                <option value="Mississippi" <?php echo $select_value == 'Mississippi' ? 'selected' : '' ?>>Mississippi</option>
                <option value="Missouri" <?php echo $select_value == 'Missouri' ? 'selected' : '' ?>>Missouri</option>
                <option value="Montana" <?php echo $select_value == 'Montana' ? 'selected' : '' ?>>Montana</option>
                <option value="Nebraska" <?php echo $select_value == 'Nebraska' ? 'selected' : '' ?>>Nebraska</option>
                <option value="Nevada" <?php echo $select_value == 'Nevada' ? 'selected' : '' ?>>Nevada</option>
                <option value="New Hampshire" <?php echo $select_value == 'New Hampshire' ? 'selected' : '' ?>>New Hampshire</option>
                <option value="New Jersey" <?php echo $select_value == 'New Jersey' ? 'selected' : '' ?>>New Jersey</option>
                <option value="New Mexico" <?php echo $select_value == 'New Mexico' ? 'selected' : '' ?>>New Mexico</option>
                <option value="New York" <?php echo $select_value == 'New York' ? 'selected' : '' ?>>New York</option>
                <option value="North Carolina" <?php echo $select_value == 'North Carolina' ? 'selected' : '' ?>>North Carolina</option>
                <option value="North Dakota" <?php echo $select_value == 'North Dakota' ? 'selected' : '' ?>>North Dakota</option>
                <option value="Ohio" <?php echo $select_value == 'Ohio' ? 'selected' : '' ?>>Ohio</option>
                <option value="Oklahoma" <?php echo $select_value == 'Oklahoma' ? 'selected' : '' ?>>Oklahoma</option>
                <option value="Oregon" <?php echo $select_value == 'Oregon' ? 'selected' : '' ?>>Oregon</option>
                <option value="Pennsylvania" <?php echo $select_value == 'Pennsylvania' ? 'selected' : '' ?>>Pennsylvania</option>
                <option value="Rhode Island" <?php echo $select_value == 'Rhode Island' ? 'selected' : '' ?>>Rhode Island</option>
                <option value="South Carolina" <?php echo $select_value == 'South Carolina' ? 'selected' : '' ?>>South Carolina</option>
                <option value="South Dakota" <?php echo $select_value == 'South Dakota' ? 'selected' : '' ?>>South Dakota</option>
                <option value="Tennessee" <?php echo $select_value == 'Tennessee' ? 'selected' : '' ?>>Tennessee</option>
                <option value="Texas" <?php echo $select_value == 'Texas' ? 'selected' : '' ?>>Texas</option>
                <option value="Utah" <?php echo $select_value == 'Utah' ? 'selected' : '' ?>>Utah</option>
                <option value="Vermont" <?php echo $select_value == 'Vermont' ? 'selected' : '' ?>>Vermont</option>
                <option value="Virginia" <?php echo $select_value == 'Virginia' ? 'selected' : '' ?>>Virginia</option>
                <option value="Washington" <?php echo $select_value == 'Washington' ? 'selected' : '' ?>>Washington</option>
                <option value="West Virginia" <?php echo $select_value == 'West Virginia' ? 'selected' : '' ?>>West Virginia</option>
                <option value="Wisconsin" <?php echo $select_value == 'Wisconsin' ? 'selected' : '' ?>>Wisconsin</option>
                <option value="Wyoming" <?php echo $select_value == 'Wyoming' ? 'selected' : '' ?>>Wyoming</option>
            </select>
            </div>
            <div id="whiteMiddle"></div>
            <div id="current">
                <input type="checkbox" id="currentPlace" name="currentPlace" value="currentPlace" onchange="lockOthers()">&nbsp;&nbsp;Current Location
                <input type="hidden" type="text" name="detail_date" id="detail_date" value="">
                <input type="hidden" type="text" name="hidden_longitude" id="hidden_longitude" value="">
                <input type="hidden" type="text" name="hidden_latitude" id="hidden_latitude" value="">
                <input type="hidden" type="text" name="hidden_city" id="hidden_city" value="">
                <div id="btn">
                    <input type="submit" id="mySearch" name="search" value="search" style="color: black;">
                    <input type="button" id="myClear" name="clear" value="clear" onclick="clearForm()" style="color: black;">
                </div>
            </div>
        </form>
    </div>

    <div id="checkValid" style="display: none;">
        Please check the input address.
    </div>

    <div id="content2">
        <div id="city1">
            <?php echo $_POST['cityToshow'];?>            
        </div>

        <div id="timezone1"></div>

        <div id="temp1">
            <div id="temp1num"></div>
            <div id="temp1char1">
                <img src="https://cdn3.iconfinder.com/data/icons/virtual-notebook/16/button_shape_oval-512.png">
            </div>
            <div id="temp1char2">
                F
            </div>
            <div id="clear"></div>
        </div>

        <div id="summary1"></div>
        <div id="icon1" style="display: flex; justify-content: space-around;">
            <div class="icons" id="humidity1">
                <div class="img1" title="Humidity"><img id="humidity1img" src="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-16-512.png"></div>
                <div id="humidity1num" class="text1"></div>
            </div>
            <div class="icons" id="presure1">
                <div class="img1" title="Pressure"><img id="presure1img" src="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-25-512.png"></div>
                <div id="presure1num" class="text1"></div>
            </div>
            <div class="icons" id="windspeed1">
                <div class="img1" title="WindSpeed"><img id="windspeed1img" src="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-27-512.png"></div>
                <div id="windspeed1num" class="text1"></div>
            </div>
            <div class="icons" id="visibility1">
                <div class="img1" title="Visibility"><img id="visibility1img" src="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-30-512.png"></div>
                <div id="visibility1num" class="text1"></div>
            </div>
            <div class="icons" id="cloudcover1">
                <div class="img1" title="CloudCover"><img id="cloudcover1img" src="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-28-512.png"></div>
                <div id="cloudcover1num" class="text1"></div>
            </div>
            <div class="icons" id="ozone1">
                <div class="img1" title="Ozone"><img id="ozone1img" src="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-24-512.png"></div>
                <div id="ozone1num" class="text1"></div>
            </div>
        </div>
    </div>

    <div id="content3">
        <table id="daily_weather" border="2px" cellspacing="0"> 
            <tr id="table_header">
                <td width="95px">Data</td>
                <td width="55px">Status</td>
                <td width="317px">Summary</td>
                <td width="155px">TemperatureHigh</td>
                <td width="152px">TemperatureLow</td>
                <td width="105px">Wind Speed</td>
            </tr>
            <tr id="date1">
                <td></td>
                <td><img src="#"></td>
                <td onclick='getDate(0)' class="detail"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr id="date2">
                <td></td>
                <td><img src="#"></td>
                <td onclick='getDate(1)' class="detail"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr id="date3">
                <td></td>
                <td><img src="#"></td>
                <td onclick='getDate(2)' class="detail"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr id="date4">
                <td></td>
                <td><img src="#"></td>
                <td onclick='getDate(3)' class="detail"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr id="date5">
                <td></td>
                <td><img src="#"></td>
                <td onclick='getDate(4)' class="detail"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr id="date6">
                <td></td>
                <td><img src="#"></td>
                <td onclick='getDate(5)' class="detail"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr id="date7">
                <td></td>
                <td><img src="#"></td>
                <td onclick='getDate(6)' class="detail"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr id="date8">
                <td></td>
                <td><img src="#"></td>
                <td onclick='getDate(7)' class="detail"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div id="content4">
        <div id="weather_detail">
            Daily Weather Detail
        </div>
        <div id="detail_card">
            <div id="summary2"></div>
            <div id="temp2">
                <div id="temp2num"></div>
                <div id="temp2char1"><img src="https://cdn3.iconfinder.com/data/icons/virtual-notebook/16/button_shape_oval-512.png" style="width: 16px;height: 16px;"></div>
                <div id="temp2char2">F</div>
                <div id="clear"></div>
            </div>
            <div id="icon2"><img src="#"></div>
            <div id="info">
                <table>
                    <tr>
                        <td class="first_col">Precipitation:</td>
                        <td id="precipitation2"></td>
                    </tr>
                    <tr>
                        <td class="first_col">Chance of Rain:</td>
                        <td id="rainchance2"><span></span><span style="font-size: 14px; margin: 0 2px">%</span></td>
                    </tr>
                    <tr>
                        <td class="first_col">Wind Speed:</td>
                        <td id="windspeed2"><span></span><span style="font-size: 14px; margin: 0 2px">mph</span></td>
                    </tr>
                    <tr>
                        <td class="first_col">Humidity:</td>
                        <td id="humidity2"><span></span><span style="font-size: 14px; margin: 0 2px">%</span></td>
                    </tr>
                    <tr>
                        <td class="first_col">Visibility:</td>
                        <td id="visibility2"><span></span><span style="font-size: 14px; margin: 0 2px">mi</span></td>
                    </tr>
                    <tr>
                        <td class="first_col">Sunrise / Sunset:</td>
                        <td id="sun2"><span></span><span style="font-size: 14px; margin: 0 2px">AM/</span><span></span><span style="font-size: 14px; margin: 0 2px">PM</span></td>
                    </tr>
                </table>
            </div>
<!--             <div id="info_mark">
                
            </div> -->
        </div>
        <div id="hourly_detail">
            Day's Hourly Weather
        </div>
        <div id="hidden_icon" mark='0'>
            <a href="#" onclick="hiddenChart()"><img src="https://cdn4.iconfinder.com/data/icons/geosm-e-commerce/18/point-down-512.png"></a>
        </div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div id="hourly_line" style="display: none">
            
        </div>
    </div>

</div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    if(document.getElementById('checkStreet').innerText=='' || document.getElementById('checkCity').innerText==''){
        document.getElementById('checkValid').style.display='block';
    }else{
        if(document.getElementById('weathercode_contents')!=null){
            // set the blue card
            // document.getElementById('weathercode_contents').style.display="none";
            document.getElementById('content2').style.display='block';
            document.getElementById('content3').style.display='block';
            weathercode_contents = JSON.parse(document.getElementById('weathercode_contents').innerText);
            document.getElementById('timezone1').innerText = weathercode_contents['timezone'];
            document.getElementById('temp1num').innerText = weathercode_contents['currently']['temperature'];
            document.getElementById('summary1').innerText = weathercode_contents['currently']['summary'];
            var num=0;
            if(weathercode_contents['currently']['humidity'] == '0'){
                num+=1;
                document.getElementById('humidity1').parentNode.removeChild(document.getElementById('humidity1'));
            }else{
                document.getElementById('humidity1num').innerText = weathercode_contents['currently']['humidity'];
            }
            if(weathercode_contents['currently']['pressure'] == '0'){
                num+=1;
                document.getElementById('presure1').parentNode.removeChild(document.getElementById('presure1'));
            }else{
                document.getElementById('presure1num').innerText = weathercode_contents['currently']['pressure'];
            }
            if(weathercode_contents['currently']['windSpeed'] == '0'){
                num+=1;
                document.getElementById('windspeed1').parentNode.removeChild(document.getElementById('windspeed1'));
            }else{
                document.getElementById('windspeed1num').innerText = weathercode_contents['currently']['windSpeed'];
            }
            if(weathercode_contents['currently']['visibility'] == '0'){
                num+=1;
                document.getElementById('visibility1').parentNode.removeChild(document.getElementById('visibility1'));
            }else{
                document.getElementById('visibility1num').innerText = weathercode_contents['currently']['visibility'];
            }
            if(weathercode_contents['currently']['cloudCover'] == '0'){
                num+=1;
                document.getElementById('cloudcover1').parentNode.removeChild(document.getElementById('cloudcover1'));
            }else{
                document.getElementById('cloudcover1num').innerText = weathercode_contents['currently']['cloudCover'];
            }
            if(weathercode_contents['currently']['ozone'] == '0'){
                num+=1;
                document.getElementById('ozone1').parentNode.removeChild(document.getElementById('ozone1'));
            }else{
                document.getElementById('ozone1num').innerText = weathercode_contents['currently']['ozone'];
            }

            for(var i=1; i<document.getElementById('daily_weather').getElementsByTagName('tr').length; i++){
                var myDate = "date"+i;
                // document.write(myDate);
                document.getElementById(myDate).getElementsByTagName('td')[0].innerText=timeStamp2date( weathercode_contents['daily']['data'][i-1]['time'],weathercode_contents['timezone']);
                document.getElementById(myDate).getElementsByTagName('td')[1].getElementsByTagName('img')[0].src=statusIcon(weathercode_contents['daily']['data'][i-1]['icon']);
                document.getElementById(myDate).getElementsByTagName('td')[2].innerText=weathercode_contents['daily']['data'][i-1]['summary'];
                document.getElementById(myDate).getElementsByTagName('td')[3].innerText=weathercode_contents['daily']['data'][i-1]['temperatureHigh'];
                document.getElementById(myDate).getElementsByTagName('td')[4].innerText=weathercode_contents['daily']['data'][i-1]['temperatureLow'];
                document.getElementById(myDate).getElementsByTagName('td')[5].innerText=weathercode_contents['daily']['data'][i-1]['windSpeed'];
            }
        }

        if(document.getElementById('detail_contents')!=null){
            document.getElementById('content2').style.display='none';
            document.getElementById('content3').style.display='none';
            document.getElementById('content4').style.display='block';
            detail_contents = JSON.parse(document.getElementById('detail_contents').innerText);
            document.getElementById('summary2').innerText = detail_contents['currently']['summary'];
            document.getElementById('temp2num').innerText = Math.round(detail_contents['currently']['temperature']);
            document.getElementById('icon2').getElementsByTagName('img')[0].src = detailIcon(detail_contents['currently']['icon']);
            document.getElementById('precipitation2').innerText = preciption(detail_contents['currently']['precipIntensity']);
            document.getElementById('rainchance2').getElementsByTagName('span')[0].innerText = Math.round(detail_contents['currently']['precipProbability']*100);
            document.getElementById('windspeed2').getElementsByTagName('span')[0].innerText = detail_contents['currently']['windSpeed'];
            document.getElementById('visibility2').getElementsByTagName('span')[0].innerText = detail_contents['currently']['visibility'];
            document.getElementById('humidity2').getElementsByTagName('span')[0].innerText = Math.round(detail_contents['currently']['humidity']*100);
            document.getElementById('sun2').getElementsByTagName('span')[0].innerText = sunTime(detail_contents['daily']['data'][0]['sunriseTime'],weathercode_contents['timezone'])
            document.getElementById('sun2').getElementsByTagName('span')[2].innerText = sunTime(detail_contents['daily']['data'][0]['sunsetTime'],weathercode_contents['timezone']);


        }


        //hidden chart part
        function hiddenChart(){
            var img=document.getElementById('hidden_icon').getElementsByTagName('img')[0];
            if(img.src=='https://cdn4.iconfinder.com/data/icons/geosm-e-commerce/18/point-down-512.png'){
                console.log("checked1");
                console.log(img.src);
                img.src='https://cdn0.iconfinder.com/data/icons/navigation-set-arrows-part-one/32/ExpandLess-512.png';
                document.getElementById('hourly_line').style.display='block';
            }else if(img.src=='https://cdn0.iconfinder.com/data/icons/navigation-set-arrows-part-one/32/ExpandLess-512.png'){
                console.log('checked2');
                console.log(img.src);
                img.src='https://cdn4.iconfinder.com/data/icons/geosm-e-commerce/18/point-down-512.png';
                document.getElementById('hourly_line').style.display='none';
            }
        }
        if(document.getElementById('detail_contents')!=null){
            hourly_temp = [];
            for(var i=0;i<23;i++){
                hourly_temp[i]=detail_contents['hourly']['data'][i]['temperature'];
            }
            // document.write(hourly_temp);
            google.charts.load('current', {packages: ['corechart', 'line']});
            google.charts.setOnLoadCallback(drawBasic);
            function drawBasic() {
                var data = new google.visualization.DataTable();
                data.addColumn('number', 'X');
                data.addColumn('number', 'T');

                data.addRows([
                [0, hourly_temp[0]],[1, hourly_temp[1]],[2, hourly_temp[2]],[3, hourly_temp[3]],[4, hourly_temp[4]],[5, hourly_temp[5]],[6, hourly_temp[6]],[7, hourly_temp[7]],[8, hourly_temp[8]],[9, hourly_temp[9]],[10, hourly_temp[10]],[11, hourly_temp[11]],[12, hourly_temp[12]],[13, hourly_temp[13]],[14, hourly_temp[14]],[15, hourly_temp[15]],[16, hourly_temp[16]],[17, hourly_temp[17]],[18, hourly_temp[18]],[19, hourly_temp[19]],[20, hourly_temp[20]],[21, hourly_temp[21]],[22, hourly_temp[22]],[23, hourly_temp[23]]
                ]);
                var options = {
                hAxis: {
                  title: 'Time'
                },
                vAxis: {
                  title: 'Teperature',
                  textStyle:{color:'white'}
                },
                width:750,
                colors:['#93CBD7']
                };
                var chart = new google.visualization.LineChart(document.getElementById('hourly_line'));
                chart.draw(data, options);
            }
        }
    }
</script>
</html>