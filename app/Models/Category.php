<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Class Category
 * @property string $title
 * @property string $body
 * @package App\Models
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     title="Category",
 *     required={"name", "description"},
 *     properties={
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string")
 *     },
 * )
 */
class Category extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'description'
    ];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, "permission_category");
    }
}
