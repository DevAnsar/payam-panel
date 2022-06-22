<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\PackageCollection;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PackageApiController extends Controller
{
    /**
     * return packages list
     * @return JsonResponse
     */
    public function getPackages(): JsonResponse
    {
        try {
            $packages = Package::query()->where('status',true)->get();
            return $this->baseJsonResponse([
                'status'=>  true,
                'packages'=>new PackageCollection($packages)
            ],['title'=>'لیست پک های پیامکی']);
        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * get package details for buy
     * @param Package $package
     * @return JsonResponse
     */
    public function getPackage(Package $package): \Illuminate\Http\JsonResponse
    {
        try {
            if ($package->status){
                $prices = $this->packPayPrice((string)$package->price);
                return $this->baseJsonResponse([
                    'status'=>  true,
                    'title'=>$package->title,
                    'count'=>$package->count,
                    'packPrice'=>$package->price,
                    'days'=>$package->days,
                    'commissionPercentage'=>$prices["commissionPercentage"],
                    'commissionPrice'=>$prices["commissionPrice"],
                    'payPrice'=>$prices["totalPrice"],
                ],['title'=>'مشخصات و قیمت پک پیامکی']);
            }else{
                return $this->baseJsonResponse([
                    'status'=>  false,
                ],['title'=>'پکیج مورد نظر یافت نشد']);
            }


        }catch (\Exception $exception){
            return $this->baseJsonResponse(['status'=>false],[$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }
}
