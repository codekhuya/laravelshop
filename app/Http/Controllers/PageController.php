<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Slide;
use App\Product;
use App\ProductType;
use Session;
use App\Cart;
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
        
        $new_product = Product::where('new',1)->paginate(4);
        //dd($new_product);
        $sanpham_khuyenmai = Product::where('promotion_price','<>',0)->paginate(8);
        return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    }

    public function getLoaiSp($type){
        $sp_theoloai = Product::where('id_type',$type)->get();
        $sp_khac = Product::where('id_type','<>',$type)->inRandomOrder()->paginate(3);
        $loai = ProductType::all();
        $loai_id = ProductType::where('id',$type)->first(); 
        return view('page.loai_sanpham',compact('sp_theoloai','sp_khac','loai','loai_id'));
    }

    public function getChitiet(Request $req ){
        $sanpham = Product::where('id',$req->idsp)->first();
        $sp_tuongtu = Product::where('id_type',$sanpham->id_type)->paginate(3);
        return view('page.chitiet_sanpham', compact('sanpham','sp_tuongtu'));
    }

    public function getLienhe(){
        return view('page.lienhe');
    }

    public function getGioithieu(){
        return view('page.gioithieu');
    }

    public function getAddtoCart(Request $req, $id){
        $product = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart', $cart);
        return redirect()->back();
    }

    public function getDelItemCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items)>0){
            Session::put('cart',$cart);
        }
        else{
            Session::forget('cart');
        }
        return redirect()->back();
    }
}
