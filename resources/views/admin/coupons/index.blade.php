
@extends('layouts.admin')
@section('content')
    <div class="col-11 mx-auto">
        @include('includes.form_error')

    @if(session('coupon_message'))
            <div class="alert alert-success opacity-7 alert-dismissible text-white" role="alert">
                <i class="material-icons ps-3">
                    notifications_active
                </i>
                <span class="text-sm ps-4">{{session('coupon_message')}} </span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close" control-id="ControlID-6">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

        @endif
    </div>
    <div class="row m-0 p-0">
        <div class="col-12 mt-5">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                        <h6 class="text-white text-capitalize ps-3">Coupons table :  <span class="ms-5 text-sm "> {{$coupons->count()}}  /  {{\App\Models\Coupon::all()->count()}}  </span></h6>
                        <button class="btn bg-gradient-warning  mb-0  me-4" type="button"   data-bs-toggle="modal" data-bs-target="#exampleModal" >
                            <div class=" me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">add</i>  Add coupon

                            </div>
                        </button>
                    </div>
                </div>

                <form class="ms-5 mt-5">
                    @csrf
                    <input type="text" name="search" class="form-control mb-3 border-1 small"
                           placeholder="Search through codes, descriptions, discounts, ..." aria-label="Search" aria-describedby="basic-addon2">
                </form>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>



                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Coupon code</th>

                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Discount</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>

                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deleted</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coupons as $coupon)

                                <tr>
                                    <td>
                                        <span class=" text-xs font-weight-bold ps-3">
                                         {{$coupon->id}}
                                        </span>

                                    </td>

                                    <td class="text-center text-uppercase text-xxs font-weight-bolder opacity-9"><span class=" text-xs font-weight-bold">{{$coupon->code}}</span></td>
                                    <td class="text-center text-uppercase  text-xxs font-weight-bolder opacity-9"><span class=" text-xs font-weight-bold">{{$coupon->discount}} &percnt;</span></td>
                                    <td class="text-center text-uppercase  text-xxs font-weight-bolder opacity-9"><span class=" text-xs font-weight-bold">{{$coupon->description}}</span></td>

                                    <td class="align-middle text-center"><span class="text-secondary text-xs font-weight-bold">{{$coupon->created_at}}</span></td>
                                    <td class="align-middle text-center"><span class="text-secondary text-xs font-weight-bold">{{$coupon->updated_at}}</span></td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$coupon->deleted_at}}</span>
                                    </td>
                                    <td class="align-middle ">

                                        @if($coupon->deleted_at != null)
                                            <a class="btn btn-link text-dark px-3 mb-0" href="{{route('coupons.restore',$coupon->id)}}"><i class="material-icons text-sm me-2">restore</i>Restore</a>
                                        @else
                                            <form method="POST"
                                                  action="{{action("App\Http\Controllers\AdminCouponsController@destroy", $coupon->id)}}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{route('coupons.edit', $coupon->id)}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit coupon">
                                                    <i class="material-icons text-sm me-2">edit</i>
                                                </a>
                                                <button class="btn btn-link text-danger text-gradient px-3 mb-0 ps-5" type="submit"><i class="material-icons text-sm me-2">delete</i></button>
                                            </form>
                                        @endif
                                    </td>
                                    <div class="ms-auto text-end">

                                    </div>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-3 mx-auto">
            {{$coupons->render()}}

        </div>
        <!-- Modal coupon CREATE -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add a new coupon to database</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('coupons.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="input-group input-group-dynamic mt-5">
                                <input class="fs-5 form-control" type="text" onfocus="focused(this)" required
                                       onfocusout="defocused(this)"  id="code" name="code" placeholder="Coupon code... (only numbers!)">
                            </div>
                            <div class="input-group input-group-dynamic mt-5">
                                <input class="fs-5 form-control" type="text" onfocus="focused(this)" required
                                       onfocusout="defocused(this)" control-id="ControlID-3" id="description" name="description" placeholder="Coupon description...">
                            </div>
                            <div class="input-group input-group-dynamic mt-5">
                                <input class="fs-5 form-control" type="number" onfocus="focused(this)" required
                                       onfocusout="defocused(this)" control-id="ControlID-4" id="discount" name="discount" placeholder="Coupon discount...">
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary opacity-8">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

