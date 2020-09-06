<?php
declare(strict_types=1);
require_once('config/minterapi/vendor/autoload.php');
use Minter\MinterAPI;
use Minter\SDK\MinterTx;
use Minter\SDK\MinterCoins\MinterMultiSendTx;

$address = 'Mxc683d0f51a2395a15b9c7377c7104611a8e5e840';
$address2 = 'Mx836a597ef7e869058ecbcc124fae29cd3e2b4444';

include('../config.php');
include('function.php');
include('estimate.php');
include('CreateMultisig.php');

$WSGAME = CoinBalance($address, 'WSGAME');
$MINTERCAT = CoinBalance($address, 'MINTERCAT');
$BIP = CoinBalance($address, 'BIP');
//-------------------------------
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$price_json = json_decode(file_get_contents('https://api.coingecko.com/api/v3/coins/bip'));
$price = $price_json->market_data->current_price->usd;
$price_change_percentage_24h = '('. number_format($price_json->market_data->price_change_percentage_24h,1, '.', '') . '%)';

$totalBIP = number_format($BIP * $price,2, '.', '');
$totalMINTERCAT = number_format(estimate('MINTERCAT')* $price,2, '.', '');
$totalWSGAME = number_format($WSGAME * 0.01,2, '.', '');


echo "
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='utf-8'>
  <title>WSGpool</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>
<center>
<br>
<h3>WSGpool</h3>
<blockquote>
WSGAME: $WSGAME ($". $totalWSGAME .")<br>
MINTERCAT: $MINTERCAT ($". $totalMINTERCAT .")<br>
BIP: $BIP ($". $totalBIP .")<br>
<br>";
$butt = false;
echo "<form method='POST'>
<select size='1' name='int'>
<option disabled>minimum 10 WSGAME</option>";
if ($WSGAME > 10) {echo "<option value='10'>10</option>";}
if ($WSGAME > 50) {echo "<option value='50'>50</option>";}
if ($WSGAME > 100) {echo "<option value='100'>100</option>";}
if ($WSGAME > 500) {echo "<option value='500'>500</option>";}
if ($WSGAME > 1000) {echo "<option value='1000'>1000</option>";}
if ($WSGAME > 5000) {echo "<option value='5000'>5000</option>";}
echo "
</select>
<input id='Exchange' name='Exchange' type='submit' value='Exchange'>
<input id='CreateMultisig' name='CreateMultisig' type='submit' value='CreateMultisig'>
</form>";
//-------------------------------
echo "</center>";
if (isset($_POST['CreateMultisig']))
	{
		echo CreateMultisigAddr($address2,$privat_key_system);
	}
if (isset($_POST['Exchange']))
	{
		$int = $_POST['int'];
		/*
		if ($BIP >= $int)
			{
				$tx_array = array(array(
					'coin' => 'BIP',
					'to' => 'Mx836a597ef7e869058ecbcc124fae29cd3e2b4444',
					'value' => $int
				));
				
				$api = 'https://api.minter.one/';
				$transaction = TransactionCreate($api,$address,$private_key,$gasCoin = 'BIP',$text = '',$tx_array);
				
				$code = $transaction->code;
				if ($code == 0)
					{
						$tx_array = array(array(
							'coin' => 'WSGAME',
							'to' => $address,
							'value' => $int
						));
						$transaction = TransactionCreate($api,'Mx836a597ef7e869058ecbcc124fae29cd3e2b4444',$privat_key_system,$gasCoin = 'BIP',$text = '',$tx_array);
						$code = $transaction->code;
						if ($code == 0)
							{
								header_lol('index.php');
							}
					}
			}
			*/
	}