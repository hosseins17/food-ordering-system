@extends('master')
@section('content')
@if ($errors->any())
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <h6>{{ $error }}</h6>
        @endforeach
    </div>
@endif
امروز:{{ $date }}
<div class="row">
        <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">جدول غذاها</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <tr>
                    <th >تاریخ</th>
                    <th>گزینه یک</th>
                    <th>گزینه دو</th>
                    <th>انتخاب</th>
                  </tr>
                    <?php
                    use Illuminate\Support\Facades\Auth;$targetDate=\Illuminate\Support\Carbon::now()->format("Y-m-d");
                    $foods = \App\Models\Options::whereDate('date' ,'>',$targetDate)->get();
                    $startNum=7;
                    foreach ($foods as $f){
                        $order=\App\Models\Orders::where('order_id',$f->id)->where("user_id",Auth::user()->id)->first();
                        if (isset($order->id)){
                            $startNum++;
                        }
                    }
                    $foods=$foods->take($startNum);
                    $counter=0;
                    ?>
                    @foreach($foods as $food)
                        <?php
                            $order=\App\Models\Orders::where("order_id",$foods[$counter]->id)->where("user_id",Auth::user()->id)->first();
                            $counter++;
                        ?>
                        <?php $flag=false; ?>
                        {{--@foreach($lastOrders as $fo)--}}
                            {{--@if($fo->order_id == $food->id)--}}
                            @if(isset($order->id))
                                <?php $flag=true; ?>

                            @endif
                            @if(!isValidTimeToSubmitOrDeleteOrder($food))
                                <?php $flag=true; ?>
                            @endif
                        {{--@endforeach--}}
                        @if($flag)

                            @continue
                        @endif

                        <tr>
                            <td>{{ Morilog\Jalali\Jalalian::fromDateTime($food->date)->format('%A, %d %B %Y') }}</td>
                            <td>{{ $food->option1 }}</td>
                            <td>{{ $food->option2 }}</td>
                            <td>
                                <form method="post" action="{{ route("submitOrder") }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $food->id }}" name="option_id">
                                    <select class="form-control" name="option">
                                        <option value="{{ $food->option1 }}">{{ $food->option1 }}</option>
                                        <option value="{{ $food->option2 }}">{{ $food->option2 }}</option>
                                    </select>

                                    <select class="form-control" name="location">
                                        @foreach($locations as $location)
                                            @if($location->id==Auth::user()->default_location+1)
                                                <option value="{{ $location->id }}" selected>{{ $location->name }}</option>
                                                @else
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <button class="btn btn-success btn-block" type="submit">ثبت</button>
                                </form>
                            </td>

                        </tr>

                    @endforeach

                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
    </div>

    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">سفارشات قبلی</h3>
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
                                @if(isValidTimeToSubmitOrDeleteOrder($lastOrder->targetOption))
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


    <script>
        $(document).ready(function() {
            var popup = localStorage.getItem("popup");
            if(popup !== "false"){
                $('#exampleModal').modal('toggle');
            }
            $('#exampleModal').on('hidden.bs.modal', function (e) {
                localStorage.setItem("popup",false);
            })
        });
    </script>
@endsection
