<?php

require('./vendor/autoload.php');

array_shift($argv); // Remove the script name
$argc = count($argv); // Reset the default argc counter

// Check that at least two parameters have been sent, the API key and at least one domain of sorts.
if($argc < 2)
{
	echo '❌  You have not passed enough information. Usage:'."\n";
	echo '    domaincheck api_key domain.co.uk [domain2.co.uk] [domain3.co.uk]'."\n";
	echo '    or'."\n";
	echo '    domaincheck api_key domain.co.uk[,domain2.co.uk][,domain3.co.uk]'."\n";
	echo ''."\n";
	echo '    Example to check google.com'."\n";
	echo '    domaincheck $api_key_in_env google.com'."\n";
	echo ''."\n";
	exit();
}

// Get the API key and remove it from the args array
$apiKey = $argv[0];
array_shift($argv);
$argc = count($argv); // Reset the default argc counter

# TODO - Make some magic parser so domain.com,domain.co.uk domain.net can be requested
$domains = [];
if($argc == 1)
{
	// Only one genuine domain sent
	if(strpos($argv[0], ",") === false)
	{
		$domains[] = $argv[0];
	}
	elseif(strpos($argv[0], ',') > 0)
	{
		$domains = explode(",", $argv[0]);
	}
}
else{
	$domains = $argv;
}

foreach ($domains as $domain) {
	checkRegistration($apiKey, $domain);
}

function checkRegistration($apiKey, $domain)
{
	try {
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'https://api.20i.com/domain-search/'.$domain, [
			'headers' => [
				'Authorization' => 'Bearer '.base64_encode($apiKey),
				'Content-Type' => 'application/json'
			]
		]);

		$domain = array_pop(json_decode($res->getBody()));

		if($domain->can == 'register')
		{
			echo "✅  $domain->name can be registered - https://my.20i.com/services/domain-search?domain=$domain->name\n";
		}
		else
		{
			echo "❌  $domain->name is currently registered";
			if(!empty($domain->expiryDate))
			{
				echo ", and is due to expire on ".date("jS F Y", strtotime($domain->expiryDate));
			}
			echo "\n";
		}

	} catch (Exception $e) {
		exit($e->getMessage());	
	}	
}
