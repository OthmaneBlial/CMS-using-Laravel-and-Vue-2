<template>
    <!-- CATEGORIES  INDEX -->
    <div class="categories">
    <div v-show="flashMessageIsVisible" class="notification is-success" id="flash_message">
      <button  v-on:click='hideFlashMessage' class="delete"></button>
      {{ flash_message }}
    </div>
    <a class="button is-primary"  v-on:click='isActiveClass = "is-active"'>Add a new Category</a><br>
        <table class="table" id="categories_index">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Create at</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="category in categories">
              <td>{{  category.id }}</td>
              <td>{{  category.name }}</td>
              <td>{{  category.created_at }}</td>
              <td><a v-on:click='editCategory(category)' class="button is-info">Edit</a></td>
              <td><a v-on:click='deleteCategory(category.id)' class="button is-danger">Delete</a></td>
            </tr>
          </tbody>
        </table>

        <!-- CATEGORIES CREATE -->
        <form method="POST" v-on:submit.prevent="onCategorySubmit">
        <div class="modal" v-bind:class="[isActiveClass]">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">Add a new Category</p>
              <a class="delete" v-on:click='isActiveClass = ""'></a>
            </header>
            <section class="modal-card-body">
                <div class="field">
                  <label class="label">Name</label>
                  <p class="control">
                    <input name="name" v-model="name" class="input" type="text" placeholder="Enter Category">
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

         <!-- CATEGORIES EDIT -->
            <form method="POST" v-on:submit.prevent="onCategoryUpdate">
         <div class="modal" v-bind:class="[isActiveClassEdit]">
           <div class="modal-background"></div>
           <div class="modal-card">
             <header class="modal-card-head">
               <p class="modal-card-title">Edit this Category</p>
               <a class="delete" v-on:click='isActiveClassEdit = ""'></a>
             </header>
             <section class="modal-card-body">
                <div class="field">
                  <label class="label">Name</label>
                  <p class="control">
                    <input name="name" v-model="category.name" class="input" type="text" placeholder="Enter Category">
                  </p>
                </div>
             </section>
             <footer class="modal-card-foot">
               <button type="submit" class="button is-success">Submit</button>
               <a class="button" v-on:click='isActiveClassEdit = ""'>Cancel</a>
             </footer>
           </div>
         </div>
         </form>
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
                isActiveClassEdit: '',
                name: "",
                categories: {},
                category: {},
                flash_message: "",
                flashMessageIsVisible: false
            }
        },

        methods: {

            fetchData() {
                axios.get('/categories')
                  .then(response => this.categories = response.data);
            },

            fadeFlashMesssage() {
                sleep(3000).then(() => {
                  this.flashMessageIsVisible = false;
                  this.flash_message = "";
              });
            },

            onCategorySubmit() {

              axios.post('/categories', {

                name: this.name

              }).then(response => this.flash_message = response.data)
                .then(response => this.flashMessageIsVisible = true)
                .then(this.fetchData(), this.name = "", this.isActiveClass = "")
                .then(this.fadeFlashMesssage());
                
            },

            hideFlashMessage() {

                this.flashMessageIsVisible = false;
            },

            editCategory(category) {

                this.isActiveClassEdit = "is-active";
                this.category = category;

            },

            onCategoryUpdate() {

                this.flashMessageIsVisible = false;

              axios.post('/categories/'+ this.category.id, {

                name: this.category.name

              }).then(response => this.flash_message = response.data)
                .then(response => this.flashMessageIsVisible = true)
                .then(this.fetchData(), this.isActiveClassEdit = "")
                .then(this.fadeFlashMesssage());


            },

            deleteCategory(id) {

                axios.get('/categories/'+ id)
                    .then(response => this.flash_message = response.data)
                    .then(response => this.flashMessageIsVisible = true)
                    .then(this.fetchData())
                    .then(this.fadeFlashMesssage());


            }
        },

        mounted() {

          //this.fetchData();

        }

    }
</script>
