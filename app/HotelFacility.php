<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelFacility extends Model
{

    protected $table = 'hotel_facility';

    public function hotel()
    {
    	return $this->belongsTo('App\Hotel');
    }
    
    public function getTableColumns() {
        $fields = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());;
        
        $table_field = array();
        foreach ($fields as $field){
            if(($field != 'id') && ($field != 'hotel_id') && ($field != 'created_at') && ($field != 'updated_at') ){
                $table_field[] = $field;
            }
        }
        
        return $table_field;
    }
}
