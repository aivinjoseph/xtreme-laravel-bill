<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Car extends Model
{
    use HasFactory;
    use HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    
    protected $guarded = [];
    protected $casts = [
        'images' => 'array',
        'features' => 'array',
    ];
    protected $appends = ['can_book'];

    const AVAILABILITY = [
        'available' => 'available',
        'sold' => 'sold',
        'upcoming' => 'upcoming',
    ];

    public function scopeSearch($query, $params)
    {
        $query->when($params['price'] ?? null, function($query, $price) {
            $query->where('price', '>=', $price[0])
                ->where('price', '<=', $price[1]);
        });

        $query->when($params['mileage'] ?? null, function($query, $mileage) {
            $query->where('mileage', '>=', $mileage[0])
                ->where('mileage', '<=', $mileage[1]);
        });

        $query->when($params['year'] ?? null, function($query, $year) {
            $query->where('year', '>=', $year[0])
                ->where('year', '<=', $year[1]);
        });

        $query->when($params['make'] ?? null, function($query, $make) {
            $query->where('make', $make);
        });

        $query->when($params['model'] ?? null, function($query, $model) {
            $query->where('model', $model);
        });

        $query->when($params['ext_color'] ?? null, function($query, $color) {
            $query->where('ext_color', $color);
        });

        $query->when($params['int_color'] ?? null, function($query, $color) {
            $query->where('int_color', $color);
        });

        $query->when($params['trim'] ?? null, function($query, $trim) {
            $query->where('trim', $trim);
        });

        $query->when($params['drive'] ?? null, function($query, $drive) {
            $query->where('drive', $drive);
        });

        $query->when($params['fuel'] ?? null, function($query, $fuel) {
            $query->where('fuel', $fuel);
        });

        $query->when($params['body_type'] ?? null, function($query, $bodyType) {
            $query->where('body_type', $bodyType);
        });

        $query->when($params['door'] ?? null, function($query, $door) {
            $query->where('door', $door);
        });

        $query->when($params['condition'] ?? null, function($query, $condition) {
            $query->where('technical_condition', $condition);
        });

        $query->when($params['availability'] ?? null, function($query, $availability) {
            $query->where('availability', $availability);
        });

        $query->when($params['featured'] ?? null, function($query) {
            $query->featured();
        });
    }

    public function scopeFeatured($query)
    {
        $query->where('featured', true);
    }

    public function scopeAvailable($query)
    {
        $query->where('availability', self::AVAILABILITY['available']);
    }

    public function scopeSold($query)
    {
        $query->where('availability', self::AVAILABILITY['sold']);
    }

    public function scopeUpcoming($query)
    {
        $query->where('availability', self::AVAILABILITY['upcoming']);
    }

    public function toggleFeatured()
    {
        $this->update(['featured' => !$this->featured]);        
    }

    public function getCanBookAttribute()
    {
        return $this->availability == self::AVAILABILITY['available'];
    }
}
