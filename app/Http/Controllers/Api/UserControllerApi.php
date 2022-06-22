<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\MediaCollection;
use App\Http\Resources\v1\SentBoxCollection;
use App\Http\Resources\v1\UserPackageCollection;
use App\Http\Resources\v1\UserResource;
use App\Models\Media;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class UserControllerApi extends Controller
{
    /**
     * get authenticated user details
     * @param Request $request
     * @return JsonResponse
     */
    public function getMyDetails(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $userSmsInventory = $this->userSmsInventory($user);
            return $this->baseJsonResponse([
                'user'=>  new UserResource($user,$userSmsInventory)
            ],['title'=>'مشخصات کاربر']);

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()], ResponseAlias::HTTP_BAD_REQUEST);
        }

    }

    /**
     * update authenticated user details
     * @param Request $request
     * @return JsonResponse
     */
    public function setMyDetails(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'nullable',
                'email' => 'nullable',
                'title' => 'nullable',
            ]);

            if ($validator->fails()) {
                return $this->baseJsonResponse(['status'=>false],[
                    'validator_errors'=>$validator->messages()
                ]);
            }

            $user = $request->user();
            $update=$user->update([
                'name'=>$request->name,
                'account_title'=>$request->title,
                'email'=>$request->email
            ]);
            if ($update){
                return $this->baseJsonResponse([
                    'status'=>  true
                ],['title'=>'مشخصات با موفقیت ثبت شد']);
            }else{
                return $this->baseJsonResponse([
                    'status'=>  false
                ],['title'=>'مشکلی در ویرایش مشخصات بوجود آمد']);
            }

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>  false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * get authenticated user socials
     * @param Request $request
     * @return JsonResponse
     */
    public function getMySocials(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $medias = Media::query()->where('status',true)->get();

            return $this->baseJsonResponse([
                'status'=>true,
                'medias'=>  new MediaCollection($medias,$user)
            ],['title'=>'لیست لینک ها به همراه مقادیر ثبت شده توسط کاربر']);

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>  false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * update authenticated user socials
     * @param Request $request
     * @return JsonResponse
     */
    public function setMySocials(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $res = $this->setUserLink($request->values,$user);
            if ($res){
            return $this->baseJsonResponse(['status'=>  true],['title'=>'لینک ها ثبت شد']);
            }else{
                return $this->baseJsonResponse(['status'=>  false],['title'=>'مشکلی در ثبت لینک ها بوجود آمد']);
            }

        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }

    }


    /**
     * get authenticated user sent records
     * @param Request $request
     * @return JsonResponse
     */
    public function getSendBox(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user_sent_box = $user->user_sends()->latest()->get();
            return $this->baseJsonResponse([
                'status'=>  true,
                'sent_box'=>new SentBoxCollection($user_sent_box)
            ],['title'=>'لیست آخرین ارسال ها']);
        }catch (\Exception $exception){
            return $this->baseJsonResponse(['title'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * get authenticated user active packages
     * @param Request $request
     * @return JsonResponse
     */
    public function getMyPackages(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user_packages = $user->user_packages()
                ->where('expired_at','>=',Carbon::now())
                ->latest()->get();
            return $this->baseJsonResponse([
                'status'=>  true,
                'packages'=> new UserPackageCollection($user_packages)
            ],['title'=>'لیست بسته های فعال']);
        }catch (\Exception $exception){
            return $this->baseJsonResponse(['title'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * get authenticated user tokens
     * @param Request $request
     * @return JsonResponse
     */
    public function getMyTokens(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $user_tokens = $user->tokens;
            return $this->baseJsonResponse([
                'status'=>  true,
                'tokens'=> $user_tokens
            ],['title'=>'توکن های فعال شما']);
        }catch (\Exception $exception){
            return $this->baseJsonResponse(['title'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * delete authenticated user token with token_id
     * @param Request $request
     * @param $token_id
     * @return JsonResponse
     */
    public function deleteMyToken(Request $request,$token_id): JsonResponse
    {
        try {
            $user = $request->user();
            $deleted_token = $user->tokens()->where("id",$token_id)->delete();
            return $this->baseJsonResponse([
                'status'=>  true,
                'res'=> $deleted_token
            ],['title'=>'توکن حذف شد']);
        }catch (\Exception $exception){
            return $this->baseJsonResponse(['title'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * delete authenticated user tokens
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAllOtherMyTokens(Request $request): JsonResponse
    {
        // that function is not completed
        try {
            $user = $request->user();
            $deleted_token = $user->currentAccessToken();
            return $this->baseJsonResponse([
                'status'=>  true,
                'res'=> $deleted_token
            ],['title'=>'همه ی توکن های دیگر حذف شد']);
        }catch (\Exception $exception){
            return $this->baseJsonResponse(['title'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }
}
