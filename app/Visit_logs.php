<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Visit_logs extends Model
{
    use Notifiable;
    protected $table='visitlogs';

    protected $fillable = ['id', 'ip', 'browser', 'os', 'user_id', 'user_name', 'country_code', 'country_name', 'region_name', 'city', 'zip_code', 'time_zone', 'latitude', 'longitude', 'geoname_id', 'capital', 'country_flag', 'connection_asn', 'connection_isp', 'languages', 'view_count', 'viewstatus', 'is_banned', 'is_deleted', 'created_at', 'updated_at'];
}
