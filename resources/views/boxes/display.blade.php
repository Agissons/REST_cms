<?php
/**
 * @file display.blade.php
 * @brief file description
 * @author Created by Blooooo
 * @version 19.09.2023
 */
$title = "Gestion";
$prod = 0.0 ;
foreach ($worms as $worm)
{
    $prod += $worm->weight;
}

?>
@extends('layout')



@section('content')

    <div class="container ">
        <div class="row">
            <div class="col-4">
                <div>
                    <p>Set Name : {{$sets->name}}</p>
                </div>
                <div class="p-3 " style=" border-style: outset; border-radius: 6px">
                    <div class="row ">
                        <div class="col-6 text-end">
                            <div class="">
                                <p>Guano</p>
                            </div>
                            <div class="">
                                <p>Weight :</p>
                            </div>


                        </div>
                        <div class="col-6 text-start">
                            <div >
                                <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"> add</button>
                            </div>
                            <div class="">
                                <p>{{((float)$sets->weight)/1000}} kg</p>
                            </div>


                        </div>
                    </div>

                </div>


            </div>
            <div class="col-4">
                <div class="p-3 " style=" border-style: outset; border-radius: 6px">
                    <div class="row ">
                        <div class="col-6 text-end">
                            <div class="" >
                                <p>Worms</p>
                            </div>
                            <div class="">
                                <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"> list</button>
                            </div>
                            <div class="">
                                <p>Weight :</p>
                            </div>


                        </div>
                        <div class="col-6 text-start">
                            <div >
                                <p> </p>
                            </div>
                            <div >
                                <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"> add</button>
                            </div>
                            <div class="">
                                <p>{{((float)$prod)/1000}} kg</p>
                            </div>


                        </div>
                    </div>

                </div>

            </div>
            <div class=" col-4 ">
                <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"> User Gestion</button>
                <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"> nourrish</button>
                <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"> New Session</button>
            </div>

        </div>
        <div class="row ">
            @if($boxes->isEmpty())
                <div class="text-center m-3">
                    <p>il n'y aucune boite dans cet ensemble
                    </p>


                </div>
            @else
                @foreach($boxes as $boxe)
                    <div class="col-4 " >
                        <div class="p-3 " style=" border-style: outset; border-radius: 6px">
                            <div class="row ">
                                <div class="col-6 text-end">
                                    <div class="" >
                                        <p>name :</p>
                                    </div>
                                    <div class="">
                                        <p>Type :</p>
                                    </div>
                                    <div class="">
                                        <p>Weight :</p>
                                    </div>
                                    <div class="">
                                        <p>Crée le :</p>
                                    </div>
                                    <div class="">
                                        <p>Faites par :</p>
                                    </div>

                                </div>
                                <div class="col-6 text-start">
                                    <div >
                                        <p>{{$boxe->name}}</p>
                                    </div>
                                    <div >
                                        <p>{{$boxe->type}}</p>
                                    </div>
                                    <div class="">
                                        <p>{{((float)$boxe->weight)/1000}} kg</p>
                                    </div>
                                    <div class="">
                                        <p>{{substr($boxe->created_at,0,10)}}</p>
                                    </div>
                                    <div class="">
                                        <p>{{$boxe->username}}</p>
                                    </div>

                                </div>
                            </div>

                        </div>



                    </div>
                @endforeach

            @endif


        </div>





    </div>


@endsection