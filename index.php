<?php


function replyToUser($userID,$message,$ac_token){
	
	// Make a POST Request to Messaging API to reply to sender
	$url = 'https://api.line.me/v2/bot/message/push';
	$data = [
		'to' => $userID,
		'messages' => [$message]
	];
	$post = json_encode($data);
	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $ac_token);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	//echo $result . "\r\n";
}


function requestForProfile($ac_token,$userID){
	
	// Make a GET request to Messaging API to get profile
	$url = 'https://api.line.me/v2/bot/profile/' . $userID;
	$headers = array('Authorization: Bearer ' . $ac_token);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$response = curl_exec($ch);
	curl_close($ch);
	
				
	// Build message to reply back
	$messages = [
		'type' => 'text',
		'text' => "Respond :" . $response
	];
				
	replyToUser($userID,$messages,$ac_token);
				
				
				
		

}
$access_token = 'wM/b6mWFtv/O06aMRjru+Mk05ImmCCUuu5ERJVwBULpOyfRcyl2J4NYy9YUgWZOXoloy7F/+TTOZsgy9BwForil7Lz8MJa8d7fOkpvBkOjHExGbxU0tKMPx4CKFEvDO1aB6AxfAwRPvg1qSeQcSDdwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);



echo "Just a test";
echo $events . "\r\n";
$userID = 'a';
// Validate parsed JSON data
if (!is_null($events['events'])) {
		
		// Loop through each event
		foreach ($events['events'] as $event) {
			
			// Get replyToken
			$replyToken = $event['replyToken'];
			
			// Get userID
			$source = $event['source'];
			$userID = $source['userId'];
		
			
			
		//	$headers = array('Content-Type: application/x-www-form-urlencoded');
			
			
			// Build connection to EB and send data to EB
			// Now I only send a userID to test the connection, if the connection
			// succeeds, I will send userName later.
			$url = 'http://13.250.89.6/rest/LINE/services/';
			$data = [
                'to' => $userID,
                'messages' => 'zzz'
            ];
            $post = json_encode($data);
            $headers = array('Content-Type: application/json');

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $response = curl_exec($ch);
            curl_close($ch);
			
			
			// Request for profile and send a push message
			//requestForProfile($access_token,$userID);

			
			
			// Define whether the connection succeeds or not
			if($response){
				$messages = [
					'type' => 'text',
					'text' => "Respond :" . json_encode($event);
				];
			}else{
				$messages = [
					'type' => 'text',
					'text' => "\nFALSE"
				];
			}
			
			// Send the return value of curl connection to the user by messaging	
			replyToUser($userID,$messages,$access_token);
			
			
	
		}
	
}





echo "what's up  ";

echo "Hello Line BOT";
