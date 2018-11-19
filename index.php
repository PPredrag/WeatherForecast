<?php include 'weather.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    	<meta name="author" content="Predrag Pandza">
	    <link rel="icon" type="image/png" sizes="32x32" href="images/vreme.png">
		<title>Weather</title>

		<!-- Loading third party fonts -->
		<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- Loading main css file -->
		<link rel="stylesheet" href="style.css">
		
	</head>
	<body>

		<div class="site-content">
			<div class="site-header">
				<div class="container">
					<a href="#" class="branding">
						<img src="images/logo.png" alt="" class="logo">
						<div class="logo-type">
							<h1 class="site-title">Weather</h1>
							<small class="site-description">weather API openweathermap.org</small>
						</div>
					</a>

					<!-- Default snippet for navigation -->
					<div class="main-navigation">
						<button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
						<ul class="menu">
							<li class="menu-item"><a href="http://predragpandza.com/">Back</a></li>
						</ul> <!-- .menu -->
					</div> <!-- .main-navigation -->

					<div class="mobile-navigation"></div>
					<div class="small-mobile"></div>

				</div>
			</div> <!-- .site-header -->

			<div class="hero" data-bg-image="images/backGround.jpg">
				<div class="container">
					<form action="index.php" class="find-location" method="GET">
						<input type="text" name="city" placeholder="Find your location...">
						<input type="submit" value="Find">
					</form>

				</div>
			</div>
			<div class="forecast-table">
				<div class="container">
					<div class="forecast-container">
						<div class="today forecast">
							<div class="forecast-header">
								<div class="day">Now&nbsp;&nbsp;<span id="timer"></span></div>
								<div class="date"><?= $fiveDayWeather->list[0]->dt_txt ?></div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="location"><?= $currentWeather->name." ".$currentWeather->sys->country."&nbsp;&nbsp;&nbsp; ".ucfirst($currentWeather->weather[0]->description)?></div>
								<div class="degree">
									<div class="num"><?= $currentWeather->main->temp ?><sup>o</sup>C</div>
									<div class="forecast-icon">
										<img src="images/icons/<?= $currentWeather->weather[0]->icon ?>.png" alt="" width=80; class="ikonica">
									</div>	
								</div>
								<br>
								<span ><img src="images/icon-pressure.png" alt="Air Pressure"><?= $currentWeather->main->pressure ?> hPa</span>
								<span><img src="images/icon-wind.png" alt="Wind"><?= $currentWeather->wind->speed ?>m/s</span>
								
								<span><img src="images/icon-humidity.png" alt="Humidity"><?= $currentWeather->main->humidity ?>%</span><br><br>

								<span><img src="images/icon-sunrise.png" alt="Sunrise"><?= $currentWeather->sys->sunrise ?></span>
								<span><img src="images/icon-sunset.png" alt="Sunset"><?= $currentWeather->sys->sunset ?></span>
								<span><img src="images/icon-visibility.png" alt="Visibility"><?= $currentWeather->visibility ?>m</span>
							
							</div>
						</div>
						<?php 
						foreach($fiveDayWeather->list as $day){
							if($day->hour_txt == '15:00:00'){ ?>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day"><?= $day->day_txt ?></div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<img src="images/icons/<?= $day->weather[0]->icon ?>.png" alt="" width=70>
								</div>
								<div class="day"><?= $day->weather[0]->main ?></div>
								<div class="degree"><?= $day->main->temp ?><sup>o</sup>C</div>
							</div>
						</div>
						<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>

			<footer class="site-footer">

			</footer> <!-- .site-footer -->
		</div>
		
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/plugins.js"></script>
		<script src="js/app.js"></script>
		<script src="js/main.js"></script>
		
	</body>

</html>