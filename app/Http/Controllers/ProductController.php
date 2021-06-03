<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $products = new Product;
        if(!empty($request->searchproduct)) {
            $products = $products->where('name','LIKE',"%" .$request->searchproduct ."%");
        }

        if(!empty($request->filterdata)) {
            $products = $products-> where('category','=',$request->filterdata);
        }

        $products = $products->paginate(5);
        $totalproduct = Product::count();
        $avaliable = Product::where('status','=','Avaliable')->count();
        $unavaliable = Product::where('status','=','Unavaliable')->count();
        return view('product-index', compact('products','totalproduct','avaliable','unavaliable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('add-product',['category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $imageName = $request->file('image')->getClientOriginalName();
        $request->image->move(public_path('img'), $imageName);

        $products = new Product;
        $products->name = $request->input('productname');
        $products->category = $request->input('productcategory');
        $products->price = $request->input('productprice');
        $products->description = $request->input('productdescription');
        $products->status = "Avaliable";
        $products->image=$imageName;

        $products->save();
        return redirect('product-index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $id)
    {

        $product = Product::find($id);
        $category = Category::all();
        return view('/edit-product',['category'=>$category])->with('product',$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id',$id)->update([
            'name' => $request->input('productname'),
            'category' => $request->input('productcategory'),
            'price' => $request->input('productprice'),
            'description' => $request->input('productdescription'),
         ]);
         return redirect('/product-index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Product::destroy($id);
        return redirect('/product-index');
    }
    public function updateStatus(Request $request)
    {
        Product::where('id',$request->id)->update([
            'status' => $request->status
        ]);
    }
    public function activeproduct(Request $request)
    {
        $activeproduct = Product::where('status','Avaliable')->get();
        return view('activeproduct-index')->with('activeproduct',$activeproduct);
    }

    public function addtocart(Request $request)
    {

            $cart = new Cart;
            $cart->productid = $request->productid;
            $cart->userid = Auth::id();
            $cart->save();

            return redirect('/activeproduct-index');
    }

    public function cartlist()
    {
        $uid = Auth::id();
       // $product = DB::table('products')->join('carts','carts.productid','products.id')->where('carts.userid',$uid)->get();
       $product = Cart::where('userid',$uid)->with('products')->get();
       return view('cart-index',['product'=>$product]);
    }

    public function removecart($id)
    {
        Cart::destroy($id);
        return redirect('/cart-index');
    }

    public function ordernow()
    {
        $uid = Auth::id();
        //$total =  DB::table('carts')->join('products','carts.productid','products.id')->select('products.*')->where('carts.userid',$uid)->sum('products.price');
        //$total = Cart::with('products')->get();
        // $product = Cart::with('products')->get();
        $product = User::where('id',$uid)->with(['carts', 'carts.product'])->first();
        // $product = CartProduct::with('products')->get();

        // echo "<pre>";
        // print_r($product->toArray());
        // die;
        $total = 0;
        foreach($product->carts as $item)
        {
            $total = $total + $item->product->price;
        }
        return view('ordernow',['total'=>$total]);
    }

    public function orderplaced(Request $request)
    {
        $uid = Auth::id();
        $cartdata = Cart::where('userid',$uid)->get();

        foreach($cartdata as $cart)
        {
            $order = new Order;
            $order->productid=$cart['productid'];
            $order->userid=$cart['userid'];
            $order->status='paid';
            $order->payment=$request->payment;
            $order->save();
        }
        Cart::where('userid',$uid)->delete();
        return redirect('home');

        //return $request->input();
    }
}
