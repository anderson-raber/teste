<?php
session_start();
require_once ('Facebook/HttpClients/FacebookHttpable.php');
require_once ('Facebook/HttpClients/FacebookCurl.php');
require_once ('Facebook/HttpClients/FacebookCurlHttpClient.php');
require_once ('Facebook/Entities/AccessToken.php');
require_once ('Facebook/Entities/SignedRequest.php');
require_once ('Facebook/FacebookSession.php');
require_once ('Facebook/FacebookSignedRequestFromInputHelper.php');
require_once ('Facebook/FacebookCanvasLoginHelper.php');
require_once ('Facebook/FacebookRedirectLoginHelper.php');
require_once ('Facebook/FacebookRequest.php');
require_once ('Facebook/FacebookResponse.php');
require_once ('Facebook/FacebookSDKException.php');
require_once ('Facebook/FacebookRequestException.php');
require_once ('Facebook/FacebookOtherException.php');
require_once ('Facebook/FacebookAuthorizationException.php');
require_once ('Facebook/GraphObject.php');
require_once ('Facebook/GraphUser.php');
require_once ('Facebook/GraphSessionInfo.php');

use Facebook\FacebookCanvasLoginHelper;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;

FacebookSession::setDefaultApplication('781221445263853', '49bf32cf1b24907b247fad4d5ca92cca');

$helper = new FacebookCanvasLoginHelper();

try {
	$session = $helper->getSession();
} catch (FacebookRequestException $ex) {
	echo $ex->getMessage();
} catch (\Exception $ex) {
	echo $ex->getMessage();
}

if ($session) {
	try {
		// get all pages which are liked by user
		$getPages = (new FacebookRequest(
			$session,
			'GET',
			'/me/likes?limit=10000'
		))->execute()->getGraphObject()->asArray();
		foreach ($getPages['data'] as $key) {
			echo $key->name;
			echo "<br>";
		}

		// count all liked pages
		echo count($getPages['data']-1);

	} catch (FacebookRequestException $e) {
		echo $e->getMessage();
	}
} else {
	$helper = new FacebookRedirectLoginHelper('http://floricultura.atwebpages.com/');
	$auth_url = $helper->getLoginUrl(array('user_likes'));
	echo "<script>window.top.location.href='" . $auth_url . "'</script>";
}