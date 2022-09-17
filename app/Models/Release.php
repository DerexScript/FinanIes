<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 *     required={"description", "value", "date", "vouncher", "status"},
 *     properties={
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="value", type="string"),
 *         @OA\Property(property="date", type="date"),
 *         @OA\Property(property="vouncher", type="binary"),
 *         @OA\Property(property="status", type="boolean"),
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
    protected $fillable = [
        'description', 'value', 'date', 'vouncher', 'status'
    ];
}
