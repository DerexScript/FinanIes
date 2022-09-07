<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Class Product
 * @property string $title
 * @property string $body
 * @package App\Models
 * @OA\Schema(
 *     schema="Role",
 *     type="object",
 *     title="Role",
 *     required={"role_id", "user_id"},
 *     properties={
 *         @OA\Property(property="role_id", type="int"),
 *         @OA\Property(property="user_id", type="int")
 *     },
 * )
 */
class Role extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;



    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ["name", "view", "edit", "delete"];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
