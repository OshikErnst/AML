<?php 
if(current_user_can('administrator')){
?>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>

                <li class="text-muted menu-title">Local</li>

                <li class="has_sub ">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('users') || is_page('user') || is_page('add-user')){echo ' active';}?>"><i class="ti-user"></i> <span> Users </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="users">All Users</a></li>
                        <li><a href="add-user">Add User</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('clinical-trials') || is_page('clinical-trial') || is_page('add-clinical-trial')){echo ' active';}?>"><i class="ti-wand"></i> <span> Clinical Trials </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="clinical-trials">All Clinical Trials</a></li>
                        <li><a href="add-clinical-trial">Add Clinical Trial</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('sites') || is_page('site') || is_page('add-site')){echo ' active';}?>"><i class="ti-pin-alt"></i> <span> Sites </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="sites">All Sites</a></li>
                        <li><a href="add-site">Add Site</a></li>
                    </ul>
                </li>   

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('visits') || is_page('visit') || is_page('add-visit')){echo ' active';}?>"><i class="ti-home"></i> <span> Visits </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="visits">All Visits</a></li>
                        <li><a href="add-visit">Add Visit</a></li>
                    </ul>
                </li>                               

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('pickup-types') || is_page('pickup-type') || is_page('add-pickup-type')){echo ' active';}?>"><i class="ti-package"></i> <span> Pickup Types </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="pickup-types">All Pickup Types</a></li>
                        <li><a href="add-pickup-type">Add Pickup Type</a></li>
                    </ul>
                </li>  

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('couriers') || is_page('courier') || is_page('add-courier')){echo ' active';}?>"><i class="ti-truck"></i> <span> Couriers </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="couriers">All Couriers</a></li>
                        <li><a href="add-courier">Add Courier</a></li>
                    </ul>
                </li>   

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('targets') || is_page('target') || is_page('add-target')){echo ' active';}?>"><i class="ti-direction"></i> <span> Targets </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="targets">All Targets</a></li>
                        <li><a href="add-target">Add Target</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('zones') || is_page('zone') || is_page('add-zone')){echo ' active';}?>"><i class="ti-map"></i> <span> Zones </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="zones">All Zones</a></li>
                        <li><a href="add-zone">Add Zone</a></li>
                    </ul>
                </li>    

                <li class="text-muted menu-title">International</li> 

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('int-targets') || is_page('int-target') || is_page('add-int-target')){echo ' active';}?>"><i class="ti-direction"></i> <span> Targets </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="int-targets">All Int Targets</a></li>
                        <li><a href="add-int-target">Add Int Target</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('world-couriers') || is_page('world-courier') || is_page('add-world-courier')){echo ' active';}?>"><i class="ti-truck"></i> <span> World Couriers </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="world-couriers">All World Couriers</a></li>
                        <li><a href="add-world-courier">Add World Courier</a></li>
                    </ul>
                </li>  

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('shipping-types') || is_page('shipping-type') || is_page('add-shipping-types')){echo ' active';}?>"><i class="ti-package"></i> <span> Shipping Types </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="shipping-types">All Shipping Types</a></li>
                        <li><a href="add-shipping-type">Add Shipping Type</a></li>
                    </ul>
                </li>    


                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect <?php if(is_page('tube-names') || is_page('tube-name') || is_page('add-tube-name')){echo ' active';}?>"><i class="ti-layout-column4"></i> <span> Tube Name </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="tube-names">All Tube Names</a></li>
                        <li><a href="add-tube-name">Add Tube Name</a></li>
                    </ul>
                </li>  



                <li class="text-muted menu-title">Submitted Forms</li>  


                <li>
                    <a href="<?php echo bloginfo('url');?>" class="waves-effect <?php if(is_front_page()){echo ' active';}?>"><i class="ti-map-alt"></i> <span> Local Forms </span></a>
                </li> 
                <?php if(current_user_can('administrator')){?>
                <li>
                    <a href="int-forms" class="waves-effect <?php if(is_page('int-forms') || is_page('int-form')){echo ' active';}?>"><i class="ti-world"></i> <span> International Forms </span></a>
                </li>  
                <?php } ?>                                   


        </div>         


            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php }else{?>
<style>
    .content-page{margin-left:0px;}
</style>
<?php } ?>