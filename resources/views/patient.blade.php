<!DOCTYPE html>
<html>
@include('includes/header')

<body>
<div class="container-fluid h-100  text-white">
    <div class="row h-100">
        <!-- Menu -->
        @include('includes/sideBar')
        <!-- Main page -->
        <div class="col-md-11 h-100 text-center ">
            <!-- Bandeau outils -->

            <nav class="  row h-11 navbar navbar-expand-lg navbar-light green">
                <div class="d-flex px-md-5 container-fluid green">
                    <span class="material-symbols-outlined text-start d-block d-md-none"
                          onclick="manageClass('menu','d-none')">menu</span>
                    <span class="h1"> Fiche Patient </span>
                    <form>
                        <input type="hidden" name="action" value="deconnexion">
                        <input type="submit" class="btn btn-danger" value="Deconnexion">
                    </form>
                </div>
            </nav>
            <div class="blue row">
                <div class="d-flex justify-content-between">
                    <span></span>
                    <h1><?php echo $patient->nom . " " . $patient->prenom ?></h1>
                    <div>
                        <?php
                        if ($patient->sexe) {
                            echo "<span class='material-symbols-outlined display-3 font-40' >
										man
									</span>";
                        } else {
                            echo "<span class='material-symbols-outlined display-3 font-40'>
										woman
									</span>";
                        }
                        ?>

                    </div>
                </div>
            </div>
            <!-- Bandeau Patient -->
            <div class="container-fluid h-100 overflow-scroll overflow-md-none">
                <div class="col-12 d-flex flex-column flex-md-row px-1 px-md-5 justify-content-between text-dark">
                    <div class="d-flex flex-column col-12 col-xl-5 text-start">

                        <div class="h2"> Informations</div>
                        <div class="border-top border-dark pt-3	">

                            <div class="d-flex flex-row justify-content-between">
                                <div> Adresse :</div>
                                <div> <?php echo $patient->adresse ?></div>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <div>n°Telephone :</div><?php echo "0" . $patient->numTel ?>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <div>email :</div><?php echo $patient->email ?>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <div>Medecin Traitant :
                                </div><?php echo $patient->medecinTraitant != 0 ? $patient->medecinTraitant : "Non définie"; ?>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <div>Numéro de sécurité sociale :</div><?php echo $patient->numSecu ?>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <div>Date de naissance :</div><?php echo $patient->dateNaissance ?>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <div>Lieu de naissance :</div><?php echo $patient->LieuNaissance ?>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <div>CodePostal :</div><?php echo $patient->codePostal ?>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex flex-column col-xl-3 text-start">
                        <div class="h2">Notes</div>
                        <div class="d-flex align-items-start border border-dark ratio ratio-21x9">
                            <?php echo $patient->notes ?>
                        </div>

                    </div>
                </div>
                <!-- content -->

                <div class="col-md-12 h-50 justify-content-center">
                    <div class="text-dark text-start h2">Liste des visites</div>
                    <div class="table-responsive h-75 mb-2 w-100">
                        <table class="table table-striped lightGreen border-top border-dark">
                            <thead class="sticky-top bg-white text-dark">
                            <tr>
                                <th>Motif</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                            </thead>
                            @foreach($visits as $visite)
                                <tr>
                                    <td>{{$visite->motifVisite}} </td>
                                    <td> {{$visite->dateVisite}} </td>
                                    <td> {{$visite->Description}}</td>

                                    <td>
                                        <div class="dropdown">
										    <span class="material-symbols-outlined" type="button" id="dropdownMenuButton1"
                                              data-bs-auto-close="false" data-bs-toggle="dropdown"
                                              aria-expanded="false">
											more_horiz
										    </span>
                                            <div class="p-0 text-end dropdown-menu dropdown-menu-end green text-white no-border" aria-labelledby="dropdownMenuButton1">
                                                <form action="{{route('visit.show',$visite)}}" method="POST">
                                                    <input class="btn text-white text-decoration-underline text-end" type="submit" value="Afficher">
                                                </form>
                                                <form action="{{route('visit.destroy',$visite)}}" method="POST" onclick="add(this,'Visite : {{$visite->motifVisite}} de {{$patient->nom}}  {{$patient->prenom}}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#exampleModal" data-bs-toggle="modal" class="btn text-white text-decoration-underline text-end" >Supprimer</a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <div class="h-25">
                    <div class="d-flex flex-row justify-content-center justify-content-md-end">
                        <div class="d-flex me-2 py-2 px-3 border-1 green">
                            <form method="get" action="{{route('visit.create',$patient)}}">

                                @csrf
                                <input type="submit" class="green no-border text-white" value="Ajouter une visite">
                            </form>
                        </div>
                        <div class="d-flex me-2 py-2 px-3 border-1 green">
                            <form method="get" action="{{route('patient.edit',$patient)}}">
                                @csrf
                                <input type="submit" class="green no-border text-white" value="Modifier le patient">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes/popup')
<script type="text/javascript" src="{{asset('t.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>
