
@extends('layouts.admin')
@section('content')
    @include('includes.form_error')

    <div class="row">
        <div class="col-lg-8 col-md-10 col-12 m-auto">
            <h3 class="mt-3 mb-0 text-center">Edit coupon {{$coupon->name}}</h3>
            <p class="lead font-weight-normal opacity-8 mb-7 text-center"> Here you can edit this existing coupon.
                <br> Watch out, this will edit the coupon for all the orders in your webshop! </p>
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                        <h6 class="text-white text-capitalize ps-3">Edit :</h6>

                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('coupons.update', $coupon->id)}}" method="post" enctype="multipart/form-data" class="col-10 mx-auto mb-3">
                        @csrf
                        @method('PATCH')
                        <div class="input-group input-group-dynamic mt-5">
                            <input value="{{$coupon->code}}" class="fs-5 form-control" type="text" onfocus="focused(this)" required
                                   onfocusout="defocused(this)"  id="code" name="code" placeholder="Coupon code... (only numbers!)">
                        </div>
                        <div class="input-group input-group-dynamic mt-5">
                            <input value="{{$coupon->description}}" class="fs-5 form-control" type="text" onfocus="focused(this)" required
                                   onfocusout="defocused(this)" id="description" name="description" placeholder="Coupon description...">
                        </div>
                        <div class="input-group input-group-dynamic mt-5">
                            <input value="{{$coupon->discount}}" class="fs-5 form-control" type="number" onfocus="focused(this)" required
                                   onfocusout="defocused(this)"  id="discount" name="discount" placeholder="Coupon discount...">
                        </div>



                        <button type="submit" class="btn btn-primary mt-5 opacity-8 ">Save changes</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

