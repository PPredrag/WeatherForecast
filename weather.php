<?php 

	class Weather{

		private $city = "Belgrade";
		private $apiKey = "ef7071fde680cdfd4f43112464d89bcd";
		private $units = "metric";

		// Curl
		public function curl($url){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$json_data = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($json_data);
			if($data->cod == '200'){
				return $data;
			}else{
				return false;
			}
		}

		// set Url for fFve Days Weahter
		public function setFiveDayWeatherUrl($city){
			$url = "api.openweathermap.org/data/2.5/forecast?q={$city}&units={$this->units}&appid={$this->apiKey}";
			return $url;
		}

		// get parsed Five Day Weather by City
		public function getFiveDayWeather($city){
			$city = trim(htmlspecialchars(strip_tags($city)));
			$url = $this->setFiveDayWeatherUrl($city);
			$result = $this->curl($url);
			if(!$result){
				$result = $this->getFiveDayWeather($this->city);
			}
			return $result;
		}

		// parse Five Day Weahter
		public function parseFiveDayCurl($data){
			
			foreach($data->list as $temp){
				$temp->main->temp = round($temp->main->temp,0);
				$temp->main->temp_min = round($temp->main->temp_min,0);
				$temp->main->temp_max = round($temp->main->temp_max,0);
				$temp->main->pressure = round($temp->main->pressure,0);
				$temp->wind->speed = round($temp->wind->speed,0);
				$date = explode(" ",$temp->dt_txt);
				$temp->dt_txt = date("jS F Y", strtotime($date[0]));
				$temp->day_txt = date("l", strtotime($date[0]));;
				$temp->hour_txt = $date[1];
			}
			return $data;
		}

		// set Url for Current Weather
		public function setCurrentWeatherUrl($city){
			$url = "api.openweathermap.org/data/2.5/weather?q={$city}&units={$this->units}&appid={$this->apiKey}";
			//var_dump($url);
			return $url;
		}

		// get Current Weather by City
		public function getCurrentWeather($city){
			$city = trim(htmlspecialchars(strip_tags($city)));
			$url = $this->setCurrentWeatherUrl($city);
			$result = $this->curl($url);
			if(!$result){
				$result = $this->getCurrentWeather($this->city);
			}
			$result->main->temp = round($result->main->temp,0);
			$result->sys->sunrise = $this->parseSunsetSunrise($result->sys->sunrise);
			$result->sys->sunset = $this->parseSunsetSunrise($result->sys->sunset);
			return $result;
		}

		// set Sunrise/Sunset format
		public function parseSunsetSunrise($date){
			if(is_numeric($date)){
				$rawDate = date('H:i:s', $date);
				$formatedDate = new DateTime($rawDate);
				$formatedDate->modify("+2 hours");
				$result = $formatedDate->format("H:i:s");
			}else{
				$result = $date;
			}
			return $result;
		}


		// get Current UV Index 
		public function getCurrentUVIndex($lat, $lon){
			$url = "api.openweathermap.org/data/2.5/uvi?lat={$lat}&lon={$lon}&units={$this->units}&appid={$this->apiKey}";
			$result = $this->curlUVIndex($url);
			$result = $result->value;
			return $result;
		}

		// Curl UV Index
		public function curlUVIndex($url){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$json_data = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($json_data);
			$data->value = round($data->value,0);
			return $data;
		}

	}

	$weather = new Weather();
	isset($_GET['city'])?$city=$_GET['city']:$city="";
	$getFiveDayWeather = $weather->getFiveDayWeather($city);
	$fiveDayWeather = $weather->parseFiveDayCurl($getFiveDayWeather);
	$currentWeather = $weather->getCurrentWeather($city);
	$lat = $currentWeather->coord->lat;
	$lon = $currentWeather->coord->lon;
	$uvIndex = $weather->getCurrentUVIndex($lat,$lon);

?>