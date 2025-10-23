@extends('layout.master')
@section('title')
الرئيسية
@endsection

@section('style')
@endsection

@section('content')
    <!--/ Start:Content -->
        <div class="row mb-2">
            @can('safeSecurity_add')
            <div class="col-md-4 text-center mb-2">
                <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width " href="{{route('dashboard.surveys.safe-security.create')}}">اضافة إشراف الأمن والحراسة والمراقبة </a>
            </div>
            @endcan
            @can('building_add')
            <div class="col-md-4 text-center mb-2">
                <a class="btn btn-sm btn-primary box-shadow-2 round btn-min-width" href="{{route('dashboard.surveys.building.create')}}" >اضافة إشراف العمارات </a>
            </div>
            @endcan
            @can('general_add')
            <div class="col-md-4 text-center mb-2">
                <a class="btn btn-sm btn-warning box-shadow-2 round btn-min-width" href="{{route('dashboard.surveys.general.create')}}">اضافة إشراف عام </a>
            </div>
            @endcan
        </div>
    @can('statics_access')
    <div class="row mt-1">
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h2 class="info">{{$buildingSurvey}}</h2>
                                <h4>اشراف العمارات اليوم</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h2 class="warning">{{$generalSurvey}}</h2>
                                <h4>اشراف العام اليوم </h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h2 class="success">{{$safeSecuritySurvey}}</h2>
                                <h4>اشراف الامن والحراسة والمراقبة</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h2 class="danger">{{$surveyToday}}</h2>
                                <h4> الاشرافات على مدار  اليوم</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h2 class="danger">{{$totalSurvey}}</h2>
                                <h4> جميع الاشرافات </h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endcan
    <!--/ End:Content -->

@endsection

@section('script')
@endsection
