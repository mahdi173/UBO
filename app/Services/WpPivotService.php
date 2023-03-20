<?php

namespace App\Services;

use App\Models\WpRole;
use App\Models\WpSite;
use App\Models\WpUser;
use App\Models\WpUserSiteRole;
use Illuminate\Http\JsonResponse;

class WpPivotService
{    
    /**
     * attach
     *
     * @param  mixed $object
     * @param  int $id1
     * @param  int $id2
     * @return JsonResponse
     */
    public function  attach($object, int $id1, int $id2): JsonResponse
    {
        if($object instanceof WpUser){
            $exist= WpUserSiteRole::where('wp_user_id', $object->id)->where('wp_site_id', $id1)->where('wp_role_id', $id2)->first();
            if(!$exist){
                return WpUserSiteRole::create([
                    "wp_user_id"=> $object->id,
                    "wp_site_id"=> $id1,
                    "wp_role_id"=> $id2
                ]);
            }else{
                return response()->json(["msg"=>"Data already exist"],400)->send();
            }
           
        }else if ($object instanceof WpSite){
            $exist= WpUserSiteRole::where('wp_user_id', $id1)->where('wp_site_id', $object->id)->where('wp_role_id', $id2)->first();
            if(!$exist){
                return WpUserSiteRole::create([
                    "wp_user_id"=> $id1,
                    "wp_site_id"=> $object->id,
                    "wp_role_id"=> $id2
                ]);
            }else{
                return response()->json(["msg"=>"Data already exist"],400)->send();
            }
        
        }else if ($object instanceof WpRole){
            $exist= WpUserSiteRole::where('wp_user_id', $id1)->where('wp_site_id', $id2)->where('wp_role_id', $object->id)->first();

            if(!$exist){
                return WpUserSiteRole::create([
                    "wp_user_id"=> $id1,
                    "wp_site_id"=> $id2,
                    "wp_role_id"=> $object->id
                ]);
            }else{
                return response()->json(["msg"=>"Data already exist"],400)->send();
            }
        }
    }
    
    /**
     * dettach
     *
     * @param  mixed $object
     * @param  int $id1
     * @param  int $id2
     * @return JsonResponse
     */
    public function dettach($object, int $id1, int $id2): JsonResponse
    {
        if($object instanceof WpUser){
            $query1= WpUserSiteRole::where("wp_site_id", $id1)->where("wp_user_id", $object->id);
            $query2= WpUserSiteRole::where("wp_role_id", $id2)->where("wp_user_id", $object->id);
        }else if ($object instanceof WpSite){
            $query1= WpUserSiteRole::where("wp_user_id", $id1)->where("wp_site_id", $object->id);
            $query2= WpUserSiteRole::where("wp_role_id", $id2)->where("wp_site_id", $object->id);
        }else if ($object instanceof WpRole){
            $query1= WpUserSiteRole::where("wp_user_id", $id1)->where("wp_role_id", $object->id);
            $query2= WpUserSiteRole::where("wp_site_id", $id2)->where("wp_role_id", $object->id);
        }

        $queryData1= $query1->get()->toArray();
        $queryData2= $query2->get()->toArray();
        if(!$queryData1 || !$queryData2){
            return response()->json([
                "msg"=>"One of the arguments doesn't exist or they are already deleted!"
            ], 404)->send();

        }else if($queryData1){

            foreach($query1->get() as $item){
                $item->delete();
            }

            return response()->json([
                "msg"=>"Items deleted!"
            ]);
        }else if($queryData2){

            foreach($query2->get() as $item){
                $item->delete();
            }

            return response()->json([
                "msg"=>"Items deleted!"
            ]);        
        }
    }
    
    /**
     * sync
     *
     * @param  mixed $object
     * @param  array $arryId1
     * @param  array $arryId2
     * @return JsonResponse
     */
    public function sync($object, array $arryId1, array $arryId2): JsonResponse
    {
        if($object instanceof WpUser){
            $query= WpUserSiteRole::where("wp_user_id", $object->id);

            if($query->get()->toArray()){
                foreach($query->get() as $item){
                    if(!in_array($item->wp_site_id, $arryId1)){
                        $item->delete();
                    }else if(!in_array($item->wp_role_id, $arryId2)){
                        $item->delete();
                    }
                }

                return response()->json([
                    "msg"=>"Items deleted!"
                ]);
            }else{
                return response()->json([
                    "msg"=>"Item doesn't exist!"
                ], 404)->send();
            }
        }else if ($object instanceof WpSite){
            $query= WpUserSiteRole::where("wp_site_id", $object->id);

            if($query->get()->toArray()){
                foreach($query->get() as $item){
                    if(!in_array($item->wp_user_id, $arryId1)){
                        $item->delete();
                    }else if(!in_array($item->wp_role_id, $arryId2)){
                        $item->delete();
                    }
                }

                return response()->json([
                    "msg"=>"Items deleted!"
                ]);
            }else{
                return response()->json([
                    "msg"=>"Item doesn't exist!"
                ], 404)->send();
            }
        }else if ($object instanceof WpRole){
            $query= WpUserSiteRole::where("wp_role_id", $object->id);

            if($query->get()->toArray()){
                foreach($query->get() as $item){
                    if(!in_array($item->wp_user_id, $arryId1)){
                        $item->delete();
                    }else if(!in_array($item->wp_site_id, $arryId2)){
                        $item->delete();
                    }
                }

                return response()->json([
                    "msg"=>"Items deleted!"
                ]);
            }else{
                return response()->json([
                    "msg"=>"Item doesn't exist!"
                ], 404)->send();
            }
        }

    }
}