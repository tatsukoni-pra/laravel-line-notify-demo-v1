<?php

namespace App\Http\Controllers;

class TestApiController extends Controller
{
    public function index()
    {
        return [
            [
                'key1' => 'hoge',
                'key2' => 'fuga',
            ],
            [
                'key1' => 'foo',
                'key2' => 'bar',
            ]
        ];
    }
}
