@extends('layout.master')
@section('title')
 كل المراحل
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
                        <h4 class="card-title">المراحل</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                       @can('step_create')
                            <div class="heading-elements">
                                <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="#" data-toggle="modal" data-target="#addStep">اضافة مرحلة</a>
                                <x-dashboard.form.model
                                    action="{{route('dashboard.steps.store')}}"
                                    method="post"
                                    modelId="addStep"
                                    title="اضافة مرحلة">
                                    <x-slot name="inputs">
                                        <x-dashboard.form.input id="name" label="الاسم" inputName="name" value="{{old('name')}}"></x-dashboard.form.input>
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
                                    <th class="border-top-0">الاسم</th>
                                    <th class="border-top-0">الحالة</th>
                                    <th class="border-top-0">تعديل</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($steps as $i => $step)
                                    <tr>
                                    <td>{{$i + 1}}</td>
                                    <td>{{$step->name}}</td>

                                    <td>
                                        <x-dashboard.status :status="$step->status"></x-dashboard.status>
                                    </td>
                                    <td>
                                        @can('step_edit')
                                            <a href="#" class="text-primary" data-toggle="modal" data-target="#EditStep-{{$step->id}}">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <x-dashboard.form.model
                                                action="{{route('dashboard.steps.update', $step->id)}}"
                                                method="post"
                                                methodBody="put"
                                                modelId="EditStep-{{$step->id}}"
                                                title="تعديل مرحلة">
                                                <x-slot name="inputs">
                                                    <x-dashboard.form.input id="name" label="الاسم" inputName="name" value="{{$step->name}}"></x-dashboard.form.input>
                                                    <x-dashboard.form.selectStatus status="{{$step->status}}"></x-dashboard.form.selectStatus>
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
                {{$steps->links()}}
            </div>
        </div>
    <!--/ End:Content -->
@endsection

@section('scripts')
@endsection
