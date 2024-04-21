<div id="description" class="tab-pane active show" role="tabpanel">
    <div class="product-description">
        <table class="table table-hover table-light">
            <tr>
                <td>Email:</td>
                <td class="h6 text-info">{{ $user['data']->email ?? 'NULL' }}</td>
            </tr>
            <tr>
                <td>Password:</td>
                <td class="h6 text-info">{{ $user['data']->password ?? 'NULL' }}</td>
            </tr>
            <tr>
                <td>Trạng thái:</td>
                <td class="h6 text-info">{{ $user['data']->is_active ?? 'NULL' }}</td>
            </tr>
            @if (isset($user['data']->person))
                <tr>
                    <td>Họ và tên:</td>
                    <td class="h6 text-info">{{ $user['data']->person->full_name ?? 'NULL' }}</td>
                </tr>
                <tr>
                    <td>Giới tính:</td>
                    <td class="h6 text-info text-capitalize">{{ $user['data']->person->gender ?? 'NULL' }}</td>
                </tr>
                <tr>
                    @php
                        $user['data']->person->birthdate = new DateTime($user['data']->person->birthdate);
                        $formattedDate = $user['data']->person->birthdate->format('d-m-Y');
                    @endphp
                    <td>Ngày sinh:</td>
                    <td class="h6 text-info">{{ $formattedDate ?? 'NULL' }}</td>
                </tr>
                <tr>
                    <td>Số điện thoại:</td>
                    <td class="h6 text-info">{{ $user['data']->person->phone_number ?? 'NULL' }}</td>
                </tr>
                <tr>
                    <td>Địa chỉ:</td>
                    <td class="h6 text-info">{{ $user['data']->person->address ?? 'NULL' }}</td>
                </tr>
                <tr>
                    <td>Công ty:</td>
                    <td class="h6 text-info">{{ $user['data']->person->company->name ?? 'NULL' }}</td>
                </tr>
            @endif
            <tr>
                <td>Vai trò:</td>
                @foreach ($user['data']->roles as $value)
                    <td class="h6 text-info text-uppercase">{{ $value->role ?? 'NULL' }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Ngày tạo:</td>
                <td class="h6 text-info">
                    {{ $user['data']->created_at }}</td>
            </tr>
            <tr>
                <td>Ngày update:</td>
                <td class="h6 text-info">{{ $user['data']->updated_at }}</td>
            </tr>
        </table>
    </div>
</div>
