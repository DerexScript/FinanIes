<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Class Resource
 * @property string $title
 * @property string $body
 * @package App\Models
 * @OA\Schema(
 *     schema="Resource",
 *     type="object",
 *     title="Resource",
 *     required={"name", "resource"},
 *     properties={
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="resource", type="string")
 *     },
 * )
 */
class Resource extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;



    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ["name", "resource"];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
