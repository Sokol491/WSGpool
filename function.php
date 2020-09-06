<?php
function header_lol($url)
{
	echo "<script>window.location.href='".$url."'</script>";
	exit;
}
function JSON ($url)
	{
		$data = file_get_contents($url);
		return json_decode($data);
	}
function TransactionSend($api,$address,$private_key,$gasCoin,$text,$tx_array)
{
	$api = new MinterAPI($api);
	$tx = new MinterTx([
		'nonce' => $api->getNonce($address),
		'chainId' => MinterTx::MAINNET_CHAIN_ID,
		'gasPrice' => 1,
		'gasCoin' => $gasCoin,
		'type' => MinterMultiSendTx::TYPE,
		'data' => [
			'list' => $tx_array
		],
		'payload' => $text,
		'serviceData' => '',
		'signatureType' => MinterTx::SIGNATURE_SINGLE_TYPE
	]);
	$transaction = $tx->sign($private_key);
	return $api->send($transaction)->result;
}

function CoinBalance($address, $symbol)
	{
		$url = 'https://explorer-api.minter.network/api/v1/addresses/' . $address;
		$data = file_get_contents($url);
		$json = json_decode($data)->data->balances;
		foreach ($json as $value => $coins) {
					$coin = $coins->coin;
					if ($coin == $symbol) {$amount = $coins->amount;break;}else{$amount = 0;}
				}
		return number_format((int)$amount,2, '.', '');
	}