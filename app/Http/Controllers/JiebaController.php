<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;

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
     * jiebaProcess
     *
     * @return Response
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
        $seg_list = Jieba::cut($paragraph);
        $paragraph_processed = implode(' / ', $seg_list);
        return $paragraph_processed;
    }
}
