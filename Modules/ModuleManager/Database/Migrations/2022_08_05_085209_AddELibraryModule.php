<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\ModuleManager\Entities\Module;
use Illuminate\Database\Migrations\Migration;

class AddELibraryModule extends Migration
{
    public function up()
    {
        $totalCount = DB::table('modules')->count();
        $newModule = new Module();
        $newModule->name = 'ELibrary';
        $newModule->details = 'ELibrary Module For acsLMS. ';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }

    public function down()
    {
        //
    }
}
