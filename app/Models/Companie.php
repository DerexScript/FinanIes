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
 *     schema="Companie",
 *     type="object",
 *     title="Companie",
 *     required={"name", "title"},
 *     properties={
 *         @OA\Property(property="role_id", type="string"),
 *         @OA\Property(property="user_id", type="string")
 *     },
 * )
 */
class Companie extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'title'
    ];
}
