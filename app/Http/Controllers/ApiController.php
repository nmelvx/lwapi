<?php

namespace App\Http\Controllers;

use App\Repositories\FilesRepository;
use App\Tags;
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
                    'status' => 'error',
                    'message' => 'invalid_email_or_password',
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'failed_to_create_token',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'result' => [
                'userID' => $request->id,
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
                    'userID' => $request->userID,
                    'title' => $request->title,
                    'statusID' => $request->statusID,
                    'ratingUp' => $request->ratingUp,
                    'ratingDown' => $request->ratingDown
                ]
            );

            if(!empty($request->file('preview_img'))){
                $this->file->saveOrUpdate($request->file('preview_img'), $lw, 'previewURL', 'uploads/images/');
            }
            if(!empty($request->file('resource'))){
                $this->file->saveOrUpdate($request->file('resource'), $lw, 'resourceURL', 'uploads/files/');
            }

            /*if(!empty($request->tags))
            {
                $tags = (is_array($request->tags))? $request->tags: explode(',', $request->tags);

                foreach ( $tags as $tag )
                {
                    $save = new Tags();
                    $save->name = $tag;

                    $lw->tags()->save($save);
                }
            }*/

            $this->saveTags($lw, $request->tags);


            return response()->json([
                'lwID' => $lw->id
            ]);

        } catch (Exception $e){
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'status' => 'invalid'
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

    private function saveTags($element, $request)
    {
        if(!empty($request))
        {
            $tags = (is_array($request))? $request: explode(',', $request);
            $element->tags()->detach();

            foreach ( $tags as $k => $tag )
            {
                $element->tags()->save((new \App\Tags)->updateOrCreate(['name' => ucwords($tag)]));
            }
        } else {
            $element->tags()->detach();
        }
        return true;
    }

    public function deleteLW(Request $request){
        try {
            $result = $this->lw->destroy($request->lwID);
        } catch (Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'status' => 'invalid'
            ]);
        }

        return response()->json([
            'status' => ($result)? 'deleted':'invalid'
        ]);
    }

    //dont forget to add filters in query
    public function listUserLW(Request $request){

        //dd($request->all());

        try {
            $results = LiveWallpapers::with('tags')
                ->with('category')
                ->with('type')
                ->where('userID', '=', $request->userID)
                ->withFilters($request->all())
                ->get();
        } catch (Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'status' => 'invalid'
            ]);
        }

        return response()->json($results->toArray());
    }

}