<?php

namespace Tests\Feature;

use App\Enum\CronStateEnum;
use App\Models\Pole;
use App\Models\Type;
use App\Models\UserSite;
use App\Models\WpSite;
use App\Models\WpUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PerformanceTest extends TestCase
{
    public function test_basic_eloquent_retrieval()
    {
        $start = microtime(true);
        $records = WpUser::all();
        $end = microtime(true);

        $executionTime = $end - $start;

        $this->assertTrue(true); // You can add assertions or perform any other necessary checks
        $this->printExecutionTime($executionTime, 'Eloquent Retrieval');
    }

    public function test_basic_DB_retrieval()
    {
        $start = microtime(true);
        $records = DB::table('wp_users')->get();
        $end = microtime(true);

        $executionTime = $end - $start;

        $this->assertTrue(true); // You can add assertions or perform any other necessary checks
        $this->printExecutionTime($executionTime, 'DB Retrieval');
    }

    public function test_userSite_eloquent_retrieval()
    {
        $start = microtime(true);
        $records = UserSite::with('user')->where("etat", CronStateEnum::Active->value)->get()->groupBy('wp_site_id');
        $end = microtime(true);

        $executionTime = $end - $start;

        $this->assertTrue(true); // You can add assertions or perform any other necessary checks
        $this->printExecutionTime($executionTime, 'userSite Eloquent Retrieval');
    }

    public function test_userSite_DB_retrieval()
    {
        $start = microtime(true);
        $records = DB::table('user_site')
                        ->join('wp_users', 'user_site.wp_user_id', '=', 'wp_users.id')
                        ->select('user_site.id', 'wp_user_id', 'wp_site_id', 'roles', 'wp_users.email', 'wp_users.userName', 'wp_users.firstName', 'wp_users.lastName')
                        ->where('user_site.etat', CronStateEnum::Active->value)
                        ->get()
                        ->groupBy('wp_site_id');
        $end = microtime(true);

        $executionTime = $end - $start;

        $this->assertTrue(true); // You can add assertions or perform any other necessary checks
        $this->printExecutionTime($executionTime, 'userSite DB Retrieval');
    }

    public function test_ShowSite_eloquent_retrieval()
    {
        $start = microtime(true);
        
        WpSite::with(['pole', 'type', 'users' => function ($query) {
            $query->select('wp_users.*','roles','user_site.username')->where("etat","!=", CronStateEnum::ToDelete->value)
                ->whereHas('sites', function ($query) {
                    $query->where('wp_site_id', 52);
                });            
        }])->find(52);        
        
        $end = microtime(true);

        $executionTime = $end - $start;

        $this->assertTrue(true); // You can add assertions or perform any other necessary checks
        $this->printExecutionTime($executionTime, 'ShowSite Eloquent Retrieval');
    }

    public function test_ShowSite_DB_retrieval()
    {
        $start = microtime(true);
      
        $type= Type::where('id', 52)->first();
        $pole= Pole::where('id',52)->first();


        $users = DB::table('user_site')
                    ->join('wp_sites', 'user_site.wp_site_id', '=', 'wp_sites.id')
                    ->join('wp_users', 'user_site.wp_user_id', '=', 'wp_users.id')
                    ->select('wp_users.*', 'roles', 'user_site.username')
                    ->where('user_site.wp_site_id',52)
                    ->where('user_site.etat', '!=', CronStateEnum::ToDelete->value)
                    ->where('user_site.deleted_at', '=', null)
                    ->get();


        foreach($users as $user){
            $user->roles= json_decode( $user->roles);
        }

        $end = microtime(true);

        $executionTime = $end - $start;

        $this->assertTrue(true); // You can add assertions or perform any other necessary checks
        $this->printExecutionTime($executionTime, 'ShowSite DB Retrieval');
    }

    private function printExecutionTime($executionTime, $operationName)
    {
        $executionTime = round($executionTime, 4); // Optional: Round execution time to desired decimal places
        dump("Execution time for $operationName: $executionTime seconds\n");
    }
}
