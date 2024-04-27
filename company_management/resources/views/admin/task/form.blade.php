@extends('admin/layout/layout')
@section('admin_content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form thông tin nhiệm vụ</h2>
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
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Dự án<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control" name="project_id" id="project_id" required>
                                    @if (isset($projects) && !$projects->isEmpty())
                                        <option value="">--------------------------Chọn dự án--------------------------</option>
                                        @foreach ($projects as $value)
                                            <option value="{{ encrypt($value->id) }}"
                                                {{ isset($project['data']) && $value->id == $project['data']->company_id ? 'selected' : '' }}>
                                                {{ $value->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ encrypt($task['data']->project_id) }}">
                                            {{ $task['data']->project->name }}</option>
                                    @endif
                                </select>
                                @error('project_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Nhân viên</label>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control" name="person_id" id="person_id">
                                    @if (isset($task))
                                        @foreach ($task['data']->project->persons as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $task['data']->person_id == $value->id ? 'selected' : '' }}>
                                                {{ $value->full_name }}</option>
                                        @endforeach
                                    @else
                                        <option value=""></option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Nhiệm vụ<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="name" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="name" placeholder="Nhập nhiệm vụ" required
                                    value="{{ $task['data']->name ?? '' }}" />
                                @error('name')
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
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Mô tả</label>
                            <div class="col-md-6 col-sm-6">
                                <textarea rows="3" name="description" class="form-control ckeditor" placeholder="Mô tả nhiệm vụ">{{ $task['data']->description ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Thời gian bắt đầu</label>
                            <div class="col-md-6 col-sm-6 ">
                                <input id="start_time" name="start_time" class="date-picker form-control"
                                    placeholder="dd-mm-yyyy" type="text" type="date"
                                    onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'"
                                    onblur="this.type='text'" onmouseout="timeFunctionLong(this)"
                                    value="{{ $task['data']->start_time ?? '' }}">
                                @error('start_time')
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
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Thời gian kết thúc </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input id="end_time" name="end_time" class="date-picker form-control"
                                    placeholder="dd-mm-yyyy" type="text" type="date"
                                    onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'"
                                    onblur="this.type='text'" onmouseout="timeFunctionLong(this)"
                                    value="{{ $task['data']->end_time ?? '' }}">
                                @error('end_time')
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
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Mức độ ưu tiên</label>
                            <div class="form-check form-check-inline ml-3">
                                <input class="flat" type="radio" value="1" name="priority"
                                    {{ !empty($task['data']->priority) && $task['data']->status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label ml-1" for="inlineradio">Cao</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="flat" type="radio" value="2" name="priority"
                                    {{ !empty($task['data']->priority) && $task['data']->status == 2 ? 'checked' : '' }}>
                                <label class="form-check-label ml-1" for="inlineradio">Trung bình</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="flat" type="radio" value="3" name="priority"
                                    {{ !empty($task['data']->priority) && $task['data']->status == 3 ? 'checked' : '' }}>
                                <label class="form-check-label ml-1" for="inlineradio">Thấp</label>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Trạng thái</label>
                            @if (!empty($task['data']->status))
                                <div class="form-check form-check-inline ml-3">
                                    <input class="flat" type="radio" value="1" name="status"
                                        {{ $task['data']->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label ml-1" for="inlineradio">Mới tạo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="flat" type="radio" value="2" name="status"
                                        {{ $task['data']->status == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label ml-1" for="inlineradio">Đang làm</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="flat" type="radio" value="4" name="status"
                                        {{ $task['data']->status == 4 ? 'checked' : '' }}>
                                    <label class="form-check-label ml-1" for="inlineradio">Tạm hoãn</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="flat" type="radio" value="3" name="status"
                                        {{ $task['data']->status == 3 ? 'checked' : '' }}>
                                    <label class="form-check-label ml-1" for="inlineradio">Hoàn thành</label>
                                </div>
                            @else
                                <div class="form-check form-check-inline ml-3">
                                    <input class="flat" type="radio" value="1" name="status" checked>
                                    <label class="form-check-label ml-1" for="inlineradio">Mới tạo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="flat" type="radio" value="2" name="status">
                                    <label class="form-check-label ml-1" for="inlineradio">Đang làm</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="flat" type="radio" value="4" name="status">
                                    <label class="form-check-label ml-1" for="inlineradio">Tạm hoãn</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="flat" type="radio" value="3" name="status">
                                    <label class="form-check-label ml-1" for="inlineradio">Hoàn thành</label>
                                </div>
                            @endif
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
            $("#project_id").change(function() {
                var project_id = $(this).val(); // Lấy id của chính nó
                $.get("admin/tasks-ajax/" + project_id, function(data) { // gọi ajax
                    $("#person_id").html(data); //truyền lại cho nhân viên
                })
            });
        });
    </script>
@endsection
