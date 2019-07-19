<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlatformRequest;
use App\Models\User;
use App\Services\PlatformService;
use App\Models\PlatformDatabase;

class PlatformController extends Controller
{
    private $platformService;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platformService = $platformService;
    }

    public function index()
    {
        $platform = PlatformDatabase::all();
        return view('platforms.database.index', compact(
            'platform'
        ));
    }

    public function create()
    {
        return view('platforms.database.create');
    }

    public function store(CreatePlatformRequest $request)
    {
        try {
            PlatformDatabase::create([
                'name'     => $request->input('name'),
                'database' => $request->input('db_name'),
                'status'   => $request->input('status'),
                'note'     => $request->input('note')
            ]);
            $result = ['message_success' => trans('message.create_success')];
        } catch (\Exception $e) {
            $result = ['message_fail' => trans('message.create_failed')];
        }

        return redirect()->route('database.index')
            ->with($result);
    }

    public function setting()
    {

    }
}