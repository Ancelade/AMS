<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StatusGroup
 *
 * @property int $id
 * @property string $name
 * @property int $status_page_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatusGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusGroup whereStatusPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatusGroup extends Model
{
    use HasFactory;

    protected $table = 'status_group';
}
