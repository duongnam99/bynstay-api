<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Client;
use App\Models\Host;
use App\Models\User;
use App\Validators\InputValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'int',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('bynstay')->plainTextToken;
        $success['user'] =  $user;

        if ($request->has('user_type')) {
            $success['user_type'] =  $request->user_type;
            if ($request->user_type == User::CLIENT) {
                $this->createSubEntity(new Client(), $user->id);
            } elseif ($request->user_type == User::HOSTS) {
                $this->createSubEntity(new Host(), $user->id);
            }
        } else {
            $this->createSubEntity(new Client(), $user->id);
        }

        return $this->sendResponse($success, 'User register successfully.');
    }

    
    private function createSubEntity($entity, $userId) 
    {   
        $entity->user_id = $userId;
        $entity->save();
    }


    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('bynstay')->plainTextToken; 
            $success['email'] =  $user->email;
            $success['user'] =  $user;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 

        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 403);
    }

    public function updatePassword(Request $request)
    {

        $validator = InputValidator::updatePw($request);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        if ($request->new_password != $request->new_cf_password) {
            return response()->json(['status' => false]);
        }
        
        if($user = User::where('email', $request->email)->first()){ 
            $user->password = bcript($request->new_password);
            $user->save();
            return response()->json([
                'status' => true,
                'user' => $user
            ]);
        } 

        return response()->json(['status' => false]);
    }

    public function edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }
        
        if($user = User::where('email', $request->email)->first()){ 
            $user->name = $request->name;
            $user->phone = $request->phone;
            if ($request->has('file')) {
                $path = Storage::disk('public_uploads')->put('user', $request->file[0]);
                $user->avatar = $path;
            }
            $user->save();
            return response()->json([
                'status' => true,
                'user' => $user
            ]);
        } 

        return response()->json(['status' => false]);
    }

}