@extends('admin/layout/layout')
@section('admin_content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="product-area pt-35 col-lg-12">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="li-product-tab">
                                                    <ul class="nav li-product-menu">
                                                        <li><a class="active btn btn-primary" data-toggle="tab"
                                                            href="#company"><span>Form công ty</span></a>
                                                        </li>
                                                        <li><a class="btn btn-primary {{ (isset($function) && $function == 'edit') ? '' : 'd-none' }}"
                                                            data-toggle="tab" href="#department"><span>Form phòng ban</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="tab-content">
                                            @include('admin.company.layout.form-company')
                                            @if ((isset($function) && $function == 'edit'))
                                                @include('admin.company.layout.form-department')
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
