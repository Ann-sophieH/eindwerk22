<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsEditRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Specification;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdminProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        $this->authorize('viewAny', $user);

        $categories = Category::all();
        $products = Product::with(['specifications', 'colors', 'category', 'photos'])->withTrashed()->filter(request(['search']))->paginate(15);
        $specs = Specification::whereNotNull('parent_id')->with( 'childspecs')->get();
        $product = null;
        return view('admin.products.index', compact('products', 'specs', 'categories', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();
        $this->authorize('create', $user);

        $colors = Color::all(); //see all knop maken!!
        $specs = Specification::whereNull('parent_id')->with( 'childspecs')->get();
        $categories = Category::all();
        $product = null; // simply so i can use same sub_specs_filter in create as i used in edit.blade
        return view('admin.products.create', compact('colors', 'specs' , 'categories', 'product'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->details = $request->details;
        $product->slug = Str::slug($product->name, '-');

        $product->price = $request->price;
        $product->category_id = $request->category;
        $product->save();
        /**photo opslaan**/
        $files = $request->file('photos');
       // dd($request->file('photos') );
        if($request->hasfile('photos')){
            foreach( $files as $file){
                $name = time() . $file->getClientOriginalName();
                Image::make($file)
                    ->resize(2650, 2650, function ($constraint){
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('assets/img/products/' . 'md_' . $name)); //enkel thumbnail vn product
                $mediumProduct = 'products/' . 'md_' . $name ;
                $photo = Photo::create(['file'=>$mediumProduct]);
                $product->photos()->save($photo);
            }}
        $product->colors()->sync($request->colors,false);

        $product->specifications()->sync($request->specifications,false);
        Session::flash('product_message', 'A new product was added!');

        return redirect('admin/products');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //see page details frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $product = Product::findOrFail($id);
        $user = User::findOrFail($id);
        $this->authorize('update', $product, $user);
        $specs = Specification::whereNull('parent_id')->with( 'childspecs')->get();
        $categories = Category::all();
        $colors = Color::all();

        return view('admin.products.edit', compact('product','specs','categories', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsEditRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $input = $request->all();
        /** edit many-relationships **/
        $product->colors()->sync($request->colors, true);
        $product->specifications()->sync($request->specifications, true);

        /** update photo **/
        $files = $request->file('photos');
        if($request->hasfile('photos')){
            foreach( $files as $file){
                $name = time() . $file->getClientOriginalName();
                Image::make($file)
                    ->resize(720, 720, function ($constraint){
                        $constraint->aspectRatio();
                    })

                    ->save(public_path('assets/img/products/' . 'md_' . $name));
                $mediumProduct = 'products/' . 'md_' . $name ;

                $photo = Photo::create(['file'=>$mediumProduct]);
                $product->photos()->save($photo);
            }
        }

        $product->update($input);
        Session::flash('product_message', 'Product: ' . $product->name . ' was edited!');
        return redirect('/admin/products');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        //need to cascade delete something here?
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product, $user);

        Session::flash('product_message', $product->name . ' was deleted!'); //naam om mess. op te halen, VOOR DELETE OFC
        $product->delete();
        return redirect('/admin/products');
    }
    public function restore($id){
        Product::onlyTrashed()->where('id', $id)->restore();
        Session::flash('product_message', 'Product was restored  !');

        return redirect('/admin/products');
    }
    public function productsPerCat($id){
        $user = Auth::user();
        $this->authorize('viewAny', $user);

        $categories = Category::all();
        $products = Product::where('category_id' , $id)->with(['colors', 'photos', 'specifications'])->paginate(25);
        return view('admin.products.index', compact('categories', 'products'));

    }


}
