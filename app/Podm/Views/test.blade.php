@extends('PodmView::layout')
@section('content')
<div id="date-picker" class="section scrollspy">
        <h2 class="header">Date Picker</h2>
        <p>We use a modified version of pickadate.js to create a materialized date picker. Test it out below! </p>
        <label for="birthdate">Birthdate</label>
        <input id="birthdate" type="text" class="datepicker">
        <pre><code class="language-markup">
  &lt;input type="date" class="datepicker">
        </code></pre>

        <h4>Initialization</h4>
        <p>At this time, not all pickadate.js options are working with our implementation</p>
        <pre><code class="language-javascript">
  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
  });
        </code></pre>
      </div>
@endsection