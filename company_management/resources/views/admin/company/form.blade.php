@extends('admin/layout/layout')
@section('admin_content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form thông tin công ty</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ $action }}" method="{{ $method }}" enctype="multipart/form-data">
                        @csrf
                        @if (isset($function) && $function == 'edit')
                            @method('PUT')
                        @endif
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Code<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="code" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="code" placeholder="Nhập mã code" required
                                    value="{{ $company['data']->code ?? '' }}" />
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if (session('errorCode'))
                                    <div class="text-danger">
                                        {{ session('errorCode') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Công ty<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="name" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="name" placeholder="Nhập tên công ty" required
                                    value="{{ $company['data']->name ?? '' }}" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if (session('errorName'))
                                    <div class="text-danger">
                                        {{ session('errorName') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Địa chỉ<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="address" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="address" placeholder="Nhập địa chỉ" required
                                    value="{{ $company['data']->address ?? '' }}" />
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="ln_solid">
                            <div class="form-group">
                                <br>
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-success">Submit</button>
                                    <button type='reset' class="btn btn-primary">Reset</button>
                                    <a href="{{ route('companies.index') }}" class="btn btn-warning text-danger">Come back
                                        <i class="fa fa-backward"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
