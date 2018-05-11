<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Slide;
use App\Product;
class PageController extends Controller
{
    public function getIndex(){
        #Do du lieu ra Slide
        $slide = Slide::all();
        //test
        //print_r($slide);
        //exit;

        //cach 1
        //return view('page.trangchu',['slide'=>$slide]);
        //cach 2
        
        $new_product = Product::where('new',1)->get();
        //dd($new_product);
        return view('page.trangchu',compact('slide','new_product'));
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
