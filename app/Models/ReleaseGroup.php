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
 * Class ReleaseGroup
 * @property string $title
 * @property string $body
 * @package App\Models
 * @OA\Schema(
 *     schema="ReleaseGroup",
 *     type="object",
 *     title="ReleaseGroup",
 *     required={"name", "description", "status"},
 *     properties={
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="status", type="boolean"),
 *         @OA\Property(property="company_id", type="integer", nullable=true),
 *         @OA\Property(property="release_id", type="integer", nullable=true),
 *     },
 * )
 */
class ReleaseGroup extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'description', 'status', 'company_id', 'expiration'];

    protected $table = 'releases_groups';

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function company(){
        return $this->hasOne(Company::class);
    }

    public function releases(){
        return $this->hasMany(Release::class);
    }
}
