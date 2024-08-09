<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Devices
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Devices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Devices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Devices query()
 * @method static \Illuminate\Database\Eloquent\Builder|Devices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devices whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devices whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Devices extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'devices';

    /**
     * @return Monitor|null
     */
    public function getMasterMonitor() : mixed
    {
        return Monitor::where("device_id", $this->id)->where('type', 'ICMP')->first();
    }
}
