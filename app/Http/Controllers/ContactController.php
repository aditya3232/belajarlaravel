<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function AdminContact(){
        $contacts = Contact::all();
        return view('admin.contact.index',compact('contacts'));
    }

    public function AdminAddContact(){
        return view('admin.contact.create');
    }

    public function AdminStoreContact(Request $request){
         Contact::insert([
            'email' => $request->email,
            'phone' => $request->phone, 
            'address' => $request->address, 
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.contact')->with('success', 'Insert contact berhasil dilakukan');
    }

    public function Contact(){
        $contacts = DB::table('contacts')->first();
        return view('pages.contact',compact('contacts'));
    }

    public function ContactForm(Request $request){
        ContactForm::insert([
            'name' => $request->name,
            'email' => $request->email, 
            'subject' => $request->subject, 
            'message' => $request->message, 
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('contact')->with('success', 'Pesan kamu sudah terkirim');
    }
}