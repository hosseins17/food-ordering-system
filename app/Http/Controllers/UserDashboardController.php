<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use App\Models\Options;
use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    function submitOrder(Request $request)
    {
        $option=Options::find($request->option_id);
        if(isValidTimeToSubmitOrDeleteOrder($option)){
            Orders::create([
                'user_id'=>Auth::user()->id,
                'order_id'=>$request->option_id,
                'location_id'=>$request->location,
                'company_id'=>Auth::user()->company,
                'option'=>$request->option
            ]);

            return back()->withErrors("غذا با موفقیت ثبت شد.");
        }else{
            return back()->withErrors("غذا ثبت نشد. زمان انتخاب شما مناسب نیست و باید حتماً در روز قبل تا قبل از ساعت ۱۲ ظهر باشد");
        }

    }

    function deleteOrder(Request $request)
    {
        $order=Orders::find($request->orderid);
        $option=Options::find($order->order_id);
        if(isValidTimeToSubmitOrDeleteOrder($option)) {
            $order->delete();
            return back()->withErrors("غذا با موفقیت حذف شد.");
        }else{
            return back()->withErrors("غذا حذف نشد. زمان حذف غذا مناسب نیست و باید حتماً در روز قبل تا قبل از ساعت ۱۲ ظهر باشد");

        }
    }

    public function profilePage(){
        $locations = Locations::get();
        return view('profile',compact('locations'));
    }

    public function changePassword(Request $request)
    {
        if ($request->password==$request->password_conf){
            $user=User::find(Auth::user()->id);
            $user->password=bcrypt($request->password);
            $user->save();
            return back()->withErrors('رمز شما با موفقیت تغییر کرد.');
        }else{
            return back()->withErrors('رمز وارد شده با تکرار آن مطابقت ندارد.');
        }
    }
    public function changeInfo(Request $request)
    {
        $user=User::find(Auth::user()->id);
        $user->update($request->all());
        $user->save();
        return back()->withErrors('اطلاعات شما بروز شد.');
    }

    public function ordersHistory(Request $request)
    {
        if(!isset($request->startDate)){
            $lastOrders= Orders::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        }else{
            $startDate=JalaliToGregorian($request->startDate);
            $endDate=JalaliToGregorian($request->endDate);
            $options=Options::whereDate('date',">=",$startDate)->whereDate('date',"<=",$endDate)->get();
            $lastOrders=new Collection();
            //$lastOrders = Orders::where('user_id',-1)->get();
            foreach ($options as $option){
                $Orders = Orders::where('user_id',Auth::user()->id)->where("order_id",$option->id)->get();
                foreach ($Orders as $order){
                    $lastOrders->push($order);
                }

                //array_push($lastOrders,Orders::where('user_id',Auth::user()->id)->where("order_id",$option->id)->get());
            }

        }
        return view('ordersHistory', compact('lastOrders'));
    }
}
