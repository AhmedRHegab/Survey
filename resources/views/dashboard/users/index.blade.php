@extends('layout.master')
@section('title')
    كل المستخدمين
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css-rtl/plugins/animate/animate.css')}}">
@endsection

@section('content')
    <!--/ Start:Content -->
    <div class="row">

        <div id="recent-sales" class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">المستخدمين</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    @can('user_create')
                        <div class="heading-elements">
                            <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="#"
                               data-toggle="modal" data-target="#addUser">اضافة مستخدم</a>
                            <x-dashboard.form.model
                                action="{{route('dashboard.users.store')}}"
                                method="post"
                                modelId="addUser"
                                title="اضافة مسنخدم">
                                <x-slot name="inputs">
                                    <x-dashboard.form.input id="name" label="الاسم" inputName="name"
                                                            value="{{old('name')}}"></x-dashboard.form.input>
                                    <x-dashboard.form.input type="email" id="email" label="البريد الالكترونى"
                                                            inputName="email"
                                                            value="{{old('email')}}"></x-dashboard.form.input>
                                    <x-dashboard.form.input type="password" id="password" label="كلمة المرور"
                                                            inputName="password"></x-dashboard.form.input>
                                    <x-dashboard.form.input type="password" id="password_confirm"
                                                            label=" تاكيد كلمة المرور"
                                                            inputName="password_confirm"></x-dashboard.form.input>
                                    <div class="col-md-12">
                                        <label for="roles">الصلاحيات</label>
                                        <select id="roles" name="roles" class="form-control">
                                            <option disabled selected>اختار ...</option>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-dashboard.form.selectStatus
                                        status="{{old('status')}}"></x-dashboard.form.selectStatus>
                                </x-slot>
                            </x-dashboard.form.model>
                        </div>
                    @endcan
                </div>
                <div class="card-content mt-1">
                    <div class="table-responsive">
                        <table id="recent-orders" class="table table-hover table-xl mb-0">
                            <thead>
                            <tr>
                                <th class="border-top-0">#</th>
                                <th class="border-top-0">الاسم</th>
                                <th class="border-top-0">البريد الالكترونى</th>
                                <th class="border-top-0">الصلاحيات</th>
                                <th class="border-top-0">الحالة</th>
                                <th class="border-top-0">تعديل</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $i => $user)
                                <tr>
                                    <td>{{$i + 1}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user['roles'][0]['name']}}</td>
                                    <td>
                                        @can('user_status')
                                            <x-dashboard.status :status="$user->status"></x-dashboard.status>
                                        @endcan
                                    </td>
                                    @can('user_edit')
                                        <td>
                                            <a href="#" class="text-primary" data-toggle="modal"
                                               data-target="#EditUser-{{$user->id}}">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <x-dashboard.form.model
                                                action="{{route('dashboard.users.update', $user->id)}}"
                                                method="post"
                                                methodBody="put"
                                                modelId="EditUser-{{$user->id}}"
                                                title="تعديل مسنخدم">
                                                <x-slot name="inputs">
                                                    <x-dashboard.form.input id="name" label="الاسم" inputName="name"
                                                                            value="{{$user->name}}"></x-dashboard.form.input>
                                                    <x-dashboard.form.input type="email" id="email"
                                                                            label="البريد الالكترونى" inputName="email"
                                                                            value="{{$user->email}}"></x-dashboard.form.input>
                                                    <x-dashboard.form.input type="password" id="password"
                                                                            label="كلمة المرور"
                                                                            inputName="password"></x-dashboard.form.input>
                                                    <x-dashboard.form.input type="password" id="password_confirm"
                                                                            label=" تاكيد كلمة المرور"
                                                                            inputName="password_confirm"></x-dashboard.form.input>
                                                    <div class="col-md-12">
                                                        <label for="roles">الصلاحيات</label>
                                                        <select id="roles" name="roles" class="form-control">
                                                            <option disabled selected>اختار ...</option>
                                                            @foreach($roles as $role)
                                                                <option
                                                                    value="{{$role->id}}" {{ $role->id  == $user['roles'][0]['id']? 'selected' : ''}}>{{$role->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <x-dashboard.form.selectStatus
                                                        status="{{$user->status}}"></x-dashboard.form.selectStatus>
                                                </x-slot>
                                            </x-dashboard.form.model>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End:Content -->
@endsection

@section('scripts')
@endsection
