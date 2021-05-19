<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
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

    public function index()
    {
        $products = Product::paginate(5);
        return view('product-index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add-product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = new Product;
        $products->name = $request->input('productname');
        $products->category = $request->input('productcategory');
        $products->price = $request->input('productprice');
        $products->description = $request->input('productdescription');
        $products->status = "Avaliable";

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
        return view('/edit-product')->with('product',$id);
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
            'status' => $request->input('productstatus')
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

            return view('cart-index');
    }

    public function cartlist()
    {
        $uid = Auth::id();
       $cart = DB::table('cart')->join('product','cart.productid','=','product.id')->where('cart.userid',$uid)->select('product.*')->get();
    }
}