<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RethinkDBService;

class TaskController extends Controller
{
    protected $rethinkDBService;

    public function __construct(RethinkDBService $rethinkDBService)
    {
        $this->rethinkDBService = $rethinkDBService;
    }

    public function getTasks()
    {
        $tasks = $this->rethinkDBService->getTasks();

        return response()->json($tasks);
    }
}
