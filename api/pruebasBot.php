<?php
	$returnArray = true;
	$rawData = file_get_contents('php://input');
	$response = json_decode($rawData, $returnArray);
	$id_del_chat = $response['message']['chat']['id'];


	// Obtener comando (y sus posibles parametros)
	$regExp = '#^(\/[a-zA-Z0-9\/]+?)(\ .*?)$#i';


	$tmp = preg_match($regExp, $response['message']['text'], $aResults);

	if (isset($aResults[1])) {
	    $cmd = trim($aResults[1]);
	    $cmd_params = trim($aResults[2]);
	} else {
	    $cmd = trim($response['message']['text']);
	    $cmd_params = '';
	}

	$msg = array();
	$msg['chat_id'] = $response['message']['chat']['id'];
	$msg['text'] = null;
	$msg['disable_web_page_preview'] = true;
	$msg['reply_to_message_id'] = $response['message']['message_id'];
	$msg['reply_markup'] = null;

	switch ($cmd) {
		case '/start':
		    $msg['text']  = 'Hola ' . $response['message']['from']['first_name'] .
		               " Usuario: " . $response['message']['from']['username'] . '!' . PHP_EOL;
		    $msg['text'] .= '¿Como puedo ayudarte? /help';
		    $msg['reply_to_message_id'] = null;
		    break;

		case '/help':
		    $msg['text']  = 'Los comandos disponibles son estos:' . PHP_EOL;
		    $msg['text'] .= '/start Inicializa el bot' . PHP_EOL;
		    $msg['text'] .= '/turnos aaaa-mm-dd Muestra los turnos disponibles del día' . PHP_EOL;
		    $msg['text'] .= '/reservar dni aaaa-mm-dd hh:mm Realiza la reserva del turno' . PHP_EOL;
		    $msg['text'] .= '/help Muestra esta ayuda flaca';
		    $msg['reply_to_message_id'] = null;
		    break;

		case '/reservar':	
			$params=explode(' ',$cmd_params);
			$cmd_param1=$params[0];
			$cmd_param2=$params[1];
			$cmd_param3=$params[2];
			$url = "https://grupo16.proyecto2017.linti.unlp.edu.ar/api/index.php/turnos/$cmd_param1/fecha/$cmd_param2/hora/$cmd_param3";
			// use key 'http' even if you send the request to https://...
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => http_build_query($msg)
			    )
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
		    $msg['text'] =$result;
		    $msg['reply_to_message_id'] = null;
		    break;

		case '/turnos':
			if ($cmd_params!=''){
			$turnosDisp = file_get_contents("https://grupo16.proyecto2017.linti.unlp.edu.ar/api/index.php/turnos/$cmd_params");
			$turnosDisp = str_replace('"',"",$turnosDisp);
			$turnosDisp = str_replace('{',"",$turnosDisp);
			$turnosDisp = str_replace('}',"",$turnosDisp);
			$turnosDisp = str_replace('[',"",$turnosDisp);
			$turnosDisp = str_replace(']',"",$turnosDisp);
		    }
		    else{
		    	$turnosDisp="Ingresa una fecha de la forma AA-MM-DD";
		    }
		    $msg['text']  = $turnosDisp;
		    break;
	}

	$url = 'https://api.telegram.org/bot494800519:AAFmUXOOByzNCYO0bzGBSJsDoCMkg3wogrU/sendMessage';

	$options = array(
	'http' => array(
	    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	    'method'  => 'POST',
	    'content' => http_build_query($msg)
	    )
	);

	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	exit(0);
?>


