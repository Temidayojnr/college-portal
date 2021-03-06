<?php

namespace App\Repositories;

use App\User;
use App\Models\Course;
use App\Filters\CourseFilters;
use Carbon\Carbon;

class CourseRepository
{
    public function model()
    {
        return app(Course::class);
    }

    public function courses(User $user, CourseFilters $filters) {
        $items = $user->courses()->filter($filters)->paginate();
        $items->transform(function ($item) use ($filters) {
            return $filters->transform($item);
        });
        return $items;
    }

    public function course($id, CourseFilters $filters = null) {
        $q = $this->model();
        if ($filters) {
            $q = $q->filter($filters);
        }
        return $filters ? $filters->transform($q->findOrFail($id)) : $q->findOrFail($id);
    }

    public function delete($id) {
        return $this->model()->where('id', $id)->delete();
    }

    public function create($opts) {
        return $this->model()->create($opts);
    }

    public function update($id, $opts = []) {
        $this->model()->where('id', $id)->update($opts);
        return $this->course($id);
    }

    public function count(CourseFilters $filters)
    {
        return $this->model()->filter($filters)->select('id', DB::raw('count(*) as total'))->count();
    }
}