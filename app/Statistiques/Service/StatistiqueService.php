<?php

namespace App\Statistiques\Service;

use App\Services\UserService;
use App\Services\WpRoleService;
use App\Services\WpSiteService;
use App\Services\WpUserService;
use App\Modules\Poles\Service\PoleService;
use App\Modules\Roles\Service\RoleService;
use App\Modules\Types\Service\TypeService;


class StatistiqueService {

    public function __construct( 
    protected PoleService $poleService,
    protected RoleService $roleService,
    protected TypeService $typeService,
    protected UserService $userService,
    protected WpRoleService $wpRoleService,
    protected WpSiteService $wpSiteService,
    protected WpUserService $wpUserService)
    {
    }   
   

        public function statistics()
        {
            $poleCount = $this->poleService->count();
            $sitesPerPole = $this->poleService->SitesPerPole();
            $roleCount = $this->roleService->count();
            $typeCount = $this->typeService->count();
            $sitesPerType = $this->typeService->SitesPerType();
            $userCount = $this->userService->count();
            $wpRoleCount = $this->wpRoleService->count();
            $wpUsersCount = $this->wpUserService->count();
            $wpSitesCount = $this->wpSiteService->count();
            $userRolesInSite = $this->wpSiteService->getUsersRolesInSite();

            $statistics = [

                'poles' => $poleCount,
                'roles' => $roleCount,
                'types' => $typeCount,
                'users' => $userCount,
                'WpRoles' => $wpRoleCount,
                'WpUsers' => $wpUsersCount,
                'WpSites' => $wpSitesCount,
                'sitesPerPole' =>$sitesPerPole,
                'sitesPerType' =>$sitesPerType,
                'userRolesInSite' =>$userRolesInSite
            ];
        
            return $statistics;
        }
    
}