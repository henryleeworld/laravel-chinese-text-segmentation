<?php

namespace App\Http\Controllers;

use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;
use Illuminate\Http\Request;

class JiebaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jieba');
    }

    /**
     * Jieba process
     */
    public function process(Request $request)
    {
        ini_set('memory_limit', '600M');
        $paragraph = $request->input('paragraph');
        Jieba::init(array(
            'mode'=>'default',
            'dict'=>'samll'
        ));
        Finalseg::init();
        return implode(' / ', Jieba::cut($paragraph));
    }
}
