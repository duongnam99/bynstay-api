<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Client;
use App\Models\Host;
use App\Models\User;
use App\Validators\InputValidator;
use Illuminate\Support\Facades\Auth;
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
            return $this->sendError('Validation Error.', $validator->errors());       
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
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('bynstay')->plainTextToken; 
            $success['email'] =  $user->email;
            $success['user'] =  $user;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function updatePassword(Request $request)
    {
        $validator = InputValidator::updateHostPw($request);
        if ($request->new_password != $request->new_cf_password) {
            return response()->json(['status' => false]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $user->password = $request->new_password;
            $user->save();
            return response()->json(['status' => true]);
        } 

        return response()->json(['status' => false]);
    }

}