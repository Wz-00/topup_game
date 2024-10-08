<?php

namespace App\Http\Controllers;
use App\Models\Company;

use App\Models\Message;
use App\Models\MessageAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    
    public function index(){
        $company = Company::find(1);
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                $message = Message::all();
                return view('admin.contact', [
                    'title' => 'Messages',
                    'activities' => $message
                ]);
            } else{
                $message = Message::where('user_id', Auth::user()->id)->get();
                return view('user.contact', [
                    'title' => 'Contact',
                    'company' => $company,
                    'activities' => $message,
                ]);
            }
        } else {
            return view('user.contact', [
                'title' => 'Contact',
                'company' => $company,
            ]);
        }

        
    }
    public function detail(Message $activity){
        $elapsedTime = $activity->created_at->diffForHumans();
    
        // Cari MessageAdmin yang sesuai dengan request_id di Message
        $admin = MessageAdmin::where('request_id', $activity->request_id)->first();
        $reply = null;
        $adminElapsedTime = null; // Variabel untuk menyimpan waktu pesan admin
    
        if ($admin) {
            // Jika ada admin message yang sesuai, set reply dengan message admin tersebut
            $reply = $admin->message;
            // Hitung waktu diffForHumans untuk pesan admin
            $adminElapsedTime = $admin->created_at->diffForHumans();
        }
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return view('admin.detailmessage', [
                    'title' => 'Detail Message',
                    'activity' => $activity,
                    'elapsedTime' => $elapsedTime,
                    'reply' => $reply,
                    'adminElapsedTime' => $adminElapsedTime, 
                ]);
            } else {
                return view('user.detailmessage', [
                    'title' => 'Detail Message',
                    'activity' => $activity,
                    'elapsedTime' => $elapsedTime,
                    'reply' => $reply,
                    'adminElapsedTime' => $adminElapsedTime, 
                ]);
            }
        }
        return redirect('/')->with('error', 'anda tidak memiliki akses untuk halaman ini');
    }
    
    
    public function updateStatus($id){
        $activity = Message::find($id);
        $return = $activity->request_id;
        if ($activity) {
            if ($activity->status === 'unread') {
                $activity->status = 'Read';
                $activity->save();
                return redirect()->route('detail.message',['activity'=>$return]);
            }
        }
    }
    public function store(Request $request){
        
        if (Auth::check()) {
            $request->validate([
                'subject' => 'required|string',
                'message' => 'required' 
            ]);
            $userId = Auth::id();
            $message = new Message;
            $message->user_id = $userId;
            $message->name = Auth::user()->name;
            $message->subject = $request->input('subject');
            $message->email = Auth::user()->email;
            $message->message = $request->input('message');
        } else {
            $request->validate([
                'name' => 'required|string',
                'subject' => 'required|string',
                'email' => 'required|email:dns',
                'message' => 'required' 
            ]);
            $message = new Message;
            $message->name = $request->input('name');
            $message->subject = $request->input('subject');
            $message->email = $request->input('email');
            $message->message = $request->input('message');
        }
        $message->save();
        return back()->with('success', 'Pesan berhasil terkirim');
    }
    public function replyMessage(Request $request, $id){
        $message = Message::find( $id);
        $request->validate([
            'message' => 'required'
        ]);
        $reply = new MessageAdmin;
        $reply->message = $request->input('message');
        $reply->request_id = $message->request_id;
        $reply->receiver_id = $message->user_id;
        $reply->save();
        $message->status = 'Solved';
        $message->save();
        return redirect()->back()->with('success', 'Pesan berhasil dikirim');
    }
}
