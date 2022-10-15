<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Find or create permission by its name (and optionally guardName).
     *
     * @param string $name
     * @param string|null $guardName
     *
     * @return \Spatie\Permission\Contracts\Permission
     */
    public function findOrCreate(string $name): Position
    {
        $exists = $this->where('name', $name)->first();

        if (empty($exists)) {
            return $this->create(['name' => $name]);
        }

        return $exists;
    }

    /**
     * Get the candidates for the position.
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    /**
     * Get the users for the position.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
