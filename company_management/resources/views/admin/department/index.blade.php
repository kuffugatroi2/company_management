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
                    <form action="{{ route('departments.index') }}" method="GET" id="demo-form2" data-parsley-validate
                        class="form-horizontal form-label-left">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Phòng ban</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Vui lòng nhập phòng ban cần tìm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 "></label>
                                        <div class="col-md-9 col-sm-9 ">
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
                    <h2>Danh sách phòng ban</h2>
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
                                <br>
                                <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Phòng ban</th>
                                            <th>Công ty</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['departmentParent'] as $value)
                                            <tr>
                                                <td>{{ $value->code }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->company->name }}</td>
                                                <td class="text-primary">{{ $value->created_at }}</td>
                                                <td class="text-primary">{{ $value->updated_at }}</td>
                                            </tr>
                                            @foreach ($data['departmentChild'] as $item)
                                                @if ($item->parent_id == $value->id)
                                                    <tr>
                                                        <td>---- {{ $item->code }}</td>
                                                        <td>---- {{ $item->name }}</td>
                                                        <td>{{ $item->company->name }}</td>
                                                        <td class="text-primary">{{ $item->created_at }}</td>
                                                        <td class="text-primary">{{ $item->updated_at }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if (!empty($data['departments']))
                            <div class="col-lg-12 mt-3 d-flex justify-content-center">
                                {{ $data['departments']->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
