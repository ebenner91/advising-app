<div class="container">
  <div class="row">
    <div class="col s12">
      <h4 class="center">Green River Tech Advising</h4>
      <p>This is a tool for planning purposes only. While every effort has been made to ensure that
         the information in this publication is accurate and up to date, students should assume the
         responsibility of consulting their advisor for the most current information. All schedules
         are subject to change without notice and do not constitute an agreement between Green River
         College and the student.</p>
      <p id="select-text">Please select the degree that you are interested in and the quarter you intend to
         start.</p>
    </div>
  </div>
  <!--Filter degrees-->
  <form class="row" id="degree-form">
    <!--Degrees select-->
    <div class="col s12 m5 input-field">
      <select id="degree-select-title"></select>
      <label>Degree</label>
    </div>
    <!--Quarter start select-->
    <div class="col s12 m3 input-field">
      <select id="degree-select-start"></select>
      <label>Quarter Start</label>
    </div>
    <div class="col s12 m4">
      <!--Filter button-->
      <button class="col s12 btn-large waves-effect waves-light green darken-4" id="degree-btn-filter" type="submit">
        SUBMIT
      </button>
    </div>
  </form>

  <?php if(isset($_SESSION['auth-current-user'])) { ?>
    <?php include 'includes/admin.php'; ?>
  <?php } ?>

  <!--List of degrees-->
  <div class="row">
    <div class="col s12">
      <!--Degrees map populated with hbs templates-->
      <div id="degree-map"></div>
    </div>
  </div>

  <div class="row">
    <div class="col s12">
      <div class="divider"></div>
    </div>
  </div>

  <!--Resources-->
  <div class="row" id="degree-resources">
    <div class="col s12 center">
      <h4>Resources</h4>
      <ul>
        <li><a href="http://greenrivertech.net/frequently-asked-questions.php" target="_blank">
            Frequently Asked Questions</a>
        </li>
        <li><a href="http://greenrivertech.net/advisors.php" target="_blank">
            10 Questions for Advisees</a>
        </li>
        <li><a href="http://greenrivertech.net/files/course-offerings.pdf" target="_blank">
            Course Offerings Grid (PDF)</a>
        </li>
      </ul>
    </div>
  </div>

  <!--Follow Us-->
  <div class="row" id="follow-us">
    <div class="col s12 center">
      <h4>Follow Us</h4>
      <!--Social media icons-->
      <a href="https://www.facebook.com/greenrivertechnologyprograms" target="_blank">
        <img src="assets/img/ico/facebook.png" alt="Facebook logo">
      </a>
      <a href="http://instagram.com/greenrivertech" target="_blank">
        <img src="assets/img/ico/instagram.png" alt="Instagram logo">
      </a>
      <a href="https://www.linkedin.com/groups?home=&gid=6781985&trk=anet_ug_hm" target="_blank">
        <img src="assets/img/ico/linkedin.png" alt="Linkedin logo">
      </a>

    </div>
  </div>

  <!--Contact Us-->
  <div class="row" id="contact-us">
    <div class="col s12 center">
      <h4>Contact Us</h4>
      <ul>
        <li><a href="tel:2538339111">(253) 833-9111 ext.4600</a></li>
        <li><a href="mailto:itdegrees@greenriver.edu">itdegrees@greenriver.edu</a></li>
        <li><a href="http://greenriver.edu/it" target="_blank" id="request-info">Request Information</a></li>
      </ul>
    </div>
  </div>

  <!--College Address-->
  <div class="row">
    <div class="col s12 center">
      <a id="grc-logo" href="http://www.greenriver.edu/" target="_blank">
        <img  src="assets/img/green-river-college-logo.jpg" alt="Green River College logo">
      </a>
      <p><strong>Main Campus:</strong></p>
      <address>
        <a href="https://www.google.com/maps/place/Green+River+Community+College/@47.3130745,-122.179769,16z/data=!4m2!3m1!1s0x549058a045230aab:0x296322357297393b" target="_blank">
          12401 Southeast 320th Street<br>
          Auburn, WA 98092
        </a>
      </address>
      <p><strong>Auburn Center Campus:</strong></p>
      <address>
        <a
          href=https://www.google.com/maps/place/Green+River+College+Auburn+Center/@47.3185425,-122.2247615,17z/data=!4m12!1m6!3m5!1s0x5490586042ed8d9d:0xd7d1f0734c75c053!2sGreen+River+College+Auburn+Center!8m2!3d47.3185425!4d-122.2247615!3m4!1s0x5490586042ed8d9d:0xd7d1f0734c75c053!8m2!3d47.3185425!4d-122.2247615"
          target="_blank">
          1221 D St NE<br>
          Auburn, WA 98002
        </a>
      </address>
    </div>
  </div>
</div>

<!-- Degree Course Modal -->
<div id="course" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h5 class="course-modal-title"></h5>
    <p class="course-modal-description"></p>
    <p class="course-modal-prereq"></p>
    <p class="course-modal-quarter"></p>
  </div>
  <div class="modal-footer">
    <button class="btn modal-action modal-close waves-effect waves-light green" type="submit">CLOSE
    </button>
  </div>
</div>