<?php
    $test1 =   DB::table('conversations')
        ->where('user_one', Auth::user()->id)
        ->where('status',1) // unread message
        ->count();

    $test2 =   DB::table('conversations')
        ->where('user_two', Auth::user()->id)
        ->where('status',1) // unread message
        ->count();

    echo $test1 + $test2;
?>