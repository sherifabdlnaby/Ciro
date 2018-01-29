<?php
namespace App\Controllers\Web;

use App\Core\WebController;

/*
 * Class Name should match this pattern {Controller Name}Controller
 */

class HomeController extends WebController {
    public function Index(){
        return $this->render();
    }

    public function About(){
        //Set title of About page.
        $this->meta['title'] = 'About · Ciro';
        return $this->render();
    }
}