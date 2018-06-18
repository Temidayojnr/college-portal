<?php

namespace App\Filters;

use App\User;
use App\Models\School;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SchoolFilters extends BaseFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }
}