@extends('master')
@section('content')
@if ($errors->any())
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <h6>{{ $error }}</h6>
        @endforeach
    </div>
@endif
<!-- Small boxes (Stat box) -->
<div class="row">

          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h3>{{ $ordersCount }}</h3>

                <p>تعداد کل سفارش ها</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!--<a href="" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>-->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $usersCount }}</h3>

                <p>کاربران ثبت شده</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
                <!--<a href="" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>-->
            </div>
          </div>

        </div>
        <!-- /.row -->
@if(Auth::user()->role !== 2)

        <div class="row">
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">آپلود با اکسل</h3>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ route('addUserExcel') }}">
                    {{ csrf_field() }}
                    <input type="file" class="form-control" name="userFile">
                    <input type="submit" class="btn btn-success form-control" value="ارسال">
                </form>
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">افزودن کاربر</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route("addUser") }}">
              {{ csrf_field() }}
                <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputName1">نام</label>
                    <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="نام مشتری را وارد کنید">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputUserName1">نام کاربری</label>
                    <input type="text" name="phone" class="form-control" id="exampleInputUserName1" placeholder="شماره موبایل کاربر را وارد کنید">
                  </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">شرکت</label>
                        <select class="form-control" name="company">
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach

                        </select>
                    </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">لوکیشن پیشفرض</label>
                      <select class="form-control" name="default_loc">
                          @foreach($locations as $location)
                          <option value="{{ $location->id-1 }}">{{ $location->name }}</option>
                          @endforeach

                      </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">نوع کاربر</label>
                    <select class="form-control" name="type">
                        <option value="0">قراردادی</option>
                        <option value="1">پروژه ای</option>
                        <option value="2">سرباز</option>
                    </select>
                  </div>



                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">ثبت</button>
                </div>
              </form>
            </div>
            </div>
            <!-- /.card -->
            <div class="col-md-6">
            <!-- general form elements -->
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">آپلود با اکسل</h3>
                    </div>
                    <form method="post" enctype="multipart/form-data" action="{{ route('addFoodExcel') }}">
                        {{ csrf_field() }}
                        <input type="file" class="form-control" name="foodFile">
                        <input type="submit" class="btn btn-success form-control" value="ارسال">
                    </form>
                </div>
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">افزودن غذا</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('addFood') }}">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputLink1">تاریخ</label>
                    <input type="text" name="date" class="form-control option_date" id="exampleInputLink1" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputTitle1">گزینه اول</label>
                    <input type="text" name="option1" class="form-control" id="exampleInputTitle1" placeholder="نام غذا را وارد کنید">
                  </div>
                    <div class="form-group">
                        <label for="exampleInputTitle1">گزینه دوم</label>
                        <input type="text" name="option2" class="form-control" id="exampleInputTitle1" placeholder="نام غذا را وارد کنید">
                    </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">ثبت</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


        </div>

            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">افزودن محل تحویل</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('addLoc') }}">
                        {{ csrf_field() }}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputTitle1">نام محل</label>
                                <input type="text" name="name" class="form-control" id="exampleInputTitle1" placeholder="سهروردی٬ پاسداران و...">
                            </div>



                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ثبت</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->

        </div>

    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">افزودن شرکت</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ route('addComp') }}">
                {{ csrf_field() }}
                <div class="card-body">

                    <div class="form-group">
                        <label for="exampleInputTitle1">نام شرکت</label>
                        <input type="text" name="name" class="form-control" id="exampleInputTitle1" placeholder="آتیه ارتباط٬ سازمان فضای مجازی سراج و...">
                    </div>



                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">ثبت</button>
                </div>
            </form>
        </div>
        <!-- /.card -->

    </div>


@endif



            <div class="col-lg-12 col-12">

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">سفارشات ثبت شده</h3>
                            <form method="get" action="{{ route('exportExcNew') }}" style="display: inline-block">
                                <select style="display: inline-block" name="date">
                                    <option value="{{ \Illuminate\Support\Carbon::now()->format("Y-m-d") }}">
                                        {{ \Morilog\Jalali\Jalalian::now()->format("Y-m-d") }}
                                    </option>

                                    @if(\Illuminate\Support\Carbon::now()->isWednesday())
                                        <option value="{{ \Illuminate\Support\Carbon::now()->addDays(3)->format("Y-m-d") }}">
                                            {{ \Morilog\Jalali\Jalalian::now()->addDays(3)->format("Y-m-d") }}
                                        </option>
                                    @elseif(\Illuminate\Support\Carbon::now()->isThursday())
                                        <option value="{{ \Illuminate\Support\Carbon::now()->addDays(2)->format("Y-m-d") }}">
                                            {{ \Morilog\Jalali\Jalalian::now()->addDays(2)->format("Y-m-d") }}
                                        </option>
                                    @else
                                        <option value="{{ \Illuminate\Support\Carbon::now()->addDays(1)->format("Y-m-d") }}">
                                            {{ \Morilog\Jalali\Jalalian::now()->addDays(1)->format("Y-m-d") }}
                                        </option>
                                    @endif
                                </select>
                                @if(Auth::user()->role !== 2)
                                <select style="display: inline-block" name="location">
                                    <option value="-1">همه</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id-1 }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @endif
                            <button class="btn btn-success">خروجی اکسل</button>
                            </form>
                            <form method="get" action="{{ route('exportExcAccounting') }}" style="display: inline-block">
                                <select style="display: inline-block" name="year">
                                    <option value="1401">1401</option>
                                    <option value="1402">1402</option>
                                    <option value="1403">1403</option>
                                    <option value="1404">1404</option>
                                    <option value="1405">1405</option>
                                </select>
                                <select style="display: inline-block" name="month">
                                    <option value="01">فروردین</option>
                                    <option value="02">اردیبهشت</option>
                                    <option value="03">خرداد</option>
                                    <option value="04">تیر</option>
                                    <option value="05">مرداد</option>
                                    <option value="06">شهریور</option>
                                    <option value="07">مهر</option>
                                    <option value="08">آبان</option>
                                    <option value="09">آذر</option>
                                    <option value="10">دی</option>
                                    <option value="11">بهمن</option>
                                    <option value="12">اسفند</option>
                                </select>
                                <button class="btn btn-info">خروجی اکسل مالی</button>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <tr>
                                    <th >تاریخ</th>
                                    <th >کاربر</th>
                                    <th >نوع کاربر</th>
                                    <th> انتخاب</th>
                                    <th>محل دریافت</th>
                                    <th>لوکیشن پیشفرض</th>
                                </tr>
                                @foreach($lastOrders as $lastOrder)
                                    <tr>
                                        <td>{{ Morilog\Jalali\Jalalian::fromDateTime($lastOrder->targetOption->date)->format('%A, %d %B %Y') }}</td>
                                        <td>{{ $lastOrder->user->name }}</td>
                                        <td>
                                            @if($lastOrder->user->type==0)
                                            قراردادی
                                            @elseif($lastOrder->user->type==1)
                                            پروژه ای
                                            @else
                                            سرباز
                                            @endif
                                        </td>
                                        <td>{{ $lastOrder->option }}</td>
                                        <td>{{ $lastOrder->location->name }}</td>
                                        <td>
                                            {{ \App\Models\Locations::find($lastOrder->default_location+1)->name }}
                                        </td>

                                    </tr>
                            @endforeach
                            </table>
                        </div>
                    </div>
                </div>


        @endsection
