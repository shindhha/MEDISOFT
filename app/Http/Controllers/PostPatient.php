<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Patient;
use App\Models\settings;
use App\Models\User;
use App\Models\UsersServices;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PostPatient extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersServices $usersservices)
    {


        $pageSettings = settings::getDefaultConfigMedecin('Liste Patients');
        $pageSettings->setRoute('patient.destroy');
        $pageSettings->popUpTarget('patient');
        $pageSettings->addText('Etes vous sur de vouloir supprimer le patient ?');
        $pageSettings->addText('Toutes ses visites seront perdue .');
        $patients = $usersservices->getListPatients('%',"%","%");
        $patients = Patient::all();
        $medecin = $usersservices->getMedecins();
        return view('listPatient',['medecins' => $medecin, 'patients' => $patients, 'pageInfos' => $pageSettings->getSettings()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $newPatient = new Patient;
        $medecins = Medecin::all();
        $pageSettings = settings::getDefaultConfigMedecin('Fiche Patient');
        return
            view('editPatient',['patient' => $newPatient,
            'medecins' => $medecins ,
            'pageInfos' => $pageSettings->getSettings()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $newPatient = new Patient;
            $newPatient->fill($request->all());
            $newPatient->save();
            return to_route('patient.show',$newPatient);

        } catch (\PDOException $e) {
        }
        return redirect()->back()->withInput()->withErrors("Bonjour");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        $visit = $patient->visites;

        $pageSettings = settings::getDefaultConfigMedecin('Fiche Patient');
        $pageSettings->setRoute('visit.destroy');
        $pageSettings->popUpTarget('$visite');
        $pageSettings->addText('Etes vous sur de vouloir supprimer la visite ?');
        $pageSettings->addText('Touts ses médicaments seront perdue .');
        return view('patient',['visits' => $visit, 'patient' => $patient,'pageInfos' => $pageSettings->getSettings()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $medecins = Medecin::all();
        $pageSettings = settings::getDefaultConfigMedecin('Fiche Patient');
        return view('editPatient',['patient' => $patient,
            'medecins' => $medecins ,
            'pageInfos' => $pageSettings->getSettings()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        try {
            $patient->fill($request->all());
            $patient->save();
            return to_route('patient.show',$patient);
        } catch (QueryException $e) {
        }
        return redirect()->back()->withInput();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->medicines()->delete();
        $patient->visites()->delete();
        $patient->delete();

        return to_route('patient.index');
    }
}
