<?php
session_start();
include "BancoDados.php";
require_once ('Facebook/FacebookSession.php');
require_once ('Facebook/FacebookRedirectLoginHelper.php');
require_once ('Facebook/FacebookRequest.php');
require_once ('Facebook/FacebookResponse.php');
require_once ('Facebook/FacebookSDKException.php');
require_once ('Facebook/FacebookRequestException.php');
require_once ('Facebook/FacebookAuthorizationException.php');
require_once ('Facebook/GraphObject.php');
require_once ('Facebook/GraphUser.php');
require_once ('Facebook/GraphSessionInfo.php');

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;

// Requested permissions for the app - optional

$permissions = array(
	'email',
	'user_location',
	'user_birthday',
	'user_photos',
	'publish_actions',
	'user_likes',
	'manage_pages',
	'publish_stream',
	'user_groups',
);

$id = '781221445263853';

$secret = '49bf32cf1b24907b247fad4d5ca92cca';

FacebookSession::setDefaultApplication($id, $secret);

$helper = new FacebookRedirectLoginHelper('http://niobio.cafw.ufsm.br/~grupo01/teste/index.php');
if (isset($_SESSION) && isset($_SESSION['fb_token'])) {
	// Create new session from saved access_token
	$session = new FacebookSession($_SESSION['fb_token']);

	// Validate the access_token to make sure it's still valid
	try {
		if (!$session->
			validate()) {
			$session = null;
		}
	} catch (Exception $e) {
		// Catch any exceptions
		$session = null;
	}
} else {
	// No session exists
	try {
		$session = $helper->getSessionFromRedirect();
	} catch (FacebookRequestException $ex) {

		// When Facebook returns an error
	} catch (Exception $ex) {

		// When validation fails or other local issues
		echo $ex->message;
	}
}

// Check if a session exists
if (isset($session)) {

	try {
		// uploading image to user timeline using facebook php sdk v4
		/*$response = (new FacebookRequest(
		$session, 'POST', '/me/photos', array(
		'source' => new CURLFile('picture.jpg', 'image/jpg'), // photo must be uploaded on your web hosting
		'message' => 'User provided message'
		)
		)
		)->execute()->getGraphObject();
		if($response) {
		echo "Photo is uploaded...";
		}



		$access_token = (new FacebookRequest( $session, 'GET', '/' . $page_id,  array( 'fields' => 'access_token' ) ))
		->execute()->getGraphObject()->asArray();

		// save access token in variable for later use
		$access_token = $access_token['access_token'];

		$page_post = (new FacebookRequest( $session, 'POST', '/'. $page_id .'/feed', array(
		'access_token' => $access_token,
		'name' => 'Facebook API: Posting As A Page using Graph API v2.x and PHP SDK 4.0.x',
		'link' => 'https://www.webniraj.com/2014/08/23/facebook-api-posting-as-a-page-using-graph-api-v2-x-and-php-sdk-4-0-x/',
		'caption' => 'The Facebook API lets you post to Pages you administrate via the API. This tutorial shows you how to achieve this using the Facebook PHP SDK v4.0.x and Graph API 2.x.',
		'message' => 'Check out my new blog post!',
		) ))->execute()->getGraphObject()->asArray();

		// return post_id
		print_r( $page_post );



		 */

		//funcioando*******************************************
		//$access_token = (new FacebookRequest($session, 'GET', '/1506433346288628', array('fields' => 'access_token')))
		//->execute()	->getGraphObject()	->asArray();

// save access token in variable for later use
		$access_token = $access_token['access_token'];
		$page_post = (new FacebookRequest($session, 'POST', '/1506433346288628/feed', array(
			'name' => 'Facebook API: Posting As A Page using Graph API v2.x and PHP SDK 4.0.x',
			'link' => 'https://www.webniraj.com/2014/08/23/facebook-api-posting-as-a-page-using-graph-api-v2-x-and-php-sdk-4-0-x/',
			'caption' => 'The Facebook API lets you post to Pages you administrate via the API. This tutorial shows you how to achieve this using the Facebook PHP SDK v4.0.x and Graph API 2.x.',
			'message' => 'Check out my new blog post!',
		)))->execute()->getGraphObject()->asArray();

// return post_id
		print_r($page_post);

		/*$request = (new FacebookRequest($session, 'POST', '/737334336313171/feed', array(
	'name' => 'Testando',
	'caption' => '',
	'link' => '',
	'message' => 'testando postador automatico facebook',
	)))->execute();

	//********************************************************

	// Get response as an array, returns ID of post
	$response = $request->getGraphObject()->asArray();

	print_r($response);*/

	} catch (FacebookRequestException $e) {
		echo $e->getMessage();
	}
} else {
	// No session

	// Get login URL
	$loginUrl = $helper->getLoginUrl($permissions);

	echo '<a href="' . $loginUrl . '">Log in</a>';
}
