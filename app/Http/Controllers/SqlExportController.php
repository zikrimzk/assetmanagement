<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SqlExportController extends Controller
{
    public function downloadSql()
    {
        if (Auth::user()->staff_role == 1 || Auth::user()->staff_role == 5) {
            $response = new StreamedResponse(function () {
                $handle = fopen('php://output', 'w');

                // Get the list of tables
                $tables = DB::select('SHOW TABLES');
                foreach ($tables as $table) {
                    $tableName = $table->{'Tables_in_' . env('DB_DATABASE')};

                    // Get CREATE TABLE statement
                    $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
                    fwrite($handle, $createTable[0]->{'Create Table'} . ";\n\n");

                    // Get INSERT statements
                    $rows = DB::table($tableName)->get();
                    foreach ($rows as $row) {
                        $columns = array_keys((array)$row);
                        $values = array_values((array)$row);
                        $values = array_map(function ($value) {
                            return is_null($value) ? 'NULL' : '"' . addslashes($value) . '"';
                        }, $values);
                        $columnsList = implode('`, `', $columns);
                        $valuesList = implode(', ', $values);
                        $insertSql = "INSERT INTO `$tableName` (`$columnsList`) VALUES ($valuesList);\n";
                        fwrite($handle, $insertSql);
                    }
                    fwrite($handle, "\n");
                }

                fclose($handle);
            });

            $response->headers->set('Content-Type', 'application/sql');
            $response->headers->set('Content-Disposition', 'attachment; filename="assettrack_backup.sql"');

            return $response;
        } else {
            return redirect()->route('user-index');
        }
    }
}
