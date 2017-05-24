@extends('layouts.app')

@section('content')

<div class="container">
    <?php //echo "User is logged in: ".Auth::user()->id; ?>

  <div class="columns">
    <div class="column is-3">
      <ul id="app-links">
        <li><a href="#/" class="button is-primary" v-on:click='onIndex'>Index</a></li>
        <li><a href="#/posts/" class="button is-primary" v-on:click='Visibility = "posts"'>Posts</a></li>
        <li><a href="#/categories" class="button is-primary" v-on:click='Visibility = "cats"'>Categories</a></li>
        <li><a href="#/tags" class="button is-primary" v-on:click='Visibility = "tags"'>Tags</a></li>
      </ul>
    </div>
    <div class="column is-9">
      <index v-show='Visibility == "index"'></index>
      <post v-show='Visibility == "posts"'></post>
      <category v-show='Visibility == "cats"'></category>
      <tag v-show='Visibility == "tags"'></tag>
    </div>
  </div>
</div>



@endsection
