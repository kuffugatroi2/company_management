@extends('admin/layout/layout')
@section('admin_content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form thông tin dự án</h2>
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
                                    value="{{ $project['data']->code ?? '' }}" />
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
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Dự án<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="name" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="name" placeholder="Nhập tên dự án" required
                                    value="{{ $project['data']->name ?? '' }}" />
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
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Mô tả</label>
                            <div class="col-md-6 col-sm-6">
                                <textarea rows="3" name="description" class="form-control ckeditor" placeholder="Mô tả vai trò">{{ $project['data']->description ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Công ty<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control" name="company_id" id="company_id" required>
                                    @if (isset($companies) && !$companies->isEmpty())
                                        <option value="">--------------------------Chọn công ty--------------------------</option>
                                        @foreach ($companies as $value)
                                            <option value="{{ encrypt($value->id) }}"
                                                {{ (isset($project['data']) && $value->id == $project['data']->company_id) ? 'selected' : '' }}>
                                                {{ $value->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="hidden" value="{{ (isset($project['data']) && !empty($project['data']) ? $project['data']->id : 0) }}" id="project_id">
                                @error('company_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Nhân viên</label>
                            <div class="col-md-6 col-sm-6" id="person_id">
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

    <script>
        $(document).ready(function() {
            $("#company_id").change(function() {
                var company_id = $(this).val(); // Lấy id của chính nó
                var project_id = $("#project_id").val(); // lấy id của project
                $.get("admin/persons-ajax/" + company_id + "/" + project_id, function(data) { // gọi ajax
                    console.log(data);
                    $("#person_id").html(data); //truyền lại cho nhân viên
                })
            });
        });
    </script>
@endsection
