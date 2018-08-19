<div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="<?php echo bloginfo('url');?>" class="logo">AML</a>
                        <!-- Image Logo here -->
                        <!--<a href="index.html" class="logo">-->
                        <!--<i class="icon-c-logo"> <img src="assets/images/logo_sm.png" height="42"/> </i>-->
                        <!--<span><img src="assets/images/logo_light.png" height="20"/></span>-->
                        <!--</a>-->
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <nav class="navbar-custom">

                    <ul class="list-inline float-right mb-0">
                        
                        <li class="list-inline-item dropdown forms-mobile">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                Forms <i class="dripicons-document-edit "></i>
                                
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg" aria-labelledby="Preview">
                                <!-- item-->


                                
                                <?php if(!current_user_can('contributor')){?>
                                <a href="new-form" class="dropdown-item"><i class="ti-plus"></i> &nbsp;<span> New local Form </span></a>
                                <hr />
                                <?php } ?>
                                <?php if(current_user_can('administrator')){?>
                                <a href="add-int-form" class="dropdown-item"><i class="ti-plus"></i>&nbsp; <span> New International Form </span></a>
                                <?php } ?>


                                <?php if(current_user_can('contributor')){?>
                                <a href="local-forms" class="dropdown-item"><i class="ti-plus"></i> &nbsp;<span> Local Forms </span></a>
                                <hr />
                                <a href="int-forms" class="dropdown-item"><i class="ti-plus"></i>&nbsp; <span> International Forms </span></a>

                                <?php } ?>

                            </div>
                        </li>
                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <?php global $current_user;
                                      get_currentuserinfo();
                                      echo $current_user->display_name;
                                      
                                ?>

                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg" aria-labelledby="Preview">


                                <!-- item-->
                                <a href="<?php echo wp_logout_url( home_url() ); ?> " class="dropdown-item notify-item">
                                    <div class=""><i class="ti-shift-right" style="color:red;"></i> </div>
                                    Logout
                                </a>


                            </div>
                            
                        </li>

                    </ul>



                    <ul class="list-inline menu-left mb-0">



                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-light waves-effect">
                                <i class="dripicons-menu"></i>
                            </button>
                        </li>

                        <li class="forms-large float-left">
                            <ul> 
                                <?php if(!current_user_can('contributor')){?>
                                <li>  
                                <a href="new-form" class="dropdown-item"><i class="ti-plus"></i> &nbsp;<span> טופס חדש </span></a></li>
                                <?php } ?>
                                <?php if(current_user_can('administrator')){?>
                                <li>  
                                <a href="add-int-form" class="dropdown-item"><i class="ti-plus"></i>&nbsp; <span> טופס בינלאומי חדש </span></a></li>
                                <?php }?>
                                <?php if( current_user_can( 'subscriber' ) ){   ?>
                                <li> 
                                <a href="forms" class="dropdown-item"><i class="ti-map-alt"></i> &nbsp;<span> לכל הטפסים שנשלחו </span></a></li>
                                <?php } ?>


                                <?php if(current_user_can('contributor')){?>
                                <li> 
                                <a href="local-forms" class="dropdown-item"><i class="ti-map-alt"></i> &nbsp;<span> טפסים מקומיים </span></a></li>
                                <li> 
                                <a href="int-forms" class="dropdown-item"><i class="ti-world"></i> &nbsp;<span> טפסים בינלאומיים </span></a></li>
                                <?php } ?>
                            </ul>
                        </li>


                        

                        
                        
                        
                    </ul>



                </nav>


            </div>