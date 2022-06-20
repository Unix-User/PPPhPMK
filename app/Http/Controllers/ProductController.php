<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Product;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::latest()->paginate(3);
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 3);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->teams->first()->id == '1') {
            return view('products.create');
        } else {
            return redirect('/products')->with('error', 'Unauthorized Page');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->teams->first()->id == '1') {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'tags' => 'required',
                'price' => 'required|numeric',
                'user_id' => 'max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $product = new Product();
            if ($image = $request->file('image')) {
                $destinationPath = 'images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $product->image = "$profileImage";
            }
            $product->name = $request->name;
            $product->description = $request->description;
            $product->tags = $request->tags;
            $product->price = $request->price;
            $product->user_id = auth()->user()->id;
            $product->save();

            return redirect('/products')->with('success', 'Product created successfully');
        } else {
            return redirect('/products')->with('error', 'Unauthorized Page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if (auth()->user()->id == '1' || auth()->user()->id == $product->user_id) {
            return view('products.edit', compact('product'));
        }
        return redirect('/products')->with('error', 'Unauthorized Page');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (auth()->user()->id == '1' || auth()->user()->id == $product->user_id) {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'tags' => 'required',
                'price' => 'required|numeric',
                'user_id' => 'max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($image = $request->file('image')) {
                $destinationPath = 'images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $product->image = "$profileImage";
            }
            $product->name = $request->name;
            $product->description = $request->description;
            $product->tags = $request->tags;
            $product->price = $request->price;
            $product->user_id = auth()->user()->id;
            $product->save();

            return redirect('/products')->with('success', 'Product updated successfully');
        } else {
            return redirect('/products')->with('error', 'Unauthorized Page');
        }
    }

    /**
     * Buy the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function select($id)
    {
        $product = Product::find($id);
        // update auth user's contract
        $user = User::find(auth()->user()->id);
        $team = Team::where('name', $product->user->name)->first();
        if (!$team) {
            $team = new Team;
            $team->name = $product->user->name;
            $team->save();
        }
        $user->contracts()->create(['user_id' => $user->id, 'product_id' => $product->id, 'reference' => Uuid::uuid4(), 'created_at' => now(), 'updated_at' => null]);
        $user->teams()->sync($team);
        // redirect user id page
        return redirect('/user/' . $user->id . '/show')->with('success', 'Seu novo produto foi selecionado com sucesso');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $product = Product::where('id', $id)->first();
        if ($product->user_id == auth()->user()->id || auth()->user()->id == '1') {
            $product->delete();
            return redirect('/products')->with('success', 'Product deleted successfully');
        }
        return redirect('/products')->with('error', 'Unauthorized Page');
    }
}
