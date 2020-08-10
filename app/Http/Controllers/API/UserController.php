<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::with(['orders'])->get());
    }

    /**
     * 
     */
    public function login(Request $request){
        $status = 401;
        $response = ['error' => 'Unauthorised'];
        if(Auth::attempt($request->only(['email','password']))){
            $status = 200;
            $response = [
                'user'=>Auth::user(),
                'token'=>Auth::user()->createToken('bigStore')->accessToken
            ];
        }
        return response()->json($response,$status);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $data = $request->only(['name','email','password']);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        \Illuminate\Support\Facades\Log::info($user);
        $user->is_admin = 0;
        return response()->json([
            'user'=>$user,
            'token'=> $user->createToken('bigStore')->accessToken
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    public function showOrders(User $user){
        return \response()->json($user->orders()->with(['product']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
