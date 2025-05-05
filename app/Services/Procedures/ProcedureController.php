<?php

namespace App\Services\Procedures;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProcedureController
{
    public function __construct() {}

    public static function index()
    {
        self::publish();
        $data = DB::table('procedure_data')->get();
        return view('procedures::index', compact('data'));
    }

    public static function create()
    {
        self::publish();
        return view('procedures::create');
    }

    public static function edit($id)
    {
        self::publish();
        $procedure = DB::table('procedure_data')->where('id', $id)->first();
        self::publish();
        return view('procedures::edit', compact('procedure'));
    }

    public static function store()
    {
        $request = request();

        try {
            if ($request->type == 'test') {

                $paramList = [];
                $properties = [];
                $newParams = is_array(request('new_key')) ? request('new_key') : [];
                foreach ($newParams as $key => $new_param) {
                    $paramList[] = "IN p_" . $new_param . " VARCHAR(50)";
                    $properties[] = $request->new_val[$key];
                }

                $params = implode(', ', $paramList);

                return self::testProcedure($params, $properties);

                
            } else {
                // dd($request->all());
                $id = DB::table('procedure_data')->max('id') + 1;
                DB::table('procedure_data')->insert([
                    'id' => $id,
                    'parameters' => json_encode(array_merge(array_values(request('parameter') ?? []), array_values(request('new_key') ?? []))),
                    'title' => Str::slug($request->title, '_'),
                    'leaver' => Str::slug($request->leaver, '_'),
                    'source' => $request->source,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return self::error($e);
        }
    }

    public static function update()
    {
        try {

            $request = request();
            $procedure = DB::table('procedure_data')->where('id', $request->id)->first();

            $paramList = [];
            $properties = [];

            // $currentParams = json_decode($procedure->parameters);
            $currentParams = request('parameter');
            // dd( $currentParams, $request->all());
            foreach ($currentParams as $k => $param) {
                // dd($k, $param, $request->all(), $currentParams);
                $paramList[] = "IN p_" . $request->name[$k] . " VARCHAR(50)";
                $properties[] = $param;
            }
            // dd($paramList, $properties);
            $newParams = is_array(request('new_key')) ? request('new_key') : [];
            // $newParams = array_filter($newParams);
            // $newParams = array_unique($newParams);
            foreach ($newParams as $key => $new_param) {
                $paramList[] = "IN p_" . $new_param . " VARCHAR(50)";
                $properties[] = $request->new_val[$key];
            }

            $params = implode(', ', $paramList);

            // dd($params, $properties);
            if ($request->type == 'test') {
                return self::testProcedure($params, $properties);

            } else {

                DB::table('procedure_data')->where('id', $request->id)->update([
                    'parameters' => json_encode(
                        array_merge(
                            array_filter(
                                array_unique(
                                    array_values(request('name') ?? []),
                                )
                            ),
                            array_filter(
                                array_unique(
                                    array_values(request('new_key') ?? []),
                                )
                            )
                        )
                    ),
                    'title' => Str::slug($request->title, '_'),
                    'leaver' => Str::slug($request->leaver, '_'),
                    'source' => $request->source,
                    'updated_at' => now(),
                ]);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return self::error($e);
        }
    }

    public static function testProcedure($params, $properties, $procedure=null)
    {
        $request = request();
        if(is_null($procedure)){
            $leaver = '';
            if (strlen($request->leaver)) {
                $leaver = Str::slug($request->leaver, '_') . ":";
            }
            $title = Str::slug($request->title, '_');
            $source =  $request->source;
        }else{
            $leaver = $procedure->leaver. ":";
            $title = $procedure->title;
            $source = $procedure->source;
        }
        
        $procedureSQL = <<<SQL
        DROP PROCEDURE IF EXISTS $title;
        
        CREATE PROCEDURE $title (
            $params
        )
        $leaver BEGIN
            $source
        END;
        SQL;

        DB::unprepared($procedureSQL);

        $q = implode(',', array_fill(0, count($properties), '?'));
        $result = DB::select("CALL `$title`($q)", $properties);
        
        $data = [
            'success' => true,
            'result' => $result,
        ];
        if(is_null($procedure)){
            return response()->json($data);
        }
        return $data;
    }

    public static function error($e): string
    {
        return $e->getMessage() . ' on line: ' . $e->getLine() . ' in file: ' . $e->getFile() . ' with code: ' . $e->getCode();
    }

    public static function publish(): void
    {
        /************* Create Tables if not found *************/
        if (!Schema::hasTable('procedure_data')) {
            DB::unprepared("
                CREATE TABLE procedure_data(
                id INT PRIMARY KEY, title VARCHAR(255), source TEXT,
                leaver varchar(255) DEFAULT NULL, parameters TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP   
                );
            ");
        }
        if (!Schema::hasTable('seq_0_to_365')) {
            DB::unprepared("
                CREATE TABLE seq_0_to_365 (seq INT PRIMARY KEY);
                INSERT INTO seq_0_to_365 (seq) 
                SELECT a.N + b.N * 10 + c.N * 100 AS seq
                FROM 
                    (SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) a,
                    (SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) b,
                    (SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3) c;
            ");
        }

        /********************** FOR Public Root { /public } ***************************/
        $destination = public_path('services' . DIRECTORY_SEPARATOR . 'procedures');
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }
        File::copy(base_path('app/Services/Procedures/views/assets/bootstrap.min.css'), $destination . '/bootstrap.min.css');
        File::copy(base_path('app/Services/Procedures/views/assets/bootstrap.min.js'), $destination . '/bootstrap.min.js');
        File::copy(base_path('app/Services/Procedures/views/assets/jquery.min.js'), $destination . '/jquery.min.js');
        File::copy(base_path('app/Services/Procedures/views/assets/clipboard.min.js'), $destination . '/clipboard.min.js');
        /************************* FOR Basic Root { / } ********************************/
        $destination2 = base_path('services' . DIRECTORY_SEPARATOR . 'database');
        if (!file_exists($destination2)) {
            mkdir($destination2, 0777, true);
        }
        File::copy(base_path('app/Services/Procedures/views/assets/bootstrap.min.css'), $destination2 . '/bootstrap.min.css');
        File::copy(base_path('app/Services/Procedures/views/assets/bootstrap.min.js'), $destination2 . '/bootstrap.min.js');
        File::copy(base_path('app/Services/Procedures/views/assets/jquery.min.js'), $destination2 . '/jquery.min.js');
        File::copy(base_path('app/Services/Procedures/views/assets/clipboard.min.js'), $destination2 . '/clipboard.min.js');
        /********************************************************************************/
        view()->addNamespace('procedures', base_path('app/Services/Procedures/views'));
    }
}
