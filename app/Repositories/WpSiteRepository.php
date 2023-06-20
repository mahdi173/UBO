<?php

namespace App\Repositories;

use App\Enum\CronStateEnum;
use App\Models\WpSite;
use App\Interfaces\CrudInterface;
use Illuminate\Http\JsonResponse;
use App\Interfaces\WpSiteRepositoryInterface;

class WpSiteRepository implements CrudInterface,WpSiteRepositoryInterface 
{      
    /**
     * getAll
     *
     * @return mixed
     */
    public function getAll(): mixed{
        return  WpSite::paginate(10);
    }
    
    /**
     * create
     *
     * @param  array $data
     * @return WpSite
     */
    public function create(array $data): WpSite {
        return WpSite::create($data);
    }
    
    /**
     * update
     *
     * @param  mixed $wpSite
     * @param  array $data
     * @return void
     */
    public function update(mixed $wpSite, array $data): void {
      $wpSite->update($data);
    }
    
    /**
     * delete
     *
     * @param  mixed $wpSite
     * @return void
     */
    public function delete(mixed $wpSite): void{
        $wpSite->delete();
    }
    
    public function showUsers(WpSite $wpSite) :JsonResponse{
        $siteWithUsers = WpSite::with(['pole', 'type', 'users' => function ($query) use ($wpSite) {
            $query->select('wp_users.*','roles','user_site.username')->where("etat","!=", CronStateEnum::ToDelete->value)
                ->whereHas('sites', function ($query) use ($wpSite) {
                    $query->where('wp_site_id', $wpSite->id);
                });            
        }])->find($wpSite->id);
        return response()->json($siteWithUsers, 200);   
    }

    /**
     * getWpSiteByName
     *
     * @param  string $name
     * @return WpSite
     */
    public function getWpSiteByName(string $name): ?WpSite{
        return WpSite::withTrashed()->where("name", $name)->first();
    }

     /**
     * getWpSiteByDomain
     *
     * @param  string $domain
     * @return WpSite
     */
    public function getWpSiteByDomain(string $domain): ?WpSite{
        return WpSite::where("domain", $domain)->first();
    }

    /**
     * findById
     *
     * @param  int $id
     * @return mixed
     */
    public function findById(int $id): ?WpSite{
        return WpSite::where("id", $id)->first();
    }
}