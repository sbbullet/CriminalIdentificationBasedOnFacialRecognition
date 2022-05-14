<?php

namespace App\Http\Controllers;

use App\Suspect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth:admin');

        $addedSuspects = Suspect::latest()->get();

        View::share('addedSuspects', $addedSuspects);
    }

    public function showDashboard()
    {
    	return view('admin.dashboard');
    }

   /*
    |--------------------------------------------------------------------------
    | DETECTION ZONE
    |--------------------------------------------------------------------------
    */

    public function getAddedSuspects()
    {

        $knownSuspects = Suspect::select('id', 'embedding')->whereNotNull('embedding')->get();
        return response()->json(['suspects' => $knownSuspects]);
    }
    
    public function showDetectedSuspects()
    {
        return view('admin.detected-suspects');
    }

    public function addDetectedSuspectToUserProfile(Suspect $suspect)
    {
        $user = Auth::user();

        if($user->suspects()->where('id', $suspect->id)->exists()){

            $existingSuspect = $user->suspects->find($suspect->id);
            if(Carbon::now()->diffInSeconds($existingSuspect->pivot->updated_at) > 30){
                $user->suspects()->updateExistingPivot($suspect->id, [
                    'updated_at'=> Carbon::now(),
                    'no_of_detections'=> $existingSuspect->pivot->no_of_detections + 1,
                    ]);
                    return response()->json(['message'=> 'exists']);
                }
                return response()->json(['message'=>'just_detected']);
        }
        
        $user->suspects()->attach($suspect, ['no_of_detections'=>1]);

        return response()->json(['message'=>'attached']);
    }

   /*
    |--------------------------------------------------------------------------
    | ADD SUSPECT ZONE
    |--------------------------------------------------------------------------
    */

    public function showAddSuspectForm()
    {
        return view('admin.add-suspect');
    }

    public function addSuspect(Request $request)
    {
        $request->validate([
            'fullName' => 'regex:/^([a-zA-Z ]+)$/',
            'address' => 'string',
            'file' => 'required|file|max:3000|mimes:jpg,jpeg',
        ]);

        $suspect = new Suspect;
         
        if(request('fullName')){
            $suspect->name = request('fullName');
        }
                 
        if(request('address')){
            $suspect->address = request('address');
        }

        if($request->hasFile('file')){

            $file = request('file');

            $data = base64_encode(file_get_contents($request->file('file')));


            $fileName = time().'-'. $file->getClientOriginalName();

            $file->move(public_path() . '/storage/uploads', $fileName);

            $image = "data:image/{$file->getClientOriginalExtension()};base64,{$data}";


            $suspect->photo = $fileName;

            // dd(($image));

        }

        // dd($image);

        $suspect->save();

        // session()->flash('flashMessage', 'Suspect successfully added');

        return response()->json([
            'id' => $suspect->id,
            'image' => $image,
        ]);
    }

    public function addEmbedding(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'embedding'=> 'required'
        ]);

        $suspect = Suspect::findOrFail(request('id'));

        $suspect->embedding = request('embedding');

        $suspect->save();

        return response()->json(['message'=> 'Embedding saved successfully']);
    }

    public function deleteSuspect(Suspect $suspect)
    {
        unlink(public_path($suspect->photo_path));
        $suspect->delete();
        session()->flash('flashMessage', 'Suspect deleted successfully');
        return redirect()->back();
    }






   /*
    |--------------------------------------------------------------------------
    | CHANGE PASSWORD SECTION
    |--------------------------------------------------------------------------
    */

    public function changePW()
    {
        return view('admin.change-pw');
    }

    public function updatePW(Request $request)
    {
        
        if(!(Hash::check(request('oldPw'), Auth::user()->password))){

            // Return error if entered password doesn't match current password
            return redirect()->back()->withErrors([
                'oldPw' => 'Entered password doesn\'t match the current password. Please, try again.' ,
            ]);
        }

        // Return error if current and new password are same
        if(strcmp($request->oldPw, $request->newPw) == 0){

            return redirect()->back()->withErrors([
                    'newPw' => 'New password cannot be same as current password. Try a different password.' ,
            ]);
        }

        // Validate inputs
        $request->validate([
                'oldPw' => 'required',
                'newPw' => 'required|string|min:6|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ],[
            'oldPw.required' => 'This field is required.',
            'newPw.required' => 'This field is required.',
            'newPw.min' => 'Password must have at least 6 characters.',
            'newPw.confirmed' => 'The new password confirmation doesn\'t match.',
            'newPw.regex' => 'Password must have at least 6 characters with at least 1 uppercase letter, 1 lowercase letter & 1 digit.',
        ]);

        // Regex for password with at least 8 characters, one uppercase letter, one lowercase letter, one number, one special character
        // ^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$
        // ^(?=.*\d)(?=.*?[a-zA-Z])(?=.*?[\W_]).{8,}$

        // Update/Change password

        $user = Auth::user();
        $user->password = bcrypt(request('newPw'));
        $user->save();

        session()->flash('flashMessage', 'Password has been changed successfully.');

        return redirect('/admin');

    }


    /*
    |--------------------------------------------------------------------------
    | EDIT PROFILE SECTION
    |--------------------------------------------------------------------------
    */

    public function editProfile()
    {
        return view('admin.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'fullName' => 'min:6|regex:/^([a-zA-Z ]+)$/',
            'email'    => 'email',
            'file' => 'max:3000|mimes:jpg,jpeg,btm,png',
        ],[
            'fullName.min' => 'Your full name must have at least 5 characters.',
            'fullName.regex' => 'Your full name must have only letters and space between first and last name.',
            'file.max' => 'File can not be more than 3MB.',
            'file.mimes' => 'Your profile picture can only be image files.',
        ]);

        $user = Auth::user();

        if($request->hasFile('file')){

            $file = request('file');

            $fileName = time().'-'. $file->getClientOriginalName();

            if(!empty($user->dp)){

                unlink(public_path('storage/uploads/' . $user->dp));
            }

            $user->update(['dp' => $fileName]);

            $file->move(public_path() . '/storage/uploads', $fileName);
            

            // Image compression using Intervention Package
            // $img= Image::make(public_path('storage/uploads/'.$fileName));
            // $img->resize(null, 150, function($constraint){
            //     $constraint->aspectRatio();
            // });
            // $img->save();

        }

        $user->update([
            'name' => request('fullName'),
            'email'=> request('email'),
        ]);

        session()->flash('flashMessage','Your profile has successfully been updated.');
        return redirect('/admin');
    }

}
