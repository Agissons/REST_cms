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
                                <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#Guanoadd"> add</button>
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
                                <p>Weight :</p>
                            </div>
                            <div class="">
                                <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#Wormslist"> list</button>
                            </div>


                        </div>
                        <div class="col-6 text-start">
                            <div >
                                <p> </p>
                            </div>
                            <div class="">
                                <p>{{((float)$prod)/1000}} kg</p>
                            </div>
                            @if($boxes->contains('type','size4'))
                            <div >
                                <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#Wormsadd"> add</button>
                            </div>
                            @endif


                        </div>
                    </div>

                </div>

            </div>
            <div class=" col-4 ">
                <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#Users"> User Gestion</button>
                <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#Nourish"> Nourish</button>
                <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#Session"> New Session</button>
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
                                    @if($boxe->nourish!=null)
                                    <div class="">
                                        <p>Nouri le :</p>
                                    </div>
                                    @else
                                    <div class="">
                                        <p>Faites par :</p>
                                    </div>
                                    @endif

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
                                    @if($boxe->nourish!=null)
                                    <div class="">
                                        <p>{{$boxe->nourish}}</p>
                                    </div>
                                    @else
                                    <div class="">
                                        <p>{{$boxe->username}}</p>
                                    </div>
                                    @endif

                                </div>
                            </div>

                        </div>



                    </div>
                @endforeach

            @endif


        </div>





    </div>
    @include('boxes.modal.guanoadd')
    @include('boxes.modal.wormsadd')
    @include('boxes.modal.wormslist')
    @include('boxes.modal.users')
    @include('boxes.modal.nourish')
    @include('boxes.modal.session')

@endsection
