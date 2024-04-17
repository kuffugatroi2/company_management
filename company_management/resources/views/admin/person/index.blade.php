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
                    <form action="{{ route('persons.index') }}" method="GET" id="demo-form2" data-parsley-validate
                        class="form-horizontal form-label-left">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Nhân viên</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" name="full_name"
                                                placeholder="Vui lòng nhập tên nhân viên cần tìm">
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Số điện thoại</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" name="phone_number"
                                                placeholder="Vui lòng nhập số điện thoại cần tìm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Địa chỉ</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" name="address"
                                                placeholder="Vui lòng nhập địa chỉ cần tìm">
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
                    <h2>Danh sách nhân viên</h2>
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
                                                <form action="{{ route('persons.index') }}" method="GET">
                                                    <label>Chọn</label>
                                                    <select name="select-item" id="persons"
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
                                            <button class="btn btn-danger delete-all"
                                                onclick="return confirm('Bạn có chắc muốn xóa những công ty này không?')">Xóa
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
                                            <th>Nhân viên</th>
                                            <th>Email</th>
                                            <th>Giới tính</th>
                                            <th>Ngày sinh</th>
                                            <th>Số điện thoại</th>
                                            <th>Địa chỉ</th>
                                            <th>Công ty</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày update</th>
                                            <th>Hoạt động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['persons'] as $value)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" value="{{ $value->id }}">
                                                </td>
                                                <td>{{ $value->full_name }}</td>
                                                <td>{{ $value->user->email }}</td>
                                                <td>{{ checkPersonGender($value->gender) }}</td>
                                                <td class="text-primary">{{ $value->birthdate }}</td>
                                                <td class="text-success">{{ $value->phone_number }}</td>
                                                <td>{{ $value->address }}</td>
                                                <td>{{ $value->company->name }}</td>
                                                <td class="text-primary">{{ $value->created_at }}</td>
                                                <td class="text-primary">{{ $value->updated_at }}</td>
                                                <td class="d-flex justify-content-center">
                                                    <form action="{{ route('persons.destroy', encrypt($value->id)) }}"
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
                                                                    href="{{ route('persons.edit', encrypt($value->id)) }}">
                                                                    <i class="text-primary mr-1 fa fa-edit"></i>Sửa
                                                                </a>
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Bạn có chắc muốn xóa nhân viên này không?')">
                                                                    <i class="text-danger mr-1 fa fa-trash"></i>Xóa
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if (!empty($data['persons']))
                            <div class="col-lg-12 mt-3 d-flex justify-content-center">
                                {{ $data['persons']->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
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
                    fetch('{{ route('persons.delete_all') }}', {
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
                    alert('Vui lòng chọn ít nhất một nhân viên để xóa!');
                }
            });
        });
    </script>
@endsection
