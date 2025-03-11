<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\HeaderMenu;

class AddForumPageToFrontendPage extends Migration
{

    public function up()
    {
        $check_forum = FrontPage::where('slug', '/forum')->first();
        if (!$check_forum) {
            DB::table('front_pages')->insert([
                'name' => 'Forum',
                'title' => 'Forum',
                'sub_title' => 'Forum',
                'details' => 'Forum Page',
                'slug' => '/forum',
                'status' => 1,
                'is_static' => 1,
            ]);
        }

        $forum = FrontPage::where('slug', '/forum')->first();
        $header_menu = HeaderMenu::where('link', '/forum')->first();
        if ($forum && $header_menu == null) {
            $menu = new HeaderMenu();
            $menu->type = "Static Page";
            $menu->element_id = $forum->id;
            $menu->title = $forum->title;
            $menu->link = $forum->slug;
            $menu->position = 8;
            $menu->save();

        }
    }


    public function down()
    {
        //
    }
}
