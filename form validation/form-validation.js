function submitHandler(event) {
  event.preventDefault();
  const form = document.querySelectorAll("form");
  const displayError = document.querySelector(".errors");
  // console.log(form);
  // console.log(form[0]);
  // console.log(form[0].length);
  const nameError = document.querySelector(".nameError")
  const dobError = document.querySelector(".dobError")
  const emailError = document.querySelector(".emailError")
  const addressError = document.querySelector(".addressError")
  const mobileError = document.querySelector(".mobileError")
  const genderError = document.querySelector(".genderError")
  const eduError = document.querySelector(".eduError")
  const termError = document.querySelector(".termError")

  const validationError = document.getElementsByClassName("validation-error")

  let requiredFields = document.querySelectorAll(".required");
  // console.log(requiredFields);
  // console.log(requiredFields.length);

  // displayError.textContent = "";
  const radioNameSets = new Set();
  const checkBoxesSet = new Set();

  let errors = [];

  for (let i = 0; i < requiredFields.length; i++) {



    // type email
    const emailRegex = /^([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})$/;
    if (requiredFields[i].type == "email") {
      
      
      const nextEle = requiredFields[i].nextElementSibling
      console.log(nextEle);

      if (requiredFields[i].value === "") {
        if (nextEle) {
          nextEle.textContent = "email is required"
        }
      } else if (!emailRegex.test(requiredFields[i].value)) {
        // errors.push("Email is invalid");
        if (nextEle) {
          nextEle.textContent = "email is invaluid"
        }
        
      }
      else {
        nextEle.textContent = ""
      }
      
    }
    

    // type text
    if (requiredFields[i].type == "text") {
      const nextEle = requiredFields[i].nextElementSibling
      console.log(nextEle);

      if (requiredFields[i].value === "") {
        // errors.push(`${requiredFields[i].name} is required`);
        // displayError.innerHTML = `${requiredFields[i].name} is required`
        // para.textContent = `${requiredFields[i].name} is required`
        nextEle.textContent = `${requiredFields[i].name} is required`
      }
      else {
        nextEle.textContent = ""
      }
    }

    // type date
    if (requiredFields[i].type == "date") {
      // const para = document.createElement('p')
      const nextEle = requiredFields[i].nextElementSibling
      console.log(nextEle);

      if (requiredFields[i].value === "") {
        // errors.push(`${requiredFields[i].name} is required`);
        // displayError.innerHTML = `${requiredFields[i].name} is required`
        nextEle.textContent = `${requiredFields[i].name} is required`
      }
      // requiredFields[i].insertAdjacentElement("afterend", para)
      else {
        nextEle.textContent = ""
      }
    }

    // type tel
    const mobRegex = /^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$/;
    if (requiredFields[i].type == "tel") {
      const nextEle = requiredFields[i].nextElementSibling
      console.log(nextEle);
      // const para = document.createElement('p')
      if (requiredFields[i].value === "") {
        // errors.push(`${requiredFields[i].name} is required`);
        // displayError.innerHTML = `${requiredFields[i].name} is required`
        nextEle.textContent = `${requiredFields[i].name} is required`
      } else if (!mobRegex.test(requiredFields[i].value)) {
        // errors.push(`${requiredFields[i].name} is required`);
        nextEle.textContent = `${requiredFields[i].name} is invalid`
      }
      // requiredFields[i].insertAdjacentElement("afterend", para)
      else{
        nextEle.textContent = ""
      }
    }

    // type radio
    if (requiredFields[i].type === "radio") {
      // const para = document.createElement('p')
      const nextEle = requiredFields[i].nextElementSibling
      const totalRadios = document.querySelectorAll(
        'input.required[type="radio"]'
      );
      for (let i = 0; i < totalRadios.length; i++) {
        if (radioNameSets.has(totalRadios[i].name)) {
          continue;
        }
        // console.log("iter", i);
        radioNameSets.add(totalRadios[i].name);
        let tempRadio = document.getElementsByName(totalRadios[i].name);
        // console.log(tempRadio);
        let isChecked = false;
        for (let i = 0; i < tempRadio.length; i++) {
          if (tempRadio[i].checked) {
            isChecked = true;
            break;
          }
        }
        // console.log(radioNameSets);
        if (!isChecked) {
          // errors.push(`select the ${totalRadios[i].name}`);
          nextEle.textContent = `select the ${totalRadios[i].name}`
        }
        else {
          nextEle.textContent = ""
        }
      } //end of inner loop
      // requiredFields[i].insertAdjacentElement("afterend", para)

    }

    // for selection
    if (requiredFields[i].tagName == "SELECT") {
      // const para = document.createElement('p')
      const nextEle = requiredFields[i].nextElementSibling

      if (requiredFields[i].value === "") {
        // errors.push(`select one of the option for ${requiredFields[i].name}`);
        nextEle.textContent = `select one of the option for ${requiredFields[i].name}`
      }
      else {
        nextEle.textContent = ""
      }
      // requiredFields[i].insertAdjacentElement("afterend", para)
    }

    // console.log("outer loop iter", i, requiredFields[i].type);


    // for checkboxes
    if (requiredFields[i].type === "checkbox") {
      // const para = document.createElement('p')
      const nextEle = requiredFields[i].nextElementSibling
      

      let totalCheckboxes = document.querySelectorAll(
        'input.required[type="checkbox"]'
      );
      // console.log("total checkboxes", totalCheckboxes);
      // console.log("total checkboxes", totalCheckboxes.length);

      for (let i = 0; i < totalCheckboxes.length; i++) {
        _name = totalCheckboxes[i].name;
        // console.log("name", _name);
        if (checkBoxesSet.has(totalCheckboxes[i].name)) {
          console.log("skipping this time");
          continue;
        }
        // console.log("iteration", i);

        console.log(checkBoxesSet.add(totalCheckboxes[i].name));

        let tempCheckboxes = document.getElementsByName(
          totalCheckboxes[i].name
        );
        // console.log("temp checkboxes", tempCheckboxes);
        // console.log("temp checkboxes", tempCheckboxes.length);


        // console.log(Array.from(tempCheckboxes).some((item) => item.checked));

        if (!Array.from(tempCheckboxes).some((item) => item.checked)) {
          console.log("pushing error");
          // errors.push(`please select the ${totalCheckboxes[i].name}`);
          nextEle.textContent = `please select the ${totalCheckboxes[i].name}`
        }
        else {
          nextEle.textContent = ""
        }
      }
      // requiredFields[i].insertAdjacentElement("afterend", para)
    }

    // for textarea
    if (requiredFields[i].tagName == "TEXTAREA") {
      // const para = document.createElement('p')
      const nextEle = requiredFields[i].nextElementSibling

      if (requiredFields[i].value === "") {
        // errors.push(`${requiredFields[i].name} is required`);
        nextEle.textContent = `${requiredFields[i].name} is required`
      } 
      else{
        nextEle.textContent = ""
      }
      
      
    }
  } //end of for loop
  
  // else {
  //   requiredFields[i].nextElementSibling.remove()
  // }
  console.log("errors....", errors);
  console.log("errors....", errors.length);

  // for (let i = 0; i < errors.length; i++) {
  //   displayError.innerHTML += `<ul>
  //       <li>${errors[i]}</li>
  //     </ul>`;
  // }
}
