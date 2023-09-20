@extends('master')
@section('content')
@if ($errors->any())
    <div class="alert alert-warning">
            @foreach ($errors->all() as $error)
                <h6>{{ $error }}</h6>
            @endforeach
    </div>
@endif
<div class="row">
        <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">مشخصات پروفایل</h3>
              </div>
              <!-- /.card-header -->
                <form role="form" method="POST" action="{{ route("changeInfo") }}">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputName1">نام</label>
                            <input type="text" name="name" class="form-control" id="exampleInputName1" value="{{ Auth::user()->name }}" placeholder="نام خود را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUserName1">نام کاربری</label>
                            <input type="text" name="phone" class="form-control" id="exampleInputUserName1" value="{{ Auth::user()->phone }}" placeholder="شماره موبایل کاربر را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">محل تحویل پیشفرض</label>
                            <select class="form-control" name="default_location">
                                @foreach($locations as $location)
                                    @if($location->id==Auth::user()->default_location+1)
                                        <option value="{{ $location->id-1 }}" selected>{{ $location->name }}</option>
                                    @else
                                        <option value="{{ $location->id-1 }}">{{ $location->name }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">نوع کاربر</label>
                            <select class="form-control" name="type">
                                <option value="0" @if(Auth::user()->default_loc==0) selected @endif>قراردادی</option>
                                <option value="1" @if(Auth::user()->default_loc==1) selected @endif>پروژه ای</option>
                                <option value="2" @if(Auth::user()->default_loc==2) selected @endif>سرباز</option>
                            </select>
                        </div>



                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ثبت</button>
                    </div>
                </form>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">تغییر رمزعبور</h3>
            </div>
            <!-- /.card-header -->
            <form role="form" method="POST" action="{{ route("changePassword") }}">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputName1">رمز عبور جدید</label>
                        <input type="password" name="password" class="form-control" id="exampleInputName1" placeholder="رمز جدید را وارد کنید">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUserName1">تکرار رمز عبور</label>
                        <input type="password" name="password_conf" class="form-control" id="exampleInputUserName1"  placeholder="تکرار رمز عبور جدید را وارد کنید">
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">ثبت</button>
                </div>
            </form>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


</div>

@endsection
