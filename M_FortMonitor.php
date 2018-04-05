<?php
define("FM_ULR", "https://web.fort-monitor.ru");
define("FM_UTC", 2);

class M_FortMonitor {
	private $base_url;

	public function __construct($url) {
		$this->base_url = $url . "/api/Api.svc/";
	}

	public function __call($name, $args) {
		return $this->request($name, count($args) === 0 ? array() : $args[0]);
	}

	public function request($name, $args) {
		$ch = curl_init($this->base_url . $name . "?" . http_build_query($args));

		curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER["DOCUMENT_ROOT"] . '/tmp/cookies' . $_SESSION["user_id"] . '.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, $_SERVER["DOCUMENT_ROOT"] . '/tmp/cookies' . $_SESSION["user_id"] . '.txt');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		curl_close($ch);

		return json_decode($result, true);
	}
}
