<?php

namespace App\Http\Controllers;


use App\ListM;
use App\User;


use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class VoteController extends Controller
{

    /**
     * Propose each list and buttons to vote
     */
    public function index(){
        $lists =  ListM::all()->toArray();


        $endTime = config('election.end')->diff(new DateTime(), true)->format('%d jour(s), %h heure(s) et %i minute(s)');
        shuffle($lists);

        return view('vote.list', ['lists' => $lists, 'endTime' => $endTime]);
    }

    /**
     * Ask user to confirm his vote
     */
    public function confirm($id){
        $list =  ListM::where('id', $id)->first();;

        return view('vote.confirm', ['list' => $list]);
    }

    /**
     * Put the vote in database
     */
    public function doit($id){

        if($id != 0)
        {
            ListM::find($id)->increment('score');
        }
        else {
            $list = ListM::firstOrCreate(['name' => '', 'description' => '', 'promises' => '', 'members' => '']);
            $list->increment('score');
        }

        $user = new User;
        $user->login = Session::get('login');
        $user->save();

        // deconnexion
        Session::flush();
        return view('vote.done');
    }

    /**
     * Errot that explain that you already voted
     */
    public function already(){
        return view('vote.already');
    }
}
