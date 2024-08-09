<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Monitor
 *
 * @property int $id
 * @property string|null $name
 * @property string $host
 * @property int|null $port
 * @property int $timeout
 * @property int $interval
 * @property int $retry
 * @property string|null $keyword
 * @property string $type
 * @property int $n_down
 * @property int $n_up
 * @property int $n_down_total
 * @property int $n_up_total
 * @property int $status
 * @property int $last_latency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $device_id
 * @property string $username
 * @property string $password
 * @property string $community
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereCommunity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereLastLatency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereNDown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereNDownTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereNUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereNUpTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereRetry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereTimeout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUsername($value)
 * @mixin \Eloquent
 */
class Monitor extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @param int $tick
     * @param int $interval
     * @return array[]
     */
    public function getTick( int $tick = 12, int $interval = 3600 * 24) : array
    {
        return Cache::remember(md5($tick . $interval . $this->id), intval($interval / 1.1), function () use ($tick, $interval) {


            $now = time() - ($tick * $interval);

            $data = Alert::query()->where('monitor_id', $this->id)->where('created_at', '<=', Carbon::createFromTimestamp($now))->latest()->first();
            if ($data) {
                $originaleState = $data->state;
                if ($originaleState === "WARN") {
                    $originaleState = "UP";
                }
            } else {
                $originaleState = "UP";
            }

            $currentTick = 0;
            $result = [];
            while ($currentTick != $tick) {
                $start = (time() - ($tick * $interval)) + ($interval * $currentTick);
                $end = (time() - ($tick * $interval)) + ($interval * ($currentTick + 1));
                if ($originaleState === "WARN") {
                    $originaleState = "UP";
                }
                $data = Alert::query()->where('monitor_id', $this->id)->where('created_at', '<=', Carbon::createFromTimestamp($end))->where('created_at', '>=', Carbon::createFromTimestamp($start))->get();


                if ($data->count() === 0) {
                    $result[] = ['state' => $originaleState, 'time' => $start];
                    $currentTick++;
                    continue;
                } elseif ($data->count() === 1) {
                    $tickFind = false;
                    foreach ($data as $d) {
                        if ($d->state != "WARN") {
                            $result[] = ['state' => $d->state, 'time' => $start, 'count' => $data->count()];
                            $originaleState = $d->state;
                            $tickFind = true;
                            break;
                        }
                    }
                    if (!$tickFind) {
                        $result[] = ['state' => $originaleState, 'time' => $start, 'count' => $data->count()];
                    }


                    $currentTick++;
                    continue;
                } elseif ($data->count() > 1) {
                    $originaleState = "WARN";
                    $result[] = ['state' => 'WARN', 'time' => $start, 'count' => $data->count()];
                    $currentTick++;
                    continue;
                }


                $currentTick++;

            }

            return $result;
        });
    }


}
