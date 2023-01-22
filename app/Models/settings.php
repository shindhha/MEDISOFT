<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\arrayWrapper;
class settings extends Model
{
    use HasFactory;
    private $mainSettings;
    private $sideBarSettings;
    private $navBarSettings;
    function __construct()
    {

        $this->mainSettings = [
            'title' => '',
        ];
        $this->sideBarSettings = array(['pageLinked' => '' , 'icone' => '']);
        $this->navBarSettings = array();
    }

    public function getSettings()
    {
        $settings = $this->mainSettings;
        $settings['sideBarContents'] = $this->sideBarSettings;
        $settings['navBarContents'] = $this->navBarSettings;
        return $settings;
    }
    public function addIconToSideBar($link,$icone)
    {
        $this->sideBarSettings[] = ['pageLinked' => $link, 'icone' => $icone];
    }
    public function addIconToNavBar($link,$icone)
    {
        $this->navBarSettings[] = ['pageLinked' => $link, 'icone' => $icone];
    }
    public function setTitle($title)
    {
        $this->mainSettings['title'] = $title;
    }

}
