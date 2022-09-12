<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Class Permission
 * @property string $title
 * @property string $body
 * @package App\Models
 * @OA\Schema(
 *     schema="Permission",
 *     type="object",
 *     title="Permission",
 *     required={"name", "description", "view", "edit", "delete"},
 *     properties={
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="view", type="tinyint"),
 *         @OA\Property(property="edit", type="tinyint"),
 *         @OA\Property(property="delete", type="tinyint")
 *     },
 * )
 */
class Permission extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;



    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ["name", "description", "view", "edit", "delete"];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'permission_companie');
    }
    public function releases()
    {
        return $this->belongsToMany(Release::class, 'permission_release');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'permission_category');
    }
}
