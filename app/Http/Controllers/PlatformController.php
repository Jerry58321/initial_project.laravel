<?php

namespace App\Http\Controllers;

use App\Exceptions\PlatformDatabaseExistException;
use App\Http\Requests\CreatePlatformRequest;
use App\Http\Requests\PlatformApiKeyRequest;
use App\Http\Requests\PlatformMaintainRequest;
use App\Http\Requests\UpdatePlatformRequest;
use App\Jobs\SlackReport;
use App\Services\PlatformService;
use App\Models\PlatformDatabase;
use App\RedisIronMan\RedisIronMan;
use Illuminate\Support\Facades\Redis;

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
                    'name'           => $request->input('name'),
                    'database'       => $request->input('db_name'),
                    'redis_database' => $request->input('redis_database'),
                    'status'         => $request->input('status'),
                    'note'           => $request->input('note')
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
                'name'           => $request->input('name'),
                'database'       => $databaseName,
                'redis_database' => $request->input('redis_databse'),
                'status'         => $request->input('status'),
                'note'           => $request->input('note')
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
            $result = ['message_fail' => trans('message.event_failed', ['event' => trans('platform.kick_member_all')])];
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
            $result = ['message_success' => trans('message.event_success', ['event' => trans('platform.toggle_maintain.' . $status)])];
        } catch (\Exception $e) {
            $result = ['message_fail' => trans('message.event_failed', ['event' => trans('platform.toggle_maintain.' . $status)])];
            dispatch(new SlackReport('Error', 'toggleMaintainPlatform', $e->getMessage()));
        }

        return redirect()->back()->with($result);
    }

    public function toggleApiKey(PlatformApiKeyRequest $request)
    {
        $status = $request->input('status');
        try {
            $redisDatabase = PlatformDatabase::where('status', 'enable')->pluck('redis_database')->toArray();
            $redisDatabase[] = env('REDIS_DB');

            (new RedisIronMan())->setDatabase($redisDatabase)->doAction(function () use ($status) {
                if ($status == 'enable') {
                    Redis::del('whitelist_api_key');
                    Redis::lpush('whitelist_api_key', env('DDFG_ADMIN_API_KEY'));
                } else {
                    Redis::del('whitelist_api_key');
                }
            });

            RedisIronMan::resetDatabase();
            $result = ['message_success' => trans('message.event_success', ['event' => trans('platform.toggle_api_key.' . $status)])];
        } catch (\Exception $e) {
            $result = ['message_fail' => trans('message.event_failed', ['event' => trans('platform.toggle_api_key.' . $status)])];
        }

        return redirect()->back()->with($result);
    }
}