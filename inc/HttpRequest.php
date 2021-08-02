<?php
class HttpRequest {
	
	public function query($url, $postData = [], $cookie = '', $headers = false)
	{
		$curl = curl_init();
		$rHeaders = [];
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
		curl_setopt($curl, CURLOPT_REFERER, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADERFUNCTION,
			function($curl, $header) use (&$rHeaders) {
				$len = strlen($header);
				$header = explode(':', $header, 2);
				if(count($header) < 2) {
					return $len;
				}
				$rHeaders[strtolower(trim($header[0]))][] = trim($header[1]);
				return $len;
			}
		);
		if(!empty($postData)) {
			curl_setopt($curl, CURLOPT_POST, 1);
            if(is_array($postData)) {
			    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
            } else {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
            }
		}
		if($cookie) {
			curl_setopt($curl, CURLOPT_COOKIE, $cookie);
		}
		if($headers) {
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		}
		$data = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if(curl_errno($curl)) {
			$httpCode = curl_error($curl);
		}
		curl_close($curl);
		return new HttpResponse($httpCode, $rHeaders, $data);
	}
}
