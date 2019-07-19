<?php
/**
 * Created by PhpStorm.
 * User: liangyuehchen
 * Date: 2019/1/26
 * Time: 上午12:29
 */

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

use Carbon\Carbon;

use App\Models\User;

/**
 * Trait QueryTrait
 *
 * Query的集合
 * 1. 可以配合Criteria使用
 *
 * @package App\Traits
 */
trait QueryTrait
{
    /**
     * 檢測對象是否為查詢Builder
     *
     * @param $instance
     * @return bool
     */
    public static function isQueryBuilder($instance): bool
    {
        return $instance instanceof Builder || $instance instanceof QueryBuilder;
    }

    /**
     * 檢測對象是否為查詢庫
     *
     * @param $instance
     * @return bool
     */
    public static function isEloquent($instance): bool
    {
        return $instance instanceof Model || static::isQueryBuilder($instance);
    }

    /**
     * 取得資料表名稱
     *
     * @param $query
     * @return string
     * @throws \ReflectionException
     */
    protected function getTableName($query): string
    {
        if ($query instanceof Model) {
            return $query->getTable();
        } elseif ($query instanceof Builder) {
            return $query->getModel()->getTable();
        } elseif ($query instanceof QueryBuilder) {
            return $query->from;
        } else {
            throw new \ReflectionException('Must be Model or Builder');
        }
    }

    /**
     * 若傳進來是Model則產生Query
     *
     * @param $query
     * @return Builder
     * @throws \ReflectionException
     */
    protected function convertBuilder($query)
    {
        if ($query instanceof Model) {
            return $query->newQuery();
        } elseif ($query instanceof Builder || $query instanceof QueryBuilder) {
            return $query;
        } else {
            throw new \ReflectionException('Must be Model or Builder');
        }
    }

    /**
     * 擇user, 若傳入的是agent則使用階層機制
     * 目前預設是用 user_id 如果名稱不一樣請實作 $columns mapping
     *
     * @param $query
     * @param $user
     * @param $boolean
     * @return Builder
     * @throws \ReflectionException
     */
    private function selectUserUnder($query, $user, $boolean = 'and')
    {
        $query = $this->convertBuilder($query);
        $tableName = $this->getTableName($query);

        if ($user instanceof User) {
            $column = $this->getMappingColumn($tableName, "{$user->levelTitle}_id");
            $this->executeQuery($query, 'where', $boolean, $column, $user->id);
        } elseif ($user instanceof Collection || is_array($user)) {
            $userTitleGroup = collect($user)
                ->map(function ($u) {
                    return $u->getOwner();
                })
                ->groupBy(function ($u) use ($tableName) {
                    return $this->getMappingColumn($tableName, "{$u->levelTitle}_id");
                });

            $count = 0;
            foreach ($userTitleGroup as $title => $users) {
                if ($count++ > 0) $boolean = 'or';

                $this->executeQuery($query, 'whereIn', $boolean, $title, $users->pluck('id')->toArray());
            }
        }

        return $query;
    }

    /**
     * 擇user, 若傳入的是agent則使用階層機制
     * 目前預設是用 user_id 如果名稱不一樣請實作 $columns mapping
     *
     * @param $query
     * @param $user
     * @return Builder
     * @throws \ReflectionException
     */
    private function orSelectUserUnder($query, $user)
    {
        return $this->selectUserUnder($query, $user, 'or');
    }

    /**
     * 取得指定層次
     *
     * @param $query
     * @param $user
     * @param $specificClass
     * @param string $boolean
     * @return Builder
     * @throws \ReflectionException
     */
    private function selectSpecificUnder($query, $user, $specificClass, $boolean = 'and')
    {
        $query = $this->convertBuilder($query);
        $specificClass = $this->getMappingColumn($query, $specificClass);
        $value = $this->parseField($user, 'id');

        $this->executeQuery($query, is_array($value) ? 'whereIn' : 'where', $boolean, $specificClass, $value);

        return $query;
    }

    /**
     * 取得指定層次
     *
     * @param $query
     * @param $user
     * @param $SpecificClass
     * @return Builder
     * @throws \ReflectionException
     */
    private function orSelectSpecificUnder($query, $user, $SpecificClass)
    {
        return $this->selectSpecificUnder($query, $user, $SpecificClass, 'or');
    }

    /**
     * 選擇下面一個階級用戶
     *
     * @param $query
     * @param $user
     * @param $boolean
     * @return Builder
     * @throws \ReflectionException
     */
    private function selectFirstUnder($query, $user, $boolean = 'and')
    {
        $query = $this->convertBuilder($query);
        $column = $this->getMappingColumn($query, 'parent_id');

        if ($user instanceof User) {
            $this->executeQuery($query, 'where', $boolean, $column, $user->id);
        } elseif ($user instanceof Collection || is_array($user)) {
            $userParentGroup = collect($user)
                ->filter(function ($u) {
                    return $u->role !== 'user';
                })
                ->map(function ($u) {
                    return $u->getOwner()->id;
                });

            $this->executeQuery($query, 'whereIn', $boolean, $column, $userParentGroup->toArray());
        }

        return $query;
    }

    /**
     * 選擇下面一個階級用戶
     *
     * @param $query
     * @param $user
     * @return Builder
     * @throws \ReflectionException
     */
    private function orSelectFirstUnder($query, $user)
    {
        return $this->selectFirstUnder($query, $user);
    }

    /**
     * 擇user, 若傳入的是agent則使用階層機制
     * 目前預設是用 user_id 如果名稱不一樣請實作 $columns mapping
     *
     * @param $query
     * @param $user
     * @param $boolean
     * @return Builder
     * @throws \ReflectionException
     */
    private function selectUser($query, $user, $boolean = 'and')
    {
        $query = $this->convertBuilder($query);
        $tableName = $this->getTableName($query);
        $column = $tableName === 'user' ? 'id' : $this->getMappingColumn($tableName,'user_id');

        if ($user instanceof User) {
            $this->executeQuery($query, 'where', $boolean, $column, $user->id);
        } else {
            if ($user instanceof Collection || is_array($user)) {
                $userIds = collect($user)->map(function ($u){
                    return ($u instanceof User) ? $u->id : $u;
                })->toArray();

                $this->executeQuery($query, 'whereIn', $boolean, $column, $userIds);
            } else {
                $this->executeQuery($query, 'where', $boolean, $column, $user);
            }
        }

        return $query;
    }

    /**
     * 擇user, 若傳入的是agent則使用階層機制
     * 目前預設是用 user_id 如果名稱不一樣請實作 $columns mapping
     *
     * @param $query
     * @param $user
     * @return Builder
     * @throws \ReflectionException
     */
    private function orSelectUser($query, $user)
    {
        return $this->selectUser($query, $user, 'or');
    }

    /**
     * 選擇user_id or 會員下線
     *
     * @param $query
     * @param $user
     * @param $boolean
     * @return Builder
     * @throws \ReflectionException
     */
    private function selectUserOrUnder($query, $user, $boolean = 'and')
    {
        if (is_array($user)) {
            $user = collect($user);
        }

        $isUser = function ($target): bool {
            return ! ($target instanceof User) || $target->isUser;
        };

        if ($user instanceof Collection && $user->isNotEmpty()) {
            if ($isUser($user->first())) {
                $this->selectUser($query, $user, $boolean);
            } else {
                $this->selectUserUnder($query, $user, $boolean);
            }
        } elseif ($isUser($user)) {
            $this->selectUser($query, $user, $boolean);
        } else {
            $this->selectUserUnder($query, $user, $boolean);
        }

        return $query;
    }

    /**
     * 選擇user_id or 會員下線
     *
     * @param $query
     * @param $user
     * @return mixed
     * @throws \ReflectionException
     */
    private function orSelectUserOrUnder($query, $user)
    {
        $this->selectUserOrUnder($query, $user, 'or');

        return $query;
    }

    /**
     * 選擇時間Range
     *
     * @param $query
     * @param $beginAt
     * @param $endAt
     * @param string $timeColumn
     * @param $boolean
     * @return Builder
     * @throws \ReflectionException
     */
    private function selectTimeRange($query, $beginAt, $endAt, $timeColumn = 'created_at', $boolean = 'and')
    {
        $query = $this->convertBuilder($query);
        if (empty($beginAt)) {
            $beginAt = Carbon::today()->startOfDay()->toDateTimeString();
        }

        if (empty($endAt)) {
            $endAt = Carbon::today()->endOfDay()->toDateTimeString();
        }

        return $this->executeQuery($query, 'whereBetween', $boolean, $timeColumn, [$beginAt, $endAt]);
    }

    /**
     * 選擇時間Range
     *
     * @param $query
     * @param $beginAt
     * @param $endAt
     * @param string $timeColumn
     * @return Builder
     * @throws \ReflectionException
     */
    private function orSelectTimeRange($query, $beginAt, $endAt, $timeColumn = 'created_at')
    {
        return $this->selectTimeRange($query, $beginAt, $endAt, $timeColumn, 'or');
    }

    /**
     * 加入Partition條件
     * 目前預設是用 p_month 如果名稱不一樣請實作 $columns mapping
     *
     * @param $query
     * @param $beginAt
     * @param $endAt
     * @param $boolean
     * @return Builder
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function selectPartition($query, $beginAt, $endAt, $boolean = 'and')
    {
        $query = $this->convertBuilder($query);

        if (is_null($beginAt)) {
            // 正式上線日子
            $beginAt = Carbon::parse('2018-05-01 00:00:00')->firstOfMonth();
        } elseif (is_string($beginAt)) {
            $beginAt = Carbon::parse($beginAt)->firstOfMonth();
        }

        if (is_string($endAt) || is_null($endAt)) {
            $endAt = Carbon::parse($endAt)->endOfMonth();
        }

        // 取得Y-m-d 之間的月份差異
        $period = collect(new \DatePeriod(
            new \DateTime($beginAt->toDateString()),
            new \DateInterval('P1M'),
            new \DateTime($endAt->toDateString())
        ));

        if ($period->isEmpty()) {
            $period->push(new \DateTime($beginAt->toDateString()));
        }

        // ex. 2018-06-01 ~ 2018-08-31 => [1806, 1807, 1808]
        //     2018-07-01 ~ 2018-08-01 => [1807, 1808]
        //     2018-07-01 ~ 2018-07-31 => [1807]
        //     2018-07-01 ~ 2018-07-01 => [1807]
        $range = $period->map(function ($item, $key) {
            return (int)$item->format('ym');
        })->unique()->values();

        $column = $this->getMappingColumn($query, 'p_ym');

        $this->executeQuery($query, 'whereIn', $boolean, $column, $range->all());

        return $query;
    }

    /**
     * 加入Partition條件
     * 目前預設是用 p_month 如果名稱不一樣請實作 $columns mapping
     *
     * @param $query
     * @param $beginAt
     * @param $endAt
     * @return Builder
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function orSelectPartition($query, $beginAt, $endAt)
    {
        return $this->selectPartition($query, $beginAt, $endAt);
    }

    /**
     * 選擇時間區間
     *
     * @param $query
     * @param $interval
     * @param string $timeColumn
     * @param string $day
     * @param $boolean
     * @return Builder
     * @throws \ReflectionException
     */
    private function selectInterval($query, $interval, $timeColumn = 'created_at', $day = 'today', $boolean = 'and')
    {
        $query = $this->convertBuilder($query);

        switch ($interval) {
            case 'day':
                $beginAt = Carbon::parse($day)->startOfDay();
                $endAt = Carbon::parse($day)->endOfDay();
                break;
            case 'week':
                $beginAt = Carbon::parse($day)->startOfWeek();
                $endAt = Carbon::parse($day)->endOfWeek();
                break;
            case 'month':
                $beginAt = Carbon::parse($day)->startOfMonth();
                $endAt = Carbon::parse($day)->endOfMonth();
                break;
            case 'year':
                $beginAt = Carbon::parse($day)->startOfYear();
                $endAt = Carbon::parse($day)->endOfYear();
                break;
            default:
                break;
        }

        if (isset($beginAt) && isset($endAt)) {
            $this->executeQuery($query, 'whereBetween', $boolean, $timeColumn, [$beginAt, $endAt]);
        }

        return $query;
    }

    /**
     * 選擇時間區間
     *
     * @param $query
     * @param $interval
     * @param string $timeColumn
     * @param string $day
     * @return Builder
     * @throws \ReflectionException
     */
    private function orSelectInterval($query, $interval, $timeColumn = 'created_at', $day = 'today')
    {
        return $this->selectInterval($query, $interval, $timeColumn, $day, 'or');
    }

    /**
     * 選擇多個條件
     *
     * @param $query
     * @param array $where
     * @param $boolean
     * @return Builder
     * @throws \ReflectionException
     */
    private function selectConditions($query, array $where, $boolean = 'and')
    {
        $query = $this->convertBuilder($query);
        $operators = ['>', '>=', '=', '<', '<=', '!=', 'like'];
        $count = 0;
        foreach ($where as $field => $value) {
            if ($count++ > 0) $boolean = 'and';

            if (is_array($value) && count($value) == 3 && in_array($value[1], $operators)) {
                list($field, $condition, $val) = $value;
                $this->executeQuery($query, 'where', $boolean, $field, $condition, $val);
            } else if (is_array($value)) {
                $this->executeQuery($query, 'whereIn', $boolean, $field, $value);
            } else {
                $this->executeQuery($query, 'where', $boolean, $field, $value);
            }
        }

        return $query;
    }

    /**
     * 選擇多個條件
     *
     * @param $query
     * @param array $where
     * @return Builder
     * @throws \ReflectionException
     */
    private function orSelectConditions($query, array $where)
    {
        return $this->selectConditions($query, $where, 'or');
    }

    /**
     * 選擇階層
     *
     * @param $query
     * @param $user
     * @return mixed
     */
    private function selectClassColumn($query, $user)
    {
        $classColumn = $this->getUserClassColumn($query, $user);

        $this->executeQuery($query, 'addSelect', 'and', $classColumn);

        return $query;
    }

    /**
     * 群組階層
     *
     * @param $query
     * @param $user
     * @return mixed
     */
    private function groupByClassColumn($query, $user)
    {
        $classColumn = $this->getUserClassColumn($query, $user);

        $this->executeQuery($query, 'groupBy', 'and', $classColumn);

        return $this->selectClassColumn($query, $user);
    }

    private function getUserClassColumn($query, $user)
    {
        $user = ($user instanceof Collection || is_array($user)) ? collect($user) : $user;
        if ($user instanceof Collection) {
            $user = $user->first();
        }
        return $user->getClassColumn($this->getTableName($query) === 'user');
    }

    private function executeQuery($query, $method, $boolean, ...$value)
    {
        if (strtolower($boolean) === 'or') {
            return $query->{('or' . ucfirst($method))}(...$value);
        } else {
            return $query->{$method}(...$value);
        }
    }

    /**
     * 取得mapping後的column
     *
     * @param $table
     * @param $column
     * @return array|mixed
     * @throws \ReflectionException
     */
    protected function getMappingColumn($table, $column)
    {
        if (! is_string($table)) {
            $table = $this->getTableName($table);
        }

        if (isset($this->columnMapping[$table]) && is_array($this->columnMapping[$table])) {
            $columnMapping = $this->columnMapping[$table];
        } else {
            $columnMapping = $this->columnMapping ?? [];
        }

        if (is_array($column)) {
            foreach ($column as $key => $value) {
                if (isset($columnMapping[$value])) {
                    $column[$key] = $columnMapping[$value];
                }
            }
            return $column;
        }

        return $columnMapping[$column] ?? $column;
    }

    /**
     * 判斷是否有階層機制
     *
     * @param $query
     * @return bool
     * @throws \ReflectionException
     */
    protected function hasClassColumns($query)
    {
        $classColumns = collect(config('constants.AGENT_CLASS'))->slice(0, 4)->map(function ($class) {
            return $class . '_id';
        })->toArray();

        $tableName = $this->getTableName($query);
        return Schema::hasColumns($tableName, $this->getMappingColumn($tableName, $classColumns));
    }

    private function parseField($object, $field)
    {
        if ($object instanceof Collection || is_array($object)) {
            return collect($object)->map(function ($obj) use ($field) {
                return $this->parseValue($obj, $field);
            })->toArray();
        }
        return $this->parseValue($object, $field);
    }

    private function parseValue($object, $field)
    {
        if (is_object($object)) {
            return $object->{$field};
        } elseif (is_array($object)) {
            return $object[$field];
        }

        return $object;
    }
}