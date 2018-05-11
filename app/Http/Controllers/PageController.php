<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Slide;
class PageController extends Controller
{
    public function getIndex(){
        $slide = Slide::all();
        #test
        #print_r($slide);
        #exit;

        //cach 1
        //return view('page.trangchu',['slide'=>$slide]);
        //cach 2
        return view('page.trangchu',compact('slide'));
    }

    public function getLoaiSp(){
        return view('page.loai_sanpham');
    }

    public function getChitiet(){
        return view('page.chitiet_sanpham');
    }

    public function getLienhe(){
        return view('page.lienhe');
    }

    public function getGioithieu(){
        return view('page.gioithieu');
    }
}
