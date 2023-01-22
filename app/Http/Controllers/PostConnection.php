<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersServices;
use App\Http\Controllers\PostAdministrateur;
use App\Models\settings;
class PostConnection extends Controller
{
    private $usersServices;
    function __construct()
    {
        $this->usersServices = UsersServices::getDefaultUsersService();
    }
    public function index(Request $request) {

        $nbUsers = $this->usersServices->findIfUserExists($request->login,$request->password);

        if ($nbUsers) {
            if ($request->login == "admin") {
                return redirect()->action([PostAdministrateur::class, 'index']);
            } else {
                return view('listPatient');
            }
        }

        $pageSettings = new settings();
        $pageSettings->setTitle('Connexion');

        return view('connection',['pageInfos' => $pageSettings->getSettings()]);
    }

    
}
