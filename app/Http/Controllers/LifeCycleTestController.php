<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\ServiceTest\Message;
use App\Http\ServiceTest\Sample;

class LifeCycleTestController extends Controller
{
    public function showSeviceContainerTest()
    {
        app()->bind('lifeCycleTest', function(){
            return "ライフサイクルのテスト";
        });
        $call1 = app()->make('lifeCycleTest');
        $call2 = app('lifeCycleTest');
        $call3 = resolve('lifeCycleTest');
        $call4 = App::make('lifeCycleTest');

        $message = new Message();
        $sample = new Sample($message);
        $sample->run();

        $sample = app()->make('sample');
        $sample->run();

        dd(app(), $call1, $call2, $call3, $call4);
    }

    public function showSeviceProviderTest()
    {
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');
        $sample = app()->make('serviceProviderTest');
        dd($password, $encrypt->decrypt($password), $sample);
    }
}