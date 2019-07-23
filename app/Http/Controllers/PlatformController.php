<?php

namespace App\Http\Controllers;

use App\Exceptions\PlatformDatabaseExistException;
use App\Http\Requests\CreatePlatformRequest;
use App\Http\Requests\PlatformMaintainRequest;
use App\Http\Requests\UpdatePlatformRequest;
use App\Jobs\SlackReport;
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
        $platformDatabase = PlatformDatabase::all();
        return view('platforms.database.index', compact(
            'platformDatabase'
        ));
    }

    public function create()
    {
        return view('platforms.database.create');
    }

    public function store(CreatePlatformRequest $request)
    {
        try {
            $platformDatabase = PlatformDatabase::firstOrCreate([
                'database' => $request->input('db_name'),
            ],
                [
                    'name'       => $request->input('name'),
                    'database'   => $request->input('db_name'),
                    'redis_code' => $request->input('redis_code'),
                    'status'     => $request->input('status'),
                    'note'       => $request->input('note')
                ]);

            if (!$platformDatabase->wasRecentlyCreated) {
                throw new PlatformDatabaseExistException();
            }

            $result = ['message_success' => trans('message.create_success')];
        } catch (PlatformDatabaseExistException $e) {
            $result = ['message_fail' => trans('message.create_event_existed', ['event' => 'database'])];
        } catch (\Exception $e) {
            $result = ['message_fail' => trans('message.create_failed')];
        }

        return redirect()->route('database.index')
            ->with($result);
    }

    public function edit(PlatformDatabase $database)
    {
        return view('platforms.database.edit', compact(
            'database'
        ));
    }

    public function update(PlatformDatabase $database, UpdatePlatformRequest $request)
    {
        try {
            $databaseName = $request->input('db_name');

            if($this->platformService->checkDatabaseExist($database->id, $databaseName)) {
                throw new PlatformDatabaseExistException();
            }
            $database->update([
                'name'       => $request->input('name'),
                'database'   => $databaseName,
                'redis_code' => $request->input('redis_code'),
                'status'     => $request->input('status'),
                'note'       => $request->input('note')
            ]);
            $result = ['message_success' => trans('message.update_success')];
        } catch (PlatformDatabaseExistException $e) {
            $result = ['message_fail' => trans('message.update_event_existed', ['event' => 'database'])];
        } catch (\Exception $e) {
            $result = ['message_fail' => trans('message.update_failed')];
        }

        return redirect()->route('database.index')
            ->with($result);

    }

    public function destroy(PlatformDatabase $database)
    {
        try {
            $database->delete();

            $result = ['message_success' => trans('message.delete_success')];
        } catch (\Exception $e) {
            $result = ['message_fail' => trans('message.delete_failed')];
        }

        return redirect()->route('database.index')
            ->with($result);
    }

    public function setting()
    {

        return view('platforms.setting');
    }

    public function kickMemberAll()
    {
        try {
            foreach (explode(',', env('DDFG_PLATFORM_GAME')) as $platform) {
                $this->platformService->kickPlatformMemberAll($platform);
            }
            $result = ['message_success' => trans('message.event_success', ['event' => trans('platform.kick_member_all')])];
        } catch (\Exception $e) {
            $result = ['message_success' => trans('message.event_failed', ['event' => trans('platform.kick_member_all')])];
            dispatch(new SlackReport('Error', 'kickMemberAll', $e->getMessage()));
        }

        return redirect()->back()->with($result);
    }

    public function toggleMaintain(PlatformMaintainRequest $request)
    {
        $status = $request->input('status');

        try {
            foreach(explode(',', env('DDFG_PLATFORM_GAME')) as $platform) {
                $this->platformService->toggleMaintainPlatform($platform, $status);
            }
            $result = ['message_success' => trans('message.event_success', ['event' => trans('platform.maintain_type.' . $status)])];
        } catch (\Exception $e) {
            $result = ['message_success' => trans('message.event_failed', ['event' => trans('platform.maintain_type.' . $status)])];
            dispatch(new SlackReport('Error', 'toggleMaintainPlatform', $e->getMessage()));
        }

        return redirect()->back()->with($result);
    }
}