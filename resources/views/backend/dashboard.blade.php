<x-admin-layout >

<?php 
    


   

    ?>
    <x-slot name="heading">
        Admin Dashboard
    </x-slot>
        <div class="dashbaord_outer">
            <div class="row">
                <div class="col-md-3">
                    <div class="dashboard_inner">
                        <div class="dash_inner_left">
                            <div class="count_title">{{$inquiryC}}</div>
                            <p>Total Inquirys</p>
                        </div>
                        <div class="dash_inner_right">
                            <img src="{{publicPath()}}/assets/images/icon1.png" alt="icon1">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard_inner">
                        <div class="dash_inner_left">
                            <div class="count_title">{{$studentC}}</div>
                            <p>Total Student</p>
                        </div>
                        <div class="dash_inner_right">
                            <img src="{{publicPath()}}/assets/images/icon2.png" alt="icon2">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard_inner">
                        <div class="dash_inner_left">
                            <div class="count_title">{{$recordC}}</div>
                            <p>Total Record</p>
                        </div>
                        <div class="dash_inner_right">
                            <img src="{{publicPath()}}/assets/images/icon3.png" alt="icon3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
       

      
    
</x-admin-layout>