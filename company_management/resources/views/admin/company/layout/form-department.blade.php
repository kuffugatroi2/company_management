@php
    $i = 0;
    $j = 0;
    $keyNew = 0;
    $checkIssetDepartment = true;
    if (isset($departments) && $departments->count() > 0) {
        $action = route('departments.update', encrypt($company['data']->id));
    } else {
        $action = route('departments.store');
        $checkIssetDepartment = false;
    }
@endphp
<div id="department" class="tab-pane" role="tabpanel">
    <div class="product-details-manufacturer">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form thông tin phòng ban</h2>
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
                    @if ($checkIssetDepartment)
                        @method('PUT')
                    @endif
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Công ty</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" data-validate-length-range="6"
                                data-validate-words="2" required value="{{ $company['data']->name ?? '' }}"
                                readonly />
                            <input type="hidden" name="company_id" id="company_id"
                                value="{{ $company['data'] ? encrypt($company['data']->id) : '' }}">
                        </div>
                    </div>
                    @if ($checkIssetDepartment)
                        @foreach ($departmentParent as $key => $value)
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Code
                                    <span class="text-danger h5">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" id="code" class="form-control"
                                        data-validate-length-range="6" data-validate-words="2"
                                        name="code {{ $i }}" placeholder="Nhập mã code" required
                                        value="{{ $value->code ?? '' }}" />
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if (session('errorCode'))
                                        <div class="text-danger">
                                            {{ session('errorCode') }}
                                        </div>
                                    @endif
                                </div>
                                @if(!in_array($value->id, $listIdDepartmentChild))
                                    <button class="btn btn-danger text-light delete-button">Xóa</button>
                                @endif
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Phòng ban
                                    <span class="text-danger h5">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" id="name" class="form-control"
                                        data-validate-length-range="6" data-validate-words="2"
                                        name="name {{ $i }}" placeholder="Nhập tên phòng ban" required
                                        value="{{ $value->name ?? '' }}" />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if (session('errorName'))
                                        <div class="text-danger">
                                            {{ session('errorName') }}
                                        </div>
                                    @endif
                                </div>
                                @if(!in_array($value->id, $listIdDepartmentChild))
                                    <button class="btn btn-danger text-light delete-button">Xóa</button>
                                @endif
                                <input type="hidden" name="id {{ $i }}" value="{{ $value->id }}" class="input-hidden">
                            </div>
                            @php
                                $j = $i + 1;
                            @endphp
                            @foreach ($departmentChild as $index => $item)
                                @if ($item->parent_id == $value->id)
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="text" id="code" class="form-control"
                                                data-validate-length-range="6" data-validate-words="2"
                                                name="code {{ $j }}" placeholder="Nhập mã code" required
                                                value="{{ $item->code ?? '' }}" />
                                            @error('code')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            @if (session('errorCode'))
                                                <div class="text-danger">
                                                    {{ session('errorCode') }}
                                                </div>
                                            @endif
                                        </div>
                                        <button class="btn btn-danger text-light delete-button">Xóa</button>
                                    </div>
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="text" id="name" class="form-control"
                                                data-validate-length-range="6" data-validate-words="2"
                                                name="name {{ $j }}" placeholder="Nhập tên phòng ban" required
                                                value="{{ $item->name ?? '' }}" />
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            @if (session('errorName'))
                                                <div class="text-danger">
                                                    {{ session('errorName') }}
                                                </div>
                                            @endif
                                        </div>
                                        <button class="btn btn-danger text-light delete-button">Xóa</button>
                                        <input type="hidden" name="id {{ $j }}" value="{{ $item->id }}" class="input-hidden">
                                    </div>
                                    @php
                                        $j++;
                                    @endphp
                                @endif
                            @endforeach
                            @php
                                $i = $j;
                                $keyNew = $i;
                            @endphp
                        @endforeach
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
                            <div class="col-md-6 col-sm-6">
                                <a class="btn btn-success text-light show-form-add-department">Thêm phòng ban</a>
                            </div>
                        </div>
                        <span id="show-form" class="d-none">
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Phòng ban cha</label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" name="parent_id">
                                        <option value="">----------------------Chọn phòng ban----------------------</option>
                                        @foreach ($departmentParent as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @foreach ($departmentChild as $item)
                                                @if ($item->parent_id == $value->id)
                                                    <option value="{{ $item->id }}">-----   {{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Code<span
                                        class="text-danger h5">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" id="code_new" class="form-control"
                                        data-validate-length-range="6" data-validate-words="2"
                                        name="code {{ $keyNew }}" placeholder="Nhập mã code"/>
                                    @error('code_new')
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
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Phòng ban<span
                                        class="text-danger h5">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" id="name_new" class="form-control"
                                        data-validate-length-range="6" data-validate-words="2"
                                        name="name {{ $keyNew }}" placeholder="Nhập tên phòng ban"/>
                                    @error('name_new')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if (session('errorName'))
                                        <div class="text-danger">
                                            {{ session('errorName') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </span>
                    @else
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Code<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="code" class="form-control"
                                    data-validate-length-range="6" data-validate-words="2" name="code"
                                    placeholder="Nhập mã code" required value="{{ $value->code ?? '' }}" />
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
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Phòng ban<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="name" class="form-control"
                                    data-validate-length-range="6" data-validate-words="2" name="name"
                                    placeholder="Nhập tên phòng ban" required value="{{ $value->name ?? '' }}" />
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
                    @endif
                    <div class="ln_solid">
                        <div class="form-group">
                            <br>
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-success">Submit</button>
                                <button type='reset' class="btn btn-primary">Reset</button>
                                <a href="{{ route('companies.index') }}" class="btn btn-warning text-danger">Come
                                    back
                                    <i class="fa fa-backward"></i></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var btnAddDepartment = document.querySelector('.show-form-add-department');
    var formAddDepartment = document.getElementById('show-form');
    var inputCodeNew = document.getElementById('code_new');
    var inputNameNew = document.getElementById('name_new');

    btnAddDepartment.addEventListener('click', function() {
        var isFormHidden = formAddDepartment.classList.contains('d-none');

        if (isFormHidden) {
            formAddDepartment.classList.remove('d-none')
            inputCodeNew.setAttribute('required', 'required');
            inputNameNew.setAttribute('required', 'required');
        } else {
            formAddDepartment.classList.add('d-none')
            inputCodeNew.removeAttribute('required');
            inputNameNew.removeAttribute('required');
        }
    });

    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function() {
            event.preventDefault();
            var parentItem = this.closest('.item'); // Tìm phần tử cha gần nhất có class 'item'
            var inputField = parentItem.querySelector('.form-control'); // Tìm ô input trong phần tử cha
            var inputHidden = parentItem.querySelector('.input-hidden')
            if (inputHidden) {
                inputHidden.remove();
            }
            inputField.remove(); // Xóa ô input
            this.remove(); // Xóa button
        });
    });
</script>
