/* must be placed after:
<script src="https://code.jquery.com/jquery-2.1.1.min.js "></script>
<script src="../dependencies/materializeJS/materialize.js "></script>
*/

(function() {
  'use strict';
  // check if url contains login hash for modals
  if (window.location.hash.toLowerCase() == '#login') {
    $('#loginModal').openModal();
  }
  // check if url contains signup hash for modals
  if (window.location.hash.toLowerCase() == '#signup') {
      $('#signupModal').openModal();
  }
}());

/* EXAMPLE MODALS
<div id="signupModal" class="modal modal-fixed-footer">
    <div class="modal-content" style="color: black">
        <h4>Signup for Clout</h4>
        <p>text</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Submit</a>
    </div>
</div>
<div id="loginModal" class="modal modal-fixed-footer">
    <div class="modal-content" style="color: black">
        <h4>Login to Clout</h4>
        <p>text</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Login</a>
    </div>
</div>
*/
