document.addEventListener("DOMContentLoaded", function(){

/* ===========================
   APPOINTMENT PAGE SCRIPT
=========================== */

const vaccinatedSelect = document.getElementById("vaccinatedSelect");

if(vaccinatedSelect){

    const vaccinationFields = document.getElementById("vaccinationFields");
    const vaccinationNeeded = document.getElementById("vaccinationNeeded");
    const serviceSelect = document.getElementById("service");

    const autoMsg = document.createElement("p");
    autoMsg.style.color = "green";
    autoMsg.style.marginTop = "10px";
    autoMsg.style.display = "none";
    vaccinatedSelect.parentNode.appendChild(autoMsg);

    vaccinatedSelect.addEventListener("change", function(){

        if(this.value === "yes"){
            vaccinationFields.style.display = "block";
            vaccinationNeeded.style.display = "none";
            autoMsg.style.display = "none";
        }
        else if(this.value === "no"){
            vaccinationFields.style.display = "none";
            vaccinationNeeded.style.display = "block";
            serviceSelect.value = "Vaccination";

            autoMsg.innerHTML = "✔ Vaccination service automatically added.";
            autoMsg.style.display = "block";
        }
        else{
            vaccinationFields.style.display = "none";
            vaccinationNeeded.style.display = "none";
            autoMsg.style.display = "none";
        }
    });
}


/* ===========================
   FORM VALIDATION
=========================== */

const appointmentForm = document.querySelector(".appointment-form");

if(appointmentForm){
appointmentForm.addEventListener("submit", function(e){

    const petName = document.getElementById("petName").value.trim();
    const petType = document.getElementById("petType").value;
    const service = document.getElementById("service").value;
    const appointmentDate = document.getElementById("appointmentDate").value;
    const timeSlot = document.getElementById("timeSlot").value;

    if(petName === "" || petType === "" || service === "" || appointmentDate === "" || timeSlot === ""){
        alert("Please fill all required fields.");
        e.preventDefault();
        return;
    }

});
}


/* ===========================
   REGISTER FORM
=========================== */

const registerForm = document.getElementById("registerForm");

if(registerForm){
registerForm.addEventListener("submit", function(e){

    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if(password !== confirmPassword){
        alert("Passwords do not match!");
        e.preventDefault();
        return;
    }

    if(password.length < 6){
        alert("Password must be at least 6 characters!");
        e.preventDefault();
        return;
    }

});
}


/* ===========================
   LOGIN FORM
=========================== */

const loginForm = document.getElementById("loginForm");

if(loginForm){
loginForm.addEventListener("submit", function(e){

    const username = document.getElementById("loginUsername").value;
    const password = document.getElementById("loginPassword").value;

    if(username === "" || password === ""){
        alert("Please fill all fields!");
        e.preventDefault();
        return;
    }

});
}


/* ===========================
   ADMIN DASHBOARD SCRIPT
=========================== */

const adminMenus = document.querySelectorAll(".admin-menu");
const adminSections = document.querySelectorAll(".admin-section");

if(adminMenus.length > 0){

    adminMenus.forEach(menu=>{
        menu.addEventListener("click", function(){

            adminMenus.forEach(m=>m.classList.remove("active"));
            adminSections.forEach(sec=>sec.classList.remove("active"));

            this.classList.add("active");

            const targetSection = document.getElementById(this.dataset.target);

            if(targetSection){
                targetSection.classList.add("active");
            }
        });
    });

    const params = new URLSearchParams(window.location.search);
    const activeSection = params.get("section");

    if(activeSection){
        adminMenus.forEach(m=>m.classList.remove("active"));
        adminSections.forEach(sec=>sec.classList.remove("active"));

        const menu = document.querySelector(`[data-target="${activeSection}"]`);
        const section = document.getElementById(activeSection);

        if(menu && section){
            menu.classList.add("active");
            section.classList.add("active");
        }
    }
}

});
