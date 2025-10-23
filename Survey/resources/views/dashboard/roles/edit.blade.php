@extends('layout.master')

@section('title')
   تعديل صلاحية
@endsection
@section('content')
    <div class="row">

        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-content">
                    <!-- Type Here Form Code-->
                    <!--start card input form-->

                    <div class="card-header">
                        <h2 class="h1 text-center text-monospace mt-md-2"> تعديل صلاحية</h2>

                    </div>
                    <div class="card-content collapse show ">
                        <div class="card-body card-size">
                            <form class="form form-horizontal" action="{{route('dashboard.roles.update', $role->id)}}" method="post">
                                @csrf
                                {{method_field('put')}}
                                <div class="form-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="name_ar">اسم الصلاحية</label>
                                        <div class="col-md-9 mx-auto">
                                                <input type="text" id="name" class="form-control" placeholder="اسم الصلاحية" name="name" value="{{$role->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        @foreach($permissions as $permission)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="checkbox" name="permissions[]" id="{{$permission->name}}" {{in_array($permission->id, $rolePermissions) ? 'checked' : ''}} value="{{$permission->id}}">
                                                    <label for="{{$permission->name}}"  class="">{{$permission->name}}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                <div class="form-actions row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success">
                                            <i class="la la-check-square-o"></i>
                                            حفظ
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--end card input form-->

@endsection

@section('script')
@endsection
