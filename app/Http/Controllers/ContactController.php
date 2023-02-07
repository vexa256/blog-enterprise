<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Contacts;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        if (get_buzzy_config('p_buzzycontact') != 'on') {
            return redirect()->route('home');
        }

        $labels = Tag::byType('maillabel')->pluck('name', 'id');

        return view('_contact.contactpage', compact('labels'));
    }

    public function create(Request $request)
    {
        $inputs = $request->all();

        // incase if $thumb then tuse save button. we need to save image for that
        try {
            $validator = $this->validator($inputs);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $cat = Tag::byType('mailcat')->where('slug', 'inbox')->first();
            $contact = new Contacts;
            $contact->name = clean($inputs['name'], 'titles');
            $contact->email = clean($inputs['email'], 'titles');
            $contact->subject = clean($inputs['subject'], 'titles');
            $contact->text = clean($inputs['text'], 'titles');
            $contact->category_id = $cat->id;
            $contact->label_id = $inputs['label'];
            $contact->read = 0;
            $contact->save();

            $this->sendCopyEmail($contact);

            Session::flash('success.message', trans('buzzycontact.successgot'));
            return redirect()->route('home');
        } catch (\Exception $e) {
            Session::flash('error.message', $e->getMessage());
            return redirect()->back()->withInput($inputs);
        }
    }

    public function sendCopyEmail(Contacts $contact)
    {
        try {
            $composeto = get_buzzy_config('BuzzyContactCopyEmail');
            if (!empty($composeto)) {
                Mail::to($composeto)->send(new ContactMail($contact));
            }
        } catch (\Exception $e) {
            // no error
        }
    }

    public function validator($inputs)
    {
        $rules = [
            'name'      => 'required',
            'email'     => 'required|email',
            'subject'   => 'required|min:5|max:255',
            'text'      => 'required|max:1500',
            'label'     => 'required',
        ];
        if (get_buzzy_config('BuzzyContactCaptcha') == "on") {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }

        return Validator::make($inputs, $rules);
    }
}
