@extends('user.layouts.master')

@section('content')
<div class="container">
    <h3>Math Test</h3>
    <div class="row">
      <form action="/">
          <h6>what's the capital of Morocco ?</h6>
         <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="" required>
            <label class="form-check-label" for="flexRadioDefault1">
              Paris
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="" >
            <label class="form-check-label" for="flexRadioDefault2">
              Rabat
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="" >
            <label class="form-check-label" for="flexRadioDefault2">
              Roma
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="" >
            <label class="form-check-label" for="flexRadioDefault2">
                Ottawa
            </label>
          </div>
          <h6>what's the values greater than 2 ?</h6>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" name="salam" id="" >
            <label class="form-check-label" for="defaultCheck1">
             3
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value=""  name="salam" id="" >
            <label class="form-check-label" for="defaultCheck2">
              4
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="" >
            <label class="form-check-label" for="defaultCheck2">
              10
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="" >
            <label class="form-check-label" for="defaultCheck2">
              1
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="" >
            <label class="form-check-label" for="defaultCheck2">
              -4
            </label>
          </div>
          <h6>Morocco is a European country ?</h6>
          <div class="form-check">
             <input class="form-check-input" type="radio" name="flexRadioDefault1" id="">
             <label class="form-check-label" for="flexRadioDefault1">
               True
             </label>
           </div>
           <div class="form-check">
             <input class="form-check-input" type="radio" name="flexRadioDefault1" id="" required>
             <label class="form-check-label" for="flexRadioDefault2">
               False
             </label>
           </div>
           <button class="btn btn-success" type="submit">Submit</button>
      </form>
    </div>
  </div>

@endsection