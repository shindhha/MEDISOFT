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
    private $popUpSettings;
    public static function getDefaultConfigMedecin($name)
    {
        $pageSettings = new settings();
        $pageSettings->setTitle($name);
        $pageSettings->addIconToSideBar('/listMedic','medication');
        $pageSettings->addIconToSideBar('/patients','groups');
        return $pageSettings;
    }
    public static function getDefaultConfigAdministrateur($name)
    {
        $pageSettings = new settings();
        $pageSettings->setTitle($name);
        $pageSettings->addIconToSideBar('/cabinet','article');
        $pageSettings->addIconToSideBar('/listMedecin','groups');
        $pageSettings->addIconToSideBar('/erreursimport','settings');
        return $pageSettings;
    }
    function __construct()
    {

        $this->mainSettings = [
            'title' => '',
        ];
        $this->sideBarSettings = array(['pageLinked' => '' , 'icone' => '']);
        $this->navBarSettings = array();
        $this->popUpSettings = array();
    }

    public function getSettings()
    {
        $settings = $this->mainSettings;
        $settings['sideBarContents'] = $this->sideBarSettings;
        $settings['navBarContents'] = $this->navBarSettings;
        $settings['popUpSettings'] = $this->popUpSettings;
        return $settings;
    }

    public function popUpTarget($name) {
        $this->popUpSettings['variable'] = $name;
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
    public function setRoute($route)
    {
        $this->popUpSettings['route'] = $route;
    }
    public function addVariable($variableName)
    {
        $this->popUpSettings['variables'][] = ['name' => $variableName];
    }
    public function addText($text)
    {
        $this->popUpSettings['texts'][] = ['text' => $text];
    }
}
