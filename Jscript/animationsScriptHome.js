


function toggleFAQ(element) {
    const allAnswers = document.getElementsByClassName('faq-answer');
    const answer = element.querySelector('.faq-answer');
    if (answer.style.display === 'block') {
        answer.style.display = 'none';
        element.classList.remove('faq-active');
        const arrow = element.querySelector('.dropdown-arrow');
        arrow.textContent = '▼'; 
        return;
    }
    for (let i = 0; i < allAnswers.length; i++) {
        allAnswers[i].style.display = 'none'; 
    } 
    const allFAQs = document.getElementsByClassName('faq');
    for (let i = 0; i < allFAQs.length; i++) {
        allFAQs[i].classList.remove('faq-active'); 
    }
    answer.style.display = 'block';
    element.classList.add('faq-active');
  }