<?php 
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 'on');

?> 
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<title>OLG Basel &ndash; Autoapp</title>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">

<link rel="stylesheet" href="css/layouts/blog.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
var space =parseInt("<?php echo $_POST['space']; ?>");
var count=2;
function addMore() {
    if(count<space){
    document.getElementById("collegue").innerHTML = document.getElementById("collegue").innerHTML+'<div class="pure-control-group"><label for="name">'+count+'.Mitfahrer </label><input id="name" type="text"  placeholder="" name="name'+count+'"></input></div>';
    count++;
    }
    else{
      document.getElementById("collegue").innerHTML = document.getElementById("collegue").innerHTML+'<div class="pure-control-group"><label for="name">'+count+'.Mitfahrer </label><input id="name" type="text"  placeholder="" name="name'+count+'"></input></div>';
      document.getElementById("button").innerHTML = "";
    }
}
</script>
<script>
$('document').ready(function(){
    window_size = $(window).height();
  //alert(window_size);
    document.getElementById("layout").style.minHeight = window_size+'px';
});
</script>

</head>
<body>

<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <?php 
            require_once('configuration.php');
            echo '<a href="'.$baseLink.'/"><h1 class="brand-title">Mitfahren</h1></a>';
            ?>
            <h2 class="brand-tagline">Eine Platform für Autofahrer und das Klima</h2>
			</br>
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
			<div style="  text-align: left;">
			<form class="pure-form pure-form-aligned" action="registerCarSend.php" method="post">
		  <fieldset>
			<div class="pure-control-group">
			<label for="name">1.Mitfahrer</label>
			<input id="name" type="text"  placeholder="Jannis Schönleber" name="name1"></input>
		  </div>
      <div id="collegue" style="margin-left: 5px;"></div>
      <div class="pure-control-group" id="button">
      <a class="pure-button" onclick="addMore()">Mehr Mitfahrer</a>
      </div>
      

			<div class="pure-control-group">
				<label for="state">Frühste Startzeit</label>
				<select id="state" name="starttimeHour">
                <option value="00">00</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
            </select>
            <select id="state" name="starttimeMinute">
                <option value="00">00</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
                <option value="32">32</option>
                <option value="33">33</option>
                <option value="34">34</option>
                <option value="35">35</option>
                <option value="36">36</option>
                <option value="37">37</option>
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
                <option value="45">45</option>
                <option value="46">46</option>
                <option value="47">47</option>
                <option value="48">48</option>
                <option value="49">49</option>
                <option value="50">50</option>
                <option value="51">55</option>
                <option value="52">52</option>
                <option value="53">53</option>
                <option value="54">54</option>
                <option value="55">55</option>
                <option value="56">56</option>
                <option value="57">57</option>
                <option value="58">58</option>
                <option value="59">59</option>
            </select>
			</div>
      <input name="carId" type="hidden" value=<?php echo $_POST['carId']?>></input> 
      <input name="space" type="hidden" value=<?php echo $_POST['space']?>></input>
			<div class="pure-controls">
				<button type="submit" class="pure-button pure-button-primary">Submit</button>
			</div>
			</fieldset>
			</form>
			
        </div>
    </div>
</div>

</body>
</html>
