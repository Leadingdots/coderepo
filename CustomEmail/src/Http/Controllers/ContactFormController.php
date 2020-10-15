<?php
namespace Leadingdots\CustomEmail\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Leadingdots\CustomEmail\Models\ContactForm;

class ContactFormController extends Controller {

    public function index()
    {
        return view('customemail::contact');
    }

    public function sendMail(Request $request)
    {
        ContactForm::create($request->all());

        return redirect(route('contact'))->with(['message' => 'Thank you, your mail has been sent successfully.']);;
    }


}