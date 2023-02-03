<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\settings;
use App\Models\Visite;
use Illuminate\Http\Request;

class PostVisit extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Patient $patient)
    {
        $visit = new Visite;
        $pageSettings = settings::getDefaultConfigMedecin('Edition Patient');
        return view('editVisite',['pageInfos' => $pageSettings->getSettings(),
                                       'patient' => $patient,
                                       'visit' => $visit]);
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
            $newVisit = new Visite;
            $newVisit->fill($request->all());
            $newVisit->save();
            return to_route('visit.show',$newVisit);
        } catch (PDOException $e) {
        }
        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function show(Visite $visit)
    {
        $drugs = $visit->drugs();
        $patient = $visit->patient;
        $pageSettings = settings::getDefaultConfigMedecin('Fiche Visite');
        return view('visite',[
            'drugsVisite' => $drugs,
            'patient' => $patient,
            'visit' => $visit,
            'pageInfos' => $pageSettings->getSettings()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function edit(Visite $visit)
    {
        $pageSettings = settings::getDefaultConfigMedecin('Edition Patient');
        return view('editVisite',['pageInfos' => $pageSettings->getSettings(),
            'visit' => $visit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visite $visit)
    {
        try {
            $visit->fill($request->all());
            $visit->save();
            return to_route('visit.show',$visit);
        } catch (PDOException $e) {
        }
        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visite $visit)
    {
        dd($visit);
        $patient = $visit->patient;
        $visit->drugs()->delete();
        $visit->delete();
        return to_route('patient.show',$patient);
    }
}
