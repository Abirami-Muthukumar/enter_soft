<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddPermissionForForum extends Migration
{

    public function up()
    {
        $routes = [
            ['name' => 'Forum', 'route' => 'forum', 'type' => 1, 'parent_route' => null, 'module' => 'Forum', 'theme' => 'wetech'],


            ['name' => 'Topic management', 'route' => 'forum.topic', 'type' => 2, 'parent_route' => 'forum', 'module' => 'Forum', 'theme' => 'wetech'],
            ['name' => 'Approval', 'route' => 'forum.topic.approval', 'type' => 3, 'parent_route' => 'forum.topic', 'module' => 'Forum', 'theme' => 'wetech'],
            ['name' => 'Lock', 'route' => 'forum.topic.lock', 'type' => 3, 'parent_route' => 'forum.topic', 'module' => 'Forum', 'theme' => 'wetech'],
            ['name' => 'Pin', 'route' => 'forum.topic.pin', 'type' => 3, 'parent_route' => 'forum.topic', 'module' => 'Forum', 'theme' => 'wetech'],
            ['name' => 'Edit', 'route' => 'forum.topic.edit', 'type' => 3, 'parent_route' => 'forum.topic', 'module' => 'Forum', 'theme' => 'wetech'],
            ['name' => 'Delete', 'route' => 'forum.topic.delete', 'type' => 3, 'parent_route' => 'forum.topic', 'module' => 'Forum', 'theme' => 'wetech'],

            ['name' => 'Deleted topic/thread', 'route' => 'forum.deleted_topic', 'type' => 2, 'parent_route' => 'forum', 'module' => 'Forum', 'theme' => 'wetech'],
            ['name' => 'Restore', 'route' => 'forum.deleted_topic.restore', 'type' => 3, 'parent_route' => 'forum.deleted_topic', 'module' => 'Forum', 'theme' => 'wetech'],
            ['name' => 'View', 'route' => 'forum.deleted_topic.View', 'type' => 3, 'parent_route' => 'forum.deleted_topic', 'module' => 'Forum', 'theme' => 'wetech'],
            ['name' => 'Delete', 'route' => 'forum.deleted_topic.delete', 'type' => 3, 'parent_route' => 'forum.deleted_topic', 'module' => 'Forum', 'theme' => 'wetech'],


            ['name' => 'Forum setup', 'route' => 'forum.setting', 'type' => 2, 'parent_route' => 'forum', 'module' => 'Forum', 'theme' => 'wetech'],


        ];

        if (function_exists('permissionUpdateOrCreate')) {
            permissionUpdateOrCreate($routes);
        }
    }

    public function down()
    {
        //
    }
}
