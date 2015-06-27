<?php namespace Yun;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeviceWx extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'yun_device_wxuser';
    protected $fillable = ['open_id', 'device_id'];
    public $timestamps = false;

}
