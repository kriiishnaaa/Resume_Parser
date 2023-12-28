const urlParams = new URLSearchParams(window.location.search);
const jsonFilePath = urlParams.get('data');
// Fetch the JSON data
fetch("data.json")
  .then(response => response.json())
  .then(data => {
    // Access the JSON data and populate form fields
    document.getElementById("CandName").value = data.CandName;
    document.getElementById("CandContact").value = data.CandContact;
    document.getElementById("CandEmail").value = data.CandEmail;
    document.getElementById("CandAddress").value = data.CandAddress;
    document.getElementById("CandEducation").value=data.CandEducation;
    document.getElementById("CandTechSkills").value=data.CandTechSkills;
    document.getElementById("CandProfSkills").value=data.CandProfSkills;
    document.getElementById("CandExperience").value=data.CandExperience;
  })
  .catch(error => console.log(error));
