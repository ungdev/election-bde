<?php

return [
	// Informations en rapport avec le site etu
	'etuutt' => [
		'publicuri' => 'https://etu.utt.fr', // base uri used to redirect user
		'baseuri' => 'https://etu.utt.fr', // base uri used to connect to api
		'appid' => env('ETU_APP_ID', ''),
		'appsecret' => env('ETU_APP_SECRET', '')
	],

	// Login des arbitres et email de contact
	// Les arbitres peuvent administrer les listes
	'referer' => [
		'login' => explode(',', env('LOGIN_ADMIN', '')),
        'email' => env('EMAILS_ADMIN', '')
		],

	// Liste des login des personnes pouvant lire les résultats pendant
	// et après les elections sans pouvoir modifier les parametres
	'viewer' => explode(',', env('LOGIN_VIEWER', '')),

	// Date de début et de fin d'election
	'start' => new DateTime(env('VOTE_START', '2017-03-02 21:00:00'), new DateTimeZone('Europe/Paris')),
	'end' => new DateTime(env('VOTE_END', '2017-03-05 23:59:59'), new DateTimeZone('Europe/Paris')),

];
