<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
	use HasFactory;

	// Define that book can have many reviews
	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	/**`
	 * Local Query Scopes
	 */
	public function scopeTitle(Builder $query, string $title)
	{
		return $query->where('title', 'LIKE', "%{$title}%");
	}

	public function scopePopular(Builder $query, $from = null, $to = null): Builder
	{
		return $query
			->withCount([
				'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
			])
			->orderBy('reviews_count', 'desc');
	}

	public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
	{
		return $query
			->withCount([
				'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
			])
			->withAvg([
				'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
			], 'rating')
			->orderBy('reviews_avg_rating', 'desc');
	}

	public function scopeMinReviews(Builder $query, int $minReviews)
	{
		return $query->having('reviews_count', '>=', $minReviews);
	}

	// can be access in this class
	private function dateRangeFilter(Builder $query, $from = null, $to = null)
	{
		if ($from && !$to) {
			$query->where('created_at', '>=', $from);
		} else if (!$from && $to) {
			$query->where('created_at', '<=', $to);
		} else if ($from && $to) {
			$query->whereBetween('created_at', [$from, $to]);
		}
	}
}
