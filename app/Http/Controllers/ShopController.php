<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    //response the controller on website
    public function index(){
        return Inertia::render('/')->json(['status' => true]);
    }

    public function register(){
        return Inertia::render('/register')->json(['status' => true]);
    }

    public function login(){
        return Inertia::render('/login')->json(['status' => true]);
    }

    public function productlist(){
        return Inertia::render('shop/productlist')->json(['status' => true]);
    }

    public function userproductlist(){
        return Inertia::render('user/productlist')->json(['status' => true]);
    }

    public function orderlist(){
        return Inertia::render('user/orderlist')->json(['status' => true]);
    }

    //product management api route
    public function productdestroy($id){
        Product::find($id)->delete();
        return redirect()->route('product.list')->json(['status' => true]);
    }

    public function productupdate($id, Request $request){
        Validator::make($request->all(),[
            'product_name' => ['required'],
            'description' => ['required'],
            'product_price' => ['required'],
            'type_id' => ['required']
        ])->validate();

        Product::find($id)->update($request->all());
        return redirect()->route('product.list')->json(['status' => true]);
    }

    public function productcreate(Request $request){
        Validator::make($request->all(),[
            'product_name' => ['required'],
            'description' => ['required'],
            'product_price' => ['required'],
            'type_id' => ['required']
        ])->validate();

        Product::insert($request->all());
        return redirect()->route('product.list')->json(['status' => true]);
    }

    //order management api route
    public function orderdestroy($id){
      Order::find($id)->delete();
      return redirect()->route('order.list')->json(['status' => true]);
    }

    public function orderupdate($id, Request $request){
        Validator::make($request->all(),[
            'order_date' => ['required'],
            'payment_date' => ['required'],
            'delivery_date' => ['required'],
            'address' => ['required']
        ])->validate();

        Order::find($id)->update($request->all());
        return redirect()->route('order.list')->json(['status' => true]);
    }

    public function ordercreate(Request $request){
        Validator::make($request->all(),[
            'order_date' => ['required'],
            'payment_date' => ['required'],
            'delivery_date' => ['required'],
            'user_id' => auth()->id(),
            'status_id' => [1],
            'product_id' => ['required'],
            'address' => ['required']
        ])->validate();

        Order::insert($request->all());
        return redirect()->route('order.list')->json(['status' => true]);
    }

    //staff order update api route
    public function orderstatusupdate($id,Request $request){
        Validator::make($request->all(),[
            'status_id' => ['required']
        ]);

        Order::find($id)->update($request->all());
        return redirect()->route('order.list')->json(['status' => true]);
    }

    //register insertation api route
    public function userregister(){
        return Inertia::render('User/Register');
    }

    //user login api route while type = 'user'
    public function userlogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
            'user_type' => 'user'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'fix errors', 'errors' => $validator->errors()], 500)->route('user.login');
        }
        $credentials = $request->only('email', 'password');
        if(auth()->attempt($credentials, $request->filled('remember'))) {
            return response()->json(['status' => true, 'user' => auth()->user()])->route('user.index');
        }
        return response()->route('user.login')->json(['status' => false, 'message' => 'invalid username or password'], 500);
    }

    //user logout api route
    public function userlogout(Request $request){
        auth('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->route('user.login')->json(['status' => true, 'message' => 'logged out']);
    }

    //user insertation form registartion page
    public function customeruserinsert(Request $request){
        Validator::make($request->all(),[
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'type' => 'customer'
        ])->validate();

        User::insert($request->all());
        return redirect()->route('confirm.index')->json(['status' => true]);
    }

    //staff register insertation api route
    public function staffuserinsert(Request $request){
        Validator::make($request->all(),[
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'type' => 'staff'
        ])->validate();

        User::insert($request->all());
        return redirect()->route('confirm.index')->json(['status' => true]);
    }

    //staff register delete api route
    public function staffuserdelete($id){
      User::find($id)->where('type','=','staff')->delete();
      return redirect()->route('staff.list')->json(['status' => true]);
    }

}
