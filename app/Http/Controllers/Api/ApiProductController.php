<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\chat;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use SebastianBergmann\Environment\Console;

class ApiProductController extends Controller
{
    //

    // public function create(Request $request)
    // {



            // $file = $request->file('image');
            // $uploadpath = 'public/img';
            // $imageName = $file->getClientOriginalName();
            // $file->move($uploadpath,$imageName);


            // $product = new Product();
            // $product->name = $request->input('name');
            // $product->category = $request->input('category');
            // $product->price = $request->input('price');
            // $product->description = $request->input('description');
            // $product->status = $request->input('status');
            // $product->image=$imageName;
            // $product->save();

            // return response($product);
    // }

    public function create(Request $request)
    {
        // dd($request->all());

        $id = $request->id;
        $file = $request->file('image');
        $uploadpath = '../public/img';
        $imageName = $file->getClientOriginalName();
        $file->move($uploadpath,$imageName);

        $productData = json_decode($request->data,true);
        $productData['image'] = $imageName;


        $product = Product::updateOrCreate(['id'=>$id],$productData);
        return response($product,201);
    }

    public function showbyid($id)
    {
        $product = Product::find($id);
        if(is_null($product))
        {
            return response()->json(['message' => 'Product Not Found'],404);
        }

        return response($product);
    }

    public function updatebyid(Request $request, $id)
    {
        // dd($request->all(),$id);
        $product = Product::find($id);

        $file = $request->file('image');
        $uploadpath = '../public/img';
        $imageName = $file->getClientOriginalName();
        $file->move($uploadpath,$imageName);

        $productData = json_decode($request->data,true);
        $productData['image'] = $imageName;


        // $product->name = $request->input('name');
        // $product->category = $request->input('category');
        // $product->price = $request->input('price');
        // $product->description = $request->input('description');
        // $product->status = $request->input('status');
        // $product->save();

        $product->update($productData);
        return response($product);
    }


    public function show()
    {
        $product = Product::all();
        return $product;
    }

    public function destroy(Request $request,$id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(null,204);
    }

    public function getProduct(Request $request)
    {
        $product = Cart::where('userid',$request->userid)->with('product')->get();
        $total_price = 0;
        foreach($product as $index=>$data){
            $products[$index]['id'] = $data->productid;
            $products[$index]['name'] = $data->product['name'];
            $products[$index]['description'] = $data->product['description'];
            $products[$index]['price'] = $data->product['price'];
            $products[$index]['category'] = $data->product['category'];
            $total_price = $total_price + $data->product['price'];
            $products[$index]['total_amt'] = $total_price;
        }
        return $products;
    }

    public function makeOrder(Request $request)
    {
        $data = $request->payment_data;
        try
        {
            foreach($data as $item){
                $productData['prd_id'] = $item['id'];
                $productData['userid'] = $request->user_id;
                $productData['prd_name'] = $item['name'];
                $productData['prd_price'] = $item['price'];
                $productData['GST'] = "";
                $productData['total_price'] = $request->payment_amount;
                $productData['status'] = 'Completed';
                OrderProduct::create($productData);
            }
            Cart::where('userid',$request->user_id)->delete();
            $response['message'] = 'Successfully Added';
            $response['status'] = 201;
            return response($response);
        }catch(Exception $ex){
            return response($ex->getMessage());
        }
    }

    public function getPaymentDetails(Request $request)
    {
        try{
            $payment_data = Cart::where('userid',$request->user_id)->with('product')->get();

            foreach($payment_data as $index=>$data){
                $products[$index]['id'] = $data->productid;
                $products[$index]['name'] = $data->product['name'];
                $products[$index]['description'] = $data->product['description'];
                $products[$index]['price'] = $data->product['price'];
                $products[$index]['category'] = $data->product['category'];
            }
            return $products;
        }catch(Exception $ex){
            return response($ex->getMessage());
        }
    }

    public function addToCart(Request $request)
    {
        try{
            $cart = new Cart;
            $cart->productid = $request->product_id;
            $cart->userid = $request->user_id;
            $cart->save();

            $cart_count = Cart::count();
            return $cart_count;

        }catch(Exception $ex){
            return response($ex->getMessage());
        }
    }

    public function register(Request $request)
    {
        $user = User::where('email',$request['email'])->first();
        if($user){
            $response['message'] = 'Email Already Exists';
        }else{

            $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_active' => 0,
            'status' => 'Active'
        ]);

            $response['message'] = 'Register Success';
            $response ['user'] = $user;
            $response ['token'] = $user->createToken('userdata')->accessToken;
        }
            return response($response);
    }

    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!Auth::attempt($login))
        {
            $response['message'] = 'Invalid Email and Password';
            $response['status'] = 0;

            return response($response);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        $response ['accessToken'] = $accessToken;
        $response ['message'] = "Login Success";
        $response ['user'] = Auth::user();
        $response['status'] = 1;

        return response($response);
    }

    public function showUser()
    {
        $user = User::all();
        return $user;
    }

    public function insertChatData(Request $request,$id)
    {
        //$file = $request->file('file');
        //$uploadpath = '../public/img';
        //$image = $file->getClientOriginalName();
        //$file->move($uploadpath,$image);
        $chat = new Chat();
        $text = $request->data;
        $chat->toUser = $id;
        $chat->textChat = $text;
        $uid = json_decode($request->userid);
        $chat->fromUser = $uid;
        //$chat->image = $image;
        $chat->save();

        return response($chat);

    }

    public  function getChatData(Request $request,$id)
    {
        $logged_id = json_decode($request->uid);

        //\DB::enableQueryLog();
        // $chat = Chat::where('toUser','=',$id)->where('fromUser','=',$logged_id)->get();
        //dd(\DB::getQueryLog());

        $query =  Chat::where(function($query) use($id,$logged_id)
        {
           $query->where('toUser','=',$id)
            ->Where('fromUser','=',$logged_id);
        })->orWhere(function($query)use($id,$logged_id) {
           $query->where('toUser','=',$logged_id)
            ->Where('fromUser','=',$id);
        })->get();

        return response($query);

    }

    // public  function getChat(Request $request,$id)
    // {
    //     $logged_id = json_decode($request->uid);
    //     //\DB::enableQueryLog();
    //     $chat = Chat::where('toUser','=',$logged_id)->where('fromUser','=',$id)->get();
    //     //dd(\DB::getQueryLog());
    //     return response($chat);

    // }



}
