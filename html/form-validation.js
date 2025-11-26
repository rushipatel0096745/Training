

function submitHandler(event) {

        event.preventDefault()
        const nameValue = document.getElementById('name').value
        const emailValue = document.getElementById('email').value
        const dobValue = document.getElementById('dob').value
        const addressValue = document.getElementById('address').value
        const mobValue = document.getElementById('mob').value
        const educationValue = document.getElementById('education').value

        // console.log(document.querySelectorAll('input[name="hobby"]'));

        // errors elements
        const nameErr =  document.getElementById("nameErr")
        const emailErr =  document.getElementById("emailErr")
        const dobErr =  document.getElementById("dobErr")
        const addressErr =  document.getElementById("addressErr")
        const mobErr =  document.getElementById("mobErr")
        const genderErr =  document.getElementById("genderErr")
        const hobbyErr =  document.getElementById("hobbyErr")
        const eduErr =  document.getElementById("eduErr")
        const termErr =  document.getElementById("termErr")

        nameErr.textContent = ""
        emailErr.textContent = ""
        dobErr.textContent = ""
        addressErr.textContent = ""
        mobErr.textContent = ""
        genderErr.textContent = ""
        hobbyErr.textContent = ""
        eduErr.textContent = ""
        termErr.textContent = ""
            

    if(nameValue === "" ){
        nameErr.innerHTML = "Name required"
    }
    else{
        nameErr.innerHTML = ""
    }

    if(dobValue === "" ){
        dobErr.innerHTML = "DOB required"
    }
    else{
        dobErr.innerHTML = ""
    }


    const emailRegex = /^([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})$/;
    if(emailErr === "" ){
        emailErr.innerHTML = "email required"
    }
    else if(!emailRegex.test(emailValue)){
        emailErr.innerHTML = "email is invalid"
    }
    else{
        emailErr.innerHTML = ""
    }
    

    if(addressValue === "" ){
        addressErr.innerHTML = "address required"
    }
    else if (addressValue.length > 100){
        addressErr.innerHTML = "Address should not be more than 100 character"
    }
    else{
        addressErr.innerHTML = ""
    }
    

    const mobRegex = /^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$/;
    if(mobValue === "" ){
        mobErr.innerHTML = "Phone number required"
    }
    else if (!mobRegex.test(mobValue)){
        mobErr.innerHTML = "Phone number is invalid"
    }
    else {
        mobErr.innerHTML = ""
    }

    const gender = document.getElementsByName('gender')
    let isChecked = false
    for(let i=0; i<gender.length; i++){
        if(gender[i].checked){
            isChecked = true
            break;
        }
    }
    if(!isChecked){
        genderErr.innerHTML = "Select the Gender"
    }
    else {
        genderErr.innerHTML = ""
    }

    if(educationValue === ""){
        eduErr.innerHTML = "select one of the option"
    }
    else{
        eduErr.innerHTML = ""
    }

    // function limitSelections(checkboxGroup, maxSelections) {
    //     let selectedCount = 0;
    //     // Loop through each checkbox
    //     for (let i = 0; i < checkboxGroup.length; i++) {
    //       // If the checkbox is checked
    //       if (checkboxGroup[i].checked) {
    //         selectedCount++;
    //         // Check if limit exceeded
    //         if (selectedCount > maxSelections) {
    //           // Uncheck the exceeding checkbox
    //           checkboxGroup[i].checked = false;
    //           hobbyErr.innerHTML = "maximum 3 hobbies are allowed"
    //           break; // Stop checking further
    //         }
    //         else {
    //             hobbyErr.innerHTML = ""
    //         }
    //       }
    //     }
    //   }
      
    //   limitSelections(hobby, 3); // Maximum 3 selections

    const hobby = document.querySelectorAll('input[name="hobby"]')

    let notChecked = 0
    for(x of hobby){
        if(!x.checked){
            notChecked++
        }
    }
    if(notChecked === hobby.length){
        hobbyErr.innerHTML = "select at least one"
    }
    else{
        hobbyErr.innerHTML = ""
    }

    

    let selectedCount = 0;
        // Loop through each checkbox
        for (let i = 0; i < hobby.length; i++) {
          if (hobby[i].checked) {
            selectedCount++;
            // Check if limit exceeded
            if (selectedCount > 2) {
              // Uncheck the exceeding checkbox
              hobby[i].checked = false;
              hobbyErr.innerHTML = "maximum 2 hobbies are allowed"
              break; // Stop checking further
            }
            else {
                hobbyErr.innerHTML = ""
            }
          }
        }
    
    const termValue = document.getElementById('terms').checked

    if(!termValue){
        termErr.innerHTML = "Please select the above"
    }
    else{
        termErr.innerHTML = ""
    }

}