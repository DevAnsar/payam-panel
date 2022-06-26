<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class MainController extends Controller
{
    public function indexPage(){
        return view('web.index');
    }
    public function aboutUsPage()
    {
        return view('web.about-us');
    }

    public function contactUsPage()
    {
        return view('web.contact-us');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveContact(Request $request){

        try {
            $this->validate($request,[
                "name"=>"required",
                "email"=>"required|email",
                "subject"=>"required|min:3",
                "content"=>"required|min:5"
            ]);
            Contact::create($request->all());
            Alert::success('ممنون از همراهی شما'," پیام شما با موفقیت به پشتیبانی ارسال شد");
            return redirect(route('web.index'));
        }catch (\Exception $err){
            Alert::error('ممنون از همراهی شما',"مشکلی در ارسال پیام شما رخ داد کمی بعد دوباره تلاش کنید");
            return redirect(route('web.contact-us'));
        }

    }
}
