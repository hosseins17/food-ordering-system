<?php

namespace App\Http\Controllers;

use App\Exports\OrdersAccountingExport;
use App\Exports\OrdersExport;
use App\Exports\OrdersExportNew;
use App\Imports\OptionsImport;
use App\Imports\UsersImport;
use App\Models\Company;
use App\Models\Locations;
use App\Models\Options;
use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class AdminDashboardController extends Controller
{
    public function dashboardShow(){
        if (Auth::check()) {
            $locations = Locations::get();
            if(Auth::user()->role==1){
                $companies = Company::get();

                $lastOrders= Orders::orderBy('id','desc')->get()->take(7);
                $usersCount=User::count();
                $ordersCount=Orders::count();
                return view('adminDashboard',compact('locations','companies','lastOrders','usersCount','ordersCount'));
            }elseif(Auth::user()->role==0){
                $date = Jalalian::forge('today')->format('%A, %d %B %Y');
                $date2 = Jalalian::forge('today')->addDays(7)->format('%A, %d %B %Y');
                $targetDate=Carbon::now()->format("Y-m-d");
                $foods = Options::whereDate('date' ,'>',$targetDate)->get();
                $startNum=7;
                foreach ($foods as $f){
                    $order=Orders::where('order_id',$f->id)->where("user_id",Auth::user()->id)->first();
                    if (isset($order->id)){
                        $startNum++;
                    }
                }
                $foods=$foods->take($startNum);
                $lastOrders= Orders::where('user_id',Auth::user()->id)->orderBy('id','desc')->get()->take(10);
                return view('dashboard',compact('date','date2','foods','locations','lastOrders'));
            }elseif (Auth::user()->role==2){

                $lastOrders= Orders::where('company_id',Auth::user()->company)->orderBy('id','desc')->get()->take(7);
                $usersCount=User::where('company',Auth::user()->company)->count();
                $ordersCount=Orders::where('company_id',Auth::user()->company)->count();
                return view('adminDashboard',compact('locations','lastOrders','usersCount','ordersCount'));
            }
        }else{
            return redirect('/');
        }
    }

    public function order(){
        $locations = Locations::get();
        $date = Jalalian::forge('today')->format('%A, %d %B %Y');
        $date2 = Jalalian::forge('today')->addDays(7)->format('%A, %d %B %Y');
        $targetDate=Carbon::now()->format("Y-m-d");
        $foods = Options::whereDate('date' ,'>',$targetDate)->get();
        $startNum=7;
        foreach ($foods as $f){
            $order=Orders::where('order_id',$f->id)->where("user_id",Auth::user()->id)->first();
            if (isset($order->id)){
                $startNum++;
            }
        }
        $foods=$foods->take($startNum);
        $lastOrders= Orders::where('user_id',Auth::user()->id)->orderBy('id','desc')->get()->take(7);
        return view('dashboard',compact('date','date2','foods','locations','lastOrders'));
    }


    public function addLoc(Request $request){
        $name= $request->name;
        Locations::create([
            'name'=>$name
        ]);
        return back()->withErrors("شرکت با موفقیت افزوده شد.");
    }

    public function addComp(Request $request){
        $name= $request->name;
        Company::create([
            'name'=>$name
        ]);
        return back()->withErrors("شرکت با موفقیت افزوده شد.");
    }

    public function addUser(Request $request){
        $pass= substr($request->phone, 1);
        $user = User::create([
            'name' => $request->name,
            'role' => 0,
            'type' => $request->type,
            'company'=>$request->company,
            'default_location' => $request->default_loc,
            'phone' => $request->phone,
            'password' => bcrypt($pass)
        ]);
        return back()->withErrors("کاربر با موفقیت افزوده شد.");
    }

    public function addFood(Request $request){
        $date = $request->date;
        $option1 = $request->option1;
        $option2 = $request->option2;

        $date=JalaliToGregorian($date);

        Options::create([
           'date'=>$date,
           'option1'=>$option1,
           'option2'=>$option2,
        ]);
        return back()->withErrors("غذا با موفقیت افزوده شد.");
    }

    public function exportExc(Request $request){
        $toJalali=GregorianToJalalian($request->date);
        return Excel::download(new OrdersExport($request->date,$request->location), 'orders'.$toJalali.'.xlsx');
    }

    public function exportExcNew(Request $request){
        $toJalali=GregorianToJalalian($request->date);
        if (Auth::user()->role==2){
            return Excel::download(new OrdersExport($request->date,$request->location), 'orders'.$toJalali.'.xlsx');
        }else{
            return Excel::download(new OrdersExportNew($request->date,$request->location), 'orders'.$toJalali.'.xlsx');
        }
    }

    public function exportExcAccounting(Request $request){
        return Excel::download(new OrdersAccountingExport($request->year,$request->month), 'orders-'.$request->year."-".$request->month.'.xlsx');
    }

    public function addUserExcel(Request $request){
        Excel::import(new UsersImport, $request->file('userFile'));
        return back()->withErrors('لیست با موفقیت افزوده شد.');

    }

    public function addFoodExcel(Request $request){
        Excel::import(new OptionsImport, $request->file('foodFile'));
        return back()->withErrors('لیست با موفقیت افزوده شد.');
    }
}
