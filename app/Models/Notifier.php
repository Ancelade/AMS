<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Notifier
 *
 * @property int $id
 * @property string $type
 * @property string $webhook
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereWebhook($value)
 * @mixin \Eloquent
 */
class Notifier extends Model
{
    use HasFactory;
}
