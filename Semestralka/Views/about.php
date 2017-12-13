<?php
       //Nastaveni stylu jen pro tuto hlavni stranu
       echo"<style>
            .navbar{
              margin-bottom:0px;
            }
            h1,
            .carousel
            {
               margin-top:0px;
            }
            body{
                background: url('Images/programming.jpeg');
                background-size: cover; 
                background-attachment: fixed;
            }
              </style>"; 
       //Slider        
       echo "<div id='carousel' class='carousel slide carousel-fade' data-ride='carousel' style>
                  <ol class='carousel-indicators'>
                      <li data-target='#carousel' data-slide-to='0' class='active'></li>
                      <li data-target='#carousel' data-slide-to='1'></li>
                      <li data-target='#carousel' data-slide-to='2'></li>
                  </ol>
                  <!-- Carousel items -->
                  <div class='carousel-inner'>
                      <div class='active item first-carousel-item'>
                              <h1>Vítejte na stránkách Programuj</h1>        
                              <h3>Najdete zde nejaktuálnější vědecké články</h3>
                      </div>
                      <div class='item second-carousel-item'>
                              <h1>Poznejte lidi se stejným zájmem</h1>        
                              <h3>Komunita vědců, studentů a všech se zájmem o programování</h3>
                      </div>
                      <div class='item third-carousel-item'>
                              <h1>Sdílejte s ostatními své nápady</h1>        
                              <h3>Máte možnost nechat ohodnotit články odborníky</h3>
                      </div>
                  </div>
            </div>";  
          