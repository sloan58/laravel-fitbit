<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FitbitController extends Controller
{
	//first this function is called then
	public function index()
    {
    	/*Configuration of Fitbit for OAUTH*/
		$provider = new \djchen\OAuth2\Client\Provider\Fitbit([
		    'clientId'          => '22DLKH',
		    'clientSecret'      => '1952d50cc9ed1aa2bef60f48de0af527',
		    'redirectUri'       => 'http://localhost/fitbit/public/callback'
		]);
		/*End of Configuration of Fitbit for OAUTH*/
	    /*Get the Authorization url from Oauth client which is being authorization
	    which contains the auth_token which need to get data from fitbit*/
	    $authorizationUrl = $provider->getAuthorizationUrl();
        /*Just redirect to the url to get the authorization code*/
	    header('Location: ' . $authorizationUrl);
	    exit;
    }
    //after getting authorized url response this function is called with response authorization code
    public function callback(Request $request)
	{
	    $provider = new \djchen\OAuth2\Client\Provider\Fitbit([
		    'clientId'          => '22DLKH',
		    'clientSecret'      => '1952d50cc9ed1aa2bef60f48de0af527',
		    'redirectUri'       => 'http://localhost/fitbit/public/callback'
		]);
		//get the authorization code from the data 
		$code = $request['code'];
		//this authorization required to get access token for fitbit server
		 $accessToken = $provider->getAccessToken('authorization_code', [
			            'code' => $code
			        ]);
       
			        // We have an access token, which we may use in authenticated		       
			        $resourceOwner = $provider->getResourceOwner($accessToken);

			        var_export($resourceOwner->toArray());

			        // The provider provides a way to get an authenticated API request for	
			        /*================================================*/
			        /*================================================*/
			        /*This is the main API call to the fitbit response*/
			        /*================================================*/
			        /*================================================*/
			        $request = $provider->getAuthenticatedRequest(
			            \djchen\OAuth2\Client\Provider\Fitbit::METHOD_GET,
			            \djchen\OAuth2\Client\Provider\Fitbit::BASE_FITBIT_API_URL . '/1/user/-/profile.json',
			            $accessToken,
			            ['headers' => [\djchen\OAuth2\Client\Provider\Fitbit::HEADER_ACCEPT_LANG => 'en_US'], [\djchen\OAuth2\Client\Provider\Fitbit::HEADER_ACCEPT_LOCALE => 'en_US']]			           
			        );
			        //this line parse the data as we view 
			        $response = $provider->getParsedResponse($request);
			        dd(($response));
	}
    
}
