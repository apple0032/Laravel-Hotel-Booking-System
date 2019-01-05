<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelRoomFacility extends Model
{

    protected $table = 'hotel_room_facility';

    public function room()
    {
        return $this->belongsTo('App\HotelRoom');
    }
    
    public function getTableColumns() {
        $fields = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());;
        
        $table_field = array();
        foreach ($fields as $field){
            if(($field != 'id') && ($field != 'hotel_room_id') && ($field != 'created_at') && ($field != 'updated_at') ){
                $table_field[] = $field;
            }
        }
        
        return $table_field;
    }

    public static function getFontAwesome() {

        //Return fontawesome i element class ORDERBY the fields in hotel_facility table.
        //Add new field may lead to a error because of not setting this element.

        $temp_fontawesome = array(
            "fa-wifi",
            "fa-coffee",
            "fa-wind",
            "fa-bath",
            "fa-tv",
            "fa-laptop",
            "fa-chair",
        );

        return $temp_fontawesome;
    }

}
