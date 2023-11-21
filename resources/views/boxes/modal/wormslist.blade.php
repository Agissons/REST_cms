<?php
/**
 * @file wormslist.blade.php
 * @brief file description
 * @author Created by Blooooo
 * @version 14.11.2023
 */
?>

<div class="modal" id="Wormslist">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Liste de la Production</h4>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                @foreach($worms as $worm)
                    <div class="p-3 " style=" border-style: outset; border-radius: 6px">
                        <div class="row ">
                            <div class="col-6 text-end">
                                <div class="" >
                                    <p>name :</p>
                                </div>
                                <div class="">
                                    <p>Weight :</p>
                                </div>
                                <div class="">
                                    <p>Crée le :</p>
                                </div>

                            </div>
                            <div class="col-6 text-start">
                                <div >
                                    <p>{{$worm->code}}</p>
                                </div>
                                <div class="">
                                    <p>{{((float)$worm->weight)/1000}} kg</p>
                                </div>
                                <div class="">
                                    <p>{{substr($worm->created_at,0,10)}}</p>
                                </div>


                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>

        </div>
    </div>
</div>
