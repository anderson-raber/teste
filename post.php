<?php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'] . '/sys/facebook/FacebookSession.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/sys/facebook/FacebookRequest.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/sys/facebook/GraphObject.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/sys/facebook/FacebookRequestException.php');

use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;

$message = safe($_POST["message"]);
$url = safe($_POST["url"]);
$image = safe($_POST["image"]);

if ($message == "" OR $url == "" OR $image == "") {
	echo "incomplete";
	return;
}

FacebookSession::setDefaultApplication('{APP ID}', '{APP SECRET}');
$session = new FacebookSession('{Page Access Token}');

if ($session) {
	try {
		$response = (new FacebookRequest(
			$session, 'POST', '/{Page ID}/feed', array(
				'message' => $message,
				'link' => $url,
				'picture' => $image,
			)
		))->execute()->getGraphObject();
		echo "Posted with id: " . $response->getProperty('id');
	} catch (FacebookRequestException $e) {
		echo "Exception occured, code: " . $e->getCode();
		echo " with message: " . $e->getMessage();
	}
} else {
	echo "No Session available!";
}

?>