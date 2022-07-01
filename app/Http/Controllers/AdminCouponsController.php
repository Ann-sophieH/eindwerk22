<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminCouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $coupons = Coupon::withTrashed()
            ->filter(request(['search']))
            ->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.coupons.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'code' => 'required|unique:coupons',
            'discount' => 'required|integer',
            'description' => 'required',
        ], $messages = [
            'code.required' => 'We need to know what code you want to make!',
            'discount.required' => 'We need to know how much % discount (in numbers) you want to offer!',

        ]);
        $coupon = new coupon();
        $coupon->description = $request->description;
        $coupon->code = $request->code;
        $coupon->discount = $request->discount;

        $coupon->save();
        Session::flash('coupon_message', 'coupon was saved!');

        return redirect()->back();
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
    public function edit($id)
    {
        //
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact( 'coupon'));

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
        //
        $request->validate([
            'code' => 'required',
            'discount' => 'required|integer',
            'description' => 'required',
        ], $messages = [
            'code.required' => 'We need to know what code you want to make!',
            'discount.required' => 'We need to know how much % discount (in numbers) you want to offer!',

        ]);
        $coupon = Coupon::findOrFail($id);
        $coupon->description = $request->description;
        $coupon->code = $request->code;
        $coupon->discount = $request->discount;

        $coupon->update();
        Session::flash('coupon_message', $coupon->name . ' was edited and saved!');
        return redirect('/admin/coupons/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $coupon = Coupon::findOrFail($id);
        Session::flash('coupon_message', $coupon->name . ' was deleted!'); //naam om mess. op te halen, VOOR DELETE OFC
        $coupon->delete();
        return redirect()->back();
    }
    public function restore( $id){
        coupon::onlyTrashed()->where('id', $id)->restore();
        Session::flash('coupon_message', 'this coupon was restored and is active again!'); //naam om mess. op te halen, VOOR DELETE OFC

        return redirect('/admin/coupons');
    }
    public function coupon(Request $request)
    {
        if (Session::has('cart')){
            $couponDiscount = $request->coupon;
            $coupons = Coupon::all();
            $totalPrice = Session::get('cart')->totalPrice;

            foreach ($coupons as $coupon){
                if($coupon->code == $couponDiscount){                                       //vb 60 - 40% = 36 /
                    Session::put('coupon', $coupon);
                    /** edit totalprice by rule of 3 **/
                    $percentage = $totalPrice / 100;                                          // 60 / 100 = 0.6
                    $discountprice = $percentage * $coupon->discount;                               // 0.6 * 40 = 24
                    $NewTotal = $totalPrice - $discountprice;                                   // 60 - 24 = 36
                    Session::get('cart')->totalPrice = $NewTotal;                    // NewTotal = 36 eur
                    Session::flash('coupon_succes');
                    return redirect()->back();
                }else{
                    Session::flash('coupon_error');
                }
            }
            return redirect()->back();
        }else{
            Session::flash('coupon_error');
            return redirect()->back();

        }

    }
}
