<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="Materialize is a modern responsive CSS framework based on Material Design by Google. ">
        <title>Forms - Materialize</title>
        <!-- Favicons-->
        <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
        <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
        <!--  Android 5 Chrome Color-->
        <meta name="theme-color" content="#EE6E73">
        <!-- CSS-->
        <link rel="stylesheet" href="/builds/css/materialize.css">
        <link href="http://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <main><div class="container">
                <div class="row">
                    <div class="col s12 m9 l10">
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


                        <div id="character-counter" class="section scrollspy">
                            <h2 class="header">Character Counter</h2>
                            <p class="caption">Use a character counter in fields where a character restriction is in place.</p>
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="input_text" type="text" length="10">
                                            <label for="input_text">Input text</label>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="textarea1" class="materialize-textarea" length="120"></textarea>
                                            <label for="textarea1">Textarea</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <pre><code class="language-markup">
    &lt;div class="row">
      &lt;form class="col s12">
        &lt;div class="row">
          &lt;div class="input-field col s6">
            &lt;input id="input_text" type="text" length="10">
            &lt;label for="input_text">Input text&lt;/label>
          &lt;/div>
        &lt;/div>
        &lt;div class="row">
          &lt;div class="input-field col s12">
            &lt;textarea id="textarea1" class="materialize-textarea" length="120">&lt;/textarea>
            &lt;label for="textarea1">Textarea&lt;/label>
          &lt;/div>
        &lt;/div>
      &lt;/form>
    &lt;/div>
          </code></pre>
                            <br>
                            <h4>Initialization</h4>
                            <p>There are no options for this plugin, but if you are adding these dynamically, you can use this to initialize them.</p>
                            <pre><code class="language-javascript">
  $(document).ready(function() {
    $('input#input_text, textarea#textarea1').characterCounter();
  });
        </code></pre>
                        </div>
                    </div>
                </div>
            </div>

        </main>    

        <!--  Scripts-->

        
        <!--<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>-->
    <!--    <script src="js/jquery.timeago.min.js"></script>
        <script src="js/prism.js"></script>
        <script src="jade/lunr.min.js"></script>
        <script src="jade/search.js"></script>-->
        <!--<script src="/js/materialize.js"></script>-->
<script src="/builds/js/components.js"></script>

        <script type="text/javascript">
            (function($) {
                $(function() {
                    var window_width = $(window).width();
                    // BuySellAds Detection

                    // Detect touch screen and enable scrollbar if necessary
                    function is_touch_device() {
                        try {
                            document.createEvent("TouchEvent");
                            return true;
                        } catch (e) {
                            return false;
                        }
                    }
                    if (is_touch_device()) {
                        $('#nav-mobile').css({overflow: 'auto'});
                    }

                    // Set checkbox on forms.html to indeterminate
                    var indeterminateCheckbox = document.getElementById('indeterminate-checkbox');
                    if (indeterminateCheckbox !== null)
                        indeterminateCheckbox.indeterminate = true;


                    // Plugin initialization
                    $('.carousel.carousel-slider').carousel({full_width: true});
                    $('.carousel').carousel();
                    $('.slider').slider({full_width: true});
                    $('.parallax').parallax();
                    $('.modal-trigger').leanModal();
                    $('.scrollspy').scrollSpy();
                    $('.button-collapse').sideNav({'edge': 'left'});
                    $('.datepicker').pickadate({selectYears: 20});
                    $('select').not('.disabled').material_select();


                }); // end of document ready
            })(jQuery); // end of jQuery name space

        </script>
    </body>
</html>
