<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Class Company
 * @property string $title
 * @property string $body
 * @package App\Models
 * @OA\Schema(
 *     schema="Company",
 *     type="object",
 *     title="Company",
 *     required={"name", "description"},
 *     properties={
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string")
 *     },
 * )
 */
class Company extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'description', 'image_name'
    ];

    public function groupEntries()
    {
        return $this->hasMany(ReleaseGroup::class);
    }
}
