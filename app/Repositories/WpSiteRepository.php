<?php

namespace App\Repositories;

use App\Enum\CronStateEnum;
use App\Models\WpSite;
use App\Interfaces\CrudInterface;
use Illuminate\Http\JsonResponse;
use App\Interfaces\WpSiteRepositoryInterface;
use App\Models\Pole;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use stdClass;

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
        
    /**
     * showUsers
     *
     * @param  WpSite $wpSite
     * @return JsonResponse
     */
    public function showUsers(WpSite $wpSite) :JsonResponse
    {
        $response= new stdClass();

        $type= Type::where('id', $wpSite->type_id)->first();
        $pole= Pole::where('id', $wpSite->pole_id)->first();

        $users = DB::table('user_site')
                    ->join('wp_sites', 'user_site.wp_site_id', '=', 'wp_sites.id')
                    ->join('wp_users', 'user_site.wp_user_id', '=', 'wp_users.id')
                    ->select('wp_users.*', 'roles', 'user_site.username')
                    ->where('user_site.wp_site_id', $wpSite->id)
                    ->where('user_site.etat', '!=', CronStateEnum::ToDelete->value)
                    ->where('user_site.deleted_at', '=', null)
                    ->get();

        $response= $wpSite;
        $response->type= $type;
        $response->pole= $pole;

        foreach($users as $user){
            $user->roles= json_decode( $user->roles);
        }

        $response->users= $users;

        return response()->json($response, 200);   
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