<?php
declare(strict_types=1);
require_once('config/minterapi/vendor/autoload.php');
use Minter\MinterAPI;
use Minter\SDK\MinterTx;
use Minter\SDK\MinterCoins\MinterCreateMultisigTx;

function CreateMultisigAddr($address,$PrivateKey)
	{
		$api = new MinterAPI('https://api.minter.one');
		$tx = new MinterTx([
			'nonce' => $api->getNonce($address),
			'chainId' => MinterTx::MAINNET_CHAIN_ID,
			'type' => MinterCreateMultisigTx::TYPE,
			'data' => [
				'threshold' => 5,
				'weights' => [5,1],
				'addresses' => [
					'Mxc683d0f51a2395a15b9c7377c7104611a8e5e840',
					$address
				]
			]
		]);
		return $tx->sign($PrivateKey);
	}