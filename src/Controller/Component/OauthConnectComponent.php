<?php

namespace GintonicCMS\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;


class OauthConnectComponent extends Component
{
	public $client_id;
	public $client_secret;
	public $scope;
	public $responseType = "code";
	public $nonce;
	public $state;
	public $redirect_uri;
	public $code;
	public $oauth_version = "2.0";
	public $provider;
	public $accessToken;
	public $approval_prompt = "force";
	
	protected $requestUrl;
	protected $accessTokenUrl;
	protected $dialogUrl;
	protected $userProfileUrl;
	protected $header;
    
    
	public function initialize(array $config)
	{
		parent::initialize($config);
	}

    public function setSocial()
    {
    	$this->nonce = time() . rand();
  		switch($this->provider){
			case '';
				break;
			case 'Facebook':
				$this->dialogUrl = 'https://www.facebook.com/dialog/oauth?';
				$this->accessTokenUrl = 'https://graph.facebook.com/oauth/access_token';
				$this->userProfileUrl = "https://graph.facebook.com/me/?";
				$this->header="";
		        $this->client_id = Configure::read('Social.Facebook.consumer_key');
		        $this->client_secret = Configure::read('Social.Facebook.consumer_secret');
		        $this->scope = 'email';
				break;
			case 'Google':	
				if($this->approval_prompt == 'auto' || $this->approval_prompt == 'force')
					$this->dialogUrl = 'https://accounts.google.com/o/oauth2/auth?approval_prompt='.$this->approval_prompt.'&';
				else 
					$this->dialogUrl = 'https://accounts.google.com/o/oauth2/auth?';
				$this->accessTokenUrl = 'https://accounts.google.com/o/oauth2/token';
				$this->userProfileUrl = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=";
				$this->header="Authorization: Bearer ";	
				$this->scope = 'email profile';
		        $this->client_id = Configure::read('Social.Google.consumer_key');
		        $this->client_secret = Configure::read('Social.Google.consumer_secret');
				break;
			case 'Microsoft':		
				$this->dialogUrl = 'https://login.live.com/oauth20_authorize.srf?';
				$this->accessTokenUrl = 'https://login.live.com/oauth20_token.srf';
				$this->userProfileUrl = "https://apis.live.net/v5.0/me?access_token=";
				$this->header="";
				break;
			case 'Box':		
				$this->dialogUrl = 'https://www.box.com/api/oauth2/authorize?';
				$this->accessTokenUrl = 'https://www.box.com/api/oauth2/token?';
				$this->userProfileUrl = "https://api.box.com/2.0/users/me?oauth_token=";
				$this->header="Authorization: Bearer ";				
				break;
			case 'WordPress':
				$this->dialogUrl = 'https://public-api.wordpress.com/oauth2/authorize?';
				$this->accessTokenUrl = 'https://public-api.wordpress.com/oauth2/token?';
				$this->scope="";
				$this->state="";
				$this->userProfileUrl = "https://public-api.wordpress.com/rest/v1/me/?pretty=1";
				$this->header="Authorization: Bearer ";
				break;
			case 'Bitly':
				$this->dialogUrl = 'https://bitly.com/oauth/authorize?';
				$this->accessTokenUrl = 'https://api-ssl.bitly.com/oauth/access_token?';
				$this->scope="";
				$this->state="";
				$this->userProfileUrl = "https://api-ssl.bitly.com/v3/user/info?";
				$this->header="";
				break;
			case 'MeetUp':		
				$this->dialogUrl = 'https://secure.meetup.com/oauth2/authorize?';
				$this->accessTokenUrl = 'https://secure.meetup.com/oauth2/access?';
				$this->userProfileUrl = "https://api.meetup.com/2/member/self?access_token=";
				$this->scope="basic";
				break;
			case 'StockTwits':		
				$this->dialogUrl = 'https://api.stocktwits.com/api/2/oauth/authorize?';
				$this->accessTokenUrl = 'https://api.stocktwits.com/api/2/oauth/token?';
				$this->userProfileUrl = "https://api.stocktwits.com/api/2/account/verify.json?access_token=";
				$this->scope="read";
				break;
			
			default:
				return($this->provider .' is not yet a supported. We will release soon. Contact Us' );	
  		}
  		
    }
    
    public function authUrl()
    {
  		if($this->oauth_version == "2.0"){
			return $this->dialogUrl
					."client_id=".$this->client_id
					."&response_type=".$this->responseType
					."&scope=".$this->scope
					."&state=".$this->state
					."&redirect_uri=".urlencode($this->redirect_uri);
		}else{
			$date = new DateTime();
			$request_url = $this->requestUrl;
			$postvals ="oauth_consumer_key=".$this->client_id
     					."&oauth_signature_method=HMAC-SHA1"
     					."&oauth_timestamp=".$date->getTimestamp()
     					."&oauth_nonce=".$this->nonce
     					."&oauth_callback=".$this->redirect_uri
     					."&oauth_signature=".$this->client_secret
     					."&oauth_version=1.0";
			$redirect_url = $request_url."".$postvals;
   			$oauth_redirect_value= $this->curl_request($redirect_url,'GET','');
  			return $this->dialogUrl.$oauth_redirect_value;
		}
		return;
  	}
  	
  	public function getAccessToken(){
		$postvals = "client_id=".$this->client_id
						."&client_secret=".$this->client_secret
						."&grant_type=authorization_code"
						."&redirect_uri=".urlencode($this->redirect_uri)
						."&code=".$this->code;
		
		return $this->curl_request($this->accessTokenUrl,'POST',$postvals);
  	}
  	
  	public function getUserProfile(){
  		$getAccessToken_value = $this->getAccessToken();
  		
  		$getatoken = json_decode( stripslashes($getAccessToken_value) );
		if( $getatoken === NULL ){
			$atoken=$getAccessToken_value;
   		}else{
	   		$atoken = $getatoken->access_token;
   		}
   		
  		$profile_url = $this->userProfileUrl."".$atoken;
  		$userProfile = json_decode($this->curl_request($profile_url,"GET",$atoken));
  		parse_str($atoken);
  		$userProfile->access_token = isset($access_token)?$access_token:'';
		return $userProfile;
  	} 
  	
  	public function APIcall($url){
	  	return $this->curl_request($url,"GET",$_SESSION['atoken']);
  	}
  	
	public function curl_request($url,$method,$postvals){	
		$ch = curl_init($url);
		if ($method == "POST"){
		   $options = array(
	                CURLOPT_POST => 1,
	                CURLOPT_POSTFIELDS => $postvals,
	                CURLOPT_RETURNTRANSFER => 1,
			);
		}else{
		   $options = array(
	                CURLOPT_RETURNTRANSFER => 1,
			);
		}
		curl_setopt_array( $ch, $options );
		if($this->header){
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( $this->header . $postvals) );
		}
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		$response = curl_exec($ch);
		
		curl_close($ch);
		return $response;
	}
}
