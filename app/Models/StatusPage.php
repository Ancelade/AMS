<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StatusPage
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatusPage extends Model
{
    use HasFactory;

    protected $table = 'status_page';
}
