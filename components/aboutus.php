<div id="About" class="faq-container">
        <h1>About Us</h1>
        <p>Welcome to FlashBook, a centralized cloud-based booking system with portfolio customization for photographers and videographers.</p>
        <p>FlashBook is here to give you a seamless booking system and to search your chosen professionals.</p>
 
        <h1>Frequently Asked Questions</h1>
        <ul class="faq" id="faq">
            <li>
                <a href="#!" onclick="toggleAnswer('faq1')">How do I book a photographer/videographer through your website?</a>
                <div id="faq1" class="faq-answer">
                  <p>FlashBook is a centralized cloud-based booking system designed for photographers and videographers. It helps professionals manage their bookings and clients find the right talent for their projects.</p>
                </div>
            </li>

            <li>
                <a href="#!" onclick="toggleAnswer('faq2')">What information do I need to provide when booking?</a>
                <div id="faq2" class="faq-answer">
                  <p>FlashBook works by allowing photographers and videographers to create profiles showcasing their work. Clients can search for professionals based on their needs, view portfolios, and book their services directly through the platform.</p>
                </div>
            </li>

            <li>
                <a href="#!" onclick="toggleAnswer('faq3')">Can I book both photography and videography services together?</a>
                <div id="faq3" class="faq-answer">
                  <p>Joining FlashBook is easy. Simply visit our website, click on the "Sign Up" button, and follow the registration process to create your professional profile or client account.</p>
                </div>
            </li>

            <li>
                <a href="#!" onclick="toggleAnswer('faq4')">How do I make a payment through your website?</a>
                <div id="faq4" class="faq-answer">
                  <p>FlashBook offers both free and premium plans. The free plan provides basic features, while the premium plan includes additional tools and benefits for enhanced visibility and booking management.</p>
                </div>
            </li>

            <li>
                <a href="#!" onclick="toggleAnswer('faq5')">Are there any additional fees or charges I should be aware of?</a>
                <div id="faq5" class="faq-answer">
                  <p>FlashBook offers both free and premium plans. The free plan provides basic features, while the premium plan includes additional tools and benefits for enhanced visibility and booking management.</p>
                </div>
            </li>

            <li>
                <a href="#!" onclick="toggleAnswer('faq6')">Is there a penalty for cancelling or rescheduling?</a>
                <div id="faq6" class="faq-answer">
                  <p>FlashBook offers both free and premium plans. The free plan provides basic features, while the premium plan includes additional tools and benefits for enhanced visibility and booking management.</p>
                </div>
            </li>
 
        </ul>
        
    </div>

    <script>
        /*FAQ js function dropdown*/
      function toggleAnswer(id) {
          var answer = document.getElementById(id);
      if (answer.style.display === "none" || answer.style.display === "") {
        answer.style.display = "block";
                    } else {
        answer.style.display = "none";
                    }
        }
    </script>      