@extends('admin/layout/layout')
@section('admin_content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title show-filter">
                    <h2 class="h5"><small><i class="mr-2 fa fa-search"></i></small>Search</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="mt-2 ml-1"><i class="fa fa-chevron-down icon-show-filter"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content d-none" id="filter-form">
                    <br />
                    <form action="{{ route('tasks.index') }}" method="GET" id="demo-form2" data-parsley-validate
                        class="form-horizontal form-label-left">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Dự án</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select class="form-control" name="project_id" id="project_id">
                                                <option value="">--------------- Chọn dự án ---------------<option>
                                                @if (isset($projects) && !$projects->isEmpty())
                                                    @foreach ($projects as $value)
                                                        <option value="{{ $value->id }}">
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Nhân viên</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select class="form-control" name="person_id" id="person_id">
                                                <option value="">--------------- Chọn nhân viên ---------------<option>
                                                @if (isset($persons) && !$persons->isEmpty())
                                                    @foreach ($persons as $value)
                                                        <option value="{{ $value->id }}">
                                                            {{ $value->full_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Nhiệm vụ</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Vui lòng nhập nhiệm vụ cần tìm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Ưu tiên</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select class="form-control" name="priovity" id="priovity">
                                                <option value="">--------------- Chọn ưu tiên ---------------<option>
                                                <option value="1">High</option>
                                                <option value="2">Medium</option>
                                                <option value="3">Low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Trạng thái</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select class="form-control" name="status" id="status">
                                                <option value="">--------------- Chọn trạng thái ---------------<option>
                                                <option value="1">New</option>
                                                <option value="2">In progress</option>
                                                <option value="3">Resolved</option>
                                                <option value="3">pause</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-12 col-sm-12 offset-md-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success">Search</button>
                                <button class="btn btn-primary" type="reset">Reset</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div id="alert" style="opacity: 1; transition: opacity 2s;">
                    @include('Layout.messenger')
                </div>
                <div class="x_title">
                    <h2>Danh sách nhiệm vụ</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="selectbox">
                                                <form action="{{ route('tasks.index') }}" method="GET">
                                                    <label for="brand">Chọn</label>
                                                    <select name="select-item" id="companies"
                                                        style="width: 50px; height:38px" onchange="this.form.submit()">
                                                        <option value="10">10</option>
                                                        <option value="20">20</option>
                                                        <option value="50" selected>50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    mục
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-sm d-flex justify-content-end">
                                            <a href="{{ route('tasks.create') }}" class="btn btn-success">Tạo mới</a>
                                            <button class="btn btn-danger delete-all"
                                                onclick="return confirm('Bạn có chắc muốn xóa những nhiệm vụ này không?')">Xóa
                                                all</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>Dự án</th>
                                            <th>Nhiệm vụ</th>
                                            <th>Người được giao</th>
                                            <th>Mô tả</th>
                                            <th>Bắt đầu</th>
                                            <th>Kết thúc</th>
                                            <th>Ưu tiên</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày update</th>
                                            <th>Hoạt động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($data['projects']) && !$data['projects']->isEmpty())
                                            @foreach ($data['projects'] as $value)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" value="{{ $value->id }}">
                                                    </td>
                                                    <td>{{ $value->project->name }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->person->full_name }}</td>
                                                    <td>{!! $value->description !!}</td>
                                                    <td>{{ $value->start_time }}</td>
                                                    <td>{{ $value->end_time }}</td>
                                                    <td>{{ checkPriorityTask($value->priority) }}</td>
                                                    <td>{{ checkStatusTask($value->status) }}</td>
                                                    <td class="text-primary">{{ $value->created_at }}</td>
                                                    <td class="text-primary">{{ $value->updated_at }}</td>
                                                    <td class="d-flex justify-content-center">
                                                        <form action="{{ route('tasks.destroy', encrypt($value->id)) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="dropdown">
                                                                <label class="dropdown-toggle" data-toggle="dropdown"
                                                                    role="button" aria-expanded="false"><i
                                                                        class="h2 fa fa-navicon"></i>
                                                                </label>
                                                                <div class="dropdown-menu text-center"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('tasks.edit', encrypt($value->id)) }}">
                                                                        <i class="text-primary mr-1 fa fa-edit"></i>Sửa
                                                                    </a>
                                                                    <button type="submit" class="dropdown-item"
                                                                        onclick="return confirm('Bạn có chắc muốn xóa nhiệm vụ này không?')">
                                                                        <i class="text-danger mr-1 fa fa-trash"></i>Xóa
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- @if (!empty($data['companies']))
                            <div class="col-lg-12 mt-3 d-flex justify-content-center">
                                {{ $data['projects']->links('pagination::bootstrap-4') }}
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ------------------------------Xử lý xóa all checkbox---------------------------------
            // Lấy thẻ checkbox ở thẻ thead
            var mainCheckbox = document.querySelector('#datatable-checkbox thead input[type="checkbox"]');
            // Lấy tất cả các ô checkbox ở tbody trừ các thẻ có thuộc tính 'disabled'
            var checkboxes = document.querySelectorAll(
                '#datatable-checkbox tbody input[type="checkbox"]:not([disabled])');

            mainCheckbox.addEventListener('click', function() {
                /*
                    kiểm tra xem nút checkbox all ở thread có checked hay không
                    - Nếu checked thì sẽ checked tất cả các nút checkbox ở tbody
                    - Nếu bỏ checked ở thread thì cũng sẽ bỏ checked ở tbody
                */
                if (mainCheckbox && mainCheckbox.checked) {
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = mainCheckbox.checked;
                    });
                } else {
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                }
            });

            // Lắng nghe sự kiện click trên nút xóa all
            var deleteAll = document.querySelector('.delete-all');

            deleteAll.addEventListener('click', function() {
                // Lấy tất cả các checkbox đã được chọn
                var selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                // Tạo một mảng để lưu trữ các ID của sản phẩm đã chọn
                var selectedIds = [];
                // Lặp qua danh sách các checkbox đã được chọn để lấy ID và thêm vào mảng
                selectedCheckboxes.forEach(function(checkbox) {
                    // Lấy ID của sản phẩm từ thuộc tính value của checkbox
                    var BrandId = checkbox.value;
                    // Thêm ID vào mảng
                    selectedIds.push(BrandId);
                });
                // Kiểm tra xem nếu checkbox all được checked thì xóa bỏ phần tử đầu tiên (checkbox của checkbox all)
                if (mainCheckbox && mainCheckbox.checked) {
                    selectedIds.shift();
                }
                //Kiểm tra nếu có ít nhất một sản phẩm đã được chọn
                if (selectedIds.length > 0) {
                    fetch('{{ route('tasks.delete_all') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                listIds: selectedIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Cập nhật DOM để loại bỏ các phần tử đã xóa (không load lại trang)
                            selectedCheckboxes.forEach(function(checkbox) {
                                // Lấy hàng cha của checkbox và loại bỏ nó
                                var row = checkbox.closest('tr');
                                row.parentNode.removeChild(row);
                            });
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    alert('Vui lòng chọn ít nhất một nhiệm vụ để xóa!');
                }
            });
        });
    </script>
@endsection
