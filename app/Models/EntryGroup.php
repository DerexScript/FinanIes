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
 * Class EntryGroup
 * @property string $title
 * @property string $body
 * @package App\Models
 * @OA\Schema(
 *     schema="EntryGroup",
 *     type="object",
 *     title="EntryGroup",
 *     required={"name", "description", "status"},
 *     properties={
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="status", type="boolean"),
 *         @OA\Property(property="company_id", type="integer", nullable=true),
 *         @OA\Property(property="entry_id", type="integer", nullable=true),
 *     },
 * )
 */
class EntryGroup extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'description', 'status', 'entry_id', 'company_id'];

    protected $table = 'entries_group';

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function company(){
        return $this->hasOne(Company::class);
    }
}
