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
                <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"> New set</button>
            </div>

        </div>


        @if($sets->isEmpty())
            <div class="text-center">
                <p>Vous ne faite parti d'aucun ensemble


                </p>


            </div>
        @else
            @foreach($sets as $set)
                <div class="m-3" style=" border-style: outset; border-radius: 6px">
                    <div class="p-3">
                        <p>name : {{$set->name}}</p>
                    </div>
                    <div class="row text-center">
                        <div class="col-3 p-2">
                            <p>
                                Boxes
                            </p>
                            <p>
                                {{$set->boxes}}
                            </p>
                        </div>
                        <div class="col-3 p-2">
                            <p>
                                Mealworms
                            </p>
                             <p>
                                {{((float)$set->production)/1000}} kg
                            </p>
                        </div>
                        <div class="col-3 p-2">
                            <p>
                                Guano
                            </p>
                            <p>
                                {{((float)$set->weight)/1000}} kg
                            </p>
                        </div>
                        <div class="col-3 p-2">
                            <p>
                                Users
                            </p>
                            <p>
                                {{$set->users}}
                            </p>
                        </div>

                    </div>


                </div>
            @endforeach
        @endif

    </div>

@endsection

