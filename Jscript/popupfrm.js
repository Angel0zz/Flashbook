const formOpenBtn= document.querySelector("#form-open"),
        forms = document.querySelector(".forms"),
        formContainer=document.querySelector(".frm-container"),
        CloseBtn = document.querySelector(".close-btn"),
        signupBtn = document.querySelector("#signup"),
        loginBtn = document.querySelector("#login");
        formOpenBtn.addEventListener("click",() => forms.classList.add("show"));
        CloseBtn.addEventListener("click",() => forms.classList.remove("show"));
        CloseBtn.addEventListener   ("click",() => formContainer.classList.remove("active"));
        signupBtn.addEventListener("click", (e) =>{
            e.preventDefault();
            formContainer.classList.add("active");
        });
        loginBtn.addEventListener("click", (e) =>{
            e.preventDefault();
            formContainer.classList.remove("active");
        });




        // pricelist

     