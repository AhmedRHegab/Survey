@extends('layout.master')
@section('title')
 كل المجموعات
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
                        <h4 class="card-title">المجموعات</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                       @can('group_create')
                            <div class="heading-elements">
                            <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="#" data-toggle="modal" data-target="#addGroup">اضافة مجموعة</a>
                            <x-dashboard.form.model
                                action="{{route('dashboard.groups.store')}}"
                                method="post"
                                modelId="addGroup"
                                title="اضافة مجموعة">
                                <x-slot name="inputs">
                                    <x-dashboard.form.select id="steps" name="step" :options="$steps" selected="{{old('step')}}" label="المرحلة"></x-dashboard.form.select>
                                    <x-dashboard.form.input type="number"  id="number" label="رقم العمارة" inputName="number" value="{{old('number')}}"></x-dashboard.form.input>
                                    <x-dashboard.form.selectStatus status="{{old('status')}}"></x-dashboard.form.selectStatus>
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
                                    <th class="border-top-0">رقم العمارة</th>
                                    <th class="border-top-0">مرحلة</th>
                                    <th class="border-top-0">الحالة</th>
                                    <th class="border-top-0">تعديل</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($groups as $i => $group)
                                    <tr>
                                    <td>{{$i + 1}}</td>
                                    <td>{{$group->number}}</td>
                                    <td>{{$group->step->name}}</td>

                                    <td>
                                        <x-dashboard.status :status="$group->status"></x-dashboard.status>
                                    </td>
                                    <td>
                                       @can('group_edit')
                                            <a href="#" class="text-primary" data-toggle="modal" data-target="#Edit-{{$group->id}}">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <x-dashboard.form.model
                                                action="{{route('dashboard.groups.update', $group->id)}}"
                                                method="post"
                                                methodBody="put"
                                                modelId="Edit-{{$group->id}}"
                                                title="تعديل مجموعة">
                                                <x-slot name="inputs">
                                                    <x-dashboard.form.select id="steps" name="step" :options="$steps" selected="{{$group->step_id}}" label="المرحلة"></x-dashboard.form.select>
                                                    <x-dashboard.form.input type="number"  id="number" label="رقم العمارة" inputName="number" value="{{$group->number}}"></x-dashboard.form.input>
                                                    <x-dashboard.form.selectStatus status="{{$group->status}}"></x-dashboard.form.selectStatus>
                                                </x-slot>
                                            </x-dashboard.form.model>
                                       @endcan
                                    </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                {{$groups->links()}}
            </div>
        </div>
    <!--/ End:Content -->
@endsection

@section('scripts')
@endsection
