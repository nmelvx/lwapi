<?php

namespace App\Http\Controllers;

use App\Repositories\FilesRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use App\LiveWallpapers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class ApiController extends Controller
{

    private $user;
    private $lw;
    private $file;

    public function __construct(FilesRepository $filesRepository)
    {
        $this->user = new User();
        $this->lw = new LiveWallpapers();
        $this->file = $filesRepository;
    }

    public function login(Request $request){
        $credentials = $request->only('id', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'invalid_email_or_password',
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'failed_to_create_token',
            ]);
        }

        return response()->json([
            'response' => 'success',
            'result' => [
                'token' => $token,
            ],
        ]);
    }

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function register(Request $request){

        $password = $this->randomPassword();

        try {
            $user = $this->user->create([
                'phoneUniqueId' => $request->input('phoneUniquieId'),
                'password' => bcrypt($password),
            ]);
        } catch (QueryException $e){
            if($e->getCode() == '23000'){
               return response()->json(['error'=>'duplicate_phone_id']);
            }
            return response()->json(['error'=> $e->getMessage()]);
        }

        return response()->json([
            'userId' => $user->id,
            'password' => $password,
        ]);
    }

    public function getAuthUser(Request $request){

        $user = JWTAuth::toUser($request->token);

        return response()->json(['result' => $user]);
    }

    public function logout(Request $request){

        JWTAuth::invalidate($request->token);

        return true;
    }


    public function sendToPublicDrirectory(Request $request){

        try {
            $lw = $this->lw->updateOrCreate(
                [
                    'id' => isset($request->lwID) ? $request->lwID : 0
                ],
                [
                    'typeID' => $request->typeID,
                    'categID' => $request->categID,
                    'title' => $request->title,
                    'statusID' => $request->statusID,
                    'ratingUp' => $request->ratingUp,
                    'ratingDown' => $request->ratingDown
                ]
            );

            $this->file->saveOrUpdate($request->file('preview_img'), $lw, 'previewURL', 'uploads/images/');
            $this->file->saveOrUpdate($request->file('resource'), $lw, 'resourceURL', 'uploads/files/');

            return response()->json([
                'lwID' => $lw->id
            ]);

        } catch (Exception $e){
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'error' => 'invalid'
            ]);
        }
    }

    public function toUser($token = false)
    {
        $payload = $this->getPayload($token);
        if (! $user = $this->user->getBy($this->identifier, $payload['sub'])) {
            return false;
        }

        return $user;
    }

}