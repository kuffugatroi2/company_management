@extends('admin/layout/layout')
@section('admin_content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form thông tin user</h2>
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
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Email<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="email" id="email" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="email" placeholder="Nhập email" required
                                    value="{{ $user['data']->email ?? '' }}"
                                    {{ isset($user['data']->email) ? 'readonly' : '' }} />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if (session('error'))
                                    <div class="text-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">password<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="password" id="password" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="password" placeholder="Nhập password" required
                                    value="{{ $user['data']->password ?? '' }}" />
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Trạng thái</label>
                            @if (!empty($user['data']->is_active))
                                <div class="form-check form-check-inline ml-3">
                                    <input class="flat" type="radio" value="active" name="is_active"
                                        @if ($user['data']->is_active == 'active') checked @endif>
                                    <label class="form-check-label ml-1" for="inlineradio">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="flat" type="radio" value="unactive" name="is_active"
                                        @if ($user['data']->is_active == 'unactive') checked @endif>
                                    <label class="form-check-label ml-1" for="inlineradio">Unactive</label>
                                </div>
                            @else
                                <div class="form-check form-check-inline ml-3">
                                    <input class="flat" type="radio" value="active" name="is_active" checked>
                                    <label class="form-check-label ml-1" for="inlineradio">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="flat" type="radio" value="unactive" name="is_active">
                                    <label class="form-check-label ml-1" for="inlineradio">Unactive</label>
                                </div>
                            @endif
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Vai trò<span
                                    class="text-danger h5">*</span></label>
                            <div class="form-check form-check-inline ml-3">
                                @foreach ($roles as $key => $value)
                                    <span class="mr-2">
                                        @if (isset($user) && in_array($value->id, $user['listRole']))
                                            <input type="checkbox" name="{{ $value->role }}" id="role"
                                                value="{{ $value->role }}" data-parsley-mincheck="2" class="flat"
                                                checked />
                                            {{ $value->role }}
                                        @else
                                            <input type="checkbox" name="{{ $value->role }}" id="role"
                                                value="{{ $value->role }}" data-parsley-mincheck="2" class="flat" />
                                            {{ $value->role }}
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
                            <div class="form-check form-check-inline ml-3">
                                @if (session('errorRole'))
                                    <div class="text-danger">
                                        {{ session('errorRole') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="ln_solid">
                            <div class="form-group">
                                <br>
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-success">Submit</button>
                                    <button type='reset' class="btn btn-primary">Reset</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-warning text-danger">Come back <i
                                            class="fa fa-backward"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
