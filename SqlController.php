<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function raw_order_by(string $column)
    {
        User::query()->orderByRaw($column)->get();

        User::orderByRaw($column)->get();
    }

    public function raw_where(string $where)
    {
        User::query()->whereRaw($where)->get();

        User::where($where)->get();
    }

    public function raw_query(string $sql)
    {
        DB::select($sql);

        DB::statement($sql);
    }

    public function sql_without_prepare(string $value)
    {
        $sql = sprintf('select * from users where id = %s', $value);

        $pdo = DB::getPdo();

        $pdo->query($sql)->fetchAll();
    }

    public function sql_with_table_name(string $value)
    {
        $sql = sprintf('select * from %s where id > 0', $value);

        $pdo = DB::getPdo();

        $sth = $pdo->prepare($sql);

        $sth->execute();

        $sth->fetchAll();
    }
}
