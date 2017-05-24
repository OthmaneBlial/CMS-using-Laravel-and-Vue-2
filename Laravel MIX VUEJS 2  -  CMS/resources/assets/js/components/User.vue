<template>
    <div class="posts">
    

    <span class="nav-item" v-if='userStatus == true'>
      <a class="button" >
        <span><a v-on:click='isActiveClass3 = "is-active"'>PROFILE</a><br></span>
      </a>
      <a class="button is-primary">
        <span><a v-on:click='logOut'>LOG OUT</a><br></span>
      </a>
    </span>

    <span class="nav-item" v-if='userStatus == false'>
      <a class="button" >
        <span><a v-on:click='isActiveClass = "is-active"'>SIGN UP</a><br></span>
      </a>
      <a class="button is-primary">
        <span><a v-on:click='isActiveClass2 = "is-active"'>LOG IN</a><br></span>
      </a>
    </span>



        <!-- REGISTER -->
        <form method="POST" v-on:submit.prevent="onRegister">
        <div class="modal" v-bind:class="[isActiveClass]">
          <div class="modal-background"></div>
          <div class="modal-card" id="signup">
            <header class="modal-card-head">
              <p class="modal-card-title">Sign Up</p>
              <a class="delete" v-on:click='isActiveClass = ""'></a>
            </header>
            <section class="modal-card-body">
                <div class="field">
                  <label class="label">Name</label>
                  <p class="control">
                    <input name="name" v-model="data.name" class="input" type="text" placeholder="Enter Name">
                  </p>
                </div>
                <div class="field">
                  <label class="label">Username</label>
                  <p class="control">
                    <input name="username" v-model="data.username" class="input" type="text" placeholder="Enter Username">
                  </p>
                </div>
                <div class="field">
                  <label class="label">Email</label>
                  <p class="control">
                    <input name="email" v-model="data.email" class="input" type="text" placeholder="Enter Email">
                  </p>
                </div>
                <div class="field">
                  <label class="label">Password</label>
                  <p class="control">
                    <input name="password" v-model="data.password" class="input" type="password" placeholder="Enter Password">
                  </p>
                </div>
                <div class="field">
                  <label class="label">Password Confirmation</label>
                  <p class="control">
                    <input name="password_confirmation" v-model="data.password_confirmation" class="input" type="password" placeholder="Confirm Password">
                  </p>
                </div>
            </section>
            <footer class="modal-card-foot">
              <button type="submit" class="button is-success">Submit</button>
              <a class="button" v-on:click='isActiveClass = ""'>Cancel</a>
            </footer>
          </div>
        </div>
        </form>

        <!-- LOGIN -->
        <form method="POST" v-on:submit.prevent="onLogIn">
        <div class="modal" v-bind:class="[isActiveClass2]">
          <div class="modal-background"></div>
          <div class="modal-card" id="signup">
            <header class="modal-card-head">
              <p class="modal-card-title">LOG IN</p>
              <a class="delete" v-on:click='isActiveClass2 = ""'></a>
            </header>
            <section class="modal-card-body">
                <div class="field">
                  <label class="label">Email</label>
                  <p class="control">
                    <input name="email" v-model="data2.email" class="input" type="text" placeholder="Enter Email">
                  </p>
                </div>
                <div class="field">
                  <label class="label">Password</label>
                  <p class="control">
                    <input name="password" v-model="data2.password" class="input" type="password" placeholder="Enter Password">
                  </p>
                </div>
            </section>
            <footer class="modal-card-foot">
              <button type="submit" class="button is-success">Submit</button>
              <a class="button" v-on:click='isActiveClass2 = ""'>Cancel</a>
            </footer>
          </div>
        </div>
        </form>

        <!-- Profile -->
        <div class="modal" v-bind:class="[isActiveClass3]">
          <div class="modal-background"></div>
          <div class="modal-card" id="signup">
            <header class="modal-card-head">
              <p class="modal-card-title">MY PROFILE</p>
              <a class="delete" v-on:click='isActiveClass3 = ""'></a>
            </header>
            <section class="modal-card-body">
                <div class="field">
                  <label class="label">Name</label>
                  <p class="control">
                    <input name="email" v-model="user.name" class="input" type="text" placeholder="Enter Email" disabled>
                  </p>
                </div>
                <div class="field">
                  <label class="label">Email</label>
                  <p class="control">
                    <input name="email" v-model="user.email" class="input" type="text" placeholder="Enter Password" disabled>
                  </p>
                </div>
                <div class="field">
                  <label class="label">Joind at</label>
                  <p class="control">
                    <input  v-model="user.created_at" class="input" type="text"  disabled>
                  </p>
                </div>
            </section>
            <!-- <footer class="modal-card-foot">
              <button type="submit" class="button is-success">Submit</button>
              <a class="button" v-on:click='isActiveClass3 = ""'>Cancel</a>
            </footer> -->
          </div>
        </div>




    </div>

</template>

<script>
import Vue from 'vue'
import axios from 'axios'

function sleep (time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}
    export default {
       
        data() {
            return {
                isActiveClass: '',
                isActiveClass2: '',
                isActiveClass3: '',
                data: {name: '', username: '', email: '', password: '', password_confirmation: ''},
                data2: {email: '', password: ''},
                users: {},
                user: {},
                userStatus: false
            }
        },

        methods: {

            fetchData() {
                axios.get('/users')
                  .then(response => this.users = response.data);
            },

            isLoggedIn() {
                axios.get('/isloggedin')
                  .then(response => this.userStatus = response.data);
            },

            loggedInUser() {
                axios.get('/user')
                  .then(response => this.user = response.data);
            },


            onRegister() {

              axios.post('/register', {

                name: this.data.name,
                username: this.data.username,
                email: this.data.email,
                password: this.data.password,
                password_confirmation: this.data.password_confirmation,

              }).then(response => this.isActiveClass = "")
                .then(response =>  this.isLoggedIn())
                .then(response =>  this.loggedInUser());

                
            },

            onLogIn() {

              axios.post('/login', {

                email: this.data2.email,
                password: this.data2.password,

              }).then(response => this.isActiveClass2 = "")
                .then(response => this.isLoggedIn())
                .then(response =>  this.loggedInUser());

                Event.$emit('userLoggedIn');





                
            },

            
            logOut() {

                axios.get('/loggingout', {


                }).then(response => this.isLoggedIn())
                  .then(response =>  this.user = {});

                Event.$emit('userLoggedOut');
            },


        },

        mounted() {

          this.fetchData();
          this.isLoggedIn();
          this.loggedInUser();


        }

    }
</script>

<style type="text/css">
  
  label {

text-align: left;

  }

</style>
