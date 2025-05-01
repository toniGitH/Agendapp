<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'username',
        'password',
        'profile_img',
        'is_admin'
    ];

    // Attributes hidden from serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes to native types
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    // Relationship: define one-to-many relationship with contacts
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    // Boot method to hook model events
    protected static function booted()
    {
        // Delete the user's profile image file when the user is deleted
        static::deleting(function ($user) {
            if ($user->profile_img && Storage::disk('public')->exists($user->profile_img)) {
                Storage::disk('public')->delete($user->profile_img);
            }
        });
    }

    // Format the value with title casing except for certain small words
    private function formatValue($value)
    {
        $lowercaseWords = ['el', 'la', 'los', 'las', 'de', 'y', 'del', 'al', 'a', 'con', 'en', 'por', 'para', 'sobre'];

        $value = mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');

        foreach ($lowercaseWords as $word) {
            $value = preg_replace_callback('/\b' . preg_quote(ucfirst($word), '/') . '\b/', function ($matches) use ($word) {
                return $word;
            }, $value);
        }

        return $value;
    }

    // Mutator: format and set the user's name
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = $this->formatValue($value);
    }

    // Mutator: set the username in lowercase
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = mb_strtolower($value, 'UTF-8');
    }

    // Override delete method to prevent deletion if user has assigned contacts
    public function delete()
    {
        if ($this->contacts()->exists()) {
            throw new Exception("The user cannot be deleted because they have assigned contacts.");
        }

        return parent::delete();
    }
}
