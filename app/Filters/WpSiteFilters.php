<?php

namespace App\Filters;

class WpSiteFilters
{
    protected $filters = [
        'id' => IdFilter::class,
        'name' => NameFilter::class,
        'domain' => DomainFilter::class,
        'pole' => PoleFilter::class,
        'type' => TypeFilter::class,
        'created_at' => CreatedAtFilter::class,
        'updated_at' => UpdatedAtFilter::class,
        'paginate' => PaginateFilter::class
    ];

    protected $sort_order= [
        "sort"=>["id", "name", "domain", "created_at", "updated_at"],
        "order"=>["asc", "desc"],
        "sort_relation"=> ["pole", "type"]
    ];
    
    /**
     * apply
     *
     * @param  mixed $query
     * @return mixed
     */
    public function apply(mixed $query):mixed
    { 
        $querySorts= $this->receivedSorts();

        if(!empty($querySorts)){    
            $validatedParams= $this->validateParams($querySorts);

            $sortParams= $validatedParams[0];
            $orderParams= $validatedParams[1];
            $sortRelationParams= $validatedParams[2];
            $orderRelationParams= $validatedParams[3];

            $sortOrder= new SortFilter();

            if($sortParams && $orderParams && sizeof($orderParams)==sizeof($sortParams)){
                $query= $sortOrder($query, $sortParams, $orderParams);            
            }  
            
            if($sortRelationParams){
                if(in_array("pole", $sortRelationParams)){
                    $key = array_search('pole', $sortRelationParams);
                    $order= $orderRelationParams[$key];
                    $sortRelation= new SortPole();
                    $query=  $sortRelation($query, $order);
                 }
                 if(in_array("type", $sortRelationParams)){
                     $key = array_search('type', $sortRelationParams);
                     $order= $orderRelationParams[$key];
                     $sortRelation= new SortType();
                     $query=  $sortRelation($query, $order);
                 }
             }
 
        }

        foreach ($this->receivedFilters() as $name => $value) {
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
    public function validateParams(array $params):array
    {
        $sortParams= explode(',', $params["sort"]);
        $orderParams= explode(',', $params["order"]);
        $sortRelationParams= $sortParams;
        $sortRelation= [];
        $orderRelationParams=[];

        foreach($orderParams as $key=>$item){
            if(!in_array($item, $this->sort_order["order"])){
                $orderParams[$key]= "asc";
            }
        }

        foreach($sortParams as $key=>$item){
            if(!in_array($item, $this->sort_order["sort"])){
                unset($sortParams[$key]);
            }
        }

        foreach($sortRelationParams as $key=>$item){
            if(in_array($item, $this->sort_order["sort_relation"])){
                $sortRelation[]= $sortRelationParams[$key];
                if(isset($orderParams[$key])){
                    $orderRelationParams[]= $orderParams[$key];
                }else{
                    $orderRelationParams[]= "asc";
                }
            }
        }

        return [$sortParams, $orderParams, $sortRelation, $orderRelationParams];
    }
}