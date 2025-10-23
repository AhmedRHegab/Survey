@extends('layout.master')
@section('title')
    كل الاسلئة
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
                    <h4 class="card-title">الاسئلة</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    @can('question_create')
                        <div class="heading-elements">
                            <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="#"
                               data-toggle="modal" data-target="#addQuestion">اضافة سؤال </a>
                            <x-dashboard.form.model
                                action="{{route('dashboard.questions.store')}}"
                                method="post"
                                modelId="addQuestion"
                                title="اضافة سؤال">
                                <x-slot name="inputs">
                                    <x-dashboard.form.input id="question" label="السؤال" inputName="question"
                                                            value="{{old('question')}}"></x-dashboard.form.input>
                                    <div class="form-group col-md-12">
                                        <label for="inputType">نوع الحقل</label>
                                        <select name="inputType" id="inputType" class="form-control">
                                            <option disabled selected> اختار .....</option>
                                            <option
                                                value="checkbox" {{old('inputType') == 'checkbox' ? 'selected' : ''}}>
                                                Checkbox
                                            </option>
                                            <option value="radio" {{old('inputType') == 'radio' ? 'selected' : ''}}>
                                                Radio Button
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="type">نوع النموذج</label>
                                        <select name="type" id="type" class="form-control">
                                            <option disabled selected> اختار .....</option>
                                            <option value="general" {{old('type') == 'general' ? 'selected' : ''}}>
                                                إشراف عام
                                            </option>
                                            <option value="building" {{old('type') == 'building' ? 'selected' : ''}}>
                                                إشراف عمارات
                                            </option>
                                            <option
                                                value="safeSecurity" {{old('type') == 'safeSecurity' ? 'selected' : ''}}>
                                                إشراف الأمن والحراسة والمراقبة
                                            </option>
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
                                <th class="border-top-0">السؤال</th>
                                <th class="border-top-0">النموذج</th>
                                <th class="border-top-0">النوع</th>
                                <th class="border-top-0">بواسطة</th>
                                <th class="border-top-0">الحالة</th>
                                <th class="border-top-0">تعديل</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $i => $question)
                                <tr>
                                    <td>{{$i + 1}}</td>
                                    <td>{{$question->question}}</td>
                                    <td>{{$question->type}}</td>
                                    <td>{{$question->input_type}}</td>
                                    <td>{{$question->user->name}}</td>

                                    <td>
                                        <x-dashboard.status :status="$question->status"></x-dashboard.status>
                                    </td>
                                    <td>
                                        @can('question_edit')
                                            <a href="#" class="text-primary" data-toggle="modal"
                                               data-target="#EditQuestion-{{$question->id}}">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <x-dashboard.form.model
                                                action="{{route('dashboard.questions.update', $question->id)}}"
                                                method="post"
                                                methodBody="put"
                                                modelId="EditQuestion-{{$question->id}}"
                                                title="تعديل سؤال">
                                                <x-slot name="inputs">
                                                    <x-dashboard.form.input id="question" label="السؤال"
                                                                            inputName="question"
                                                                            value="{{$question->question}}"></x-dashboard.form.input>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputType">نوع الحقل</label>
                                                        <select name="inputType" id="inputType" class="form-control">
                                                            <option disabled selected> اختار .....</option>
                                                            <option
                                                                value="checkbox" {{$question->input_type == 'checkbox' ? 'selected' : ''}}>
                                                                Checkbox
                                                            </option>
                                                            <option
                                                                value="radio" {{$question->input_type == 'radio' ? 'selected' : ''}}>
                                                                Radio Button
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label for="type">نوع النموذج</label>
                                                        <select name="type" id="type" class="form-control">
                                                            <option disabled selected> اختار .....</option>
                                                            <option
                                                                value="general" {{$question->type == 'general' ? 'selected' : ''}}>
                                                                إشراف عام
                                                            </option>
                                                            <option
                                                                value="building" {{$question->type == 'building' ? 'selected' : ''}}>
                                                                إشراف عمارات
                                                            </option>
                                                            <option
                                                                value="safeSecurity" {{$question->type == 'safeSecurity' ? 'selected' : ''}}>
                                                                إشراف الأمن والحراسة والمراقبة
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <x-dashboard.form.selectStatus
                                                        status="{{$question->status}}"></x-dashboard.form.selectStatus>
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
            {{$questions->links()}}
        </div>
    </div>
    <!--/ End:Content -->
@endsection

@section('scripts')
@endsection
