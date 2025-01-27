<?php
get_header();
?>

<main>
  <!-- Jumbotron Section -->
  <section class="jumbotron text-center bg-light py-5">
    <div class="container">
      <h1 class="display-4">Welcome to Rental Homes</h1>
      <p class="lead">Find your dream home with us. Quality, comfort, and trust.</p>
      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquid dolores, labore eius nobis amet tempore hic consequatur explicabo quisquam rem quo, vero assumenda rerum. Ratione voluptatum explicabo dolorem aspernatur vero!</p>
    </div>
  </section>

  <!-- Services Section -->
  <section class="services py-5">
    <div class="container">
      <h2 class="text-center mb-4">Our Services</h2>
      <div class="row">
        <div class="col-md-4 text-center">
          <i class="fas fa-home fa-3x mb-3"></i>
          <h4>Wide Selection of Homes</h4>
          <p>Explore a wide variety of homes to suit your preferences and needs.</p>
        </div>
        <div class="col-md-4 text-center">
          <i class="fas fa-user-shield fa-3x mb-3"></i>
          <h4>Trusted Rentals</h4>
          <p>We ensure a secure and trustworthy rental experience for all our clients.</p>
        </div>
        <div class="col-md-4 text-center">
          <i class="fas fa-tools fa-3x mb-3"></i>
          <h4>Maintenance Support</h4>
          <p>Our team provides 24/7 support to address any maintenance issues promptly.</p>
        </div>
        <div class="align-self-center text-center">
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquid dolores, labore eius nobis amet tempore hic consequatur explicabo quisquam rem quo, vero assumenda rerum. Ratione voluptatum explicabo dolorem aspernatur vero!</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Company Policy Section -->
  <section class="policy bg-light py-5">
    <div class="container">
      <h2 class="text-center mb-4">Our Commitment</h2>
      <p class="text-center">At Rental Homes, we prioritize transparency, customer satisfaction, and quality service. Our team is dedicated to providing a seamless rental experience tailored to your needs.</p>
      <div class="row text-center mt-5">
        <div class="col-md-4">
          <div class="card border-0 shadow">
            <div class="card-body">
              <h5 class="card-title">Transparent Contracts</h5>
              <p class="card-text">Clear and fair agreements for peace of mind.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-0 shadow">
            <div class="card-body">
              <h5 class="card-title">Customer-Centric Approach</h5>
              <p class="card-text">Your needs are our priority at every step.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-0 shadow">
            <div class="card-body">
              <h5 class="card-title">Quality Assurance</h5>
              <p class="card-text">High standards in every property we offer.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Customer Reviews Section -->
  <section class="reviews py-5">
    <div class="container">
      <h2 class="text-center mb-4">What Our Customers Say</h2>
      <div class="row">
        <div class="col-md-4">
          <blockquote class="blockquote text-center">
            <p class="mb-3">"Finding a rental home was so easy and stress-free with Rental Homes! Highly recommended."</p>
            <footer class="blockquote-footer">Jane Doe</footer>
          </blockquote>
        </div>
        <div class="col-md-4">
          <blockquote class="blockquote text-center">
            <p class="mb-3">"Exceptional service and a fantastic selection of properties. Truly top-notch!"</p>
            <footer class="blockquote-footer">John Smith</footer>
          </blockquote>
        </div>
        <div class="col-md-4">
          <blockquote class="blockquote text-center">
            <p class="mb-3">"The team was so helpful and responsive throughout the process. Couldn't be happier."</p>
            <footer class="blockquote-footer">Emily Johnson</footer>
          </blockquote>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq bg-light py-5">
    <div class="container">
      <h2 class="text-center mb-4">Frequently Asked Questions</h2>
      <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              What is the process for renting a home?
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Our rental process is simple: browse our listings, schedule a visit, and complete the rental application online.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Are utilities included in the rent?
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Utilities vary by property. Each listing provides detailed information about what is included.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              How can I schedule a property tour?
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              You can schedule a property tour directly through our website or by contacting our team via phone or email.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
?>
