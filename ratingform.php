
<?php  require_once("sessionchecker.php");?>
<link rel="stylesheet" type="text/css" href="css/ratingstar.css"/>

<center><H1><?php //echo $take['t_fname']; ?></H1></center>
<center>
<!--div class = "rate">
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</div-->
<?php //echo "prof pic".$retrieveProfpic1;

if ($player1 != $s_id && $player1 !="0"){
    echo '
<div class="card">
    <img src="uploads/'.$retrieveProfpic1.'" alt="Avatar" style="width:100%">
        <div class="container">
            <fieldset class="rating one">
                <h4>'.$retrievename1.'</h4>
                <input type="radio" id="star5" name="ratingone" value="5" /><label for="star5" title="Rocks!"><span>&#9733</span></label>
                <input type="radio" id="star4" name="ratingone" value="4" /><label for="star4" title="Pretty good"><span>&#9733</span></label>
                <input type="radio" id="star3" name="ratingone" value="3" /><label for="star3" title="Meh"><span>&#9733</span></label>
                <input type="radio" id="star2" name="ratingone" value="2" /><label for="star2" title="Kinda bad"><span>&#9733</span></label>
                <input type="radio" id="star1" name="ratingone" value="1" /><label for="star1" title="Sucks big time"><span>&#9733</span></label>
                <input type="hidden" name="playerfk1" value="'.$player1.'">
            </fieldset>
        </div>
</div> <!--CardEnd-->';
}

if ($player2 != $s_id && $player2 !="0"){
    echo '
<div class="card">
    <img src="uploads/'.$retrieveProfpic1.'" alt="Avatar" style="width:100%">
        <div class="container">
            <fieldset class="rating two">
                <h4>'.$retrievename2.'</h4>
                <input type="radio" id="star5-2" name="ratingtwo" value="5" /><label for="star5-2" title="Rocks!"><span>&#9733</span></label>
                <input type="radio" id="star4-2" name="ratingtwo" value="4" /><label for="star4-2" title="Pretty good"><span>&#9733</span></label>
                <input type="radio" id="star3-2" name="ratingtwo" value="3" /><label for="star3-2" title="Meh"><span>&#9733</span></label>
                <input type="radio" id="star2-2" name="ratingtwo" value="2" /><label for="star2-2" title="Kinda bad"><span>&#9733</span></label>
                <input type="radio" id="star1-2" name="ratingtwo" value="1" /><label for="star1-2" title="Sucks big time"><span>&#9733</span></label>
                <input type="hidden" name="playerfk2" value="'.$player2.'">
            </fieldset>
        </div>
</div> <!--CardEnd-->';
}

if ($player3 != $s_id && $player3 !="0"){
    echo '
<div class="card">
    <img src="uploads/'.$retrieveProfpic1.'" alt="Avatar" style="width:100%">
        <div class="container">
            <fieldset class="rating three">
                <h4>'.$retrievename3.'</h4>
                <input type="radio" id="star5-3" name="ratingthree" value="5" /><label for="star5-3" title="Rocks!"><span>&#9733</span></label>
                <input type="radio" id="star4-3" name="ratingthree" value="4" /><label for="star4-3" title="Pretty good"><span>&#9733</span></label>
                <input type="radio" id="star3-3" name="ratingthree" value="3" /><label for="star3-3" title="Meh"><span>&#9733</span></label>
                <input type="radio" id="star2-3" name="ratingthree" value="2" /><label for="star2-3" title="Kinda bad"><span>&#9733</span></label>
                <input type="radio" id="star1-3" name="ratingthree" value="1" /><label for="star1-3" title="Sucks big time"><span>&#9733</span></label>
                <input type="hidden" name="playerfk3" value="'.$player3.'">
            </fieldset>
        </div>
</div> <!--CardEnd-->';
}

if ($player4 != $s_id  && $player4 !="0"){
    echo '
<div class="card">
    <img src="uploads/'.$retrieveProfpic4.'" alt="Avatar" style="width:100%">
        <div class="container">
            <fieldset class="rating four">
                <h4>'.$retrievename4.'</h4>
                <input type="radio" id="star5-4" name="ratingfour" value="5" /><label for="star5-4" title="Rocks!"><span>&#9733</span></label>
                <input type="radio" id="star4-4" name="ratingfour" value="4" /><label for="star4-4" title="Pretty good"><span>&#9733</span></label>
                <input type="radio" id="star3-4" name="ratingfour" value="3" /><label for="star3-4" title="Meh"><span>&#9733</span></label>
                <input type="radio" id="star2-4" name="ratingfour" value="2" /><label for="star2-4" title="Kinda bad"><span>&#9733</span></label>
                <input type="radio" id="star1-4" name="ratingfour" value="1" /><label for="star1-4" title="Sucks big time"><span>&#9733</span></label>
                <input type="hidden" name="playerfk4" value="'.$player4.'">
            </fieldset>
        </div>
</div> <!--CardEnd-->';
}

if ($player5 != $s_id && $player5 !="0"){
    echo '
<div class="card">
    <img src="uploads/'.$retrieveProfpic5.'" alt="Avatar" style="width:100%">
        <div class="container">
            <fieldset class="rating five">
                <h4>'.$retrievename5.'</h4>
                <input type="radio" id="star5-5" name="ratingfive" value="5" /><label for="star5-5" title="Rocks!"><span>&#9733</span></label>
                <input type="radio" id="star4-5" name="ratingfive" value="4" /><label for="star4-5" title="Pretty good"><span>&#9733</span></label>
                <input type="radio" id="star3-5" name="ratingfive" value="3" /><label for="star3-5" title="Meh"><span>&#9733</span></label>
                <input type="radio" id="star2-5" name="ratingfive" value="2" /><label for="star2-5" title="Kinda bad"><span>&#9733</span></label>
                <input type="radio" id="star1-5" name="ratingfive" value="1" /><label for="star1-5" title="Sucks big time"><span>&#9733</span></label>
                <input type="hidden" name="playerfk5" value="'.$player5.'">
            </fieldset>
        </div>
</div> <!--CardEnd-->';
}

?>




<!--Experimental>
<div class="row">
  <div class="column">
    <div class="card">
      <h3>Card 1</h3>
      <p>Some text</p>
      <p>Some text</p>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <h3>Card 2</h3>
      <p>Some text</p>
      <p>Some text</p>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
      <h3>Card 3</h3>
      <p>Some text</p>
      <p>Some text</p>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
      <h3>Card 4</h3>
      <p>Some text</p>
      <p>Some text</p>
    </div>
  </div>
</div-->


</center>
