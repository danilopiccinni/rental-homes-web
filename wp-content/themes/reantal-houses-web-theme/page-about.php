<?php
/* Template Name: About Page */
get_header();
?>

<main>
  <!-- Hero Section -->
  <section class="about-hero" style="text-align: center; padding: 50px 20px; background: #f7f7f7;">
    <h1 style="font-size: 3rem; margin-bottom: 10px;">About Us</h1>
    <p style="font-size: 1.2rem; color: #555; max-width: 800px; margin: 0 auto;">
      Discover the story behind our passion for providing the best rental homes for you and your loved ones.
    </p>
  </section>

  <!-- Mission Section -->
  <section class="about-mission" style="padding: 50px 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">
      <h2 style="font-size: 2rem; margin-bottom: 20px;">Our Mission</h2>
      <p style="line-height: 1.6; color: #333;">
        At <strong>Rental Homes</strong>, our mission is to simplify the process of finding your perfect rental home. 
        We are committed to providing a seamless, user-friendly platform that connects people with properties that meet their needs. 
        Whether you're searching for a cozy apartment or a spacious family home, we've got you covered.
      </p>
    </div>
  </section>

  <!-- Team Section -->
  <section class="about-team" style="padding: 50px 20px; background: #f7f7f7;">
    <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
      <h2 style="font-size: 2rem; margin-bottom: 20px;">Meet Our Team</h2>
      <p style="color: #555; margin-bottom: 30px;">
        A dedicated group of professionals working tirelessly to make your rental experience unforgettable.
      </p>
      <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
        <div style="flex: 1 1 300px; max-width: 300px; text-align: center;">
          <img src="https://via.placeholder.com/150" alt="Team Member" style="border-radius: 50%; margin-bottom: 10px;">
          <h3 style="margin: 0;">John Doe</h3>
          <p style="color: #777;">Founder & CEO</p>
        </div>
        <div style="flex: 1 1 300px; max-width: 300px; text-align: center;">
          <img src="https://via.placeholder.com/150" alt="Team Member" style="border-radius: 50%; margin-bottom: 10px;">
          <h3 style="margin: 0;">Jane Smith</h3>
          <p style="color: #777;">Operations Manager</p>
        </div>
        <div style="flex: 1 1 300px; max-width: 300px; text-align: center;">
          <img src="https://via.placeholder.com/150" alt="Team Member" style="border-radius: 50%; margin-bottom: 10px;">
          <h3 style="margin: 0;">Emily Brown</h3>
          <p style="color: #777;">Marketing Specialist</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="about-testimonials" style="padding: 50px 20px;">
    <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
      <h2 style="font-size: 2rem; margin-bottom: 20px;">What Our Clients Say</h2>
      <p style="color: #555; margin-bottom: 30px;">
        Hear from those who found their dream homes with us.
      </p>
      <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
        <div style="flex: 1 1 300px; max-width: 300px; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background: #fff;">
          <p style="font-style: italic;">"Rental Homes made finding a place to live so easy and stress-free. Highly recommend!"</p>
          <p style="color: #777; margin-top: 10px;">- Sarah Johnson</p>
        </div>
        <div style="flex: 1 1 300px; max-width: 300px; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background: #fff;">
          <p style="font-style: italic;">"The team was so helpful and professional. I found exactly what I needed."</p>
          <p style="color: #777; margin-top: 10px;">- Michael Lee</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section class="about-cta" style="text-align: center; padding: 50px 20px; background: #333; color: #fff;">
    <h2 style="font-size: 2rem; margin-bottom: 20px;">Find Your Dream Rental Home Today</h2>
    <p style="max-width: 800px; margin: 0 auto; margin-bottom: 20px;">
      Browse our extensive listings and discover the perfect home for you and your family.
    </p>
    <a href="/browse-homes" style="background: #ff6600; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Browse Homes</a>
  </section>
</main>

<?php
get_footer();
?>