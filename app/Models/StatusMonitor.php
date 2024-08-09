<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StatusMonitor
 *
 * @property int $id
 * @property int $monitor_id
 * @property int $status_group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatusMonitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusMonitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusMonitor query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusMonitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusMonitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusMonitor whereMonitorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusMonitor whereStatusGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusMonitor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatusMonitor extends Model
{
    use HasFactory;

    protected $table = 'status_monitor';
}
