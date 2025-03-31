document.addEventListener('DOMContentLoaded', function() {
    const menu = document.querySelector(".menu");
    const navMenu = document.querySelector(".links");
    
    menu.addEventListener("click", () => {
        navMenu.classList.toggle("active");
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const sections = {
        photography: {
            button: document.getElementById('photography'),
            content: document.getElementById('pcon')
        },
        videography: {
            button: document.getElementById('videography'),
            content: document.getElementById('vcon')
        },
        BUNDLE: {
            button: document.getElementById('BUNDLE'),
            content: document.getElementById('mcon')
        }
    };

    const toggleActive = (selectedSection) => {
        for (const sectionKey in sections) {
            const section = sections[sectionKey];
            if (sectionKey === selectedSection) {
                section.content.classList.add('active');
                section.button.classList.add('active');
            } else {
                section.content.classList.remove('active');
                section.button.classList.remove('active');
            }
        }
    };

  
    for (const sectionKey in sections) {
        const section = sections[sectionKey];
        if (section.button && section.content) {
            section.button.addEventListener('click', () => toggleActive(sectionKey));
        }
    }
});




function videoslider(links){
    document.querySelector('.slider').src=links; 
}




function handleBookNowClick() {
    var contq = document.getElementById('bk-frm-container');
    contq.classList.toggle('active');
    contq.scrollIntoView({ behavior: 'smooth' });
}


const nextButton = document.querySelector('.btn-next');
const prevButton = document.querySelector('.btn-prev');
const steps = document.querySelectorAll('.step');
const form_steps = document.querySelectorAll('.form-step');
let active = 1;

nextButton.addEventListener('click', ()=>{
    active++;
    if(active > steps.length){
        active = steps.length;
    }
    updateProgress();
});

prevButton.addEventListener('click',()=>{
    active--;
    if(active < 1){
        active = 1;
    }
    updateProgress();
});

const updateProgress = ()=>{

    steps.forEach((step, i)=>{
        if(i == (active-1)){
            step.classList.add('active');
            form_steps[i].classList.add('active');
    
        }else{
            step.classList.remove('active');
            form_steps[i].classList.remove('active')
        }
    });

    if(active === 1){
        prevButton.disabled = true;
    }else if (active === steps.length){
        nextButton.disabled = true;
    }else{
        prevButton.disabled = false;
        nextButton.disabled = false;
    }
}


