<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Class Release
 * @property string $title
 * @property string $body
 * @package App\Models
 * @OA\Schema(
 *     schema="Release",
 *     type="object",
 *     title="Release",
 *     required={"description", "value", "date", "vouncher", "type"},
 *     properties={
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="value", type="string"),
 *         @OA\Property(property="date", type="string"),
 *         @OA\Property(property="vouncher", type="string"),
 *         @OA\Property(property="type", type="boolean"),
 *         @OA\Property(property="company_id", type="integer", nullable=true),
 *         @OA\Property(property="category_id", type="integer", nullable=true),
 *     },
 * )
 */
class Release extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['description', 'value', 'date', 'voucher', 'type', 'category_id', 'release_group_id'];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function releaseGroup()
    {
        return $this->belongsTo(ReleaseGroup::class, 'id', 'release_group_id');
    }
}
