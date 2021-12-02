<?php
/**
 * Created by PhpStorm.
 * User: Burak
 * Date: 28.11.2021
 * Time: 17:47
 */

/**
 * Class vegan
 * veganstore-api
 */
class vegan {
	public $API_KEYNAME, $API_KEYVAL;

	private $_magaza_email, $_magaza_password, $_OCSESSID;

	/**
	 * vegan constructor.
	 *
	 * @param string $magaza_email mağaza email adresiniz
	 * @param string $magaza_password mağaza şifreniz
	 * nesne oluşturduğunuzda($new=new vegan()) çağırılacak constructor metodu
	 * işlem sırasında login ve login den dönen session datası otomatik olarak işlenecek siz sadece istediğiniz methodu çağırın
	 */
	public function __construct( $magaza_email = "magaza@email.com", $magaza_password = "magazaşifrem" ) {
		$this->_magaza_email    = $magaza_email;
		$this->_magaza_password = $magaza_password;
		$response               = $this->login();
		$this->_OCSESSID        = str_replace( "OCSESSID=", "", strstr( strstr( $response, "OCSESSID=" ), ";", true ) );
		$this->API_KEYNAME      = "magaza_api";
		$this->API_KEYVAL       = "4xdwbuMF1NlCVgl1EXmNOpCGUnwn4vqzK4GPIBSZTQlLYMDz6IzDBWz2gyfZBejVtZ1ZacVI44dXjC3reJiQvXGuZFrhNsmJ0DuA8EmnzP2pqHZBEw8L6Lh8M36AQoarYitTfptWaaTzgXfXEVrd8ahX1k2PjYIvUeqQFJaCQhmrVrfX6coEkZMVFKZyJfi0v7jD8gylsDdbmnHQCvB4fWiUQcSNuKAizSupTqQHPqwMMQRMWE30rsYyJSTwj6XX";

	}

	/**
	 * @return mixed
	 * bu fonksiyon mağazaya login olarak session id'nizi teymin etmenizi sağlar
	 * method constructor anında çağırılır el ile tetiklemenize gerek yoktur
	 */
	private function login() {
		$curl = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => 'https://veganistasyon.com/alisveris/magaza/api/sellerlogin',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => true,
			CURLOPT_COOKIESESSION  => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'POST',
			CURLOPT_POSTFIELDS     => array( 'email' => $this->_magaza_email, 'password' => $this->_magaza_password ),
			CURLOPT_HTTPHEADER     => array( "cache-control: no-cache" )
		) );

		$response = curl_exec( $curl );
		curl_close( $curl );

		return $response;
	}

	/**
	 * @return mixed
	 * ürünleri çekmek için kullanabilirsiniz
	 */
	public function products() {


		$curl = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => 'https://veganistasyon.com/alisveris/magaza/api/sellerproduct',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_COOKIESESSION  => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'GET',
			CURLOPT_HTTPHEADER     => array(
				"Content-Type: application/json",
				"cache-control: no-cache",
				'Cookie: OCSESSID=' . $this->_OCSESSID,
				$this->API_KEYNAME . ': ' . $this->API_KEYVAL
			),
		) );

		$response = curl_exec( $curl );
		curl_close( $curl );

		return json_decode( $response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	}

	/**
	 * @return mixed
	 * siparişlerinizi çekmek için kullanabilirsiniz
	 */
	public function orders() {

		$curl = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => 'https://veganistasyon.com/alisveris/magaza/api/sellerorder',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_COOKIESESSION  => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'GET',
			CURLOPT_HTTPHEADER     => array(
				"Content-Type: application/json",
				"cache-control: no-cache",
				'Cookie: OCSESSID=' . $this->_OCSESSID,
				$this->API_KEYNAME . ': ' . $this->API_KEYVAL
			),
		) );

		$response = curl_exec( $curl );
		curl_close( $curl );

		return json_decode( $response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	}


}