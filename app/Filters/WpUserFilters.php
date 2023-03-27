<?php

namespace App\Filters;

class WpUserFilters
{
    protected $filters = [
        'id' => IdFilter::class,
        'userName' => UserNameFilter::class,
        'firstName' => FirstNameFilter::class,
        'lastName' => LastNameFilter::class,
        'email' => EmailFilter::class,
        'created_at' => CreatedAtFilter::class,
        'updated_at' => UpdatedAtFilter::class,
        'paginate' => PaginateFilter::class
    ];

    protected $sort_order= [
        "sort" => ["id", "userName", "firstName", "lastName", "email", "created_at", "updated_at"],
        "order"=> ["asc", "desc"]
    ];
    
    /**
     * apply
     *
     * @param  mixed $query
     * @return mixed
     */
    public function apply(mixed $query): mixed
    {
        $querySorts= $this->receivedSorts();
        $queryFilters= $this->receivedFilters();

        if(sizeof($querySorts)==2){
            $validatedParams= $this->validateParams($querySorts);

            $sortParams= $validatedParams[0];
            $orderParams= $validatedParams[1];
            
            $sortOrder= new SortFilter();

            if($sortParams && $orderParams && sizeof($orderParams)==sizeof($sortParams)){
                $query= $sortOrder($query, $sortParams, $orderParams);            
            }else{
                return false;
            }
        }

        foreach ($queryFilters as $name => $value) {
            $filterInstance = new $this->filters[$name];
            $query = $filterInstance($query, $value);
        }
        
        return $query;
    }
    
    /**
     * receivedFilters
     *
     * @return array
     */
    public function receivedFilters():array
    {
        return request()->only(array_keys($this->filters));
    }
    
    /**
     * receivedSorts
     *
     * @return array
     */
    public function receivedSorts():array
    {
        return request()->only(array_keys($this->sort_order));
    }
    
    /**
     * validateParams
     *
     * @param  array $params
     * @return array
     */
    public function validateParams(array $params): array
    {
        $sortParams= explode(',', $params["sort"]);
        $orderParams= explode(',', $params["order"]);
        
        foreach($sortParams as $key=>$item){
            if(!in_array($item, $this->sort_order["sort"])){
                unset($sortParams[$key]);
            }
        }

        foreach($orderParams as $key=>$item){
            if(!in_array($item, $this->sort_order["order"])){
                unset($orderParams[$key]);
            }
        }

        return [$sortParams, $orderParams];
    }
}