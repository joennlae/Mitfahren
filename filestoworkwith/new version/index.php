<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="A layout example that shows off a blog page with a list of posts.">

    <title>OLG Basel &ndash; Autoapp</title>

<script src="http://maps.googleapis.com/maps/api/js">
</script>  

<script>
function initialize()
{
  var mapProp = {
    center: new google.maps.LatLng(51.508742,-0.120850),
    zoom:9,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var mapProp2 = {
    center: new google.maps.LatLng(51.508742,-0.120850),
    zoom:9,
    mapTypeId: google.maps.MapTypeId.SATELLITE
  };
  var mapProp3 = {
    center: new google.maps.LatLng(51.508742,-0.120850),
    zoom:9,
    mapTypeId: google.maps.MapTypeId.HYBRID
  };
  var mapProp4 = {
    center: new google.maps.LatLng(51.508742,-0.120850),
    zoom:9,
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };
  var map0 = new google.maps.Map(document.getElementById("googleMap0"),mapProp);
  var map1 = new google.maps.Map(document.getElementById("googleMap1"),mapProp2);
  var map2 = new google.maps.Map(document.getElementById("googleMap2"),mapProp3);
  var map3 = new google.maps.Map(document.getElementById("googleMap3"),mapProp4);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
  
<link rel="stylesheet" href="css/layouts/blog.css">
</head>
<body>

<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <h1 class="brand-title">Mitfahren?</h1>
            <h2 class="brand-tagline">Eine Platform für Autofahrer und das Klima</h2>

            <nav class="nav">
                <ul class="nav-list">
                    <!--<li class="nav-item">
                        <a class="pure-button" href="/login">Anmelden</a>
                    </li>-->
                    <li class="nav-item">
                        <a class="pure-button" href="register.php">Registrieren</a>
                    </li>
                </ul>
            </nav>
			</br>
			<form class="pure-form pure-form-stacked" style="display: inline-block;">
					<label for="email"></label>
					<input id="email" type="email" placeholder="Username or email" name="email"> <!-- can also be username!!-->

					<label for="password"></label>
					<input id="password" type="password" placeholder="Password" name="password">

					<label for="remember" class="pure-checkbox">
						<input id="remember" type="checkbox"> Remember me
					</label>

					<button type="submit" class="pure-button pure-button-primary">Sign in</button>
			</form>
			
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
        <div style="text-align: right;">

            <a class="pure-button button-new" nhref="/new">+</a>
            <!-- A wrapper for all the blog posts -->
            <div class="posts">
				<?php 
					for ($x = 0; $x <= 3; $x++) {
					echo <<<END
					<h1 class="content-subhead">Neustes Auto</h1>

					<section class="post">
						<header class="post-header">
							<h2 class="post-title">Fam. Hohl</h2>
							<div>
							<p class="post-meta">
                            <a href="#" class="post-author"></a><a class="post-category post-category-design" href="#">4.Nat</a> <a class="post-category post-category-pure" href="#">retour</a>
							</p>
							</div>
						</header>

                    <div class="post-description">
							<div class="buttons">
							<a class="pure-button button-space" href="#">2 Plätze Frei</a>
							<a class="pure-button button-space" href="#">12:04</a>
							</div>
							<div class="map" id="googleMap$x" style="width:300px;height:150px;"></div>
						</div>
					</section>
				

END;
				} 
				?>
			</div>
                <!--<h1 class="content-subhead">Neustes Auto</h1>

                <!-- A single blog post -->
                <!--<section class="post">
                    <header class="post-header">
                        <h2 class="post-title">Fam. Hohl</h2>
						<div>
                        <p class="post-meta">
                            <a href="#" class="post-author"></a><a class="post-category post-category-design" href="#">4.Nat</a> <a class="post-category post-category-pure" href="#">retour</a>
                        </p>
						</div>
                    </header>

                    <div class="post-description">
							<div class="buttons">
							<a class="pure-button button-space" href="#">2 Plätze Frei</a>
							<a class="pure-button button-space" href="#">12:04</a>
							</div>
							<div class="map" id="googleMap" style="width:300px;height:150px;"></div>
                    </div>
                </section>
            </div>

            <div class="posts">
                <h1 class="content-subhead">Nächster Event</h1>

                <section class="post">
                    <header class="post-header">
                        <h2 class="post-title">Fam. Hohl</h2>
						<div>
                        <p class="post-meta">
                            <a href="#" class="post-author"></a><a class="post-category post-category-design" href="#">4.Nat</a> <a class="post-category post-category-pure" href="#">retour</a>
                        </p>
						</div>
                    </header>

                    <div class="post-description">
							<div class="buttons">
							<a class="pure-button button-space" href="#">2 Plätze Frei</a>
							<a class="pure-button button-space" href="#">12:04</a>
							</div>
							<div class="map" id="googleMap2" style="width:300px;height:150px;"></div>
                    </div>
                </section>

                <!--<section class="post">
                    <header class="post-header">
                        <img class="post-avatar" alt="Reid Burke&#x27;s avatar" height="48" width="48" src="img/common/reid-avatar.png">

                        <h2 class="post-title">Photos from CSSConf and JSConf</h2>

                        <p class="post-meta">
                            By <a class="post-author" href="#">Reid Burke</a> under <a class="post-category" href="#">Uncategorized</a>
                        </p>
                    </header>

                    <div class="post-description">
                        <div class="post-images pure-g">
                            <div class="pure-u-1 pure-u-md-1-2">
                                <a href="http://www.flickr.com/photos/uberlife/8915936174/">
                                    <img alt="Photo of someone working poolside at a resort"
                                         class="pure-img-responsive"
                                         src="http://farm8.staticflickr.com/7448/8915936174_8d54ec76c6.jpg">
                                </a>

                                <div class="post-image-meta">
                                    <h3>CSSConf Photos</h3>
                                </div>
                            </div>

                            <div class="pure-u-1 pure-u-md-1-2">
                                <a href="http://www.flickr.com/photos/uberlife/8907351301/">
                                    <img alt="Photo of the sunset on the beach"
                                         class="pure-img-responsive"
                                         src="http://farm8.staticflickr.com/7382/8907351301_bd7460cffb.jpg">
                                </a>

                                <div class="post-image-meta">
                                    <h3>JSConf Photos</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>-->

                <!--<section class="post">
                    <header class="post-header">
                        <h2 class="post-title">Fam. Hohl</h2>
						<div>
                        <p class="post-meta">
                            <a href="#" class="post-author"></a><a class="post-category post-category-design" href="#">4.Nat</a> <a class="post-category post-category-pure" href="#">retour</a>
                        </p>
						</div>
                    </header>

                    <div class="post-description">
							<div class="buttons">
							<a class="pure-button button-space" href="#">2 Plätze Frei</a>
							<a class="pure-button button-space" href="#">12:04</a>
							</div>
							<div class="map" id="googleMap3" style="width:300px;height:150px;"></div>
                    </div>
                </section>-->
            <!--</div>-->

        </div>
    </div>
</div>






</body>
</html>
