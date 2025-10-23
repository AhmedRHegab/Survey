@extends('layout.master')

@section('title')
   الصلاحيات
@endsection


@section('content')


    <div class="row">

        <div id="recent-sales" class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الاسئلة</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                   @can('role_create')
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="{{route('dashboard.roles.create')}}">اضافة صلاحية </a>
                                </li>
                            </ul>
                        </div>
                   @endcan
                </div>
                <div class="card-content mt-1">
                    <div class="table-responsive">
                        <table id="recent-orders" class="table table-hover table-xl mb-0">
                            <thead>
                            <tr>
                                <th colspan="col" class="border-top-0" >#</th>
                                <th colspan="col" class="border-top-0">الصلاحية</th>
                                <th colspan="col" class="border-top-0">تعديل</th>
{{--                                <th colspan="col" class="border-top-0">حذف</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $i =>  $role)
                                <tr>
                                    <td>{{$i + 1}}</td>
                                    <td>{{$role->name}}</td>
                                    @if($role->name !== 'Super Admin')
                                      @can('role_edit')
                                            <td>

                                                <a href="{{route("dashboard.roles.edit", $role->id)}}" class="btn btn-outline-primary btn-sm">
                                                    <i class="la la-edit"></i>
                                                </a>

                                            </td>
                                    @endcan

{{--                                        <td>--}}
{{--                                            @can('role_destroy')--}}
{{--                                                <!-- Button trigger modal -->--}}
{{--                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#role_{{$role->id}}">--}}
{{--                                                    <i class="la la-trash"></i>--}}
{{--                                                </button>--}}

{{--                                                <!-- Modal -->--}}
{{--                                                <div class="modal fade" id="role_{{$role->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--                                                    <div class="modal-dialog" role="document">--}}
{{--                                                        <form action="{{route("dashboard.roles.destroy", $role->id)}}" method="post">--}}
{{--                                                            {{method_field('delete')}}--}}
{{--                                                            @csrf--}}
{{--                                                            <div class="modal-content">--}}
{{--                                                                <div class="modal-header">--}}
{{--                                                                    <h5 class="modal-title" id="exampleModalLabel">حذف الصلاحية</h5>--}}
{{--                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                                        <span aria-hidden="true">&times;</span>--}}
{{--                                                                    </button>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="modal-body">--}}
{{--                                                                    <input type="text" disabled value="{{$role->name}}" class="form-control">--}}
{{--                                                                </div>--}}
{{--                                                                <div class="modal-footer">--}}
{{--                                                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">غلاق</button>--}}
{{--                                                                    <button type="submit" class="btn btn-outline-danger">--}}
{{--                                                                        خذف--}}
{{--                                                                        <i class="la la-trash"></i>--}}
{{--                                                                    </button>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </form>--}}

{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endcan--}}
{{--                                        </td>--}}
                                    @else
                                        <td></td>
{{--                                        <td></td>--}}
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{$roles->links()}}
        </div>
    </div>
@endsection


@section('script')
@endsection
