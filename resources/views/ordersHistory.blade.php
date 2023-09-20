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
    <div class="col-md-3">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">فیلتر کردن</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <form class="form-group p-2" method="" action="">
                    <div class="form-group">
                        <label>شروع از:</label>
                        <input class="form-control option_date" name="startDate" type="text" value="@if(isset($_GET["startDate"])) <?php echo JalaliToGregorian($_GET["startDate"]); ?>@else{{ now()->format("Y-m-d") }}@endif">
                    </div>
                    <div class="form-group">
                        <label>تا:</label>
                        <input class="form-control option_date" name="endDate" type="text" value="@if(isset($_GET["endDate"])) <?php echo JalaliToGregorian($_GET["endDate"]); ?>@else{{ now()->addDays(1)->format("Y-m-d") }}@endif">
                    </div>
                    <button type="submit" class="btn btn-success btn-block">ثبت</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">تاریخچه</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <tr>
                        <th >تاریخ</th>
                        <th> انتخاب شما</th>
                        <th>محل دریافت</th>
                        <th>#</th>
                    </tr>
                    @foreach($lastOrders as $lastOrder)
                        <tr>
                            <td>{{ Morilog\Jalali\Jalalian::fromDateTime($lastOrder->targetOption->date)->format('%A, %d %B %Y') }}</td>
                            <td>{{ $lastOrder->option }}</td>
                            <td>{{ $lastOrder->location->name }}</td>
                            <td>
                                @if(Morilog\Jalali\Jalalian::fromDateTime($lastOrder->targetOption->date)->toCarbon()->diffInHours(\Carbon\Carbon::today()->format("Y-m-d")) >= 24 && Morilog\Jalali\Jalalian::fromDateTime($lastOrder->targetOption->date)->toCarbon() >= \Carbon\Carbon::today()->format("Y-m-d"))
                                    <form method="post" action="{{ route('deleteOrder') }}">
                                        {{ csrf_field() }}
                                        <input value="{{ $lastOrder->id }}" type="hidden" name="orderid">
                                        <button type="submit" class="btn btn-danger btn-block" >حذف و ویرایش</button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>
            <!-- /.card-body -->
            {{--  <style>
                  svg{
                      width: 30px !important;
                  }
                  nav div div p{
                      display:none;
                  }
              </style>
               $lastOrders->links() --}}
        </div>
        <!-- /.card -->
    </div>

</div>

@endsection
