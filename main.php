<?php

// Add your google API & Forecast API keys
$google_api_key='';
$forecast_api_key='';

$street=$_POST["street"];
$city=$_POST["city"];
$state=$_POST["state"];
$location=$street.",".$city.",".$state;
// echo "whyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy".$location."\n";
// echo "current here".$_POST["current_here"];

if($_POST["current_here"]=="0"){
    if($street != "" && $city!="" && $state!="default"){
        $geocode_url="https://maps.googleapis.com/maps/api/geocode/xml?";
        
        $query=array(
            'address'=>$location,
            'key'=>'AIzaSyDjOjAEVXEgU0hF8K25Ryr_o_0Lmvd05KE'
        );

        $link=$geocode_url.http_build_query($query);
        $content=file_get_contents($link);
        $xml=simplexml_load_string($content);

        // echo $content;
        $get_Latitude=$xml->result->geometry->location->lat;
        $get_Longitude=$xml->result->geometry->location->lng; 
    }  

}
else{
    $get_Latitude = $_POST["here_lat"];
    $get_Longitude = $_POST["here_Long"];
    $city = $_POST["here_city"]
    ;
}
// echo "Are you jere???????????????";
$hereURL = "https://api.forecast.io/forecast/".$forecast_api_key."/".$get_Latitude.",".$get_Longitude."?exclude=minutely,hourly,alerts,flags";
// echo $hereURL;
$json_file = file_get_contents($hereURL);
$json_elements = json_decode($json_file,true);

$out_city=$city;
$out_timezone=$json_elements["timezone"];
// echo "Timeeeeeeeeeeezoneeeeeeee".$out_timezone;
$out_temperature=$json_elements["currently"]["temperature"];
$out_temperature_url="https://cdn3.iconfinder.com/data/icons/virtual-notebook/16/button_shape_oval-512.png";

$out_summary=$json_elements["currently"]["summary"];

$out_humidity=$json_elements["currently"]["humidity"];
$out_humidity_url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-16-512.png";

$out_pressure=$json_elements["currently"]["pressure"];
$out_pressure_url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-25-512.png";

$out_wind_speed=$json_elements["currently"]["windSpeed"];
$out_wind_speed_url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-27-512.png";

$out_visibility=$json_elements["currently"]["visibility"];
$out_visibility_url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-30-512.png";

$out_cloud_cover=$json_elements["currently"]["cloudCover"];
$out_cloud_cover_url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-28-512.png";

$out_ozone=$json_elements["currently"]["ozone"];
$out_ozone_url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-24-512.png";


// echo "count".count($json_elements["daily"]["data"]);
for($i=0; $i<count($json_elements["daily"]["data"]); $i++){
    // echo "checllllllllllll".$json_elements["daily"]["data"]["$i"]["time"];
    $date[$i]=$json_elements["daily"]["data"][$i]["time"]; 
    $status[$i]=$json_elements["daily"]["data"][$i]["icon"]; 
    $summary[$i]=$json_elements["daily"]["data"][$i]["summary"]; 
    $temp_high[$i]=$json_elements["daily"]["data"][$i]["temperatureHigh"]; 
    $temp_low[$i]=$json_elements["daily"]["data"][$i]["temperatureLow"]; 
    $wind_speed[$i]=$json_elements["daily"]["data"][$i]["windSpeed"]; 

    $daily_url[$i]="https://api.forecast.io/forecast/".$forecast_api_key."/".$get_Latitude.",".$get_Longitude.",".$date[$i]."?exclude=minutely";
    // echo "urllll"."https://api.forecast.io/forecast/".$forecast_api_key."/".$get_Latitude.",".$get_Longitude.",".$date[$i]."?exclude=minutely";
    $get_url_contents[$i]=file_get_contents($daily_url[$i]);
    $json_daily_details[$i]=json_decode($get_url_contents[$i],true);
    // echo "daily setails".$json_daily_details;
    $sec_summary[$i]=$json_daily_details[$i]["currently"]["summary"];
    // echo "Summmaryyyyyyyyyyyyyyyyyyyyy".$sec_summary[$i];
    $sec_temperature[$i]=$json_daily_details[$i]["currently"]["temperature"];
    $sec_icon[$i]=$json_daily_details[$i]["currently"]["icon"];
    $sec_precipitation[$i]=$json_daily_details[$i]["currently"]["precipIntensity"];
    $sec_chance[$i]=$json_daily_details[$i]["currently"]["precipProbability"];
    $sec_wind_speed[$i]=$json_daily_details[$i]["currently"]["windSpeed"];
    $sec_humidity[$i]=$json_daily_details[$i]["currently"]["humidity"];
    $sec_visibility[$i]=$json_daily_details[$i]["currently"]["visibility"];
    $sec_sunriseTime[$i]=$json_daily_details[$i]["daily"]["data"][0]["sunriseTime"];
    $sec_sunsetTime[$i]=$json_daily_details[$i]["daily"]["data"][0]["sunsetTime"];

    for($h=0; $h<24; $h++){
        $hour[$h]=$json_daily_details[$i]["hourly"]["data"][$h]["temperature"];
    }

}
?>

<html>
<head>
<title>Events Search</title>
<style>
a
{
    cursor:pointer;
    text-decoration: none;
}

.weather_form
{
    padding: 20px;
    text-align: center;
    height: 200px;
    width: 600px;
    margin-left: auto;
    margin-right:auto;
    margin-bottom: 30px;
    border-radius: 15px;
    color: white;
    background-color: #20B73F;
}

.vl{
    width:0px;
    border-radius: 2px;
    border:3px solid white;
    height: 110px;
    margin-left: 300px;
    transform: translateY(-99px);
}
.current{
    float: right;
    transform: translate(-70px, -72px);
/*    transform: translateY(-50px);
*/}
.h_s 
{
    margin-top:-20px;
   /* margin-left:10px;
    margin-right:10px;*/
           
}
        
form
{
    text-align: left;
    margin-left: 10px;        
    margin-top: -10px;        
    line-height: 150%;
}

h1 
{
    text-align: center;
    font-weight: lighter;
}

input[type=submit], input[type=button] {
    background-color: white;
    border-radius: 5px;
    border: none;
    margin: 5px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    transform: translate(100px,40px);
  /*  font-size: 19px;
    margin: 4px 2px;*/
    cursor: pointer;
}
       
#submit
{
    margin-left: 65px;
}
#details
{
    margin-left: auto;
    margin-right: auto;
    width: 800px;
} 
        
          
.cursor_style
{
    cursor: pointer;
}       

.table_icon 
{
    position: relative;
    float: center;
    height: 40px;
    width:40px;
}
table.daily 
{
    background-color: #99C4EA; /*table bgcolor*/
    text-align: center;
    position:relative;
    border-collapse:collapse;
    width: 850px;
    margin-left: auto;
    margin-right: auto;
    color: white;
    font-weight: bold;
}
        
 table.daily, td.daily, th.daily 
{
   border:1.5px solid teal;
}       

th.daily
{
  text-align: center;
  height: 15px;
}
td.daily
{
   text-align: center;
   height: 35px;
}


/*===============================================First Card=======================================================*/
 .first_card{
    margin-left: auto;
/*    line-height: 10px;*/
    margin-right: auto;
    background-color: #6AC2EE; /*first card blue*/
    width: 450px;
    height: 270px;
    border-radius: 15px;
    color: white;
}
.f_city{
    margin-left: 18px;
    font-size: 28px;
    font-weight: bold;
    transform: translateY(15px);

}
.f_tzone{
    margin-left: 18px;
    font-size: 13px;
    transform: translateY(-3px);

}
.f_temp{
    margin-left: 18px;
    font-size: 80px;
    font-weight: bold;
    transform: translateY(-15px);

}
.f{
    font-size: 50px;
    font-weight: bold;
    transform: translate(200px,-67px);
}
.f_summ{
    margin-left: 18px;
    font-size: 28px;
    font-weight: bold;
    transform: translateY(-95px);
}

img.first_temp{
    width:12px;
    height: 12px;
    transform: translateY(-50px);
}

table.f_table{
    text-align: center;
    color:white;
    border:none;
    width:400px;
    margin-left: 18px;
    transform: translateY(-105px);
    font-weight: bold;
}
img.f_table{
    width: 25px;
    height: 25px;
}

/*=========================================================Second Card====================================*/
.second_card{
    margin-left: auto;
    margin-right: auto;
    background-color: #8BD2D5; /*second card blue*/
    width: 450px;
    height: 400px;
    border-radius: 12px;
    color: white;
}

p.head{
    margin-left: auto;
    margin-right: auto;
    font-size: 35px;
    text-align: center;
}
table.s_table{
    border:none;
    color:white;
    font-weight: bold;
    width:300px;
    transform: translate(120px,0px);

}
.front{
    font-size: 20px;
    float: left;
}
.side{
    font-size: 16px;
    float: left;
    transform: translateY(4px);
}
.s_summ{
    margin-left: 18px;
    font-size: 32px;
    font-weight: bold;
    transform: translateY(60px);
}

.s_temp{
    margin-left: 18px;
    font-size: 80px;
    font-weight: bold;
    transform: translateY(60px);

}
.s{
    font-size: 50px;
    font-weight: bold;
    transform: translate(200px,-65px);
}

img.second_card{
    float: right;
    right: 50px;
    top:50px;
    width: 200px;
    height: 200px;
}  

img.arrow{
    width:35px;
    height: 30px;
    cursor: pointer;
}  

#show_graph{
    margin-left: auto;
    margin-right: auto;
    font-size: 35px;
    text-align: center;                   

}
#hide_graph{
    margin-left: auto;
    margin-right: auto;
    font-size: 35px;
    text-align: center;                   

}

.error_box{
    padding:4px;
    border: 1px solid grey;
    background-color: lightgrey;
    height:20px;
    width:250px;
    margin-right: auto;
    margin-left: auto;
    text-align: center;
}

</style>

<body>
<br>
<br>
<div class="weather_form">
<div class="h_s"> 
<h1><i><b>Weather Search</b></i></h1> 
</div>
<form method="post" action="<? $_SERVER['PHP_SELF']; ?>"  id="myForm" onsubmit="return validate1();">

<b>Street</b><input type="text" name="street" id="street" value="" style="margin-left: 20px;"><br> 
<b>City</b><input type="text" name="city" id="city" value="" style="margin-left: 30px;"> <br>
<b>State</b>
<select name="state" id="state" style="width: 200px; margin-left: 10px; border-radius: 10px;">
<option value="default" selected>State</option>

<option value="AL">Alabama</option>
<option value="AK">Alaska</option>
<option value="AZ">Arizona</option>
<option value="AR">Arkansas</option>
<option value="CA">California</option>
<option value="CO">Colorado</option>
<option value="CT">Connecticut</option>
<option value="DE">Delaware</option>
<option value="DC">District Of Columbia</option>
<option value="FL">Florida</option>
<option value="GA">Georgia</option>
<option value="HI">Hawaii</option>
<option value="ID">Idaho</option>
<option value="IL">Illinois</option>
<option value="IN">Indiana</option>
<option value="IA">Iowa</option>
<option value="KS">Kansas</option>
<option value="KY">Kentucky</option>
<option value="LA">Louisiana</option>
<option value="ME">Maine</option>
<option value="MD">Maryland</option>
<option value="MA">Massachusetts</option>
<option value="MI">Michigan</option>
<option value="MN">Minnesota</option>
<option value="MS">Mississippi</option>
<option value="MO">Missouri</option>
<option value="MT">Montana</option>
<option value="NE">Nebraska</option>
<option value="NV">Nevada</option>
<option value="NH">New Hampshire</option>
<option value="NJ">New Jersey</option>
<option value="NM">New Mexico</option>
<option value="NY">New York</option>
<option value="NC">North Carolina</option>
<option value="ND">North Dakota</option>
<option value="OH">Ohio</option>
<option value="OK">Oklahoma</option>
<option value="OR">Oregon</option>
<option value="PA">Pennsylvania</option>
<option value="RI">Rhode Island</option>
<option value="SC">South Carolina</option>
<option value="SD">South Dakota</option>
<option value="TN">Tennessee</option>
<option value="TX">Texas</option>
<option value="UT">Utah</option>
<option value="VT">Vermont</option>
<option value="VA">Virginia</option>
<option value="WA">Washington</option>
<option value="WV">West Virginia</option>
<option value="WI">Wisconsin</option>
<option value="WY">Wyoming</option>

</select>
<br>


<input type="hidden" name="current_here" value="0">
<div class="current">
<input type="checkbox" name="current_here" value="1" onclick="here()" id="current_here"><b>Current Location </b></div>
<input type="submit" value="search" id="submit" onsubmit="return validate1();">
<input type="hidden" name="here_lat" value="" id="here_lat">
<input type="hidden" name="here_Long" value=""  id="here_Long">
<input type="hidden" name="here_city" value=""  id="here_city">

<input type="button" value="clear" onclick="clear_values()">
<div class="vl"></div>
</form>
</div>

<p id="error"></p>
<p id="first-card"></p>
<div><p id="tables"></p></div>
<p id="details"></p>
<p id="show_graph"></p>
<p id="hide_graph"></p>

    <div id="curve_chart" style="width: 900px; height: 250px; margin-left: auto; margin-right: auto;"></div>

<!-- ----------------------------------------------------- end of HTML----------------------------------------------- -->


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
function validate1(){
    street_val=document.getElementById("street").value;
    city_val=document.getElementById("city").value;
    state_val=document.getElementById("state").value;
    current_val=document.getElementById("current_here").checked;
    if(current_val==true){
        document.getElementById("error").innerHTML="";
    }
    else{    
        if(street_val!="" && city_val!="" && state_val!="default"){
            document.getElementById("error").innerHTML="";}
        else{
            error_text="<div class='error_box'> Please check the input address. </div>";
            document.getElementById("error").innerHTML=error_text;
            return false;
        }
    }
    return true;
}
function here(){
    document.getElementById("street").value = "";
    document.getElementById("city").value = "";
    document.getElementById("state").value = "default";
    document.getElementById("street").disabled = true;
    document.getElementById("city").disabled = true;
    document.getElementById("state").disabled = true;


    // alert("wohooooooooo")
    var xmlhttp;
    document.getElementById("submit").disabled = true;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET", "http://ip-api.com/json", false);
    xmlhttp.send();
        
    if (xmlhttp.readyState == 4 && xmlhttp.status==200 )
    {
        var jsonObj = JSON.parse(xmlhttp.responseText);
        document.getElementById("here_city").value=jsonObj.city;
        // document.write("Hereeeeeeeeee city"+jsonObj.city);
        document.getElementById("here_lat").value=jsonObj.lat;
        document.getElementById("here_Long").value=jsonObj.lon;
        // console.log("i m in here===============");
        document.getElementById("current_here").checked = true;
        document.getElementById("submit").disabled = false;
    }
}

<?php
if(isset($_POST['state'])):
?>
    document.getElementById('state').value = "<?php echo $_POST['state'];?>";
    localStorage.setItem('state',document.getElementById("state").value);
<?php
endif;
?>
<?php
if(isset($_POST['street'])):
?>
    document.getElementById("street").value = "<?php echo htmlentities($_POST['street']); ?>";
    localStorage.setItem('street',document.getElementById("street").value);
<?php
endif;
?>
<?php
if(isset($_POST['city'])):
?>
    document.getElementById("city").value = "<?php echo htmlentities($_POST['city']); ?>";
    localStorage.setItem('city',document.getElementById("city").value);
<?php
endif;
?>
<?php
if(($_POST['current_here'])=="1"):
?>
    document.getElementById("current_here").checked =true;
    localStorage.setItem('current_here',document.getElementById("current_here").checked);
    document.getElementById("street").disabled =true;
    localStorage.setItem('street',document.getElementById("street").disabled);
    document.getElementById("city").disabled =true;
    localStorage.setItem('city',document.getElementById("city").disabled);
    document.getElementById("state").disabled =true;
    localStorage.setItem('state',document.getElementById("state").disabled);
<?php
endif;
?>
// document.write(<?php $json_elements?>)
json_obj=<?php echo json_encode($json_elements) ?>;
daily_details=<?php echo json_encode($json_daily_details) ?>;
latt = <?php echo json_encode($get_Latitude) ?>;
logg = <?php echo json_encode($get_Longitude)?>;
// dat = <?php echo json_encode($date)?>;
var in_city="<?php echo $out_city ?>";
var in_timezone="<?php echo $out_timezone ?>";

var in_temperature="<?php echo $out_temperature ?>";
var in_temperature_url="<?php echo $out_temperature_url ?>";

var in_summary="<?php echo $out_summary ?>";

var in_humidity="<?php echo $out_humidity ?>";
var in_humidity_url="<?php echo $out_humidity_url ?>";

var in_pressure="<?php echo $out_pressure ?>";
var in_pressure_url="<?php echo $out_pressure_url ?>";

var in_wind_speed="<?php echo $out_wind_speed ?>";
var in_wind_speed_url="<?php echo $out_wind_speed_url ?>";

var in_visibility="<?php echo $out_visibility ?>";
var in_visibility_url="<?php echo $out_visibility_url ?>";

var in_cloud_cover="<?php echo $out_cloud_cover ?>";
var in_cloud_cover_url="<?php echo $out_cloud_cover_url ?>";

var in_ozone="<?php echo $out_ozone ?>";
var in_ozone_url="<?php echo $out_ozone_url ?>";

var dat = <?php echo json_encode($date); ?>;
var stat = <?php echo json_encode($status); ?>;
var summ = <?php echo json_encode($summary); ?>;
var temp_h = <?php echo json_encode($temp_high); ?>;
var temp_l = <?php echo json_encode($temp_low); ?>;
var wind_s = <?php echo json_encode($wind_speed); ?>;
// document.write("writeeeeeee dat"+dat)
<!-- Displays search table------------------------------------------------------------------------------------------------------------------------ -->
function today_weather(){
    card_text="<div class='first_card'>";
    card_text+="<div class='f_city'>"+in_city+"</div><br>";
    card_text+="<div class='f_tzone'>"+in_timezone+"</div><br>";
    card_text+="<div class='f_temp'>"+in_temperature;
    card_text+="<img class='first_temp' src="+in_temperature_url+"></img><div class='f'>F</div></div><br>";
    card_text+="<div class='f_summ'>"+in_summary+"</div><br>";

    card_text+="<table class='f_table'><tr>";
    card_text+="<th><img class='f_table' src="+in_humidity_url+" title='Humidity'></img></th>";
    card_text+="<th><img class='f_table' src="+in_pressure_url+" title='Pressure'></img></th>";
    card_text+="<th><img class='f_table' src="+in_wind_speed_url+" title='Wind Speed'></img></th>";
    card_text+="<th><img class='f_table' src="+in_visibility_url+" title='Visibility'></img></th>";
    card_text+="<th><img class='f_table' src="+in_cloud_cover_url+" title='Cloud Cover'></img>";
    card_text+="<th><img class='f_table' src="+in_ozone_url+" title='Ozone'></img></th></tr>";
    // // card_text+="</div>"
    card_text+="<tr>";
    card_text+="<td><div class='txt_humid'>"+in_humidity+"</div></td>";
    card_text+="<td><div class='txt_press'>"+in_pressure+"</div></td>";
    card_text+="<td><div class='txt_wind'>"+in_wind_speed+"</div></td>";
    card_text+="<td><div class='txt_visib'>"+in_visibility+"</div></td>";
    card_text+="<td><div class='txt_cloud'>"+in_cloud_cover+"</div></td>";
    card_text+="<td><div class='txt_ozone'>"+in_ozone+"</div></td></tr></table>";
   

    document.getElementById("first-card").innerHTML=card_text;

    html_text = "<table class='daily' border='1'>";
    html_text+= "<tbody>";
    html_text+= "<tr>";
    html_text+= "<th>Date</th>";
    html_text+= "<th>Status</th>";
    html_text+= "<th>Summary</th>";
    html_text+= "<th>TemperatureHigh</th>";
    html_text+= "<th>TemperatureLow</th>";
    html_text+= "<th>Wind Speed</th>";
    html_text+= "</tr>";

    for(var i=0; i<8; i++){
        // document.write(i)
        yr=new Date(dat[i]*1000).getFullYear();
        mon=new Date(dat[i]*1000).getMonth() +1;
        mon= mon<10? "0"+mon : mon;
        day=new Date(dat[i]*1000).getDate();
        day= day<10? "0"+day : day;
        my_date=yr+"-"+mon+"-"+day;
        html_text+= "<td>"+my_date+ "<br>";
        // alert(json_obj.daily[i])
        pic=stat[i]
        if(pic=="clear-day"||pic=="clear-night")
            url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-12-512.png";
        if(pic=="rain")
            url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-04-512.png";
        if(pic=="snow")
            url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-19-512.png";
        if(pic=="sleet")
            url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-07-512.png";
        if(pic=="wind")
            url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-27-512.png";
        if(pic=="fog")
            url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-28-512.png";
        if(pic=="cloudy")
            url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-01-512.png";
        if(pic=="partly-cloudy-day"||pic=="partly-cloudy-night")
            url="https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-02-512.png";

        html_text+= "<td><center><img class='table_icon' src='"+url+"'height=40px/></center></td>";

        html_text+= "<td><a onclick='daily_weather("+i+")'>"+summ[i]+"</a></td>";
        html_text+="<td>"+temp_h[i]+"</td>";
        html_text+="<td>"+temp_l[i]+"</td>";
        html_text+="<td>"+wind_s[i]+"</td>";    
        
        html_text+= "</tr>";
    }
        html_text += "</tbody>";
        html_text += "</table>";
        document.getElementById("tables").innerHTML = html_text;
}
    

<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($json_elements['daily'])):
?>
    today_weather();
    
<?php
endif;
?>

<!---------------------------------------- function to reset values ------------------------------------------------------>

function clear_values() 
{
    document.getElementById('myForm').reset();
    document.getElementById('street').value = "";
    document.getElementById('city').value = "";
    document.getElementById('state').value = "default";
    document.getElementById('street').disabled = false;
    document.getElementById('city').disabled = false;
    document.getElementById('state').disabled = false;
    document.getElementById('current_here').checked = false;
    document.getElementById("error").innerHTML="";
    document.getElementById("tables").innerHTML = "";
    document.getElementById('details').innerHTML = "";
    document.getElementById('show_graph').innerHTML = "";
    document.getElementById('hide_graph').innerHTML = "";
    document.getElementById("first-card").innerHTML="";
    document.getElementById("second-card").innerHTML="";
    document.getElementById("curve_chart").innerHTML = "";

}

function daily_weather(s){

    document.getElementById('first-card').innerHTML="";
    document.getElementById('tables').innerHTML="";
    document.body.scrollTop = document.documentElement.scrollTop = 0;
    var sec_summ=<?php echo json_encode($sec_summary); ?>;
    var sec_temp=<?php echo json_encode($sec_temperature); ?>;
    var sec_pict=<?php echo json_encode($sec_icon); ?>;
    if(sec_pict[s]=="clear-day"||sec_pict[s]=="clear-night")
        var url="https://cdn3.iconfinder.com/data/icons/weather-344/142/sun-512.png";
    if(sec_pict[s]=="rain")
        var url="https://cdn3.iconfinder.com/data/icons/weather-344/142/rain-512.png";
    if(sec_pict[s]=="snow")
        var url="https://cdn3.iconfinder.com/data/icons/weather-344/142/snow-512.png";
    if(sec_pict[s]=="sleet")
        var url="https://cdn3.iconfinder.com/data/icons/weather-344/142/lightning-512.png";
    if(sec_pict[s]=="wind")
        var url="https://cdn4.iconfinder.com/data/icons/the-weather-is-nice-today/64/weather_10-512.png";
    if(sec_pict[s]=="fog")
        var url="https://cdn3.iconfinder.com/data/icons/weather-344/142/cloudy-512.png";
    if(sec_pict[s]=="cloudy")
        var url="https://cdn3.iconfinder.com/data/icons/weather-344/142/cloud-512.png";
    if(sec_pict[s]=="partly-cloudy-day"||sec_pict[s]=="partly-cloudy-night")
        var url="https://cdn3.iconfinder.com/data/icons/weather-344/142/sunny-512.png";
    
    var sec_precip=<?php echo json_encode($sec_precipitation); ?>;
    var precipValue="";
    if(sec_precip[s]<=0.001)
        var precipValue="None";
    else if(sec_precip[s]<=0.015)
        var precipValue="Very Light";
    else if(sec_precip[s]<=0.05)
        var precipValue="Light";
    else if(sec_precip[s]<=0.1)
        var precipValue="Moderate";
    else
        var precipValue="Heavy";

    var sec_chanceRain=(<?php echo json_encode($sec_chance); ?>);
    var sec_windspeed=<?php echo json_encode($sec_wind_speed); ?>;
    var sec_humid=(<?php echo json_encode($sec_humidity); ?>);
    var sec_visib=<?php echo json_encode($sec_visibility); ?>;
    var sec_sunrise=<?php echo json_encode($sec_sunriseTime); ?>;
    var sec_sunset=<?php echo json_encode($sec_sunsetTime); ?>;

    sunrise_hour=new Date(sec_sunrise[s]*1000).getHours();
    rise_hour= sunrise_hour<12? sunrise_hour+" ": sunrise_hour-12;
    rise_ap=sunrise_hour<12? "AM": "PM";
    sunset_hour=new Date(sec_sunset[s]*1000).getHours();
    set_hour= sunset_hour<12? sunset_hour: sunset_hour-12 +" ";
    set_ap=sunset_hour<12? "AM": "PM";
    sun=rise_hour+" "+rise_ap+"/ "+set_hour+" "+set_ap;
    detailText="<p class='head'>Daily Weather Details</p>";
    detailText+="<div class='second_card'>";
    detailText+="<img class='second_card' src="+url+">";
    detailText+="<div class='s_summ'>"+sec_summ[s]+"</div><br>";
    detailText+="<div class='s_temp'>"+sec_temp[s];
    detailText+="<img class='first_temp' src="+in_temperature_url+"></img><div class='s'>F</div></div><br>"
    detailText+="<table class='s_table'>";
    detailText+="<tr><th style='text-align:right;'>Precipitation: </th><td>"+precipValue+"</td></tr>";
    detailText+="<tr><th style='text-align:right;'>Chance of Rain: </th><td><div class='front'>"+sec_chanceRain[s]+"</div><div class='side'> %</div></td></tr>";
    detailText+="<tr><th style='text-align:right;'>Wind Speed: </th><td><div class='front'>"+sec_windspeed[s]+"</div><div class='side'> mph</div></td></tr>";
    detailText+="<tr><th style='text-align:right;'>Humidity: </th><td><div class='front'>"+sec_humid[s]+"</div><div class='side'> %</div></td></tr>";
    detailText+="<tr><th style='text-align:right;'>Visibility: </th><td><div class='front'>"+sec_visib[s]+"</div><div class='side'> mi</div></td></tr>";
    detailText+="<tr><th style='text-align:right;'>Sunrise / Sunset: </th><td><div class='front'>"+rise_hour+" "+"</div><div class='side'>"+rise_ap+"/ "+"</div><div class='front'>"+set_hour+" "+"</div><div class='side'> "+set_ap+"</div></td></tr>";
    detailText+="</table></div>"
    // detailText+="<font>"+sunrise_hour+"/"+sunset_hour+"</font>";

    document.getElementById('details').innerHTML=detailText;
        
    <!-- ----------------------------------------------------------------------------------------------------------- -->
    // google.charts.load('current', {'packages':['corechart']});
    // google.charts.setOnLoadCallback(drawChart);
    showVenueInfo = "<p style='size:50px; margin-left:auto; margin-right:auto;'>Day's Hourly Weather<br></p>";
    showVenueInfo += "<img class='arrow' src='https://cdn4.iconfinder.com/data/icons/geosm-e-commerce/18/point-down-512.png' height='20px'>";
    document.getElementById("show_graph").innerHTML = showVenueInfo;
    // document.getElementById("curve_chart").style.display = "none";
    document.getElementById('show_graph').onclick =  function() {

    var hour_data=<?php echo json_encode($hour); ?>;

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
                console.log("charrrttttttttttttttttttttt")

        var data = google.visualization.arrayToDataTable([
          ['Time', 'T'],
          [0,  hour_data[0]],
          [1,  hour_data[1]],
          [2,  hour_data[2]],
          [3,  hour_data[3]],
          [4,  hour_data[4]],
          [5,  hour_data[5]],
          [6,  hour_data[6]],
          [7,  hour_data[7]],
          [8,  hour_data[8]],
          [9,  hour_data[9]],
          [10,  hour_data[10]],
          [11,  hour_data[11]],
          [12,  hour_data[12]],
          [13,  hour_data[13]],
          [14,  hour_data[14]],
          [15,  hour_data[15]],
          [16,  hour_data[16]],
          [17,  hour_data[17]],
          [18,  hour_data[18]],
          [18,  hour_data[19]],
          [20,  hour_data[20]],
          [21,  hour_data[21]],
          [22,  hour_data[22]],
          [23,  hour_data[23]]]);

        var options = {
            hAxis: {
            title: 'Time',
            titleTextStyle: {
                fontSize: 12,
                bold: true,
                italic: true
                }
            },
            vAxis: {
            title: 'Popularity',
            titleTextStyle: {
                fontSize: 12,
                bold: true,
                italic: true
                }
            },
            colors:['#8BD2D5'],
            curveType: 'function',
            legend: { position: 'right' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }


        hideVenueInfo = "<p style='size:50px; margin-left:auto; margin-right:auto;'>Day's Hourly Weather<br></p>";
        hideVenueInfo += "<img class='arrow' src='https://cdn0.iconfinder.com/data/icons/navigation-set-arrows-part-one/32/ExpandLess-512.png' height='20px'>";
        document.getElementById("show_graph").innerHTML = "";
        document.getElementById("hide_graph").innerHTML = hideVenueInfo;
    }
        
        document.getElementById('hide_graph').onclick =  function() {
        document.getElementById("hide_graph").innerHTML = "";
        document.getElementById("show_graph").innerHTML = showVenueInfo;
        document.getElementById("curve_chart").innerHTML = "";


        }   

    //     }
    //     else{
    //         document.getElementById("curve_chart").style.display = "none";
    //         document.getElementById("show_graph").innerHTML = showVenueInfo;
    //     }  
    // }        
}

</script>

</body>
</html>
