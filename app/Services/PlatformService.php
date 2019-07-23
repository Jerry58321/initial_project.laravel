<?php

namespace App\Services;

use App\Models\PlatformDatabase;
use App\Utils\Generator;
use Carbon\Carbon;
use GuzzleHttp\Client;

class PlatformService
{
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([15]);
    }

    public function checkDatabaseExist($databaseId, $databaseName)
    {
        $where = [
            ['id', '!=', $databaseId],
            'database' => $databaseName
        ];

        return PlatformDatabase::where($where)->exists();
    }

    /**
     * 加密 key 值
     *
     * @param array $dataArray
     * @return string
     */
    protected function encryptKey(array $dataArray = []): string
    {
        $parameters = http_build_query($dataArray);
        $key = Generator::getSpecifiedRand(5) . md5($parameters . config('app.ddfg_key')) . Generator::getSpecifiedRand(5);

        return $key;
    }


    /**
     * 剔除指定平台所有會員
     *
     * @param $platform
     * @throws \Exception
     */
    public function kickPlatformMemberAll($platform)
    {
        $data['key'] = $this->encryptKey();

        $response = $this->httpClient->get(config('app.ddfg_url') . $platform . '/KickMemberAll.php', [
            'query' => $data
        ]);

        $response = json_decode($response->getBody());

        if ($response->ErrorCode == 0) {
            return;
        } else {
            throw new \Exception();
        }
    }

    public function toggleMaintainPlatform($platform, $status)
    {
        $timestamps = Carbon::now()->getTimestamp();

        $data = [
            'state' => $status,
            'time'  => $timestamps
        ];

        $data['key'] = $this->encryptKey($data);
        $data['msg'] = 'GameMaintaining';
        $response = $this->httpClient->get(config('app.ddfg_url') . $platform .'/GameMaintain.php', [
            'query' => $data
        ]);

        if (json_decode($response->getBody())->ErrorCode == 0) {
            return;
        } else {
            throw new \Exception();
        }
    }
}