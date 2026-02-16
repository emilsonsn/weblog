<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'is_highlighted',
        'is_published',
        'read_count',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (is_null($post->created_by)) {
                $post->created_by = auth()->user()->id;
            }
        });

        static::deleting(function ($post) {
            $post->comments()->delete();
            $post->tags()->detach();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? locale();

        return $this->translations->where('locale', $locale)->first()
            ?? $this->translations->where('locale', 'pt')->first();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeHighlighted($query)
    {
        return $query->where('is_highlighted', 1);
    }

    public function scopeDrafted($query)
    {
        return $query->where('is_published', 0);
    }

    public function getPublishedAttribute()
    {
        return ($this->is_published) ? 'Yes' : 'No';
    }

    public function scopeAllPosts($query, $request)
    {
        $locale = locale();

        return $query->latest()
            ->when($request->search, function ($query) use ($request, $locale) {
                $search = $request->search;

                return $query->whereHas('translations', function ($q) use ($search, $locale) {
                    $q->where('locale', $locale)
                    ->where(function ($qq) use ($search) {
                        $qq->where('title', 'like', "%$search%")
                            ->orWhere('body', 'like', "%$search%");
                    });
                });
            })
            ->where('is_highlighted', 0)
            ->with(['tags', 'category', 'user', 'translations'])
            ->withCount('comments')
            ->published();
    }

    public function scopeHighlightedPosts($query)
    {
        return $query->highlighted()->with('category', 'user', 'translations');
    }

    public function incrementReadCount()
    {
        $this->read_count++;

        return $this->save();
    }

    public function getDashboardPosts()
    {
        if (auth()->user()->hasRole('Admin')) {
            return self::query();
        } else {
            return self::where('created_by', auth()->id());
        }
    }
}
