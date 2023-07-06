<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function scopeSumByCategory(Builder $query)
    {
        return $query
            ->leftJoin('expenses', 'expenses.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name', 'expenses.user_id')
            ->having('expenses.user_id', Auth::id())
            ->selectRaw('categories.id, categories.name, sum(expenses.price) as sum');
    }
}
