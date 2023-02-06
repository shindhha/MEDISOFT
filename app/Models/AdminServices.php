<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDOException;
class AdminServices extends Model
{
    use HasFactory;
    private static $defaultAdminServices;

    public static function getDefaultAdminServices()
    {
        if (AdminServices::$defaultAdminServices == null) {
            AdminServices::$defaultAdminServices = new AdminServices();
        }
        return AdminServices::$defaultAdminServices;
    }

    public function updateOrCreateCabinet($adresse,$codePostal,$ville)
    {
        $cabinet = DB::table('cabinet')
                            ->where('id',1)
                            ->update(['adresse' => $adresse,
                                      'codePostal' => $codePostal,
                                      'ville' => $ville]);
    }
    public function getInformationCabinet() {
        return DB::table("cabinet")->where('id',1)->first();
    }
    public function getErreursImportShort() {

        return DB::table('ErreursImportation')
            ->select(DB::raw('count(messageErreur) as nbreErreurs,messageErreur'))
            ->groupBy('messageErreur')
            ->orderByDesc('nbreErreurs');
    }
}
