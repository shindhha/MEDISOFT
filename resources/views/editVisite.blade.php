<!DOCTYPE html>
<html>
@include('includes/header')

<body onload="resizeMenu()">
<div class="container-fluid h-100  text-white">
    <div class="row h-100">
        <!-- Menu -->
        @include('includes/sideBar')
        <!-- Main page -->
        <div class="col-md-11 h-75 text-center">
            <!-- Bandeau outils -->

            <nav class="  row h-15 navbar navbar-expand-lg navbar-light green">
                <div class="d-flex justify-content-center justify-content-md-start px-5 container-fluid green">
                    <span class="material-symbols-outlined  d-block d-md-none col-1" onclick="manageClass('menu','d-none')">menu</span>
                    <span class="h1 "> Visite n°</span>
                    <form>
                        <input type="hidden" name="action" value="deconnexion">
                        <input type="submit" class="btn btn-danger" value="Deconnexion">
                    </form>
                </div>
            </nav>
            <div class="container-fluid d-flex justify-content-center">
                @if(isset($visit->id))

                    <form method="post" action="{{route('visit.update',$visit)}}" class=" d-flex flex-column col-12 col-md-9">
                        @method('PUT')
                @else
                    <form method="post" action="{{route('visit.store')}}" class=" d-flex flex-column col-12 col-md-9">
                        <input type="hidden" name="patient_id" value="{{$patient->id}}">
                @endif
                    @csrf
                        <input type="hidden" name="doctor_id" value="11111111111">

                    <div class="flex-row  text-dark  justify-content-center mb-3">
                        <div class="d-flex flex-column gap-5">
                            <div class="d-flex flex-row justify-content-between ">
                                <div class="d-flex flex-row align-items-center">
                                    <span>Motif: </span> <input class="form-control" type="text" name="motifVisite" value="{{old('motifVisite',$visit->motifVisite)}}">
                                </div>

                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row align-items-center">
                                        <span>Date: </span><input class="form-control" type="date" name="DateVisite" max="<?php echo date('Y-m-d'); ?>" value="{{old('DateVisite',$visit->DateVisite)}}">
                                    </div>

                                </div>
                            </div>
                            <div class="d-flex flex-column text-start">
                                <span>Description</span>
                                <textarea class="form-control" rows="5" name="Description">{{ old('Description',$visit->Description)}}</textarea>
                            </div>
                            <div class="d-flex flex-column text-start	">
                                <span>Conclusion</span>
                                <textarea class="form-control" rows="5" name="Conclusion">{{old('Conclusion',$visit->Conclusion)}}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- content -->
                    <div class="row h-100 align-items-center text-center">
                        <!-- Portail de connexion -->
                        <div class="container ">
                            <div class="row justify-content-center">
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="d-flex me-2 py-2 px-3 border-1 bg-danger">
                                        <input type="submit" class="bg-danger no-border text-white" value="Annuler" onclick="goTo('goFicheVisite','patientslist')">
                                    </div>
                                    <div class="d-flex me-2 py-2 px-3 border-1 green">
                                        <input type="submit" class="green no-border text-white" value="Valider">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script type="text/javascript" src="scripts/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>
