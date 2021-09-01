<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Content::create(['content_types_id' => '1', 'title' => 'WE WORK AND WE MAKE', 'subtitle' => 'DESIGNS ROCK STARS', 'description' => 'We create amazing solutins for our clients, contact us to learn how we can help.', 'image' => 'Test', 'position' => 'Test']);
        Content::create(['content_types_id' => '1', 'title' => 'Test', 'subtitle' => 'Test', 'description' => 'Test', 'image' => 'Test', 'position' => 'Test']);
        Content::create(['content_types_id' => '2', 'title' => 'About', 'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Nulla consequat massa quis enim.', 'image' => 'assetsfrontend/img/demos/digital-agency/slides/slide-digital-agency-1.jpg']);

        Content::create(['content_types_id' => '3', 'title' => 'Test', 'description' => 'Test', 'image' => 'Test']);
        Content::create(['content_types_id' => '4', 'title' => 'Test', 'description' => 'Test', 'image' => 'Test']);

        Content::create(['content_types_id' => '5', 'title' => 'Strategy', 'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam posuere porta. Quisque ut nulla at nunc <a href="#">vehicula</a> lacinia. Proin adipiscing porta tellus, ut feugiat nibh adipiscing sit amet. In eu justo a felis faucibus ornare vel id metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>', 'url' => '#', 'class' => 'strategyId']);
        Content::create(['content_types_id' => '5', 'title' => 'Marketing', 'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam posuere porta. Quisque ut nulla at nunc <a href="#">vehicula</a> lacinia. Proin adipiscing porta tellus, ut feugiat nibh adipiscing sit amet. In eu justo a felis faucibus ornare vel id metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>', 'url' => '#', 'class' => 'marketingId']);
        Content::create(['content_types_id' => '6', 'title' => 'Who We Are', 'subtitle' => 'Lorem ipsum dolor sit amet consectetur adipiscing', 'description' => '<p class="opacity-8 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enikklam iconsectetur adipiscing elit.</p><p class="opacity-8 mb-3">Phasellus blandit massa enim. Nullam id varius elit. blandit massa enim varius blandit massa enimariusi d varius elit.</p>', 'url' => '/about']);

        Content::create(['content_types_id' => '7', 'title' => 'icon-screen-tablet icons', 'icon' => 'Mobile Apps']);
        Content::create(['content_types_id' => '7', 'title' => 'icon-layers icons', 'icon' => 'Creative Websites']);
        Content::create(['content_types_id' => '8', 'title' => 'Testimonials', 'subtitle' => 'Lorem ipsum dolor sit amet consectetur adipiscing']);

        Content::create(['content_types_id' => '9', 'title' => 'Jhon Doe', 'subtitle' => 'Okler', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas molestie.']);
        Content::create(['content_types_id' => '9', 'title' => 'Jessica Doe', 'subtitle' => 'Okler', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas molestie.']);
        Content::create(['content_types_id' => '10', 'title' => 'Happy Clients', 'subtitle' => '3000', 'description' => 'They can’t be wrong', 'icon' => 'icon-user ']);
        Content::create(['content_types_id' => '10', 'title' => 'Premade HomePages', 'subtitle' => '4444', 'description' => 'Many more to come', 'icon' => 'icon-screen-desktop']);

        Content::create(['content_types_id' => '11', 'image' => 'assetsfrontend/img/logos/logo-15.png']);
        Content::create(['content_types_id' => '11', 'image' => 'assetsfrontend/img/logos/logo-14.png']);
        Content::create(['content_types_id' => '11', 'image' => 'assetsfrontend/img/logos/layout-styles.png']);
        Content::create(['content_types_id' => '11', 'image' => 'assetsfrontend/img/logos/device.png']);
        Content::create(['content_types_id' => '12', 'title' => 'Vision', 'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Nulla consequat massa quis enim.']);

        Content::create(['content_types_id' => '13', 'title' => 'Mission', 'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Nulla consequat massa quis enim.']);
        Content::create(['content_types_id' => '14', 'image' => 'Test']);
        Content::create(['content_types_id' => '14', 'image' => 'Test']);

        Content::create(['content_types_id' => '15', 'title' => 'David Doe, CEO', 'description' => 'Pellentesque pellentesque eget tempor tellus. Fusce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada.']);
        Content::create(['content_types_id' => '15', 'title' => 'Alfian, Programmer', 'description' => 'Pellentesque pellentesque eget tempor tellus. Fusce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada.']);
        Content::create(['content_types_id' => '16', 'title' => 'Years In Business', 'subtitle' => '200', 'icon' => 'icon-badge']);
        Content::create(['content_types_id' => '16', 'title' => 'Highscore', 'subtitle' => '3000', 'icon' => 'icon-graph']);

        Content::create(['content_types_id' => '17', 'title' => 'Leadership', 'subtitle' => 'Pellentesque pellentesque eget tempor tellus.']);
        Content::create(['content_types_id' => '18', 'title' => 'David Doe', 'subtitle' => 'Ceo', 'image' => 'assetsfrontend/img/logos/apple-touch-icon.png']);
        Content::create(['content_types_id' => '18', 'title' => 'Jeff Doe', 'subtitle' => 'Coo', 'image' => 'assetsfrontend/img/logos/apple-touch-icon.png']);

        Content::create(['content_types_id' => '19', 'title' => 'Clients', 'subtitle' => 'Pellentesque pellentesque eget tempor tellus.']);
        Content::create(['content_types_id' => '20', 'image' => 'assetsfrontend/img/logos/apple-touch-icon.png']);
        Content::create(['content_types_id' => '20', 'image' => 'assetsfrontend/img/logos/apple-touch-icon.png']);

        Content::create(['content_types_id' => '21', 'title' => 'Service']);
        Content::create(['content_types_id' => '22', 'title' => 'We Can Help You With:', 'subtitle' => 'Pellentesque pellentesque eget tempor tellus.']);

        Content::create(['content_types_id' => '23', 'title' => 'Strategy', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing metus elit. Quisque rutrum pellentesque imperdiet.', 'icon' => 'icon-bulb']);
        Content::create(['content_types_id' => '23', 'title' => 'Development', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing metus elit. Quisque rutrum pellentesque imperdiet.', 'icon' => 'icon-puzzle']);
        Content::create(['content_types_id' => '24', 'title' => '1. Brief', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing metus elit. Quisque rutrum pellentesque imperdiet.', 'icon' => 'icon-directions']);
        Content::create(['content_types_id' => '24', 'title' => '2. Creation', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing metus elit. Quisque rutrum pellentesque imperdiet.', 'icon' => 'icon-puzzle']);
        Content::create(['content_types_id' => '24', 'title' => '3. Launch', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing metus elit. Quisque rutrum pellentesque imperdiet.', 'icon' => 'icon-rocket']);

        Content::create(['content_types_id' => '25', 'title' => 'Innovation', 'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur imperdiet hendrerit volutpat. Sed in nunc nec ligula consectetur mollis in vel justo. Vestibulum ante ipsum primis in faucibus orci.', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur imperdiet hendrerit volutpat. Sed in nunc nec ligula consectetur mollis in vel justo. Vestibulum ante ipsum primis in faucibus orci.', 'image' => 'assetsfrontend/img/demos/digital-agency/laptop.png', 'url' => 'Test']);
        Content::create(['content_types_id' => '26', 'image' => 'Test']);
        Content::create(['content_types_id' => '26', 'image' => 'Test']);

        Content::create(['content_types_id' => '27', 'image' => 'Test']);
        Content::create(['content_types_id' => '27', 'image' => 'Test']);
        Content::create(['content_types_id' => '28', 'image' => 'Test']);
        Content::create(['content_types_id' => '28', 'image' => 'Test']);

        Content::create(['content_types_id' => '29', 'image' => 'Test']);
        Content::create(['content_types_id' => '29', 'image' => 'Test']);
        Content::create(['content_types_id' => '30', 'title' => 'Say Hello', 'subtitle' => 'Lorem Ipsum Dorol Sit Amet']);

        Content::create(['content_types_id' => '31', 'title' => 'Send us Message', 'subtitle' => 'Lorem Ipsum']);
    }
}
