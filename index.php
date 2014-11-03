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
use Facebook\GraphUser;

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

	// Save the session
	$_SESSION['fb_token'] = $session->getToken();

	// Create session using saved token or the new one we generated at login
	$session = new FacebookSession($session->getToken());
	// Graph API to request user data
	$request = (new FacebookRequest($session, 'GET', '/me'))->execute();
	$request2 = (new FacebookRequest($session, 'GET', '/me/picture?type=large&redirect=false'))->execute();

	// Get response as an array
	$user = $request->getGraphObject()->asArray();
	$foto2 = $request2->getGraphObject()->asArray();

	$foto = $foto2->url;

	$usuario = $request->getGraphObject(GraphUser::className());

	$email = $usuario->getProperty('email');
	$nome = $usuario->getName();
	$id = $usuario->getId();
	$aniversario = $usuario->getProperty('birthday');
	$link = $usuario->getLink();

	echo '<img src="' . $foto . '">';
	//echo "<br>" . $foto;
	echo "<br>" . $email;
	echo "<br>" . $nome;
	echo "<br>" . $id;
	echo "<br>" . $aniversario;
	echo "<br>" . $link;

	//$valores = "'$id','$nome','$email','$aniversario','$link','$foto'";
	//cadastra_face("padrao", $valores);

	/*$foto = $usuario->getProperty('picture');
	print_r($foto);*/

	// Create the logout URL (logout page should destroy the session)
	$logoutURL = $helper->getLogoutUrl($session, 'http://niobio.cafw.ufsm.br/~grupo01/teste/index.php');

	echo '<br><a href="' . $logoutURL . '">Log out</a>';
	echo "<br>";
	/*if (isset($_GET[$logoutURL])){
	session_unset();
	}*/

	//cadastra_face();
	criar_tabela($id);
	try {
		// get all pages which are liked by user
		$getPages = (new FacebookRequest(
			$session,
			'GET',
			'/me/groups'
		))->execute()->getGraphObject()->asArray();
		foreach ($getPages['data'] as $key) {
			//echo $key->name . "<br>" . $key->id;
			?>
			<input type="checkbox" name="<?=$key->id?>" value="<?=$key->id?>"> <?=utf8_decode($key->name);?><br>

<?php
$valores = "$key->id,'$key->name'";
			cadastra_grupos("usuario_" . $id, $valores, $key->id, utf8_encode($key->name));
			echo "<br>";

		}

		// count all liked pages
		/*echo count($getPages['data']);
	echo "<br>todos seus grupos foram gravados";
	 */
	} catch (FacebookRequestException $e) {
		echo $e->getMessage();
	}

} else {
	// No session

	// Get login URL
	$loginUrl = $helper->getLoginUrl($permissions);

	echo '<a href="' . $loginUrl . '">Log in</a>';
}
