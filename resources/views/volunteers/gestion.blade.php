<?php
/**
 * @file gestion.blade.php
 * @brief file description
 * @author Created by Blooooo
 * @version 18.09.2023
 */
$title = "Gestion";

?>
@extends('layout')

@section('content')


    <div class="container ">
        <div class="row">
            <div class="col-9">

            </div>
            <div class=" col-3 ">
                <button  href="#" type="button" class="btn btn-primary" data-toggle="modal" data-target="#Createvolunteer"> Nouveau Sympatisant</button>
            </div>

        </div>


        @if($volunteers->isEmpty())
            <div class="text-center">
                <p>Votre filtre ne contient personne.
                </p>
            </div>
        @else
            @foreach($volunteers as $volunteer)
                <div class="m-3 set " style=" border-style: outset; border-radius: 6px"  onclick="window.location.href = '/volunteer/{{$volunteer->id}}'" >
                    <div class="p-3">
                        <p>Nom : {{$volunteer->first_name}} {{$volunteer->last_name}}</p>
                    </div>
                    <div class="row text-center">
                        <div class="col-3 p-2">
                            <p>Adresse
                            </p>
                            <p>
                                {{$volunteer->primary_zip}}
                            </p>
                        </div>
                        <div class="col-3 p-2">
                            <p>Echelle de l'engagement
                            </p>
                            <p>
                                {{ $volunteer->scale}}
                            </p>
                        </div>
                        <div class="col-3 p-2">
                            <p>Organizer
                            </p>
                            <p>
                                {{$volunteer->username}}
                            </p>
                        </div>
                    </div>


                </div>

            @endforeach
        @endif

    </div>
    @include('volunteers.modal')
    <style>
        .set:hover{
            background-color: darkgreen;
            opacity: 0.4;

            color:whitesmoke;
        }


    </style>


@endsection

