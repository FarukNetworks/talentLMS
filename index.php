<?php

class TalentLMS
{
  private $apiKey;
  private $domain;
  private $curl;

  public function __construct($apiKey, $domain)
  {
    $this->apiKey = $apiKey;
    $this->domain = $domain;
    $this->curl = curl_init();
  }

  public function fetchUsers()
  {
    $this->setCurlOptions("https://{$this->domain}/api/v1/users");
    $response = json_decode(curl_exec($this->curl));
    curl_close($this->curl);
    return $response;
  }

  public function fetchCourses()
  {
    $this->setCurlOptions("https://{$this->domain}/api/v1/courses");
    $response = json_decode(curl_exec($this->curl));
    curl_close($this->curl);
    return $response;
  }

  private function setCurlOptions($url)
  {
    $opts = array();
    $opts[CURLOPT_HTTPGET] = 1;
    $opts[CURLOPT_URL] = $url;
    $opts[CURLOPT_RETURNTRANSFER] = true;
    $opts[CURLOPT_CONNECTTIMEOUT] = 30;
    $opts[CURLOPT_TIMEOUT] = 80;
    $opts[CURLOPT_USERPWD] = $this->apiKey . ':';
    $opts[CURLOPT_SSL_VERIFYPEER] = false;
    $opts[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
    curl_setopt_array($this->curl, $opts);
  }
}

$MY_API_KEY = 'API_KEY_HERE';
$DOMAIN = 'API_DOMAIN_HERE';


$talentLMS = new TalentLMS($MY_API_KEY, $DOMAIN);
$courses = $talentLMS->fetchCourses();

foreach ($courses as $course) {
  echo $course->name;
  echo '<br>';
}
