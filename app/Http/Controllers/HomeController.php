<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function check_email(Request $request){
        $email = $request->email;
        $check = User::where('email',$email)->first();
        if(!empty($check)){
            return true;
        }
        return false;
    }

    public function register_user(Request $request){
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
        return true;
    }

    public function generate_qr_code(Request $request){
        $email = $request->email;
        $user = User::where('email',$email)->first();
        if(!empty($user)){
            $url = url('edit_profile').'/'.$user->id;
            return $url;
        }
        return false;
    }

    public function edit_profile($id){
        $user = User::where('id',$id)->first();
        return view('edit_profile',compact('user'));
    }

    public function update_profile(Request $request){
        $user = User::where('id',$request->id)->first();
        if(!empty($user)){
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            if($request->hasFile('profile_pic')){
                $image=$request->file('profile_pic');
                $image_name= $image->getClientOriginalName();
                $path='/user_profile/';
                $image->move(public_path().$path,$image_name);
                $user->profile_pic = $path.$image_name;
            }
            $user->save();
            return true;
        }
        return false;
    }

    public function show_list(){
        return view('show_list');
    }

    public function fetch_user_list(Request $request){
        $data = User::select('id','first_name','last_name','email','profile_pic')->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('profile_pic', function($row){
                if(!empty($row->profile_pic)){
                    $img = '<image src="'.$row->profile_pic.'" height="80" widht="80">';
                } else {
                    $img = '<image src="'.asset('default_avtar.jpeg').'" height="80" widht="80">';
                }
                return $img;
            })
            ->rawColumns(['profile_pic'])
            ->make(true);
    }
}
