<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Contact extends Model
{
    // Mass assignable attributes
    protected $fillable = [
        'first_name',
        'last_name_1',
        'last_name_2',
        'image',
        'mobile',
        'landline',
        'email',
        'city',
        'province',
        'country',
        'notes',
        'user_id'
    ];

    // Relationship: a contact belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Boot method to hook model events
    protected static function booted()
    {
        // Delete the contact's image file when the contact is deleted
        static::deleting(function ($contact) {
            if ($contact->image && Storage::disk('public')->exists($contact->image)) {
                Storage::disk('public')->delete($contact->image);
            }
        });
    }

    // Format value: capitalizes appropriately, but keeps certain words in lowercase
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

    // Mutator: format first name before saving
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = $this->formatValue($value);
    }

    // Mutator: format first last name before saving
    public function setLastName1Attribute($value)
    {
        $this->attributes['last_name_1'] = $this->formatValue($value);
    }

    // Mutator: format second last name before saving
    public function setLastName2Attribute($value)
    {
        $this->attributes['last_name_2'] = $this->formatValue($value);
    }

    // Mutator: format city name before saving
    public function setCityAttribute($value)
    {
        $this->attributes['city'] = $this->formatValue($value);
    }

    // Mutator: normalize and format country name before saving
    public function setCountryAttribute($value)
    {
        $value = mb_strtolower($value, 'UTF-8');

        if ($value === 'españa') {
            $this->attributes['country'] = 'España';
        } elseif ($value === 'spain') {
            $this->attributes['country'] = 'Spain';
        } else {
            $this->attributes['country'] = ucfirst($value);
        }
    }

    // Mutator: capitalize the first letter of the notes
    public function setNotesAttribute($value)
    {
        if (!empty($value)) {
            $value = ucfirst(mb_strtolower($value[0])) . substr($value, 1);
        }

        $this->attributes['notes'] = $value;
    }
}
