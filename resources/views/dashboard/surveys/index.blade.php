@extends('layout.master')
@section('title')
    كل الانماذج
@endsection

@section('style')
@endsection

@section('content')
    <!--/ Start:Content -->
    <div class="row">

        <div id="recent-sales" class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">النماذج</h4>
                    <a class="heading-elements-toggle"> <i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="pull-left mt-3">
                            <button type="button"class="btn btn-success btn-sm" data-toggle="modal" data-target="#search">بحث</button>
                        <!--/Start : Model -->
                        <form action="{{route('dashboard.surveys.index')}}" method="get">
                            <div class="modal fade text-left" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel17">بحث</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="type">انواع النماذج</label>
                                                    <select name="surveyType" id="type" class="form-control">
                                                        <option selected disabled> اختار ....... </option>
                                                        <option value="building">اشراف عمارات</option>
                                                        <option value="safeSecurity">اشراف الامن والحراسة والمراقبة</option>
                                                        <option value="general">اشراف عام</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="step">المراحل</label>
                                                    <select name="step" id="step" class="form-control">
                                                        <option selected disabled> اختار ....... </option>
                                                       @foreach($steps as $step)
                                                            <option value="{{$step->id}}">{{$step->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="groups">العمارات</label>
                                                    <select class="custom-select d-block w-100" id="groups" name="group" >
                                                        <option value="">رقم العمارة....</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-md-4">
                                                    <label for="users">المستخدمين</label>
                                                    <select name="user" id="users" class="form-control">
                                                        <option selected disabled> اختار ....... </option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="start_date">التاريخ من : </label>
                                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="end_date"> الى : </label>
                                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn grey btn-outline-warning ">اعادة تعين</button>
                                            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">غلق</button>
                                            <button type="submit" class="btn btn-outline-primary">بحث</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--/End : Model -->
                    </div>
                </div>
                <div class="card-content mt-1">
                    <div class="table-responsive">
                        <table id="recent-orders" class="table table-hover table-xl mb-0">
                            <thead>
                            <tr>
                                <th class="border-top-0">#</th>
                                <th class="border-top-0">المرحلة</th>
                                <th class="border-top-0">العمارة</th>
                                <th class="border-top-0">نوع النموذج</th>
                                <th class="border-top-0">المشرف</th>
                                <th class="border-top-0">تاريخ الانشاء</th>
                                <th class="border-top-0">تاريخ التعديل</th>
                                <th class="border-top-0"> تعديل</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($surveys as $i => $survey)
                                    <tr>
                                        <td>{{$i + 1}}</td>
                                        <td>{{$survey->step->name}}</td>
                                        <td>{{$survey->group->number}}</td>
                                        <td>{{$survey->type}}</td>
                                        <td>{{$survey->user->name}}</td>
                                        <td>{{$survey->created_at}}</td>
                                        <td>{{$survey->updated_at}}</td>
                                        <td>
                                          @can('survey_edit')
                                                @if($survey->type =='safeSecurity')
                                                    <x-dashboard.edit href="{{route('dashboard.surveys.safe-security.edit', $survey->id)}}" id="survey-{{$survey->id}}"></x-dashboard.edit>
                                                @elseif($survey->type == 'general')
                                                    <x-dashboard.edit href="{{route('dashboard.surveys.general.edit', $survey->id)}}" id="survey-{{$survey->id}}"></x-dashboard.edit>
                                                @elseif($survey->type == 'building')
                                                    <x-dashboard.edit href="{{route('dashboard.surveys.building.edit', $survey->id)}}" id="survey-{{$survey->id}}"></x-dashboard.edit>
                                                @endif
                                          @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            {{$surveys->links()}}
        </div>
    </div>
    <!--/ End:Content -->
@endsection

@section('scripts')
    <script src="{{URL::asset('assets/js/main.js')}}"></script>
@endsection
