 <!-- Begin page content -->
 <main class="flex-shrink-0 main-container">
     <!-- page content goes here -->
     <div class="banner-hero vh-100 scroll-y bg-white">
         <div class="container h-100 mt-5">
             <form action="<?= site_url() . 'login/login_action' ?>" method="POST">
                 <div class="row h-100 h-sm-auto">
                     <div class="col-11 col-sm-8 col-md-6 mx-auto align-self-start">
                     </div>
                     <div class="w-100"></div>

                     <div class="col-11 col-sm-8 col-md-6 mx-auto align-self-center">
                         <h3 class="">Welcome to</h3>
                         <h2 class="font-weight-bold mb-4">SplashPOS</h2>
                         <?= $this->session->flashdata('message'); ?>
                         <div class="form-group">
                             <label for="email" class="sr-only">Email address</label>
                             <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
                         </div>
                         <div class="form-group">
                             <label for="password" class="sr-only">Password</label>
                             <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
                         </div>

                         <div class="my-3 row">
                             <div class="col-6 col-md py-1 text-right text-md-right">
                                 <!-- <a href="forgotpassword.html">Forgot Password?</a> -->
                             </div>
                         </div>
                         <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                     </div>
                     <div class="h-100"></div>
                     <div class="col-11 col-sm-8 col-md-6 mx-auto align-self-end">
                         <div class="mb-4">
                             <button type="submit" class="btn btn-lg btn-default default-shadow btn-block">Sign In</button>
                         </div>
                         <div class="mb-4">
                             <!-- <p>Do not have account yet?<br>Please <a href="<?= base_url() . 'signup' ?>">Sign up</a> here.</p> -->
                         </div>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </main>
 <!-- End of page content -->