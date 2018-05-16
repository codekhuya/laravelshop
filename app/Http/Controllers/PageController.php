<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Slide;
use App\Product;
use App\ProductType;
use Session;
use App\Cart;
use App\Customer;
use App\Bill;
use App\User;
use Hash;

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

    public function getDatHang(){
        return view('page.dat_hang');
    }

    public function postCheckout(Request $req){
        $cart = Session::get('cart');
        dd($cart);

        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach($cart->items as $key => $value){
            $bill_detail = new BillDetail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = ($value['price']/$value['qty']);
            $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao','Đặt hàng thành công.');
    }

    public function getLogin(){
        return view('page.dangnhap');
    }

    public function getSignup(){
        return view('page.dangky');
    }

    public function postSignup(Request $req){
        $this->validate($req,
            [
                'email'         =>'required|email|unique:users,email',
                'password'      =>'required|min:6|max:20',
                'fullname'      =>'required',
                're_password'   =>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email.',
                'email.email' => 'Định dạng email không đúng.',
                'email.unique'=>'Email đã có người sử dụng.',
                'fullname.required'=>'Vui lòng nhập tên đầy đủ của bạn.',
                'password.required'=>'Vui lòng nhập mật khẩu.',
                'password.max'=>'Mật khẩu tối đa 20 ký tự.',
                'password.min'=>'Mật khẩu phải có ít nhất 6 ký tự.',
                're_password.same'=>'Mật khẩu không giống nhau.'
            ]);
        $user = new User();
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Tạo tài khoản thành công.');
    }
}
