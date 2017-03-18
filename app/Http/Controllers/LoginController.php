<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;
use DateTimeZone;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
    /**
     * First page that the user see, it explain what this site is for
     */
    public function home(){
        // We have to be between start and end of the vote
        $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
        if($now < config('election.start')) {
            $startTime = config('election.start')->diff(new DateTime(), true)->format('%d jour(s), %h heure(s) et %i minute(s)');
            return view('home', [ 'startTime' => $startTime ]);
        }
        else if($now > config('election.end')){
            return view('home');
        }
        else {
            $endTime = config('election.end')->diff(new DateTime(), false)->format('%d jour(s), %h heure(s) et %i minute(s)');
            return view('home', [ 'endTime' => $endTime ]);
        }
    }


    /**
     * Redirect user to EtuUTT to log in and get his personal informations
     */
    public function redirect(){
        return redirect(
            config('election.etuutt.publicuri')
            . '/api/oauth/authorize?client_id='
            . config('election.etuutt.appid')
            . '&scopes=private_user_account&response_type=code&state=xyz');
    }


    /**
    * The user is redirected to this page after EtuUTT
    * with the authorization_code needed to get informations
    */
    public function auth(Request $request)
    {

        if(!$request->has('authorization_code'))
            abort(401);

        $client = new Client([
            'base_uri' => Config::get('election.etuutt.baseuri'),
            'auth' => [
                config('election.etuutt.appid'),
                config('election.etuutt.appsecret'),
            ]
        ]);

        $params = [
            'grant_type'         => 'authorization_code',
            'authorization_code' => $request->input('authorization_code')
        ];
        try {
            $response = $client->post('/api/oauth/token', ['form_params' => $params]);
        } catch (GuzzleException $e) {
            // An error 400 from the server is usual when the authorization_code
            // has expired. Redirect the user to the OAuth gateway to be sure
            // to regenerate a new authorization_code for him :-)
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 400) {
                return $this->login();
            }
            abort(500);
        }
        $json = json_decode($response->getBody()->getContents(), true);
        $access_token = $json['access_token'];
        $refresh_token = $json['refresh_token'];
        try {
            $response = $client->get('/api/private/user/account?access_token=' . $json['access_token']);
        } catch (GuzzleException $e) {
            abort(500);
        }
        $json = json_decode($response->getBody()->getContents(), true)['data'];

        // Check if the user is in cotisant list
        if(!in_array($json['login'], config('election.cotisants.login'))) {
            return redirect()->route('login_cannot');
        }

        // Login
        $request->session()->put('login', $json['login']);
        $request->session()->put('fullname', $json['fullName']);

        // Redirect to vote
        return redirect()->route('vote_index');
    }

    /**
    * The user is logged out and then redirected to home
    */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return view('login.logout');
    }

    /**
     * Errot that explain why you cannot vote
     */
    public function cannot(){
        return view('login.cannot');
    }
}
