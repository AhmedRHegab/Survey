@extends('layout.master')
@section('title')
    إشراف العام
@endsection
@section('content')
    <div class="row">

        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-content">
                    <!-- Type Here Form Code-->
                    <!--start card input form-->

                    <div class="card-header">
                        <h2 class="h1 text-center text-monospace mt-md-2">إشراف العام</h2>

                    </div>
                    <div class="card-content collapse show ">
                        <div class="card-body card-size">
                            <form action="{{route('dashboard.surveys.building.store')}}" method="post" class=" mx-3" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="form-body">
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label label-name ">المرحلة :
                                        </label>
                                        <div class="col-md-7">
                                            <select class="custom-select d-block w-100" id="step" name="step">
                                                <option value="">المرحلة....</option>
                                                @foreach($steps as $step)
                                                    <option value="{{$step->id}}">{{$step->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label label-name">رقم العمارة :
                                        </label>
                                        <div class="col-md-7">
                                            <select class="custom-select d-block w-100" id="groups" name="group" >
                                                <option value="">رقم العمارة....</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul>
                                        @foreach($questions as $question)
                                            <li>
                                                <div class="custom-control custom-radio my-2 row">
                                                    <input type="radio" name="questions[]" value="{{$question->id}}" class="custom-control-input col-md-4" id="question-{{$question->id}}">
                                                    <label class="custom-control-label col-md-8" for="question-{{$question->id}}">
                                                        {{$question->question}}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label label-name ">ارفق الملف :
                                        </label>
                                        <div class="col-md-7">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="attachments[]"  accept="image/jpeg , image/png ,image/gif,image/jpg, image/svg" multiple >
                                                <label class="custom-file-label" for="inputGroupFile02"
                                                       aria-describedby="inputGroupFile02">ارفق الملف</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label label-name ">ملاحظات :</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" id="placeTextarea" name="notes" rows="3" placeholder="ملاحظات">{{old('notes')}}</textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="type" value="general">
                                </div>
                                <hr class="mb-4 mx-5">
                                <div class=" form-actions pb-5 text-center">
                                    <div class="save-btn ">
                                        <button type="submit" class=" btn btn-primary px-2 "><i class=" ft-log-in position-left "></i>ارسال</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!--end card input form-->

        @endsection
@section('scripts')
    <script src="{{URL::asset('assets/js/main.js')}}"></script>
@endsection
