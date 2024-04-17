@extends('admin/layout/layout')
@section('admin_content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form thông tin nhân viên</h2>
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
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Công ty<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control" name="company_id">
                                    @if (isset($companies))
                                        @foreach ($companies['listCompany'] as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ $person['data']->company_id }}">
                                            {{ $person['data']->company->name }}</option>
                                    @endif
                                </select>
                                @error('company_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Họ tên<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="full_name" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="full_name" placeholder="Nhập họ tên nhân viên" required
                                    value="{{ $person['data']->full_name ?? '' }}" />
                                @error('full_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Giới tính<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <div id="gender" class="btn-group" data-toggle="buttons">
                                    @if (!empty($person['data']->gender))
                                        <label class="btn btn-warning" data-toggle-class="btn-primary"
                                            data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="male" class="join-btn"
                                                @if ($person['data']->gender == 'male') checked @endif>
                                            &nbsp;
                                            Male
                                            &nbsp;
                                        </label>
                                        <label class="btn btn-danger" data-toggle-class="btn-primary"
                                            data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="female" class="join-btn"
                                                @if ($person['data']->gender == 'female') checked @endif> Female
                                        </label>
                                        <label class="btn btn-primary" data-toggle-class="btn-primary"
                                            data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="other" class="join-btn"
                                                @if ($person['data']->gender == 'other') checked @endif>&nbsp;
                                            Other
                                            &nbsp;
                                        </label>
                                    @else
                                        <label class="btn btn-warning" data-toggle-class="btn-primary"
                                            data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="male" class="join-btn" checked>
                                            &nbsp;
                                            Male
                                            &nbsp;
                                        </label>
                                        <label class="btn btn-danger" data-toggle-class="btn-primary"
                                            data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="female" class="join-btn"> Female
                                        </label>
                                        <label class="btn btn-primary" data-toggle-class="btn-primary"
                                            data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="other" class="join-btn">&nbsp;
                                            Other
                                            &nbsp;
                                        </label>
                                    @endif

                                </div>
                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Ngày sinh <span
                                    class="text-danger h5">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input id="birthdate" name="birthdate" class="date-picker form-control"
                                    placeholder="dd-mm-yyyy" type="text" required="required" type="date"
                                    onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'"
                                    onblur="this.type='text'" onmouseout="timeFunctionLong(this)"
                                    value="{{ $person['data']->birthdate ?? '' }}">
                                @error('birthdate')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <script>
                                    function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                        }, 60000);
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Số điện thoại</label>
                            <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <input type="number" class="form-control" id="phone_number" name="phone_number"
                                    placeholder="Nhập số điện thoại" value="{{ $person['data']->phone_number ?? '' }}">
                                @error('phone_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if (session('error'))
                                    <div class="text-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Địa chỉ<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="address" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="address" placeholder="Nhập địa chỉ thường trú" required
                                    value="{{ $person['data']->address ?? '' }}" />
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @if (isset($function) && $function == 'create')
                            <input type="hidden" name="user_id" value="{{ $userId }}">
                        @endif
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
