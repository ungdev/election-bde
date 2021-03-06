<?php

return [
	// Informations en rapport avec le site etu
	'etuutt' => [
		'publicuri' => 'https://etu.utt.fr', // base uri used to redirect user
		'baseuri' => 'https://etu.utt.fr', // base uri used to connect to api
		'appid' => '',
		'appsecret' => ''
	],

	// Login des arbitres et email de contact
	// Les arbitres peuvent administratrer les listes
	'referer' => [
		'login' => [],
        'email' => ''
		],

	// Liste des login des personnes pouvant lire les résultats pendant
	// et après les elections sans pouvoir modifier les parametres
	'viewer' => [  ],

	// Date de début et de fin d'election
	'start' => new DateTime('2017-03-02 21:00:00', new DateTimeZone('Europe/Paris')),
	'end' => new DateTime('2017-03-05 23:59:59', new DateTimeZone('Europe/Paris')),


];
